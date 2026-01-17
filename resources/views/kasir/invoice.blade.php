<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaksi->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            padding: 50px; 
            color: #1a1a1a; 
            background-color: #ffffff;
            line-height: 1.5;
        }

        .invoice-wrapper {
            max-width: 850px;
            margin: auto;
        }

        /* Top Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 80px;
        }

        .header h1 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #71717a;
            margin: 0 0 10px 0;
        }

        .invoice-number {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            color: #18181b;
        }

        .company-info {
            text-align: right;
            font-size: 14px;
            color: #71717a;
        }

        .company-name {
            font-weight: 700;
            color: #18181b;
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        /* Metadata Section */
        .metadata {
            display: flex;
            gap: 100px;
            margin-bottom: 50px;
            padding-bottom: 30px;
            border-bottom: 1px solid #f4f4f5;
        }

        .meta-item label {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            color: #a1a1aa;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .meta-item span {
            font-size: 15px;
            font-weight: 500;
        }

        /* Table Style */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 40px; 
        }

        th { 
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #71717a;
            padding: 15px 0;
            border-bottom: 2px solid #18181b;
        }

        td { 
            padding: 20px 0;
            border-bottom: 1px solid #f4f4f5;
            font-size: 15px;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Summary Section */
        .summary {
            display: flex;
            justify-content: flex-end;
        }

        .summary-content {
            width: 250px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .summary-row.total {
            margin-top: 10px;
            padding-top: 20px;
            border-top: 1px solid #f4f4f5;
            font-weight: 700;
            font-size: 20px;
            color: #18181b;
        }

        /* Buttons & Utility */
        .actions {
            margin-top: 80px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
            cursor: pointer;
            margin: 0 10px;
        }

        .btn-dark {
            background: #18181b;
            color: white;
            border: none;
        }

        .btn-dark:hover { background: #3f3f46; }

        .btn-light {
            background: white;
            color: #71717a;
            border: 1px solid #e4e4e7;
        }

        .btn-light:hover { border-color: #18181b; color: #18181b; }

        @media print {
            body { padding: 0; }
            .actions { display: none; }
            .invoice-wrapper { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="invoice-wrapper">
        <header class="header">
            <div>
                <h1>Invoice Transaksi</h1>
                <p class="invoice-number">#{{ $transaksi->id }}</p>
            </div>
            <div class="company-info">
                <span class="company-name">GUDANG INVENTORY</span>
                Jl. Niaga Utama No. 45<br>
                Jakarta, Indonesia
            </div>
        </header>

        <section class="metadata">
            <div class="meta-item">
                <label>Tanggal</label>
                <span>{{ $transaksi->tanggal_transaksi->format('d F Y') }}</span>
            </div>
            <div class="meta-item">
                <label>Waktu</label>
                <span>{{ $transaksi->tanggal_transaksi->format('H:i') }} WIB</span>
            </div>
            <div class="meta-item">
                <label>Status</label>
                <span style="color: #10b981;">● Paid</span>
            </div>
        </section>

        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Item Description</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->transaksiDetails as $detail)
                <tr>
                    <td style="font-weight: 600;">{{ $detail->barang->nama_barang }}</td>
                    <td class="text-center">Rp {{ number_format($detail->harga_barang, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $detail->qty }}</td>
                    <td class="text-right" style="font-weight: 600;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-content">
                <div class="summary-row">
                    <span style="color: #71717a;">Subtotal</span>
                    <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="actions">
        <button onclick="window.print()" class="btn btn-dark">Print Invoice</button>
        <a href="{{ route('kasir.index') }}" class="btn btn-light">Back to Dashboard</a>
    </div>

</body>
</html>