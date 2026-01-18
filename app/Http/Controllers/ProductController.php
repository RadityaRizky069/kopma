<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ===============================
    // HOME (Landing Page)
    // ===============================
    public function home()
    {
        $products = Product::latest()->take(8)->get();
        return view('home', compact('products'));
    }

    // ===============================
    // INDEX (ADMIN & CUSTOMER)
    // ===============================
    public function index()
    {
        $products = Product::latest()->get();

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.products.index', compact('products'));
        }

        return view('customer.products', compact('products'));
    }

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori_id' => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
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
            'kategori_id' => $request->kategori_id,
            'gambar'      => $path
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori_id' => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
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
            'kategori_id' => $request->kategori_id,
            'gambar'      => $path
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    // ===============================
    // DELETE
    // ===============================
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

    // ===============================
    // SHOW (DETAIL + KOMENTAR)
    // ===============================
    public function show($id)
    {
        $product = Product::with([
            'comments.user',
            'comments.replies.user'
        ])->findOrFail($id);

        return view('customer.product-detail', compact('product'));
    }
}
