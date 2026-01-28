<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    // ✅ METHOD INDEX YANG WAJIB ADA
    public function index(Request $request)
    {
        $query = StockIn::with(['user', 'details.product']);

        // Ambil parameter pencarian
        $q = $request->get('q');

        if ($q) {
            $query->whereHas('details.product', function ($qQuery) use ($q) {
                $qQuery->where('nama_barang', 'like', "%{$q}%");
            })
                ->orWhereHas('user', function ($uQuery) use ($q) {
                    $uQuery->where('nama', 'like', "%{$q}%");
                });
        }

        $stockIns = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('stock-in.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock-in.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:products,id_product',
            'jumlah_masuk' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $stockIn = StockIn::create([
                'id_user' => Auth::id(),
                'tanggal_masuk' => now(),
                'keterangan' => $request->keterangan
            ]);

            StockInDetail::create([
                'id_stock_in' => $stockIn->id_stock_in,
                'id_product' => $request->id_product,
                'jumlah_masuk' => $request->jumlah_masuk
            ]);

            Product::where('id_product', $request->id_product)
                ->increment('stok', $request->jumlah_masuk);
        });

        return redirect()->route('stock-in.index')->with('success', 'Barang masuk berhasil dicatat.');
    }

    // Method lain (opsional, tapi aman untuk transaksi)
    public function show(StockIn $stockIn)
    {
        return view('stock-in.show', compact('stockIn'));
    }

    public function edit(StockIn $stockIn)
    {
        $products = Product::all();
        return view('stock-in.edit', compact('stockIn', 'products'));
    }

    public function update(Request $request, StockIn $stockIn)
    {
        // Validasi
        $request->validate([
            'id_product' => 'required|exists:products,id_product',
            'jumlah_masuk' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Ambil data lama
        $oldDetail = $stockIn->details->first();
        $oldJumlah = $oldDetail->jumlah_masuk;
        $oldProduct = $oldDetail->id_product;

        // Jika barang TIDAK berubah
        if ($oldProduct == $request->id_product) {
            // Hanya update selisih jumlah
            $selisih = $request->jumlah_masuk - $oldJumlah;
            Product::where('id_product', $oldProduct)->increment('stok', $selisih);
        } else {
            // Barang BERUBAH → kurangi stok lama, tambah stok baru
            Product::where('id_product', $oldProduct)->decrement('stok', $oldJumlah);
            Product::where('id_product', $request->id_product)->increment('stok', $request->jumlah_masuk);
        }

        // Update detail transaksi
        $oldDetail->update([
            'id_product' => $request->id_product,
            'jumlah_masuk' => $request->jumlah_masuk
        ]);

        // Update header
        $stockIn->update([
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('stock-in.index')->with('success', 'Transaksi masuk berhasil diperbarui.');
    }

    public function destroy(StockIn $stockIn)
    {
        // Ambil detail transaksi
        $detail = $stockIn->details->first();

        if ($detail) {
            // Kembalikan stok (kurangi karena ini transaksi masuk yang dihapus)
            Product::where('id_product', $detail->id_product)
                ->decrement('stok', $detail->jumlah_masuk);
        }

        // Hapus relasi dulu
        $stockIn->details()->delete();

        // Hapus transaksi utama
        $stockIn->delete();

        return redirect()->route('stock-in.index')->with('success', 'Transaksi masuk berhasil dihapus.');
    }
}
