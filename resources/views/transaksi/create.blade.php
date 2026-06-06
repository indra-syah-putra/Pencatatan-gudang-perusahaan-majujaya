@extends('layouts.app')

@section('title', 'Input Transaksi')

@section('content')
    <div class="max-w-xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-6">
            <a href="{{ route('dashboard') }}"
                class="text-sm font-medium text-slate-500 hover:text-primary transition-colors">
                &larr; Kembali ke Dashboard
            </a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Input Transaksi</h2>
            <p class="text-sm text-slate-500">Catat mutasi barang masuk atau keluar.</p>
        </div>

        {{-- CARD FORM --}}
        <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- NOTIFIKASI ERROR --}}
                @if (session('error'))
                    <div
                        class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- BARIS 1: TANGGAL & JENIS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi</label>
                        <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('transaction_date') border-red-400 @enderror">
                        @error('transaction_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Mutasi --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Mutasi</label>
                        <select name="transaction_type"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('transaction_type') border-red-400 @enderror">
                            <option value="in" {{ old('transaction_type') == 'in' ? 'selected' : '' }}>Barang Masuk (In)</option>
                            <option value="out" {{ old('transaction_type') == 'out' ? 'selected' : '' }}>Barang Keluar (Out)</option>
                        </select>
                        @error('transaction_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- BARANG --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Barang</label>
                    <div class="relative">
                        <select name="product_id" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none appearance-none transition-colors cursor-pointer @error('product_id') border-red-400 @enderror">
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            @foreach ($barangs as $b)
                                <option value="{{ $b->id }}" {{ old('product_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }} (Stok: {{ $b->persediaan->quantity ?? 0 }}) -
                                    {{ $b->unit_of_measure }}
                                </option>
                            @endforeach
                        </select>
                        {{-- Ikon Panah Bawah --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    @error('product_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if ($barangs->isEmpty())
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            Belum ada data barang. <a href="{{ route('barang.create') }}"
                                class="underline font-bold ml-1">Tambah Barang</a>
                        </p>
                    @endif
                </div>

                {{-- JUMLAH --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah (Qty)</label>
                    <div class="relative">
                        <input type="number" name="quantity" min="1" required placeholder="0" value="{{ old('quantity') }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors font-bold text-slate-800 @error('quantity') border-red-400 @enderror">
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        {{-- Label Unit (Visual Only) --}}
                        <div
                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-sm font-semibold">
                            Unit
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-blue-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan Transaksi
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
