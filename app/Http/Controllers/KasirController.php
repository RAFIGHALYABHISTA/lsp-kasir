<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Customer;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $barangs = Barang::all();
        $keranjang = session('keranjang', []);
        $total = !empty($keranjang) ? array_sum(array_column($keranjang, 'subtotal')) : 0;
        $customers = Customer::all();
        return view('kasir.index', compact('barangs', 'keranjang', 'total', 'customers'));
    }

    public function tambah(Request $request)
    {
        $produk_id = $request->produk_id;
        $qty = $request->qty;

        $barang = Barang::find($produk_id);
        if (!$barang) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        if ($barang->stok < $qty) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $keranjang = session('keranjang', []);

        if (isset($keranjang[$produk_id])) {
            $keranjang[$produk_id]['qty'] += $qty;
        } else {
            $keranjang[$produk_id] = [
                'nama' => $barang->nama_barang,
                'harga' => $barang->harga_barang,
                'qty' => $qty,
                'subtotal' => $barang->harga_barang * $qty
            ];
        }

        $keranjang[$produk_id]['subtotal'] = $keranjang[$produk_id]['harga'] * $keranjang[$produk_id]['qty'];

        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong');
        }

        $transaksi = Transaksi::create([
            'tanggal_transaksi' => now(),
            'total' => array_sum(array_column($keranjang, 'subtotal')),
            'customer_id' => $request->customer_id,
        ]);

        foreach ($keranjang as $produk_id => $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $produk_id,
                'qty' => $item['qty'],
                'harga_barang' => $item['harga'],
                'subtotal' => $item['subtotal']
            ]);

            // Kurangi stok
            $barang = Barang::find($produk_id);
            $barang->stok -= $item['qty'];
            $barang->save();
        }

        session()->forget('keranjang');

        return redirect()->route('admin.kasir.invoice', $transaksi->id)->with('success', 'Transaksi berhasil disimpan');
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with('transaksiDetails.barang', 'customer')->findOrFail($id);
        return view('kasir.invoice', compact('transaksi'));
    }

    public function hapus($id)
    {
        $keranjang = session('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session(['keranjang' => $keranjang]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}