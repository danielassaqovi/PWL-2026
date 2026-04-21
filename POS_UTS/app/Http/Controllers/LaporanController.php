<?php

namespace App\Http\Controllers;

use App\Models\TPenjualan;
use App\Models\TStok;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan penjualan
     */
    public function penjualan(Request $request)
    {
        $query = TPenjualan::with(['user', 'detail']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('penjualan_tanggal', [$request->start_date, $request->end_date]);
        }

        $penjualan = $query->latest()->get();
        
        $totalOmzet = $penjualan->sum(function ($p) {
            return $p->detail->sum(fn($d) => $d->harga * $d->jumlah);
        });

        return view('laporan.penjualan', compact('penjualan', 'totalOmzet'));
    }

    /**
     * Laporan stok
     */
    public function stok(Request $request)
    {
        $query = TStok::with(['barang', 'supplier', 'user']);

        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }
        
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $stok = $query->latest()->get();

        return view('laporan.stok', compact('stok'));
    }
}
