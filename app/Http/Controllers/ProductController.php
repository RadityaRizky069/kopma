<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /* ================= HOME ================= */
    public function home()
    {
        $products = Product::latest()->get();
        return view('home', compact('products'));
    }

    /* ================= INDEX ================= */
    public function index()
    {
        $products = Product::latest()->get();

        // ADMIN view
        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.products.index', compact('products'));
        }

        // CUSTOMER view
        return view('customer.products', compact('products'));
    }

    /* ================= CREATE ================= */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /* ================= STORE (KATEGORI BEBAS) ================= */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori'    => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Cari kategori berdasarkan NAMA, kalau belum ada → buat baru
        $category = Category::firstOrCreate([
            'nama_kategori' => $request->kategori
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('products', 'public');
        }

        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori_id' => $category->id,
            'gambar'      => $path
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /* ================= UPDATE (KATEGORI BEBAS) ================= */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori'    => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Cari / buat kategori berdasarkan NAMA
        $category = Category::firstOrCreate([
            'nama_kategori' => $request->kategori
        ]);

        $path = $product->gambar;
        if ($request->hasFile('gambar')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('gambar')->store('products', 'public');
        }

        $product->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori_id' => $category->id,
            'gambar'      => $path
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /* ================= DETAIL ================= */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.product-detail', compact('product'));
    }
}
