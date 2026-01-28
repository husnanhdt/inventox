<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← tambahkan ini
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $query = Category::withCount('products');
        if (request('q')) {
            $query->where('nama_category', 'like', '%' . request('q') . '%');
        }
        $categories = $query->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        return view('categories.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        $request->validate(['nama_category' => 'required|unique:categories']);
        Category::create($request->only('nama_category'));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        $request->validate([
            'nama_category' => 'required|unique:categories,nama_category,' . $category->id_category . ',id_category'
        ]);
        $category->update($request->only('nama_category'));
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        if ($category->products()->exists()) {
            return back()->withErrors('Kategori tidak bisa dihapus karena masih memiliki barang.');
        }
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }

    public function show(Category $category)
    {
        // Cek akses admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Ambil data kategori + hitung jumlah barang
        $category = Category::withCount('products')->findOrFail($category->id_category);

        return view('categories.show', compact('category'));
    }
}
