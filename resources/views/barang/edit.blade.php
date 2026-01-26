@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('barang.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-primary transition-colors">
                &larr; Kembali ke Data Barang
            </a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Edit Barang</h2>
            <p class="text-sm text-slate-500">Perbarui data barang di bawah ini.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Row 1: Kode & Nama -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                        <input type="text" name="code" value="{{ $barang->code }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang</label>
                        <input type="text" name="name" value="{{ $barang->name }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                </div>

                <!-- Row 2: Kategori & Satuan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                        <input type="text" name="category" value="{{ $barang->category }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan</label>
                        <input type="text" name="unit_of_measure" value="{{ $barang->unit_of_measure }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                </div>

                <!-- Row 3: Harga & Min Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Satuan (Rp)</label>
                        <input type="number" name="price_per_unit" value="{{ $barang->price_per_unit }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Minimum Stok</label>
                        <input type="number" name="min_stock" value="{{ $barang->min_stock }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('barang.index') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-blue-700 rounded-lg shadow-sm transition-colors">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
