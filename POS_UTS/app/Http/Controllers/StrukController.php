<?php

namespace App\Http\Controllers;

use App\Models\TPenjualan;
use Illuminate\Http\Request;

class StrukController extends Controller
{
    public function cetak($kode)
    {
        $penjualan = TPenjualan::with(['detail.barang', 'user'])
            ->where('penjualan_kode', $kode)
            ->firstOrFail();

        return view('pos.struk', compact('penjualan'));
    }
}
