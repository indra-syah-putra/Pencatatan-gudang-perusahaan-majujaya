@extends('layouts.app')

@section('title', 'Laporan Stok Gudang')

@section('content')
    {{-- WRAPPER UTAMA --}}
    <div class="w-full max-w-7xl mx-auto flex flex-col gap-6">

        {{-- FILTER SECTION (Screen Only) --}}
        <div class="no-print bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold mb-4 text-slate-800">Filter Laporan Stok</h2>

            <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                {{-- Bulan --}}
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Bulan</label>
                    <select name="month"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm font-medium">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ $month == sprintf('%02d', $i) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Tahun --}}
                <div class="w-32">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun</label>
                    <select name="year"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm font-medium">
                        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Tombol --}}
                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-bold text-sm transition shadow-sm">
                    Tampilkan
                </button>
                <button type="button" onclick="window.print()"
                    class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 font-bold text-sm transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-print"></i> Cetak PDF
                </button>
            </form>
        </div>

        {{-- KERTAS LAPORAN (A4 Landscape) --}}
        {{-- CSS khusus print dihandle via inline style di bawah --}}
        <div class="paper-container mx-auto bg-white shadow-lg p-10 border border-slate-200 min-h-[600px]">

            {{-- HEADER PERUSAHAAN --}}
            <div class="border-b-4 border-double border-slate-800 pb-6 mb-8 text-center">
                <h1 class="text-3xl font-extrabold uppercase tracking-widest text-slate-900 font-serif">
                    {{ company('name') }}
                </h1>
                <h2 class="text-xl font-bold text-slate-700 mt-1 font-serif">
                    LAPORAN STOK GUDANG
                </h2>
                <div class="mt-2 text-sm text-slate-600 font-bold uppercase tracking-wide">
                    Periode: <span class="underline">{{ $monthIndo }} {{ $year }}</span>
                </div>
            </div>

            {{-- INFO ALAMAT --}}
            <div class="text-sm text-slate-600 mb-8 text-justify leading-relaxed font-serif">
                <p><strong>Alamat:</strong> {{ company('address') }}</p>
                <p class="mt-1">
                    <strong>Telp:</strong> {{ company('phone') }} &nbsp;|&nbsp;
                    <strong>Email:</strong> {{ company('email') }}
                </p>
            </div>

            {{-- TABEL DATA --}}
            <table class="w-full text-sm border-collapse border border-slate-400 font-serif">
                <thead>
                    <tr class="bg-slate-100 font-bold uppercase text-xs">
                        <th class="border px-2 py-2 w-10 text-center">No</th>
                        <th class="border px-2 py-2 w-32">Kode</th>
                        <th class="border px-4 py-2 text-left">Nama Produk</th>
                        <th class="border px-2 py-2 w-24 text-center">Awal</th>
                        <th class="border px-2 py-2 w-24 text-center">Masuk</th>
                        <th class="border px-2 py-2 w-24 text-center">Keluar</th>
                        <th class="border px-2 py-2 w-24 text-center">Akhir</th>
                        <th class="border px-2 py-2 w-32 text-right">Harga Satuan</th>
                        <th class="border px-2 py-2 w-40 text-right bg-blue-50">Nilai Stok</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- Pre-calculation logic di atas --}}
                    @php
                        $no = 1;
                        $totalNilai = 0;
                    @endphp

                    @forelse ($reports as $item)
                        @php
                            $totalNilai += $item['nilai_stok'];
                        @endphp

                        {{-- Baris Data --}}
                        <tr class="break-inside-avoid">
                            <td class="border px-2 py-2 text-center">{{ $no++ }}</td>
                            <td class="border px-2 py-2 text-center font-mono text-xs">{{ $item['barang']->code ?? '-' }}
                            </td>
                            <td class="border px-4 py-2">{{ $item['barang']->name }}</td>
                            <td class="border px-2 py-2 text-center">{{ $item['stok_awal'] }}</td>
                            <td class="border px-2 py-2 text-center">{{ $item['masuk'] }}</td>
                            <td class="border px-2 py-2 text-center">{{ $item['keluar'] }}</td>
                            <td class="border px-2 py-2 text-center font-bold bg-slate-50">{{ $item['stok_akhir'] }}</td>
                            <td class="border px-2 py-2 text-right">
                                {{ number_format($item['barang']->price_per_unit, 0, ',', '.') }}</td>
                            <td class="border px-2 py-2 text-right font-bold bg-blue-50">
                                {{ number_format($item['nilai_stok'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="border px-4 py-8 text-center text-slate-500">Tidak ada data pada
                                periode ini.</td>
                        </tr>
                    @endforelse

                    {{-- TOTAL --}}
                    <tr class="bg-slate-100 font-bold text-lg">
                        <td colspan="8" class="border px-4 py-3 text-right">TOTAL NILAI ASET:</td>
                        <td class="border px-2 py-3 text-right bg-blue-100">Rp
                            {{ number_format($totalNilai, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- TANDA TANGAN --}}
            <div class="mt-16 flex justify-between text-center text-sm font-serif">
                <div class="w-1/3">
                    <p class="font-bold mb-12">Dibuat Oleh,</p>
                    <p class="font-bold underline">{{ company('ttd_dibuat') }}</p>
                    <p class="text-xs text-slate-400 mt-1">NIP. {{ company('ttd_dibuat_nip') }}</p>
                </div>
                <div class="w-1/3">
                    <p class="font-bold mb-12">Diperiksa Oleh,</p>
                    <p class="font-bold underline">{{ company('ttd_diperiksa') }}</p>
                    <p class="text-xs text-slate-400 mt-1">NIP. {{ company('ttd_diperiksa_nip') }}</p>
                </div>
                <div class="w-1/3">
                    <p class="font-bold mb-12">Menyetujui,</p>
                    <p class="font-bold underline">{{ company('ttd_menyetujui') }}</p>
                    <p class="text-xs text-slate-400 mt-1">NIP. {{ company('ttd_menyetujui_nip') }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- CUSTOM CSS UNTUK PRINT ONLY --}}
    <style>
        @media print {

            /* Hilangkan elemen luar (Navbar, Filter) */
            body * {
                visibility: hidden;
            }

            /* Hanya tampilkan area kertas laporan */
            .paper-container,
            .paper-container * {
                visibility: visible;
            }

            /* Posisi kertas saat print */
            .paper-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                /* Reset padding agar pas A4 */
                box-shadow: none;
                border: none;
            }

            /* Atur ukuran kertas A4 Landscape */
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                background-color: white;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
@endsection
