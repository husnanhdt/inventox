<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Ambil parameter pencarian (pakai 'q' untuk konsistensi)
        $q = $request->get('q');

        if ($q) {
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('nama_barang', 'like', "%{$q}%")
                    ->orWhereHas('category', function ($catQuery) use ($q) {
                        $catQuery->where('nama_category', 'like', "%{$q}%");
                    });
            });
        }

        $products = $query->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_category' => 'required|exists:categories,id_category',
            'nama_barang' => 'required|string|max:100|unique:products,nama_barang',
            'minimal_stok' => 'nullable|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = [
            'id_category' => $request->id_category,
            'nama_barang' => $request->nama_barang,
            'stok' => 0,
            'minimal_stok' => $request->minimal_stok ?? 5,
            'satuan' => $request->satuan ?? 'pcs'
        ];

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('products', 'public');
            $data['foto'] = $path;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'id_category' => 'required|exists:categories,id_category',
            'nama_barang' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'nama_barang')->ignore($product->id_product, 'id_product')
            ],
            'minimal_stok' => 'nullable|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $data = [
            'id_category' => $request->id_category,
            'nama_barang' => $request->nama_barang,
            'minimal_stok' => $request->minimal_stok ?? 5,
            'satuan' => $request->satuan ?? 'pcs'
        ];

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($product->foto && Storage::disk('public')->exists($product->foto)) {
                Storage::disk('public')->delete($product->foto);
            }
            $path = $request->file('foto')->store('products', 'public');
            $data['foto'] = $path;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->stockInDetails()->exists() || $product->stockOutDetails()->exists()) {
            return back()->withErrors('Barang tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        // Hapus foto jika ada
        if ($product->foto && Storage::disk('public')->exists($product->foto)) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
