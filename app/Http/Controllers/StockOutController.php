<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockOut;
use App\Models\StockOutDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    // ✅ METHOD INDEX WAJIB ADA
    public function index(Request $request)
    {
        $query = StockOut::with(['user', 'details.product']);

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

        $stockOuts = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('stock-out.index', compact('stockOuts'));
    }

    public function create()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('stock-out.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:products,id_product',
            'jumlah_keluar' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->id_product);
        if ($request->jumlah_keluar > $product->stok) {
            return back()->withErrors(['jumlah_keluar' => 'Stok tidak cukup. Tersedia: ' . $product->stok]);
        }

        DB::transaction(function () use ($request, $product) {
            $stockOut = StockOut::create([
                'id_user' => Auth::id(),
                'tanggal_keluar' => now(),
                'keterangan' => $request->keterangan
            ]);

            StockOutDetail::create([
                'id_stock_out' => $stockOut->id_stock_out,
                'id_product' => $request->id_product,
                'jumlah_keluar' => $request->jumlah_keluar
            ]);

            $product->decrement('stok', $request->jumlah_keluar);
        });

        return redirect()->route('stock-out.index')->with('success', 'Barang keluar berhasil dicatat.');
    }

    // Method lain (tidak dipakai untuk transaksi)
    public function show(StockOut $stockOut)
    {
        return view('stock-out.show', compact('stockOut'));
    }

    public function edit(StockOut $stockOut)
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('stock-out.edit', compact('stockOut', 'products'));
    }

    public function update(Request $request, StockOut $stockOut)
    {
        // Validasi
        $request->validate([
            'id_product' => 'required|exists:products,id_product',
            'jumlah_keluar' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Ambil data lama
        $oldDetail = $stockOut->details->first();
        $oldJumlah = $oldDetail->jumlah_keluar;
        $oldProduct = $oldDetail->id_product;

        // Jika barang TIDAK berubah
        if ($oldProduct == $request->id_product) {
            // Hanya update selisih jumlah
            $selisih = $request->jumlah_keluar - $oldJumlah;

            // Cek stok cukup untuk penambahan
            if ($selisih > 0) {
                $currentStok = Product::where('id_product', $oldProduct)->value('stok');
                if ($selisih > $currentStok) {
                    return back()->withErrors(['jumlah_keluar' => 'Stok tidak cukup untuk jumlah baru.']);
                }
            }

            // Update stok
            Product::where('id_product', $oldProduct)->decrement('stok', $selisih);
        } else {
            // Barang BERUBAH

            // Kembalikan stok lama
            Product::where('id_product', $oldProduct)->increment('stok', $oldJumlah);

            // Cek stok baru cukup
            $newProduct = Product::findOrFail($request->id_product);
            if ($request->jumlah_keluar > $newProduct->stok) {
                return back()->withErrors(['jumlah_keluar' => 'Stok tidak cukup untuk jumlah baru.']);
            }

            // Kurangi stok baru
            $newProduct->decrement('stok', $request->jumlah_keluar);
        }

        // Update detail transaksi
        $oldDetail->update([
            'id_product' => $request->id_product,
            'jumlah_keluar' => $request->jumlah_keluar
        ]);

        // Update header
        $stockOut->update([
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('stock-out.index')->with('success', 'Transaksi keluar berhasil diperbarui.');
    }

    public function destroy(StockOut $stockOut)
    {
        $detail = $stockOut->details->first();
        Product::where('id_product', $detail->id_product)->increment('stok', $detail->jumlah_keluar);

        $stockOut->details()->delete();
        $stockOut->delete();

        return redirect()->route('stock-out.index')->with('success', 'Transaksi keluar berhasil dihapus.');
    }
}
