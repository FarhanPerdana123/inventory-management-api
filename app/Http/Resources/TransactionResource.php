<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'supplier_id' => $this->supplier_id,
            'type' => $this->type,
            'transaction_date' => $this->transaction_date->format('Y-m-d'),
            'note' => $this->note,
            'user' => new UserResource($this->whenLoaded('user')),
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'items' => TransactionItemResource::collection($this->whenLoaded('items')),
            'total_amount' => $this->when($this->relationLoaded('items'), function () {
                return $this->items->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
