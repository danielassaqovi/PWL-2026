<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan - {{ $penjualan->penjualan_kode }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 80mm; margin: 0 auto; padding: 10px; font-size: 12px; color: #000; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .info p { margin: 2px 0; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; }
        table th { text-align: left; border-bottom: 1px dashed #000; padding: 5px 0; }
        table td { padding: 5px 0; vertical-align: top; }
        .total-row td { border-top: 1px dashed #000; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
        @media print {
            body { width: 100%; margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>POS APP</h2>
        <p>Jl. PWL No. 2026, Malang</p>
        <p>Telp: 08123456789</p>
    </div>

    <div class="divider"></div>

    <div class="info">
        <p><span>No. Nota:</span> <span>{{ $penjualan->penjualan_kode }}</span></p>
        <p><span>Tanggal:</span> <span>{{ $penjualan->penjualan_tanggal }}</span></p>
        <p><span>Kasir:</span> <span>{{ $penjualan->user->nama }}</span></p>
        <p><span>Pembeli:</span> <span>{{ $penjualan->pembeli }}</span></p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->detail as $item)
                <tr>
                    <td>{{ $item->barang->barang_nama }}<br><small>{{ number_format($item->harga, 0, ',', '.') }}</small></td>
                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                    <td style="text-align: right;">{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">TOTAL</td>
                <td style="text-align: right;">{{ $penjualan->total_penjualan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="footer">
        <p>Terima Kasih Atas Kunjungan Anda</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">Cetak Ulang</button>
        <button onclick="window.close()">Tutup</button>
    </div>
</body>
</html>
