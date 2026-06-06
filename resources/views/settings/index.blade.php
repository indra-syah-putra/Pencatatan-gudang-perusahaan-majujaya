@extends('layouts.app')

@section('title', 'Pengaturan Perusahaan')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Pengaturan Perusahaan</h2>
            <p class="text-sm text-slate-500">Kelola data perusahaan dan tanda tangan laporan.</p>
        </div>

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Data Perusahaan --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-800">Data Perusahaan</h3>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Logo Perusahaan</label>
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center overflow-hidden border-2 border-slate-200">
                                @if ($settings['company_logo'])
                                    <img src="{{ Storage::url($settings['company_logo']) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-2xl font-bold text-primary">{{ substr(trim(str_replace('PT.', '', $settings['company_name'])), 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="logo" accept="image/jpeg,image/png,image/svg+xml"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors cursor-pointer">
                                <p class="text-xs text-slate-400 mt-1">Maks 2MB, format JPG/PNG/SVG. Biarkan kosong jika tidak ingin ganti.</p>
                                @if ($settings['company_logo'])
                                    <label class="inline-flex items-center gap-2 mt-2 text-xs text-red-600 cursor-pointer hover:text-red-700">
                                        <input type="checkbox" name="remove_logo" value="1" class="rounded border-slate-300 text-red-500 focus:ring-red-400">
                                        Hapus logo perusahaan
                                    </label>
                                @endif
                                @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Perusahaan</label>
                        <input type="text" name="company_name" value="{{ old('company_name', $settings['company_name']) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('company_name') border-red-400 @enderror">
                        @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                        <textarea name="company_address" rows="2" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('company_address') border-red-400 @enderror">{{ old('company_address', $settings['company_address']) }}</textarea>
                        @error('company_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                            <input type="text" name="company_phone" value="{{ old('company_phone', $settings['company_phone']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('company_phone') border-red-400 @enderror">
                            @error('company_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" name="company_email" value="{{ old('company_email', $settings['company_email']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('company_email') border-red-400 @enderror">
                            @error('company_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tanda Tangan --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-800">Tanda Tangan Laporan</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Dibuat Oleh</label>
                            <input type="text" name="ttd_dibuat" value="{{ old('ttd_dibuat', $settings['ttd_dibuat']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('ttd_dibuat') border-red-400 @enderror">
                            @error('ttd_dibuat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIP</label>
                            <input type="text" name="ttd_dibuat_nip" value="{{ old('ttd_dibuat_nip', $settings['ttd_dibuat_nip']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('ttd_dibuat_nip') border-red-400 @enderror">
                            @error('ttd_dibuat_nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Diperiksa Oleh</label>
                            <input type="text" name="ttd_diperiksa" value="{{ old('ttd_diperiksa', $settings['ttd_diperiksa']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('ttd_diperiksa') border-red-400 @enderror">
                            @error('ttd_diperiksa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIP</label>
                            <input type="text" name="ttd_diperiksa_nip" value="{{ old('ttd_diperiksa_nip', $settings['ttd_diperiksa_nip']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('ttd_diperiksa_nip') border-red-400 @enderror">
                            @error('ttd_diperiksa_nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Menyetujui Oleh</label>
                            <input type="text" name="ttd_menyetujui" value="{{ old('ttd_menyetujui', $settings['ttd_menyetujui']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('ttd_menyetujui') border-red-400 @enderror">
                            @error('ttd_menyetujui') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">NIP</label>
                            <input type="text" name="ttd_menyetujui_nip" value="{{ old('ttd_menyetujui_nip', $settings['ttd_menyetujui_nip']) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('ttd_menyetujui_nip') border-red-400 @enderror">
                            @error('ttd_menyetujui_nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-primary hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
