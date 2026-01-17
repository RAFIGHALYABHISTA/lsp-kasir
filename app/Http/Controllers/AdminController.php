<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class AdminController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('admin.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_barang' => 'required|integer|min:0',
        ]);

        Barang::create($request->all());

        return redirect()->route('admin.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('admin.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_barang' => 'required|integer|min:0',
        ]);

        $barang->update($request->all());

        return redirect()->route('admin.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('admin.index')->with('success', 'Barang berhasil dihapus.');
    }
}