<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\TPenjualan;
use App\Models\TStok;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Menampilkan dashboard ringkasan
     */
    public function index()
    {
        $totalBarang = MBarang::count();
        $totalTransaksiHariIni = TPenjualan::whereDate('penjualan_tanggal', Carbon::today())->count();
        $totalStok = TStok::sum('stok_jumlah');

        // 5 Transaksi terbaru
        $transaksiTerbaru = TPenjualan::with('user')->latest()->limit(5)->get();

        return view('home.index', compact(
            'totalBarang', 
            'totalTransaksiHariIni', 
            'totalStok',
            'transaksiTerbaru'
        ));
    }
}
