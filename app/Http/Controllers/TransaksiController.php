<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Persediaan;

class TransaksiController extends Controller
{
    public function create()
    {
        $barangs = Barang::with('persediaan')->get();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:in,out',
            'product_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $barang = Barang::find($validated['product_id']);
        $totalPrice = $barang->price_per_unit * $validated['quantity'];

        Transaksi::create([
            'transaction_date' => $validated['transaction_date'],
            'transaction_type' => $validated['transaction_type'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
        ]);

        $persediaan = Persediaan::firstOrCreate(
            ['product_id' => $validated['product_id']],
            ['quantity' => 0, 'warehouse_location' => 'Gudang Utama', 'entry_date' => now()]
        );

        if ($validated['transaction_type'] == 'in') {
            $persediaan->quantity += $validated['quantity'];
        } else {
            if ($persediaan->quantity < $validated['quantity']) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $persediaan->quantity -= $validated['quantity'];
        }
        $persediaan->save();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan.');
    }
}