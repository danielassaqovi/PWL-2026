<div class="space-y-4 p-2">
    <div class="grid grid-cols-2 gap-4 rounded-lg bg-gray-50 dark:bg-gray-800 p-4">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kode Transaksi</p>
            <p class="mt-1 text-sm font-bold text-primary-600">{{ $record->penjualan_kode }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pembeli</p>
            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $record->pembeli }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kasir</p>
            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $record->user?->nama ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</p>
            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($record->penjualan_tanggal)->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>

    <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">No.</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Barang</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 dark:text-gray-300">Harga</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 dark:text-gray-300">Qty</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 dark:text-gray-300">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @php $grandTotal = 0; @endphp
                @foreach ($record->detail as $i => $item)
                    @php
                        $subtotal    = $item->harga * $item->jumlah;
                        $grandTotal += $subtotal;
                    @endphp
                    <tr class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-800/50' : '' }}">
                        <td class="px-4 py-2 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">
                            {{ $item->barang?->barang_nama ?? '-' }}
                        </td>
                        <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-300">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-300">
                            {{ $item->jumlah }}
                        </td>
                        <td class="px-4 py-2 text-right font-semibold text-gray-900 dark:text-white">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-primary-50 dark:bg-primary-900/20">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right text-sm font-bold text-gray-700 dark:text-gray-200">
                        GRAND TOTAL
                    </td>
                    <td class="px-4 py-3 text-right text-base font-bold text-primary-600 dark:text-primary-400">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
