<div class="p-4 space-y-4">
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><strong>Kode:</strong> {{ $penjualan->penjualan_kode }}</div>
        <div><strong>Pembeli:</strong> {{ $penjualan->pembeli }}</div>
        <div><strong>Kasir:</strong> {{ $penjualan->user->nama }}</div>
        <div><strong>Tanggal:</strong> {{ $penjualan->penjualan_tanggal->format('d/m/Y H:i') }}</div>
    </div>
    <table class="w-full text-sm border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Barang</th>
                <th class="p-2 text-right">Harga</th>
                <th class="p-2 text-right">Qty</th>
                <th class="p-2 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->detail as $d)
            <tr class="border-t">
                <td class="p-2">{{ $d->barang->barang_nama }}</td>
                <td class="p-2 text-right">Rp {{ number_format($d->harga,0,',','.') }}</td>
                <td class="p-2 text-right">{{ $d->jumlah }}</td>
                <td class="p-2 text-right">Rp {{ number_format($d->harga * $d->jumlah,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-t font-bold bg-gray-50">
                <td colspan="3" class="p-2 text-right">Total</td>
                <td class="p-2 text-right">
                    Rp {{ number_format($penjualan->detail->sum(fn($d) => $d->harga * $d->jumlah),0,',','.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
