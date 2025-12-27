<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::with(['product', 'warehouse']);

        // Filter by product
        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by warehouse
        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        $perPage = $request->get('per_page', 15);
        $stocks = $query->paginate($perPage);

        return StockResource::collection($stocks);
    }

    public function summary()
    {
        $summary = Stock::with(['product', 'warehouse'])
            ->get()
            ->groupBy('warehouse_id')
            ->map(function ($warehouseStocks, $warehouseId) {
                $warehouse = Warehouse::find($warehouseId);
                return [
                    'warehouse' => [
                        'id' => $warehouse->id,
                        'name' => $warehouse->name,
                        'location' => $warehouse->location,
                    ],
                    'total_items' => $warehouseStocks->count(),
                    'total_quantity' => $warehouseStocks->sum('quantity'),
                    'products' => $warehouseStocks->map(function ($stock) {
                        return [
                            'product_id' => $stock->product_id,
                            'product_name' => $stock->product->name,
                            'sku' => $stock->product->sku,
                            'quantity' => $stock->quantity,
                        ];
                    }),
                ];
            })->values();

        return response()->json([
            'data' => $summary,
        ]);
    }

    public function adjustment(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer', // Can be negative for reduction
            'items.*.price' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'supplier_id' => null,
                'type' => Transaction::TYPE_ADJUST,
                'transaction_date' => $validated['transaction_date'],
                'note' => $validated['note'] ?? 'Stock adjustment',
            ]);

            foreach ($validated['items'] as $item) {
                $transaction->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update stock
                $stock = Stock::firstOrCreate(
                    [
                        'product_id' => $item['product_id'],
                        'warehouse_id' => $validated['warehouse_id'],
                    ],
                    ['quantity' => 0]
                );

                $stock->increment('quantity', $item['quantity']);
            }

            return response()->json([
                'message' => 'Stock adjustment completed successfully',
                'transaction' => $transaction->load(['user', 'items.product']),
            ]);
        });
    }
}
