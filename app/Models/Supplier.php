<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    /**
     * Get the transactions for the supplier.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
