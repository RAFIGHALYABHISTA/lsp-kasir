@extends('layouts.sidebar')

@section('title', 'Kelola Customer')
@section('subtitle', 'Kelola data customer')

@section('content')
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
            <h2 class="font-bold text-slate-800">Daftar Customer</h2>
            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">
                Total: {{ count($customers) }} Customer
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">No Telepon</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($customers as $c)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $c->nama }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-slate-600">
                            {{ $c->no_telepon ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-slate-600">
                            {{ $c->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center font-medium text-slate-600">
                            {{ $c->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.customers.edit', $c->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    <i class="fa-solid fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
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
        <a href="{{ route('admin.customers.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i>
            Tambah Customer Baru
        </a>
    </div>
@endsection