<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\StockOut;
use App\Models\StockOutDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InventOxSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // === 1. Users (SESUAI INVENTOX (2).DOCX) ===
        User::truncate();
        User::create([
            'nama' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
        User::create([
            'nama' => 'Staff 1',
            'email' => 'staff1@gmail.com',
            'password' => Hash::make('staff1'),
            'role' => 'staff'
        ]);
        User::create([
            'nama' => 'Staff 2',
            'email' => 'staff2@gmail.com',
            'password' => Hash::make('staff2'),
            'role' => 'staff'
        ]);

        // === 2. Categories ===
        Category::truncate();
        $categories = [
            ['nama_category' => 'Bahan Pokok'],
            ['nama_category' => 'Kebersihan'],
            ['nama_category' => 'Makanan Beku'],
            ['nama_category' => 'Minuman'],
            ['nama_category' => 'Snack'],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $c = Category::create($cat);
            $categoryIds[$cat['nama_category']] = $c->id_category;
        }

        // === 3. Products (stok awal = 0, nanti diisi lewat stock-in) ===
        Product::truncate();
        $products = [
            ['nama_barang' => 'Beras Cap Tani', 'kategori' => 'Bahan Pokok', 'minimal_stok' => 100, 'satuan' => 'kg'],
            ['nama_barang' => 'Sabun Cuci Piring', 'kategori' => 'Kebersihan', 'minimal_stok' => 20, 'satuan' => 'pouch'],
            ['nama_barang' => 'Nugget Ayam 500gr', 'kategori' => 'Makanan Beku', 'minimal_stok' => 10, 'satuan' => 'bungkus'],
            ['nama_barang' => 'Minyak Goreng', 'kategori' => 'Bahan Pokok', 'minimal_stok' => 50, 'satuan' => 'liter'],
            ['nama_barang' => 'Gula Pasir', 'kategori' => 'Bahan Pokok', 'minimal_stok' => 30, 'satuan' => 'kg'],
        ];

        $productMap = [];
        foreach ($products as $p) {
            $prod = Product::create([
                'id_category' => $categoryIds[$p['kategori']],
                'nama_barang' => $p['nama_barang'],
                'stok' => 0,
                'minimal_stok' => $p['minimal_stok'],
                'satuan' => $p['satuan']
            ]);
            $productMap[$p['nama_barang']] = $prod->id_product;
        }

        // === 4. Stock In (Barang Masuk) ===
        StockIn::truncate();
        StockInDetail::truncate();

        $stockIns = [
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-10',
                'keterangan' => 'Pembelian dari Supplier Tani Jaya',
                'details' => [['barang' => 'Beras Cap Tani', 'jumlah' => 50]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-11',
                'keterangan' => 'Masuk gudang baru dari distributor',
                'details' => [['barang' => 'Sabun Cuci Piring', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-11',
                'keterangan' => 'Pembelian dari Supplier Fiesta',
                'details' => [['barang' => 'Nugget Ayam 500gr', 'jumlah' => 50]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-12',
                'keterangan' => 'Restok minyak goreng',
                'details' => [['barang' => 'Minyak Goreng', 'jumlah' => 200]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-13',
                'keterangan' => 'Pembelian dari PT SGN',
                'details' => [['barang' => 'Gula Pasir', 'jumlah' => 50]]
            ],
        ];

        foreach ($stockIns as $si) {
            $userId = User::where('nama', $si['user'])->first()->id_user;
            $stockIn = StockIn::create([
                'id_user' => $userId,
                'tanggal_masuk' => $si['tanggal'],
                'keterangan' => $si['keterangan']
            ]);

            foreach ($si['details'] as $detail) {
                $productId = $productMap[$detail['barang']];
                StockInDetail::create([
                    'id_stock_in' => $stockIn->id_stock_in,
                    'id_product' => $productId,
                    'jumlah_masuk' => $detail['jumlah']
                ]);
                Product::where('id_product', $productId)->increment('stok', $detail['jumlah']);
            }
        }

        // === 5. Stock Out (Barang Keluar) ===
        StockOut::truncate();
        StockOutDetail::truncate();

        $stockOuts = [
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-12',
                'keterangan' => 'Penjualan grosir ke warung Pak Budi',
                'details' => [['barang' => 'Beras Cap Tani', 'jumlah' => 30]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-12',
                'keterangan' => 'Penjualan ritel',
                'details' => [['barang' => 'Sabun Cuci Piring', 'jumlah' => 10]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-13',
                'keterangan' => 'Penjualan ke pelanggan tetap',
                'details' => [['barang' => 'Nugget Ayam 500gr', 'jumlah' => 15]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-15',
                'keterangan' => 'Penjualan toko',
                'details' => [['barang' => 'Minyak Goreng', 'jumlah' => 25]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-16',
                'keterangan' => 'Penjualan grosir gula',
                'details' => [['barang' => 'Gula Pasir', 'jumlah' => 25]]
            ],
        ];

        foreach ($stockOuts as $so) {
            $userId = User::where('nama', $so['user'])->first()->id_user;
            $stockOut = StockOut::create([
                'id_user' => $userId,
                'tanggal_keluar' => $so['tanggal'],
                'keterangan' => $so['keterangan']
            ]);

            foreach ($so['details'] as $detail) {
                $productId = $productMap[$detail['barang']];
                StockOutDetail::create([
                    'id_stock_out' => $stockOut->id_stock_out,
                    'id_product' => $productId,
                    'jumlah_keluar' => $detail['jumlah']
                ]);
                Product::where('id_product', $productId)->decrement('stok', $detail['jumlah']);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}