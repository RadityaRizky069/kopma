<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tambahan Fungsi untuk Landing Page Utama
    public function home()
    {
        // Mengambil produk terbaru untuk ditampilkan di home.blade.php
        $products = Product::latest()->get(); 
        return view('home', compact('products'));
    }

    public function index()
    {
        $products = Product::latest()->get();

        // ADMIN view
        if(auth()->check() && auth()->user()->role === 'admin'){
            return view('admin.products.index', compact('products'));
        }

        // CUSTOMER view
        return view('customer.products', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

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
            // Menyimpan file gambar ke storage/app/public/products
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
               ->with('success','Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $product->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada file baru yang diunggah
            if ($path) { Storage::disk('public')->delete($path); }
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
               ->with('success','Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus file fisik gambar dari storage
        if ($product->gambar) { 
            Storage::disk('public')->delete($product->gambar); 
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
               ->with('success','Produk berhasil dihapus');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.product-detail', compact('product'));
    }
}