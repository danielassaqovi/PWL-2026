<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\MKategori;
use App\Models\TPenjualan;
use App\Models\TPenjualanDetail;
use App\Models\MSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $categories = MKategori::all();
        $products = MBarang::with('kategori')->get();
        $taxPercentage = MSetting::getTaxPercentage();
        
        return view('pos.index', compact('categories', 'products', 'taxPercentage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:m_barang,barang_id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $penjualan_kode = 'PJ' . date('Ymd') . strtoupper(Str::random(5));
            
            $penjualan = TPenjualan::create([
                'user_id' => auth()->id() ?? 1, // Fallback to user_id 1 if not logged in for demo
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $penjualan_kode,
                'penjualan_tanggal' => now(),
            ]);

            foreach ($request->items as $item) {
                $barang = MBarang::find($item['barang_id']);
                
                // Logika Validasi Stok
                if ($barang->total_stok < $item['jumlah']) {
                    throw new \Exception("Stok tidak mencukupi untuk barang: {$barang->barang_nama}. Sisa stok: {$barang->total_stok}");
                }

                TPenjualanDetail::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $item['barang_id'],
                    'harga' => $barang->harga_jual,
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'redirect' => route('pos.struk', $penjualan->penjualan_kode)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
