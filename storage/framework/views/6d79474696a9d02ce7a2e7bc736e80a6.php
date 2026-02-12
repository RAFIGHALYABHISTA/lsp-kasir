<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo e($transaksi->id); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>

        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            padding: 40px; 
            color: #1a1a1a; 
            background-color: #f3f4f6;
            line-height: 1.6;
        }

        .invoice-wrapper {
            max-width: 850px;
            margin: auto;
            background: #ffffff;
            padding: 50px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }

        .brand h1 {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
            margin: 0;
            letter-spacing: -1px;
        }

        .invoice-badge {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .company-details {
            text-align: right;
            font-size: 13px;
            color: #6b7280;
        }

        .company-details strong {
            color: #111827;
            font-size: 16px;
            display: block;
            margin-bottom: 4px;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .info-section h4 {
            font-size: 11px;
            text-transform: uppercase;
            color: #9ca3af;
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 5px;
        }

        /* Customer & Meta Styling */
        .customer-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 20px;
            border-radius: 10px;
        }

        .info-label {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2px;
            display: block;
        }

        .info-value {
            font-size: 14px;
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 12px;
            display: block;
        }

        /* Table Styling */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }

        th { 
            background: #111827;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #ffffff;
            padding: 14px 15px;
        }

        td { 
            padding: 16px 15px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #374151;
        }

        tr:nth-child(even) { background-color: #fcfcfc; }

        /* Summary Section */
        .summary-box {
            display: flex;
            justify-content: flex-end;
        }

        .summary-table {
            width: 300px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            color: #4b5563;
        }

        .total-row {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #111827;
            font-weight: 800;
            font-size: 20px;
            color: #111827;
        }

        /* Footer */
        .footer-note {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid #f3f4f6;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }

        /* Action Buttons */
        .actions {
            margin-top: 40px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s;
            border: none;
        }

        .btn-print { background: #111827; color: white; margin-right: 10px; }
        .btn-print:hover { background: #374151; transform: translateY(-1px); }
        .btn-back { background: #ffffff; color: #374151; border: 1px solid #d1d5db; }
        .btn-back:hover { background: #f9fafb; }

        @media print {
            body { background: white; padding: 0; }
            .invoice-wrapper { box-shadow: none; padding: 20px; width: 100%; max-width: 100%; }
            .actions { display: none; }
        }
    </style>
</head>
<body>

    <div class="invoice-wrapper">
        <div class="header">
            <div class="brand">
                <h1>Aplikasi Kasir</h1>
                <span class="invoice-badge">Invoice Resmi Transaksi</span>
            </div>
            <div class="company-details">
                <strong>PT. LAGUNAFRO</strong>
                Jl. Darmo Hill No. 45, Surabaya Selatan, Indonesia<br>
                Email: finance@kasirinventory.com<br>
                Telp: (021) 1234-5678
            </div>
        </div>

        <div class="info-grid">
            <div class="info-section">
                <h4>Detail Invoice</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <span class="info-label">No. Invoice</span>
                        <span class="info-value">#INV-<?php echo e(str_pad($transaksi->id, 6, '0', STR_PAD_LEFT)); ?></span>
                    </div>
                    <div>
                        <span class="info-label">Status</span>
                        <span class="info-value" style="color: #059669;">● LUNAS</span>
                    </div>
                    <div>
                        <span class="info-label">Tanggal</span>
                        <span class="info-value"><?php echo e($transaksi->tanggal_transaksi->format('d/m/Y')); ?></span>
                    </div>
                    <div>
                        <span class="info-label">Waktu</span>
                        <span class="info-value"><?php echo e($transaksi->tanggal_transaksi->format('H:i')); ?> WIB</span>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h4>Informasi Pelanggan</h4>
                <div class="customer-card">
                    <?php if($transaksi->customer): ?>
                        <span class="info-label">Nama Pelanggan</span>
                        <span class="info-value" style="color: #4f46e5; font-size: 16px;"><?php echo e(strtoupper($transaksi->customer->nama)); ?></span>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                            <div>
                                <span class="info-label">No. Telepon</span>
                                <span class="info-value"><?php echo e($transaksi->customer->no_telepon ?? '-'); ?></span>
                            </div>
                            <div>
                                <span class="info-label">Email</span>
                                <span class="info-value" style="font-weight: 400;"><?php echo e($transaksi->customer->email ?? '-'); ?></span>
                            </div>
                        </div>

                        <span class="info-label">Alamat</span>
                        <span class="info-value" style="font-weight: 400; font-size: 12px; margin-bottom: 0;">
                            <?php echo e($transaksi->customer->alamat ?? 'Alamat tidak terdaftar'); ?>

                        </span>
                    <?php else: ?>
                        <div style="text-align: center; padding: 15px 0;">
                            <span style="color: #9ca3af; font-style: italic; font-size: 13px;">Pelanggan Umum (Guest)</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="border-radius: 8px 0 0 0;">Item Deskripsi</th>
                    <th style="text-align: center;">Harga Satuan</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right; border-radius: 0 8px 0 0;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $transaksi->transaksiDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #111827;"><?php echo e($detail->barang->nama_barang); ?></div>
                        <div style="font-size: 11px; color: #9ca3af;">SKU: <?php echo e($detail->barang->kode_barang ?? '-'); ?> | Kategori: <strong><?php echo e($detail->barang->kategori?->nama_kategori ?? '-'); ?></strong></div>
                    </td>
                    <td style="text-align: center;">Rp <?php echo e(number_format($detail->harga_barang, 0, ',', '.')); ?></td>
                    <td style="text-align: center;"><?php echo e($detail->qty); ?></td>
                    <td style="text-align: right; font-weight: 700; color: #111827;">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="summary-box">
            <div class="summary-table">
                <div class="summary-row">
                    <span>Subtotal Produk</span>
                    <span>Rp <?php echo e(number_format($transaksi->total, 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row">
                    <span>Diskon / Promo</span>
                    <span style="color: #ef4444;">- Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Pajak (PPN 0%)</span>
                    <span>Rp 0</span>
                </div>
                <div class="summary-row total-row">
                    <span>Total Bayar</span>
                    <span>Rp <?php echo e(number_format($transaksi->total, 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                    <span style="font-weight: 600;">Uang Diterima</span>
                    <span style="font-weight: 600; color: #059669;">Rp <?php echo e(number_format(session('uang_diterima', $transaksi->total), 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row">
                    <span style="font-weight: 700; color: #111827; font-size: 16px;">Kembalian</span>
                    <span style="font-weight: 700; color: #059669; font-size: 16px;">Rp <?php echo e(number_format(session('kembalian', 0), 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        <div class="footer-note">
            <p><strong>Catatan:</strong> Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan kecuali ada perjanjian sebelumnya.<br>
            Terima kasih telah mempercayai layanan kami.</p>
        </div>
    </div>

    <div class="actions">
        <button onclick="window.print()" class="btn btn-print">Cetak Invoice (PDF)</button>
        <a href="<?php echo e(route('admin.kasir')); ?>" class="btn btn-back">Kembali ke Kasir</a>
    </div>

</body>
</html><?php /**PATH D:\laragon\www\gudang\resources\views/kasir/invoice.blade.php ENDPATH**/ ?>