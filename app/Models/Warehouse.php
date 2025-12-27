<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    /**
     * Get the stocks for the warehouse.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
