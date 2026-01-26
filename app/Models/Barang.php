<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['code','name', 'category', 'unit_of_measure', 'price_per_unit', 'min_stock'];

    // Relasi: Satu barang punya banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'product_id');
    }

    // Relasi: Satu barang punya satu data persediaan
    public function persediaan()
    {
        return $this->hasOne(Persediaan::class, 'product_id');
    }
}