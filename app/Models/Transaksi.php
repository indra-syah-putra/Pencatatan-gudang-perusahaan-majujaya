<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_date', 'transaction_type', 'product_id', 'quantity', 'total_price'];

    // Relasi: Transaksi milik satu Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }
}