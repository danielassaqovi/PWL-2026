@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-navy">Laporan <span class="text-orange-500">Penjualan</span></h2>
            <p class="text-gray-500">Pantau performa penjualan produk Anda di sini.</p>
        </div>
        
        <form action="{{ route('laporan.penjualan') }}" method="GET" class="flex items-end space-x-4">
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-navy outline-none transition-all">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-navy outline-none transition-all">
            </div>
            <button type="submit" class="bg-navy text-white px-6 py-2 rounded-xl font-bold hover:bg-slate-800 transition-all">Filter</button>
            @if(request()->anyFilled(['start_date', 'end_date']))
                <a href="{{ route('laporan.penjualan') }}" class="text-gray-400 hover:text-red-500 font-bold text-sm underline pb-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode Transaksi</th>
                        <th class="px-6 py-4 font-semibold">Pembeli</th>
                        <th class="px-6 py-4 font-semibold">Kasir</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-right">Total Item</th>
                        <th class="px-6 py-4 font-semibold text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($penjualan as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-mono font-bold text-navy">{{ $trx->penjualan_kode }}</td>
                        <td class="px-6 py-4">{{ $trx->pembeli }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs font-semibold">{{ $trx->user->nama }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $trx->penjualan_tanggal }}</td>
                        <td class="px-6 py-4 text-right">{{ $trx->detail->count() }}</td>
                        <td class="px-6 py-4 text-right font-black text-navy">{{ $trx->total_penjualan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">Tidak ada data transaksi yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-navy text-white">
                    <tr>
                        <td colspan="5" class="px-6 py-4 font-bold text-right text-base">TOTAL OMZET</td>
                        <td class="px-6 py-4 text-right font-black text-xl text-orange-400">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
