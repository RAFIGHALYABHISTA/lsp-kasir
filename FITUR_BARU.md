# Dokumentasi Fitur Baru - Sistem Kasir Gudang

## Fitur-Fitur yang Ditambahkan

### 1. **Laporan Pendapatan Bulanan** ✅

**Lokasi:** Menu → Reports & Stats → Laporan Pendapatan

**Fitur:**

- Filter berdasarkan bulan dan tahun
- Tampilan ringkasan: Total pendapatan, jumlah transaksi, rata-rata transaksi
- Detail pendapatan per kategori produk
- List lengkap transaksi untuk periode yang dipilih
- Export data ke CSV

**Database:**

- Menggunakan tabel `transaksi` dan `transaksi_detail` yang sudah ada
- Menampilkan breakdown per kategori produk

---

### 2. **Fitur Kembalian/Return** ✅

**Lokasi:**

- Menu → Management → Return/Kembalian (untuk admin)
- Invoice → Tombol "Ajukan Return/Kembalian" (untuk kasir)

**Fitur:**

- Kasir dapat mengajukan return melalui modal di halaman invoice
- Admin dapat melihat, menyetujui, menolak, atau menghapus return
- Sistem tracking status return: Pending → Approved/Rejected
- Otomatis kembalikan stok barang ketika return disetujui

**Database:**

- Migration baru: `returns` table dengan field:
    - `transaksi_id` - referensi transaksi
    - `barang_id` - referensi barang
    - `qty` - jumlah kembalian
    - `harga_barang` - harga saat pembelian
    - `total_return` - total nilai return
    - `alasan` - alasan kembalian
    - `status` - pending/approved/rejected
    - `tanggal_return` - tanggal return

---

### 3. **Export Laporan ke CSV** ✅

**Lokasi:**

- Laporan Transaksi → Tombol "Export CSV"
- Laporan Pendapatan → Tombol "Export CSV"
- Inventory → Tombol "Export CSV" (sudah ada)

**Fitur:**

- Export laporan transaksi dengan filter (bulan, tahun, pencarian)
- Export laporan pendapatan bulanan
- Format CSV yang dapat dibuka di Excel/Google Sheets

---

### 4. **Manajemen Kategori Produk** ✅

**Lokasi:** Menu → Management → Kategori

**Fitur:**

- Tambah kategori produk baru
- Edit kategori (nama + deskripsi)
- Hapus kategori
- Lihat jumlah produk per kategori
- Modal popup untuk edit kategori

**Database:**

- Migration baru: `kategoris` table dengan field:
    - `nama_kategori` - nama kategori (unique)
    - `deskripsi` - deskripsi kategori

---

### 5. **Kode Produk Unik** ✅

**Lokasi:** Form Tambah/Edit Barang → Field "Kode Produk"

**Fitur:**

- Setiap produk dapat memiliki kode unik (SKU/Barcode)
- Kode bersifat unik per produk (tidak boleh duplikat)
- Ditampilkan di:
    - Tabel inventory
    - Tabel dashboard
    - Invoice (sebagai SKU)
    - Form create/edit barang

**Database:**

- Migration baru: tambah column `kode_barang` ke tabel `barang`
- Migration baru: tambah foreign key `kategori_id` ke tabel `barang`

---

### 6. **Searchbar & Filter di Halaman Laporan** ✅

**Lokasi:** Menu → Reports & Stats → Laporan Transaksi

**Fitur:**

- Filter berdasarkan bulan
- Filter berdasarkan tahun
- Pencarian berdasarkan:
    - ID Transaksi
    - Nama Customer
- Tombol reset untuk menghapus semua filter
- Kombinasi filter dapat digunakan bersamaan

---

## File-File yang Dibuat/Dimodifikasi

### Migrations (Database)

```
✅ database/migrations/2026_02_12_000000_create_kategoris_table.php
✅ database/migrations/2026_02_12_000001_add_kategori_and_kode_to_barang_table.php
✅ database/migrations/2026_02_12_000002_create_returns_table.php
```

### Models

```
✅ app/Models/Kategori.php (baru)
✅ app/Models/Return.php (baru)
✅ app/Models/Barang.php (modified - tambah relationships)
✅ app/Models/Transaksi.php (modified - tambah relationships)
```

### Controllers

```
✅ app/Http/Controllers/AdminController.php (modified - tambah methods)
✅ app/Http/Controllers/KasirController.php (modified - tambah return method)
```

### Routes

```
✅ routes/web.php (modified - tambah routes kategori, returns, pendapatan)
```

### Views

```
✅ resources/views/admin/kategoris.blade.php (baru)
✅ resources/views/admin/returns.blade.php (baru)
✅ resources/views/admin/pendapatan.blade.php (baru)
✅ resources/views/admin/create.blade.php (modified - tambah kategori & kode)
✅ resources/views/admin/edit.blade.php (modified - tambah kategori & kode)
✅ resources/views/admin/index.blade.php (modified - tampil kategori & kode)
✅ resources/views/admin/laporan.blade.php (modified - filter & export)
✅ resources/views/kasir/invoice.blade.php (modified - modal return)
✅ resources/views/layouts/sidebar.blade.php (modified - menu baru)
```

---

## Langkah-Langkah Setup

### 1. Run Migrations

```bash
php artisan migrate
```

### 2. Clear Cache (optional)

```bash
php artisan cache:clear
```

### 3. Test Fitur-Fitur Baru

- Buka halaman Dashboard → cek menu sidebar
- Coba tambah kategori baru
- Coba tambah barang dengan kategori dan kode
- Test laporan transaksi dengan filter
- Test laporan pendapatan
- Test return dari invoice
- Coba export ke CSV

---

## Informasi Teknis

### Relationships Model

```
Barang:
  - belongsTo(Kategori)
  - hasMany(TransaksiDetail)
  - hasMany(Return)

Kategori:
  - hasMany(Barang)

Transaksi:
  - hasMany(TransaksiDetail)
  - hasMany(Return)
  - belongsTo(Customer)

Return:
  - belongsTo(Transaksi)
  - belongsTo(Barang)
```

### Export Format

- Format: CSV (Comma Separated Values)
- Encoding: UTF-8
- Delimiter: Koma (,)
- Dapat dibuka di: Excel, Google Sheets, Numbers, LibreOffice

---

## Tips Penggunaan

1. **Untuk Laporan Pendapatan:**
    - Gunakan filter bulan + tahun untuk melihat pendapatan periode tertentu
    - Data otomatis menghitung pendapatan per kategori
    - Export CSV untuk analisis lebih lanjut di spreadsheet

2. **Untuk Return/Kembalian:**
    - Kasir hanya perlu klik tombol di invoice untuk ajukan return
    - Admin akan review dan approve/reject return
    - Stok otomatis dikembalikan setelah approval

3. **Untuk Kategori:**
    - Buat kategori dulu sebelum menambah barang
    - Kategori membantu analisis penjualan per kategori
    - Satu barang hanya bisa punya satu kategori

4. **Untuk Kode Produk:**
    - Gunakan format konsisten (misal: KBK001, KBK002, dll)
    - Kode memudahkan tracking dan inventory count
    - Kode ditampilkan di invoice sebagai SKU

---

## Testing Checklist

- [ ] Tambah kategori baru
- [ ] Edit kategori
- [ ] Hapus kategori
- [ ] Tambah barang dengan kategori dan kode
- [ ] Edit barang mengubah kategori
- [ ] Lihat inventory dengan filter kategori
- [ ] Buat transaksi baru
- [ ] Ajukan return dari invoice
- [ ] Admin approve return
- [ ] Cek stok otomatis terkaembali
- [ ] Filter laporan transaksi (bulan, tahun, customer)
- [ ] Export laporan transaksi
- [ ] Export laporan pendapatan
- [ ] Filter laporan pendapatan per bulan
- [ ] Lihat breakdown pendapatan per kategori

---

**Dibuat:** 12 February 2026
**Status:** Semua fitur sudah diimplementasikan ✅
