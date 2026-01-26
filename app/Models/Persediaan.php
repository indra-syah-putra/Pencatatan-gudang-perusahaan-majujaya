<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'warehouse_location', 'entry_date', 'expiration_date'];

    // Relasi: Persediaan milik satu Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }
}