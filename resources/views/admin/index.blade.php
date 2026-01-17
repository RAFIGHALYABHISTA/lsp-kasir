@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Kelola stok dan data barang gudang secara terpusat')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Barang</p>
                    <p class="text-2xl font-bold text-slate-900">{{ count($barangs) }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i class="fa-solid fa-box-archive text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Barang Habis</p>
                    <p class="text-2xl font-bold text-red-600">{{ $barangs->where('stok', '<=', 0)->count() }}</p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg">
                    <i class="fa-solid fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Barang Stok Rendah</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $barangs->where('stok', '>', 0)->where('stok', '<=', 10)->count() }}</p>
                </div>
                <div class="p-3 bg-orange-50 rounded-lg">
                    <i class="fa-solid fa-chart-line text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <h2 class="font-bold text-slate-800">Daftar Inventaris Terkini</h2>
            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">
                Total: {{ count($barangs) }} Items
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Informasi Barang</th>
                        <th class="px-6 py-4 text-center">Harga Satuan</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($barangs as $b)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $b->nama_barang }}</div>
                            <div class="text-xs text-slate-400">ID: #PROD-{{ $b->id }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-slate-600">
                            Rp {{ number_format($b->harga_barang, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded-md text-xs font-medium {{ $b->stok < 10 ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-slate-600' }}">
                                {{ $b->stok }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($b->stok <= 0)
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Habis</span>
                            @elseif($b->stok <= 10)
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded-full">Stok Rendah</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.edit', $b->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    <i class="fa-solid fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        <a href="{{ route('admin.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i>
            Tambah Barang Baru
        </a>
    </div>
@endsection