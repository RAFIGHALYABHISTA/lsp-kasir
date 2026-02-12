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
        return view('kasir.index', compact('barangs'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:barang,id',
            'qty' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:100'
        ]);

        $produk_id = $request->produk_id;
        $qty = $request->qty;
        $harga_manual = $request->harga;

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
                'harga' => $harga_manual,  // Use manual price from kasir
                'qty' => $qty,
                'subtotal' => $harga_manual * $qty
            ];
        }

        $keranjang[$produk_id]['subtotal'] = $keranjang[$produk_id]['harga'] * $keranjang[$produk_id]['qty'];

        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:barang,id',
            'qty' => 'required|integer|min:1',
            'uang_pelanggan' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
        ]);

        $barang = Barang::find($request->produk_id);
        if (!$barang) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        if ($barang->stok < $request->qty) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $harga = $barang->harga_barang;
        $subtotal = $harga * $request->qty;

        // create or find customer if any customer data provided
        $customerId = null;
        if ($request->customer_name || $request->customer_email || $request->customer_phone || $request->customer_address) {
            $found = null;
            if ($request->customer_email) {
                $found = Customer::where('email', $request->customer_email)->first();
            }
            if (!$found && $request->customer_name) {
                $found = Customer::where('nama', $request->customer_name)->first();
            }

            if ($found) {
                $found->no_telepon = $request->customer_phone ?? $found->no_telepon;
                $found->alamat = $request->customer_address ?? $found->alamat;
                $found->email = $request->customer_email ?? $found->email;
                $found->save();
                $customerId = $found->id;
            } else {
                $customer = Customer::create([
                    'nama' => $request->customer_name ?? 'Pelanggan',
                    'no_telepon' => $request->customer_phone ?? null,
                    'alamat' => $request->customer_address ?? null,
                    'email' => $request->customer_email ?? null,
                ]);
                $customerId = $customer->id;
            }
        }

        $transaksi = Transaksi::create([
            'tanggal_transaksi' => now(),
            'total' => $subtotal,
            'customer_id' => $customerId,
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi->id,
            'barang_id' => $barang->id,
            'qty' => $request->qty,
            'harga_barang' => $harga,
            'subtotal' => $subtotal
        ]);

        // Kurangi stok
        $barang->stok -= $request->qty;
        $barang->save();

        // Store uang_pelanggan and kembalian in session to pass to invoice
        $kembalian = $request->uang_pelanggan - $subtotal;
        session(['uang_diterima' => $request->uang_pelanggan, 'kembalian' => $kembalian]);

        return redirect()->route('admin.kasir.invoice', $transaksi->id)->with('success', 'Transaksi berhasil disimpan');
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with('transaksiDetails.barang.kategori', 'customer')->findOrFail($id);
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