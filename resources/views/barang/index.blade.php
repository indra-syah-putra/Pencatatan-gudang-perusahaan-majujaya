@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Data Barang</h2>
                <p class="text-sm text-slate-500">Kelola master data persediaan.</p>
            </div>
            <a href="{{ route('barang.create') }}"
                class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-white bg-primary hover:bg-blue-700 rounded-lg shadow-md transition-colors">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Barang
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Nama Barang</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Satuan</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Min. Stok</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($barangs as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $item->code ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $item->name }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold border border-slate-200">
                                        {{ $item->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->unit_of_measure }}</td>
                                <td class="px-6 py-4 text-slate-600">Rp
                                    {{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->min_stock }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('barang.edit', $item->id) }}"
                                            class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors"
                                            title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    Belum ada data barang. Silakan tambahkan data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-center md:justify-between items-center">
                <div class="text-xs text-slate-500 hidden md:block">Total {{ $barangs->total() }} data</div>
                {{ $barangs->links() }}
            </div>
        </div>
    </div>
@endsection
