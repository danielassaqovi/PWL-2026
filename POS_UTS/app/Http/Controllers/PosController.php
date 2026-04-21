<?php

namespace App\Http\Controllers;

use App\Models\MBarang;
use App\Models\TPenjualan;
use App\Models\TPenjualanDetail;
use App\Models\TStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosController extends Controller
{
    /**
     * Halaman kasir
     */
    public function index()
    {
        $barang = MBarang::with('kategori')->get();
        return view('pos.index', compact('barang'));
    }

    /**
     * Proses transaksi
     */
    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:50',
            'items' => 'required|array',
            'items.*.barang_id' => 'required|exists:m_barang,barang_id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $today = Carbon::now();
            $dateString = $today->format('Ymd');
            
            // Generate kode: TRX-YYYYMMDD-XXXX
            $lastTrx = TPenjualan::where('penjualan_kode', 'like', "TRX-$dateString-%")
                ->latest('penjualan_id')
                ->first();
            
            $nextNumber = 1;
            if ($lastTrx) {
                $lastNumber = (int) substr($lastTrx->penjualan_kode, -4);
                $nextNumber = $lastNumber + 1;
            }
            
            $kode = "TRX-$dateString-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Simpan ke t_penjualan
            $penjualan = TPenjualan::create([
                'user_id' => auth()->id() ?? 1, // Default to 1 if not logged in for UTS
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $kode,
                'penjualan_tanggal' => now(),
            ]);

            foreach ($request->items as $item) {
                $barang = MBarang::find($item['barang_id']);
                
                // Simpan ke t_penjualan_detail
                TPenjualanDetail::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $item['barang_id'],
                    'harga' => $barang->harga_jual,
                    'jumlah' => $item['jumlah'],
                ]);

                // Kurangi stok (Tambah entry ke t_stok dengan jumlah negatif)
                TStok::create([
                    'supplier_id' => 1, // Default or dummy for POS transaction
                    'barang_id' => $item['barang_id'],
                    'user_id' => auth()->id() ?? 1,
                    'stok_tanggal' => now(),
                    'stok_jumlah' => -$item['jumlah'],
                ]);
            }

            return response()->json([
                'success' => true,
                'redirect' => route('pos.struk', $kode)
            ]);
        });
    }

    /**
     * Cetak struk
     */
    public function struk($kode)
    {
        $penjualan = TPenjualan::with(['user', 'detail.barang'])
            ->where('penjualan_kode', $kode)
            ->firstOrFail();
            
        return view('pos.struk', compact('penjualan'));
    }
}
