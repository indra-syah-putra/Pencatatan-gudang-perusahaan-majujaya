<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $barangs = Barang::with('persediaan')->get();

        $reports = [];

        foreach ($barangs as $barang) {
            // 1. Stok Awal: semua transisi SEBELUM bulan/tahun yang dipilih
            $stokAwal = Transaksi::where('product_id', $barang->id)
                ->where(function ($q) use ($month, $year) {
                    $q->whereYear('transaction_date', '<', $year)
                      ->orWhere(function ($q) use ($month, $year) {
                          $q->whereYear('transaction_date', $year)
                            ->whereMonth('transaction_date', '<', $month);
                      });
                })
                ->sum(DB::raw("CASE WHEN transaction_type = 'in' THEN quantity ELSE -quantity END"));

            if ($stokAwal < 0) $stokAwal = 0;

            // 2. Masuk di bulan ini
            $masuk = Transaksi::where('product_id', $barang->id)
                ->where('transaction_type', 'in')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('quantity');

            // 3. Keluar di bulan ini
            $keluar = Transaksi::where('product_id', $barang->id)
                ->where('transaction_type', 'out')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('quantity');

            // 4. Stok Akhir = Stok Awal + Masuk - Keluar
            $stokAkhir = $stokAwal + $masuk - $keluar;
            if ($stokAkhir < 0) $stokAkhir = 0;

            // 5. Nilai Stok
            $nilaiStok = $stokAkhir * $barang->price_per_unit;

            $reports[] = [
                'barang' => $barang,
                'stok_awal' => $stokAwal,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'stok_akhir' => $stokAkhir,
                'nilai_stok' => $nilaiStok,
            ];
        }

        $monthIndo = match($month) {
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        };

        return view('laporan.index', compact('reports', 'month', 'year', 'monthIndo'));
    }
}
