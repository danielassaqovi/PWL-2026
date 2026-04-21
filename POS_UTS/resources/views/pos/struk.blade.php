@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <!-- Kontainer Struk -->
    <div id="print-area" class="bg-white p-8 shadow-sm border border-gray-100 rounded-lg font-mono text-sm text-gray-800">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-black text-navy uppercase tracking-widest mb-1">POS SYSTEM</h2>
            <p class="text-xs text-gray-400">Jl. Teknologi Canggih No. 123, Malang</p>
            <p class="text-xs text-gray-400">Telp: 0812-3456-7890</p>
            <div class="border-b-2 border-dashed border-gray-200 my-4"></div>
        </div>

        <div class="space-y-1 mb-6">
            <div class="flex justify-between">
                <span>No. Transaksi</span>
                <span class="font-bold">{{ $penjualan->penjualan_kode }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $penjualan->penjualan_tanggal }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span>{{ $penjualan->user->nama }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pembeli</span>
                <span>{{ $penjualan->pembeli }}</span>
            </div>
        </div>

        <div class="border-b border-dashed border-gray-200 mb-4"></div>

        <!-- Detail Barang -->
        <div class="space-y-4 mb-6">
            @foreach($penjualan->detail as $item)
            <div>
                <div class="flex justify-between">
                    <span class="font-bold uppercase">{{ $item->barang->barang_nama }}</span>
                    <span>{{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>{{ $item->jumlah }} x {{ number_format($item->harga, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="border-b-2 border-dashed border-gray-200 mb-4"></div>

        <div class="space-y-2">
            <div class="flex justify-between items-center text-lg font-black">
                <span>TOTAL</span>
                <span class="text-navy">{{ $penjualan->total_penjualan }}</span>
            </div>
        </div>

        <div class="mt-10 text-center space-y-2">
            <p class="text-xs font-bold uppercase tracking-widest">Terima Kasih</p>
            <p class="text-[10px] text-gray-400">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
        </div>
    </div>

    <!-- Aksi -->
    <div class="mt-8 flex space-x-4 no-print">
        <button onclick="window.print()" class="flex-grow bg-navy text-white py-3 rounded-xl font-bold flex items-center justify-center hover:bg-slate-800 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Struk
        </button>
        <a href="{{ route('pos.index') }}" class="flex-grow bg-white border border-gray-200 text-gray-600 py-3 rounded-xl font-bold flex items-center justify-center hover:bg-gray-50 transition-all">
            Halaman Kasir
        </a>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
