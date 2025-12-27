<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'supplier', 'items.product']);

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $perPage = $request->get('per_page', 15);
        $transactions = $query->orderBy('transaction_date', 'desc')->paginate($perPage);

        return TransactionResource::collection($transactions);
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction->load(['user', 'supplier', 'items.product']));
    }

    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
            'warehouse_id' => 'required|exists:warehouses,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'supplier_id' => $validated['supplier_id'],
                'type' => Transaction::TYPE_IN,
                'transaction_date' => $validated['transaction_date'],
                'note' => $validated['note'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $transaction->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update stock
                $this->updateStock(
                    $item['product_id'],
                    $validated['warehouse_id'],
                    $item['quantity']
                );
            }

            return new TransactionResource($transaction->load(['user', 'supplier', 'items.product']));
        });
    }

    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
            'warehouse_id' => 'required|exists:warehouses,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // Validate stock availability
            foreach ($validated['items'] as $item) {
                $stock = Stock::where('product_id', $item['product_id'])
                    ->where('warehouse_id', $validated['warehouse_id'])
                    ->first();

                if (!$stock || $stock->quantity < $item['quantity']) {
                    return response()->json([
                        'message' => 'Insufficient stock for product ID: ' . $item['product_id'],
                    ], 422);
                }
            }

            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'supplier_id' => null,
                'type' => Transaction::TYPE_OUT,
                'transaction_date' => $validated['transaction_date'],
                'note' => $validated['note'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $transaction->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update stock (reduce)
                $this->updateStock(
                    $item['product_id'],
                    $validated['warehouse_id'],
                    -$item['quantity']
                );
            }

            return new TransactionResource($transaction->load(['user', 'supplier', 'items.product']));
        });
    }

    public function void(Transaction $transaction)
    {
        // Create reverse transaction
        return DB::transaction(function () use ($transaction) {
            $reverseType = $transaction->type === Transaction::TYPE_IN 
                ? Transaction::TYPE_OUT 
                : Transaction::TYPE_IN;

            $reverseTransaction = Transaction::create([
                'user_id' => auth()->id(),
                'supplier_id' => $transaction->supplier_id,
                'type' => $reverseType,
                'transaction_date' => now(),
                'note' => 'Void of transaction #' . $transaction->id,
            ]);

            foreach ($transaction->items as $item) {
                $reverseTransaction->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            return response()->json([
                'message' => 'Transaction voided successfully',
                'reverse_transaction' => new TransactionResource($reverseTransaction->load(['user', 'supplier', 'items.product'])),
            ]);
        });
    }

    private function updateStock($productId, $warehouseId, $quantity)
    {
        $stock = Stock::firstOrCreate(
            [
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
            ],
            ['quantity' => 0]
        );

        $stock->increment('quantity', $quantity);
    }
}
