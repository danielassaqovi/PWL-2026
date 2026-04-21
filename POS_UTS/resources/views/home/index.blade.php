@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="bg-navy rounded-2xl p-8 text-white relative overflow-hidden shadow-xl">
        <div class="relative z-10 md:w-2/3">
            <h1 class="text-4xl font-extrabold mb-4">Selamat Datang di <span class="text-orange-400">POS System</span></h1>
            <p class="text-gray-300 text-lg mb-6">Kelola transaksi penjualan Anda dengan lebih efisien, cepat, dan akurat. Pantau stok barang dan laporan penjualan secara real-time.</p>
            <div class="flex space-x-4">
                <a href="{{ route('pos.index') }}" class="bg-orange-custom hover-orange px-6 py-3 rounded-xl font-bold transition-all flex items-center">
                    Mulai Kasir
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="/admin" class="bg-white/10 hover:bg-white/20 px-6 py-3 rounded-xl font-bold transition-all border border-white/30">
                    Dashboard Admin
                </a>
            </div>
        </div>
        <!-- Decorative blob -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-orange-500/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Barang</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBarang }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Transaksi Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTransaksiHariIni }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Kategori</p>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\MKategori::count() }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Stok</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalStok }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">5 Transaksi Terbaru</h2>
            <a href="{{ route('laporan.penjualan') }}" class="text-navy font-semibold text-sm hover:text-orange-500 transition-colors">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Kode</th>
                        <th class="px-6 py-4 font-semibold">Pembeli</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-right">Total</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksiTerbaru as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $trx->penjualan_kode }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $trx->pembeli }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $trx->penjualan_tanggal }}</td>
                        <td class="px-6 py-4 text-right font-bold text-navy">{{ $trx->total_penjualan }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('pos.struk', $trx->penjualan_kode) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat Struk</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
