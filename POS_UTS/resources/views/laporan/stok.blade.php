@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-navy">Laporan <span class="text-orange-500">Stok</span></h2>
            <p class="text-gray-500">Log mutasi stok barang (masuk/keluar) secara detail.</p>
        </div>
        
        <form action="{{ route('laporan.stok') }}" method="GET" class="flex items-end space-x-4">
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Cari Barang</label>
                <select name="barang_id" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-navy outline-none transition-all w-48">
                    <option value="">Semua Barang</option>
                    @foreach(\App\Models\MBarang::all() as $b)
                        <option value="{{ $b->barang_id }}" {{ request('barang_id') == $b->barang_id ? 'selected' : '' }}>{{ $b->barang_nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-navy text-white px-6 py-2 rounded-xl font-bold hover:bg-slate-800 transition-all">Filter</button>
            @if(request()->anyFilled(['barang_id']))
                <a href="{{ route('laporan.stok') }}" class="text-gray-400 hover:text-red-500 font-bold text-sm underline pb-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-sm">
                <thead class="bg-gray-50 text-gray-500 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Barang</th>
                        <th class="px-6 py-4 font-semibold">Supplier</th>
                        <th class="px-6 py-4 font-semibold text-right">Jumlah</th>
                        <th class="px-6 py-4 font-semibold">Pic (User)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($stok as $s)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $s->stok_tanggal }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-navy">{{ $s->barang->barang_nama }}</span>
                                <span class="text-[10px] text-gray-400 font-mono">{{ $s->barang->barang_kode }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-600">{{ $s->supplier->supplier_nama }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-2 py-1 rounded text-xs font-black {{ $s->stok_jumlah > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $s->stok_jumlah > 0 ? '+' : '' }}{{ $s->stok_jumlah }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs italic text-gray-400">{{ $s->user->nama }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Tidak ada log stok yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
