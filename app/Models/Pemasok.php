<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['transaction_date', 'transaction_type', 'product_id', 'quantity', 'total_price'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }
}