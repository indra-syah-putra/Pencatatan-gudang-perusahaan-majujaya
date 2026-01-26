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
        $barangs = Barang::all();
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

        $barang = Barang::find($request->product_id);
        $totalPrice = $barang->price_per_unit * $request->quantity;

        Transaksi::create([
            'transaction_date' => $request->transaction_date,
            'transaction_type' => $request->transaction_type,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        $persediaan = Persediaan::firstOrCreate(
            ['product_id' => $request->product_id],
            ['quantity' => 0, 'warehouse_location' => 'Gudang Utama', 'entry_date' => now()]
        );

        if ($request->transaction_type == 'in') {
            $persediaan->quantity += $request->quantity;
        } else {
            if ($persediaan->quantity < $request->quantity) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $persediaan->quantity -= $request->quantity;
        }
        $persediaan->save();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan.');
    }
}