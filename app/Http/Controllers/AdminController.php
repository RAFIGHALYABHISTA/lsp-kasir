<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Customer;

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

    public function inventory()
    {
        $barangs = Barang::all();
        return view('admin.inventory', compact('barangs'));
    }

    public function exportInventory()
    {
        $barangs = Barang::all();
        $filename = "inventory_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($barangs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama Barang', 'Stok', 'Harga Barang']);
            foreach ($barangs as $barang) {
                fputcsv($file, [$barang->id, $barang->nama_barang, $barang->stok, $barang->harga_barang]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function laporan()
    {
        $transaksis = Transaksi::with('transaksiDetails.barang')->orderBy('tanggal_transaksi', 'desc')->get();
        return view('admin.laporan', compact('transaksis'));
    }

    public function destroyTransaksi(Transaksi $transaksi)
    {
        // Kembalikan stok barang
        foreach ($transaksi->transaksiDetails as $detail) {
            $barang = $detail->barang;
            $barang->stok += $detail->qty;
            $barang->save();
        }

        $transaksi->delete();
        return redirect()->route('admin.laporan')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
    }

    // Customer methods
    public function customers()
    {
        $customers = Customer::all();
        return view('admin.customers', compact('customers'));
    }

    public function createCustomer()
    {
        return view('admin.create_customer');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        Customer::create($request->all());

        return redirect()->route('admin.customers')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function editCustomer(Customer $customer)
    {
        return view('admin.edit_customer', compact('customer'));
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $customer->update($request->all());

        return redirect()->route('admin.customers')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroyCustomer(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers')->with('success', 'Customer berhasil dihapus.');
    }
}
