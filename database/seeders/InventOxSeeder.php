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

        // === 1. USERS ===
        User::truncate();
        $users = [
            [
                'nama' => 'Admin Toko',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
            [
                'nama' => 'Staff 1',
                'email' => 'staff1@gmail.com',
                'password' => Hash::make('staff1'),
                'role' => 'staff'
            ],
            [
                'nama' => 'Staff 2',
                'email' => 'staff2@gmail.com',
                'password' => Hash::make('staff2'),
                'role' => 'staff'
            ],
            [
                'nama' => 'Staff 3',
                'email' => 'staff3@gmail.com',
                'password' => Hash::make('staff3'),
                'role' => 'staff'
            ],
            [
                'nama' => 'admin',
                'email' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // === 2. CATEGORIES ===
        Category::truncate();
        $categories = [
            ['nama_category' => 'Bahan Pokok'],
            ['nama_category' => 'Kebersihan'],
            ['nama_category' => 'Makanan Beku'],
            ['nama_category' => 'Minuman'],
            ['nama_category' => 'Snack'],
            ['nama_category' => 'ATK'],
            ['nama_category' => 'Obat'],
            ['nama_category' => 'Perawatan Tubuh'],
            ['nama_category' => 'Peralatan Rumah Tangga'],
            ['nama_category' => 'Kebutuhan Bayi'],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $c = Category::create($cat);
            $categoryIds[$cat['nama_category']] = $c->id_category;
        }

        // === 3. PRODUCTS ===
        Product::truncate();
        $products = [
            // Bahan Pokok
            ['nama_barang' => 'Beras Cap Tani', 'kategori' => 'Bahan Pokok', 'stok' => 280, 'minimal_stok' => 100, 'satuan' => 'kg'],
            ['nama_barang' => 'Minyak Goreng', 'kategori' => 'Bahan Pokok', 'stok' => 175, 'minimal_stok' => 50, 'satuan' => 'liter'],
            ['nama_barang' => 'Gula Pasir', 'kategori' => 'Bahan Pokok', 'stok' => 25, 'minimal_stok' => 30, 'satuan' => 'kg'],
            ['nama_barang' => 'Susu', 'kategori' => 'Bahan Pokok', 'stok' => 100, 'minimal_stok' => 15, 'satuan' => 'pcs'],
            ['nama_barang' => 'Telur Ayam', 'kategori' => 'Bahan Pokok', 'stok' => 1500, 'minimal_stok' => 100, 'satuan' => 'pcs'],
            
            // Kebersihan
            ['nama_barang' => 'Sabun Cuci Piring', 'kategori' => 'Kebersihan', 'stok' => 90, 'minimal_stok' => 20, 'satuan' => 'pouch'],
            ['nama_barang' => 'Sabun Biore', 'kategori' => 'Kebersihan', 'stok' => 200, 'minimal_stok' => 30, 'satuan' => 'pcs'],
            ['nama_barang' => 'Cling', 'kategori' => 'Kebersihan', 'stok' => 70, 'minimal_stok' => 25, 'satuan' => 'pcs'],
            ['nama_barang' => 'Detergen', 'kategori' => 'Kebersihan', 'stok' => 60, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Sabun Dettol', 'kategori' => 'Kebersihan', 'stok' => 80, 'minimal_stok' => 40, 'satuan' => 'pcs'],
            
            // Makanan Beku
            ['nama_barang' => 'Nugget Ayam 500gr', 'kategori' => 'Makanan Beku', 'stok' => 85, 'minimal_stok' => 10, 'satuan' => 'bungkus'],
            ['nama_barang' => 'sosis', 'kategori' => 'Makanan Beku', 'stok' => 75, 'minimal_stok' => 15, 'satuan' => 'pcs'],
            ['nama_barang' => 'Bakso', 'kategori' => 'Makanan Beku', 'stok' => 90, 'minimal_stok' => 30, 'satuan' => 'pcs'],
            ['nama_barang' => 'Chicken Wings', 'kategori' => 'Makanan Beku', 'stok' => 100, 'minimal_stok' => 30, 'satuan' => 'pcs'],
            ['nama_barang' => 'Crab Stick', 'kategori' => 'Makanan Beku', 'stok' => 85, 'minimal_stok' => 40, 'satuan' => 'pcs'],
            
            // Minuman
            ['nama_barang' => 'Teh Pucuk', 'kategori' => 'Minuman', 'stok' => 100, 'minimal_stok' => 50, 'satuan' => 'botol'],
            ['nama_barang' => 'Floridina', 'kategori' => 'Minuman', 'stok' => 200, 'minimal_stok' => 50, 'satuan' => 'botol'],
            ['nama_barang' => 'YouC1000', 'kategori' => 'Minuman', 'stok' => 150, 'minimal_stok' => 50, 'satuan' => 'botol'],
            ['nama_barang' => 'Coca Cola', 'kategori' => 'Minuman', 'stok' => 123, 'minimal_stok' => 50, 'satuan' => 'botol'],
            ['nama_barang' => 'Nutriboost', 'kategori' => 'Minuman', 'stok' => 230, 'minimal_stok' => 50, 'satuan' => 'botol'],
            
            // Snack
            ['nama_barang' => 'Biskuat', 'kategori' => 'Snack', 'stok' => 100, 'minimal_stok' => 20, 'satuan' => 'pcs'],
            ['nama_barang' => 'Keripik Talas', 'kategori' => 'Snack', 'stok' => 90, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'French Fries', 'kategori' => 'Snack', 'stok' => 120, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Chiki Balls', 'kategori' => 'Snack', 'stok' => 150, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Cookies', 'kategori' => 'Snack', 'stok' => 126, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            
            // ATK
            ['nama_barang' => 'Gunting', 'kategori' => 'ATK', 'stok' => 85, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Spidol', 'kategori' => 'ATK', 'stok' => 122, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Penggaris', 'kategori' => 'ATK', 'stok' => 79, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Penghapus', 'kategori' => 'ATK', 'stok' => 90, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Pensil', 'kategori' => 'ATK', 'stok' => 120, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            
            // Obat
            ['nama_barang' => 'Insto', 'kategori' => 'Obat', 'stok' => 65, 'minimal_stok' => 30, 'satuan' => 'pcs'],
            ['nama_barang' => 'Paracetamol 500mg', 'kategori' => 'Obat', 'stok' => 45, 'minimal_stok' => 50, 'satuan' => 'tablet'],
            ['nama_barang' => 'Oralit', 'kategori' => 'Obat', 'stok' => 80, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Betadine', 'kategori' => 'Obat', 'stok' => 70, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Alkohol 70%', 'kategori' => 'Obat', 'stok' => 50, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            
            // Perawatan Tubuh
            ['nama_barang' => 'Balsem', 'kategori' => 'Perawatan Tubuh', 'stok' => 150, 'minimal_stok' => 10, 'satuan' => 'pcs'],
            ['nama_barang' => 'Gillete', 'kategori' => 'Perawatan Tubuh', 'stok' => 40, 'minimal_stok' => 30, 'satuan' => 'pcs'],
            ['nama_barang' => 'Hers Protex', 'kategori' => 'Perawatan Tubuh', 'stok' => 55, 'minimal_stok' => 25, 'satuan' => 'pcs'],
            ['nama_barang' => 'Kapas', 'kategori' => 'Perawatan Tubuh', 'stok' => 63, 'minimal_stok' => 30, 'satuan' => 'pcs'],
            ['nama_barang' => 'Sunscreen', 'kategori' => 'Perawatan Tubuh', 'stok' => 60, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            
            // Peralatan Rumah Tangga
            ['nama_barang' => 'Pel', 'kategori' => 'Peralatan Rumah Tangga', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Sapu', 'kategori' => 'Peralatan Rumah Tangga', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Tempat Sampah', 'kategori' => 'Peralatan Rumah Tangga', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Ember', 'kategori' => 'Peralatan Rumah Tangga', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Piring', 'kategori' => 'Peralatan Rumah Tangga', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            
            // Kebutuhan Bayi
            ['nama_barang' => 'Baju', 'kategori' => 'Kebutuhan Bayi', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Celana', 'kategori' => 'Kebutuhan Bayi', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Sarung Tangan', 'kategori' => 'Kebutuhan Bayi', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Topi Bayi', 'kategori' => 'Kebutuhan Bayi', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
            ['nama_barang' => 'Handuk', 'kategori' => 'Kebutuhan Bayi', 'stok' => 0, 'minimal_stok' => 50, 'satuan' => 'pcs'],
        ];

        $productMap = [];
        foreach ($products as $p) {
            $prod = Product::create([
                'id_category' => $categoryIds[$p['kategori']],
                'nama_barang' => $p['nama_barang'],
                'stok' => $p['stok'],
                'minimal_stok' => $p['minimal_stok'],
                'satuan' => $p['satuan']
            ]);
            $productMap[$p['nama_barang']] = $prod->id_product;
        }

        // === 4. STOCK INS ===
        StockIn::truncate();
        StockInDetail::truncate();

        $stockIns = [
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-10 00:00:00',
                'keterangan' => 'Pembelian dari Supplier Tani Jaya',
                'details' => [['barang' => 'Beras Cap Tani', 'jumlah' => 80]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-11 00:00:00',
                'keterangan' => 'Masuk gudang baru dari distributor',
                'details' => [['barang' => 'Sabun Cuci Piring', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-11 00:00:00',
                'keterangan' => 'Pembelian dari Supplier Fiesta',
                'details' => [['barang' => 'Nugget Ayam 500gr', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-12 00:00:00',
                'keterangan' => 'Restok minyak goreng',
                'details' => [['barang' => 'Minyak Goreng', 'jumlah' => 200]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-13 00:00:00',
                'keterangan' => 'Pembelian dari PT SGN',
                'details' => [['barang' => 'Gula Pasir', 'jumlah' => 50]]
            ],
            [
                'user' => 'Admin Toko',
                'tanggal' => '2026-01-12 02:35:37',
                'keterangan' => 'Susu Bayi',
                'details' => [['barang' => 'Susu', 'jumlah' => 100]]
            ],
            [
                'user' => 'Admin Toko',
                'tanggal' => '2026-01-12 03:18:26',
                'keterangan' => 'sosis kanzler',
                'details' => [['barang' => 'sosis', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 21:28:17',
                'keterangan' => 'Pembelian dari PT Maklon',
                'details' => [['barang' => 'Balsem', 'jumlah' => 150]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 21:37:17',
                'keterangan' => 'Pembelian dari PT Kao Indonesia',
                'details' => [['barang' => 'Sabun Biore', 'jumlah' => 200]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 21:38:10',
                'keterangan' => 'Pembelian dari PT Mondelez Indonesia',
                'details' => [['barang' => 'Biskuat', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 21:41:19',
                'keterangan' => 'Pembelian dari PT. Indah Jaya Indonesia',
                'details' => [['barang' => 'Cling', 'jumlah' => 70]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 21:42:13',
                'keterangan' => 'Pembelian dari PT Wings Group Indonesia',
                'details' => [['barang' => 'Detergen', 'jumlah' => 60]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 21:45:42',
                'keterangan' => 'Pembelian dari The Procter & Gamble Company',
                'details' => [['barang' => 'Gillete', 'jumlah' => 40]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 21:48:37',
                'keterangan' => 'Pembelian dari PT Sayap Mas Utama – Wings Group Indonesia',
                'details' => [['barang' => 'Hers Protex', 'jumlah' => 55]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 21:50:02',
                'keterangan' => 'Pembelian dari PT. Pharma Health Care',
                'details' => [['barang' => 'Insto', 'jumlah' => 65]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 21:52:22',
                'keterangan' => 'Pembelian dari PT Kino Indonesia Tbk',
                'details' => [['barang' => 'Kapas', 'jumlah' => 63]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 21:53:59',
                'keterangan' => 'Supllier PT Sumber Telur Jaya',
                'details' => [['barang' => 'Telur Ayam', 'jumlah' => 1500]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 21:55:42',
                'keterangan' => 'Pembelian dari PT Reckitt Benckiser Indonesia',
                'details' => [['barang' => 'Sabun Dettol', 'jumlah' => 80]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 21:56:47',
                'keterangan' => 'Pembelian dari PT So Good Food',
                'details' => [['barang' => 'Bakso', 'jumlah' => 90]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 21:57:52',
                'keterangan' => 'Pembelian dari PT Charoen Pokphand Indonesia Tbk',
                'details' => [['barang' => 'Chicken Wings', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 21:59:10',
                'keterangan' => 'Pembelian dari PT Belfoods Indonesia',
                'details' => [['barang' => 'Crab Stick', 'jumlah' => 85]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 21:59:51',
                'keterangan' => 'Pembelian dari PT Mayora Indah Tbk',
                'details' => [['barang' => 'Teh Pucuk', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:00:41',
                'keterangan' => 'Pembelian dari PT Wings Surya',
                'details' => [['barang' => 'Floridina', 'jumlah' => 200]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:01:36',
                'keterangan' => 'Pembelian dari PT Djojonegoro C-1000 (OT Group)',
                'details' => [['barang' => 'YouC1000', 'jumlah' => 150]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:02:36',
                'keterangan' => 'PT Coca-Cola Amatil Indonesia',
                'details' => [['barang' => 'Coca Cola', 'jumlah' => 123]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 22:10:05',
                'keterangan' => 'Pembelian dari PT Kalbe Nutritionals',
                'details' => [['barang' => 'Nutriboost', 'jumlah' => 230]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 22:10:54',
                'keterangan' => 'Pembelian dari CV Talas Jaya Abadi',
                'details' => [['barang' => 'Keripik Talas', 'jumlah' => 90]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 22:13:10',
                'keterangan' => 'Pembelian dari PT McCain Indonesia',
                'details' => [['barang' => 'French Fries', 'jumlah' => 120]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 22:16:34',
                'keterangan' => 'Pembelian dari PT Indofood Fritolay Makmur',
                'details' => [['barang' => 'Chiki Balls', 'jumlah' => 150]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2026-01-21 22:17:51',
                'keterangan' => 'Pembelian dari PT Mayora Indah Tbk',
                'details' => [['barang' => 'Cookies', 'jumlah' => 126]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 22:24:28',
                'keterangan' => 'Pembelian dari PT Atali Makmur',
                'details' => [['barang' => 'Gunting', 'jumlah' => 85]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 22:25:49',
                'keterangan' => 'Pembelian dari PT Snowman Indonesia',
                'details' => [['barang' => 'Spidol', 'jumlah' => 122]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 22:26:28',
                'keterangan' => 'Pembelian dari PT Faber-Castell Indonesia',
                'details' => [['barang' => 'Penggaris', 'jumlah' => 79]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 22:27:23',
                'keterangan' => 'Pembelian dari PT Atali Makmur',
                'details' => [['barang' => 'Penghapus', 'jumlah' => 90]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2026-01-21 22:28:04',
                'keterangan' => 'Pembelian dari PT Faber-Castell Indonesia',
                'details' => [['barang' => 'Pensil', 'jumlah' => 120]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:30:17',
                'keterangan' => 'Pembelian dari PT Kimia Farma Tbk',
                'details' => [['barang' => 'Paracetamol 500mg', 'jumlah' => 45]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:31:16',
                'keterangan' => 'Pembelian dari PT Kimia Farma Tbk',
                'details' => [['barang' => 'Oralit', 'jumlah' => 80]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:32:02',
                'keterangan' => 'Pembelian dari PT Mahakam Beta Farma',
                'details' => [['barang' => 'Betadine', 'jumlah' => 70]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:33:15',
                'keterangan' => 'Pembelian dari PT Kimia Farma Tbk',
                'details' => [['barang' => 'Alkohol 70%', 'jumlah' => 50]]
            ],
            [
                'user' => 'Staff 3',
                'tanggal' => '2026-01-21 22:34:07',
                'keterangan' => 'PT Paragon Technology and Innovation',
                'details' => [['barang' => 'Sunscreen', 'jumlah' => 60]]
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
            }
        }

        // === 5. STOCK OUTS ===
        StockOut::truncate();
        StockOutDetail::truncate();

        $stockOuts = [
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-12 00:00:00',
                'keterangan' => 'Penjualan grosir ke warung Pak Budi',
                'details' => [['barang' => 'Beras Cap Tani', 'jumlah' => 100]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-12 00:00:00',
                'keterangan' => 'Penjualan ritel',
                'details' => [['barang' => 'Sabun Cuci Piring', 'jumlah' => 10]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-13 00:00:00',
                'keterangan' => 'Penjualan ke pelanggan tetap',
                'details' => [['barang' => 'Nugget Ayam 500gr', 'jumlah' => 15]]
            ],
            [
                'user' => 'Staff 1',
                'tanggal' => '2025-12-15 00:00:00',
                'keterangan' => 'Penjualan toko',
                'details' => [['barang' => 'Minyak Goreng', 'jumlah' => 25]]
            ],
            [
                'user' => 'Staff 2',
                'tanggal' => '2025-12-16 00:00:00',
                'keterangan' => 'Penjualan grosir gula',
                'details' => [['barang' => 'Gula Pasir', 'jumlah' => 25]]
            ],
            [
                'user' => 'Admin Toko',
                'tanggal' => '2026-01-21 04:49:47',
                'keterangan' => 'dibeli',
                'details' => [['barang' => 'sosis', 'jumlah' => 25]]
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
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
