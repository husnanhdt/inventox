<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung semua data dashboard
        $total_barang = Product::count();
        $jumlah_habis = Product::where('stok', 0)->count();
        $jumlah_menipis = Product::whereBetween('stok', [1, DB::raw('minimal_stok')])->count();

        $today = now()->toDateString();
        $total_masuk_hari_ini = StockInDetail::join('stock_ins', 'stock_in_detail.id_stock_in', '=', 'stock_ins.id_stock_in')
            ->whereDate('stock_ins.tanggal_masuk', $today)
            ->sum('jumlah_masuk');

        $total_keluar_hari_ini = StockOutDetail::join('stock_outs', 'stock_out_detail.id_stock_out', '=', 'stock_outs.id_stock_out')
            ->whereDate('stock_outs.tanggal_keluar', $today)
            ->sum('jumlah_keluar');

        // 🔹 Ganti dari take(5)->get() → paginate(5)
        $recentStockIns = StockIn::with('user', 'details.product')->latest()->paginate(5, ['*'], 'page_masuk');
        $recentStockOuts = StockOut::with('user', 'details.product')->latest()->paginate(5, ['*'], 'page_keluar');

        return view('dashboard', compact(
            'total_barang',
            'jumlah_habis',
            'jumlah_menipis',
            'total_masuk_hari_ini',
            'total_keluar_hari_ini',
            'recentStockIns',
            'recentStockOuts'
        ));
    }

    // 🔍 Pencarian Barang
    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::with('category')
            ->where('nama_barang', 'like', "%{$query}%")
            ->orWhereHas('category', fn($q) => $q->where('nama_category', 'like', "%{$query}%"))
            ->paginate(10);

        // Reuse logic from index()
        $total_barang = Product::count();
        $jumlah_habis = Product::where('stok', 0)->count();
        $jumlah_menipis = Product::whereBetween('stok', [1, DB::raw('minimal_stok')])->count();

        $today = now()->toDateString();
        $total_masuk_hari_ini = StockInDetail::join('stock_ins', 'stock_in_detail.id_stock_in', '=', 'stock_ins.id_stock_in')
            ->whereDate('stock_ins.tanggal_masuk', $today)
            ->sum('jumlah_masuk');

        $total_keluar_hari_ini = StockOutDetail::join('stock_outs', 'stock_out_detail.id_stock_out', '=', 'stock_outs.id_stock_out')
            ->whereDate('stock_outs.tanggal_keluar', $today)
            ->sum('jumlah_keluar');

        $recentStockIns = StockIn::with('user', 'details.product')->latest()->take(5)->get();
        $recentStockOuts = StockOut::with('user', 'details.product')->latest()->take(5)->get();

        return view('dashboard', compact(
            'products',
            'total_barang',
            'jumlah_habis',
            'jumlah_menipis',
            'total_masuk_hari_ini',
            'total_keluar_hari_ini',
            'recentStockIns',
            'recentStockOuts'
        ))->with('search_query', $query);
    }

    // 📄 Generate Laporan Stok ke PDF
    public function generateReportPDF()
    {
        $products = Product::with('category')->get();
        $pdf = Pdf::loadView('exports.stock-report', compact('products'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Stok_InventOx_' . now()->format('Y-m-d') . '.pdf');
    }
}
