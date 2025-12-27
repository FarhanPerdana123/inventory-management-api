<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function dailyStock(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));

        $stocks = Stock::with(['product', 'warehouse'])
            ->whereHas('product')
            ->get()
            ->map(function ($stock) {
                return [
                    'product_id' => $stock->product_id,
                    'product_name' => $stock->product->name,
                    'sku' => $stock->product->sku,
                    'warehouse_id' => $stock->warehouse_id,
                    'warehouse_name' => $stock->warehouse->name,
                    'quantity' => $stock->quantity,
                    'price' => $stock->product->price,
                    'total_value' => $stock->quantity * $stock->product->price,
                ];
            });

        return response()->json([
            'date' => $date,
            'total_items' => $stocks->count(),
            'total_quantity' => $stocks->sum('quantity'),
            'total_value' => $stocks->sum('total_value'),
            'stocks' => $stocks,
        ]);
    }

    public function monthlyTransactions(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));

        $transactions = Transaction::with(['items.product', 'user', 'supplier'])
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->get();

        $summary = [
            'month' => $month,
            'total_transactions' => $transactions->count(),
            'by_type' => [
                'IN' => $transactions->where('type', 'IN')->count(),
                'OUT' => $transactions->where('type', 'OUT')->count(),
                'ADJUST' => $transactions->where('type', 'ADJUST')->count(),
            ],
            'total_value' => $transactions->sum(function ($transaction) {
                return $transaction->items->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
            }),
            'transactions' => $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'type' => $transaction->type,
                    'date' => $transaction->transaction_date->format('Y-m-d'),
                    'user' => $transaction->user->name,
                    'supplier' => $transaction->supplier ? $transaction->supplier->name : null,
                    'items_count' => $transaction->items->count(),
                    'total_amount' => $transaction->items->sum(function ($item) {
                        return $item->quantity * $item->price;
                    }),
                ];
            }),
        ];

        return response()->json($summary);
    }

    public function fastMoving(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = now()->subDays($days)->format('Y-m-d');

        $fastMoving = TransactionItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('transaction', function ($query) use ($startDate) {
                $query->where('transaction_date', '>=', $startDate)
                      ->whereIn('type', ['IN', 'OUT']);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'sku' => $item->product->sku,
                    'name' => $item->product->name,
                    'total_quantity' => $item->total_quantity,
                    'current_stock' => $item->product->stocks->sum('quantity'),
                ];
            });

        return response()->json([
            'period_days' => $days,
            'start_date' => $startDate,
            'end_date' => now()->format('Y-m-d'),
            'fast_moving_products' => $fastMoving,
        ]);
    }
}
