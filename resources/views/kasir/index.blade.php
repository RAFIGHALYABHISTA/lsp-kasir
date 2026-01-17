<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kasir Inventaris</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

<div class="max-w-7xl mx-auto p-4 md:p-8">
    <header class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">🧾 POS System</h1>
            <p class="text-slate-500">Manajemen Inventaris & Penjualan Real-time</p>
        </div>
    </header>
        <div class="text-right">
            <p class="text-sm text-slate-400">Tanggal</p>
            <p class="font-semibold text-slate-700">{{ date('d M Y') }}</p>
        </div>
    </header>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Katalog Barang</h2>
                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-full border border-blue-100">
                    {{ count($barangs) }} Produk Tersedia
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 uppercase text-[11px] font-bold tracking-wider">
                            <th class="px-6 py-4 text-left">Informasi Barang</th>
                            <th class="px-6 py-4 text-center">Harga Satuan</th>
                            <th class="px-6 py-4 text-center">Stok</th>
                            <th class="px-6 py-4 text-right">Tambah Ke Pos</th>
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
                            <td class="px-6 py-4">
                                <form action="{{ route('kasir.tambah') }}" method="POST" class="flex items-center justify-end gap-3">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $b->id }}">
                                    <input type="number" name="qty" value="1" min="1" max="{{ $b->stok }}"
                                           class="w-14 border-slate-200 focus:ring-blue-500 focus:border-blue-500 rounded-lg px-2 py-1.5 text-center text-sm shadow-sm transition-all">
                                    <button class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg shadow-sm hover:shadow transition-all active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-slate-800 rounded-2xl shadow-xl text-white overflow-hidden flex flex-col h-full max-h-[700px]">
                <div class="px-6 py-5 border-b border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Keranjang Belanja
                    </h2>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                    @forelse($keranjang as $item)
                    <div class="bg-slate-700/50 rounded-xl p-4 border border-slate-600/50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-medium text-slate-100">{{ $item['nama'] }}</span>
                            <span class="text-xs text-slate-400">x{{ $item['qty'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-300 font-bold text-sm">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-12 text-slate-500">
                        <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-sm">Keranjang masih kosong</p>
                    </div>
                    @endforelse
                </div>

                @php $total = collect($keranjang)->sum('subtotal'); @endphp
                
                <div class="p-6 bg-slate-900 border-t border-slate-700">
                    <div class="flex justify-between text-slate-400 text-sm mb-1">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-white mb-6">
                        <span>Total Akhir</span>
                        <span class="text-blue-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <form action="{{ route('kasir.simpan') }}" method="POST">
                        @csrf
                        <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" 
                                {{ count($keranjang) == 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Selesaikan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>