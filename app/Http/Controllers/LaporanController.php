<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input bulan/tahun, default ke bulan sekarang
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Ambil semua barang
        $barangs = Barang::all();
        
        $reports = [];

        foreach ($barangs as $barang) {
            // 1. Hitung Stok Akhir Saat Ini (Realtime)
            $stokAkhir = $barang->persediaan ? $barang->persediaan->quantity : 0;
            
            // 2. Hitung Pemasukan di Bulan/Tahun Tersebut
            $masukBulanIni = Transaksi::where('product_id', $barang->id)
                ->where('transaction_type', 'in')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('quantity');

            // 3. Hitung Pengeluaran di Bulan/Tahun Tersebut
            $keluarBulanIni = Transaksi::where('product_id', $barang->id)
                ->where('transaction_type', 'out')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('quantity');

            // 4. Rumus: Stok Akhir = Stok Awal + Masuk - Keluar
            // Maka: Stok Awal = Stok Akhir - Masuk + Keluar
            $stokAwal = $stokAkhir - $masukBulanIni + $keluarBulanIni;
            
            // Jika hasil minus, set 0 (asumsi data bersih)
            if($stokAwal < 0) $stokAwal = 0;

            // 5. Hitung Nilai Stok Akhir (Rupiah)
            $nilaiStokAkhir = $stokAkhir * $barang->price_per_unit;

            $reports[] = [
                'barang' => $barang,
                'stok_awal' => $stokAwal,
                'masuk' => $masukBulanIni,
                'keluar' => $keluarBulanIni,
                'stok_akhir' => $stokAkhir,
                'nilai_stok' => $nilaiStokAkhir,
            ];
        }

        // Format Nama Bulan Indonesia
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $monthIndo = match($month) {
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        };

        return view('laporan.index', compact('reports', 'month', 'year', 'monthIndo'));
    }
}