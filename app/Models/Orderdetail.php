<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database secara eksplisit
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
        'price',
    ];

    /**
     * Relasi ke Model Food
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    /**
     * Relasi ke Model Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}