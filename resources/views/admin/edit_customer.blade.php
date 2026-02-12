@extends('layouts.sidebar')

@section('title', 'Edit Customer')
@section('subtitle', 'Perbarui informasi customer')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Customer</label>
                    <input type="text" name="nama" id="nama"
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all placeholder:text-slate-400 @error('nama') border-red-500 @enderror"
                           placeholder="Contoh: John Doe" value="{{ old('nama', $customer->nama) }}" required>
                    @error('nama')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_telepon" class="block text-sm font-semibold text-slate-700 mb-2">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon"
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all @error('no_telepon') border-red-500 @enderror"
                           placeholder="08123456789" value="{{ old('no_telepon', $customer->no_telepon) }}">
                    @error('no_telepon')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" id="email"
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror"
                           placeholder="john@example.com" value="{{ old('email', $customer->email) }}">
                    @error('email')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all @error('alamat') border-red-500 @enderror"
                              placeholder="Alamat lengkap customer">{{ old('alamat', $customer->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.customers') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all active:scale-95">
                    Update Customer
                </button>
            </div>
        </form>
    </div>
@endsection