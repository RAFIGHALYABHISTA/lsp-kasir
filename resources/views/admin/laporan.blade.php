@extends('layouts.sidebar')

@section('title', 'Laporan Transaksi')
@section('subtitle', 'Riwayat dan log semua transaksi penjualan')

@section('content')
@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
        <h2 class="font-bold text-slate-800">Riwayat Transaksi</h2>
        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">
            Total: {{ count($transaksis) }} Transaksi
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                    <th class="px-6 py-4">ID Transaksi</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Detail Barang</th>
                    <th class="px-6 py-4 text-center">Total</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transaksis as $transaksi)
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">
                            #TRX-{{ $transaksi->id }}
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ $transaksi->transaksiDetails->count() }} item(s)
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700">
                            {{ $transaksi->tanggal_transaksi->format('d M Y') }}
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ $transaksi->tanggal_transaksi->format('H:i') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            @foreach($transaksi->transaksiDetails as $detail)
                            <div class="text-sm">
                                <span class="font-medium">{{ $detail->barang->nama_barang }}</span>
                                <span class="text-slate-400">({{ $detail->qty }} x Rp {{ number_format($detail->harga_barang, 0, ',', '.') }})</span>
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-bold rounded-full">
                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.kasir.invoice', $transaksi->id) }}"
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors"
                               target="_blank">
                                <i class="fa-solid fa-eye mr-1"></i> Lihat Invoice
                            </a>
                            <form action="{{ route('admin.laporan.destroy', $transaksi->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                        <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                        <div>Belum ada transaksi</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection