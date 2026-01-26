@extends('layouts.app')

@section('title', 'Tambah Master Barang')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('barang.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-primary transition-colors">
                &larr; Kembali ke Data Barang
            </a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Tambah Master Barang</h2>
            <p class="text-sm text-slate-500">Isi form di bawah ini untuk menambahkan barang baru.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('barang.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Row 1: Kode & Nama -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                        <input type="text" name="code" placeholder="BRG-001"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang</label>
                        <input type="text" name="name" required placeholder="Contoh: Laptop Asus"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                </div>

                <!-- Row 2: Kategori & Satuan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                        <select name="category"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Furniture">Furniture</option>
                            <option value="ATK">ATK</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan</label>
                        <input type="text" name="unit_of_measure" required placeholder="Pcs / Box"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                </div>

                <!-- Row 3: Harga & Min Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Satuan (Rp)</label>
                        <input type="number" name="price_per_unit" required placeholder="0"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Minimum Stok</label>
                        <input type="number" name="min_stock" value="5" required
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
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-blue-700 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
