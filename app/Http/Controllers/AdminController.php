<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\Kategori;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();

        // Pendapatan harian dan bulanan
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        $dailyTransaksis = Transaksi::whereDate('tanggal_transaksi', $today)->get();
        $monthlyTransaksis = Transaksi::whereBetween('tanggal_transaksi', [$startOfMonth, Carbon::now()])->get();

        $dailyRevenue = $dailyTransaksis->sum('total');
        $monthlyRevenue = $monthlyTransaksis->sum('total');

        $dailyCount = $dailyTransaksis->count();
        $monthlyCount = $monthlyTransaksis->count();

        return view('admin.index', compact('barangs', 'dailyRevenue', 'monthlyRevenue', 'dailyCount', 'monthlyCount'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'nullable|string|max:50|unique:barang',
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_barang' => 'required|integer|min:0',
            'kategori_id' => 'nullable|exists:kategoris,id',
        ]);

        Barang::create($request->all());

        return redirect()->route('admin.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('admin.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'nullable|string|max:50|unique:barang,kode_barang,' . $barang->id,
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga_barang' => 'required|integer|min:0',
            'kategori_id' => 'nullable|exists:kategoris,id',
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
        $month = request('month');
        $year = request('year');
        $search = request('search');

        $query = Transaksi::with('transaksiDetails.barang', 'customer');

        if ($month && $year) {
            $query->whereMonth('tanggal_transaksi', $month)
                  ->whereYear('tanggal_transaksi', $year);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('nama', 'like', "%$search%");
                  });
            });
        }

        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        // Data untuk filter
        $months = collect(range(1, 12));
        $currentYear = now()->year;
        $years = collect(range($currentYear - 5, $currentYear));

        return view('admin.laporan', compact('transaksis', 'months', 'years', 'month', 'year', 'search'));
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

    // Kategori methods
    public function kategoris()
    {
        $kategoris = Kategori::with('barangs')->get();
        return view('admin.kategoris', compact('kategoris'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($request->all());

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori(Kategori $kategori)
    {
        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // Laporan Pendapatan Bulanan
    public function pendapatan()
    {
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);

        $transaksis = Transaksi::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->with('transaksiDetails.barang', 'customer')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalPendapatan = $transaksis->sum('total');
        $totalTransaksi = $transaksis->count();

        // Per kategori
        $pendapatanPerKategori = [];
        foreach ($transaksis as $transaksi) {
            foreach ($transaksi->transaksiDetails as $detail) {
                $kategori = $detail->barang->kategori?->nama_kategori ?? 'Tanpa Kategori';
                if (!isset($pendapatanPerKategori[$kategori])) {
                    $pendapatanPerKategori[$kategori] = 0;
                }
                $pendapatanPerKategori[$kategori] += $detail->subtotal;
            }
        }

        $months = collect(range(1, 12));
        $currentYear = now()->year;
        $years = collect(range($currentYear - 5, $currentYear));

        return view('admin.pendapatan', compact(
            'transaksis',
            'totalPendapatan',
            'totalTransaksi',
            'pendapatanPerKategori',
            'bulan',
            'tahun',
            'months',
            'years'
        ));
    }

    // Export Laporan ke CSV
    public function exportLaporan(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $search = $request->search;

        $query = Transaksi::with('transaksiDetails.barang', 'customer');

        if ($month && $year) {
            $query->whereMonth('tanggal_transaksi', $month)
                  ->whereYear('tanggal_transaksi', $year);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('nama', 'like', "%$search%");
                  });
            });
        }

        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        $filename = "laporan_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($transaksis) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Tanggal', 'Customer', 'Total', 'Jumlah Item']);
            foreach ($transaksis as $transaksi) {
                fputcsv($file, [
                    $transaksi->id,
                    $transaksi->tanggal_transaksi->format('d-m-Y H:i'),
                    $transaksi->customer?->nama ?? 'Guest',
                    $transaksi->total,
                    $transaksi->transaksiDetails->count()
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export Laporan Pendapatan
    public function exportPendapatan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $transaksis = Transaksi::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->with('transaksiDetails.barang', 'customer')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalPendapatan = $transaksis->sum('total');

        $filename = "laporan_pendapatan_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($transaksis, $totalPendapatan) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Transaksi ID', 'Customer', 'Total', 'Produk']);
            foreach ($transaksis as $transaksi) {
                $produk = implode('; ', $transaksi->transaksiDetails->map(function($d) {
                    return $d->barang->nama_barang . ' (' . $d->qty . ')';
                })->toArray());
                
                fputcsv($file, [
                    $transaksi->tanggal_transaksi->format('d-m-Y H:i'),
                    $transaksi->id,
                    $transaksi->customer?->nama ?? 'Guest',
                    $transaksi->total,
                    $produk
                ]);
            }
            fputcsv($file, ['', '', '', '']);
            fputcsv($file, ['TOTAL PENDAPATAN', '', '', $totalPendapatan, '']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
