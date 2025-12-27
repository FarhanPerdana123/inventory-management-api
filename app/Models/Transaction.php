<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'supplier_id',
        'type',
        'transaction_date',
        'note',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    const TYPE_IN = 'IN';
    const TYPE_OUT = 'OUT';
    const TYPE_ADJUST = 'ADJUST';

    /**
     * Get the user that created the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supplier for the transaction.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the items for the transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Get the total amount of the transaction.
     */
    public function getTotalAmountAttribute()
    {
        return $this->items()->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}
