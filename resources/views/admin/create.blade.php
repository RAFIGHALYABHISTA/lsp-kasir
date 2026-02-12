@extends('layouts.sidebar')

@section('title', 'Tambah Barang Baru')
@section('subtitle', 'Masukkan detail informasi barang untuk menambah stok inventaris')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.store') }}" method="POST" class="p-8" id="formTambahBarang">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk</label>
                    <input type="text" name="nama_barang" id="nama_barang"
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all placeholder:text-slate-400 @error('nama_barang') border-red-500 @enderror"
                           placeholder="Contoh: Kopi Bubuk Arabika" value="{{ old('nama_barang') }}">
                    @error('nama_barang')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_barang" class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">Rp</span>
                        <input type="number" name="harga_barang" id="harga_barang"
                               class="w-full pl-12 pr-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all @error('harga_barang') border-red-500 @enderror"
                               placeholder="0" value="{{ old('harga_barang') }}">
                    </div>
                    @error('harga_barang')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-semibold text-slate-700 mb-2">Stok Awal</label>
                    <input type="number" name="stok" id="stok"
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all @error('stok') border-red-500 @enderror"
                           placeholder="0" value="{{ old('stok') }}">
                    @error('stok')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all active:scale-95" id="btnSimpanBarang">
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formTambahBarang');
            form.addEventListener('submit', () => {
                notify.loading('Menyimpan barang...', 'Mohon tunggu');
            });
        });
    </script>
    @endpush
@endsection