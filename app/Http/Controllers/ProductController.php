<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index()
    {
        $products = Product::latest()->get();

        // ADMIN
        if(auth()->check() && auth()->user()->role === 'admin'){
            return view('admin.products.index', compact('products'));
        }

        // CUSTOMER
        return view('customer.products', compact('products'));
    }

    // =====================
    // ADMIN - FORM TAMBAH
    // =====================
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // =====================
    // ADMIN - SIMPAN
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'kategori_id'=> 'required'
        ]);

        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori_id'=> $request->kategori_id,
            'gambar'      => $request->gambar ?? null
        ]);

        return redirect()->route('admin.products.index')
               ->with('success','Produk berhasil ditambahkan');
    }

    // =====================
    // ADMIN - FORM EDIT
    // =====================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product','categories'));
    }

    // =====================
    // ADMIN - UPDATE
    // =====================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori_id'=> $request->kategori_id,
            'gambar'      => $request->gambar ?? $product->gambar
        ]);

        return redirect()->route('admin.products.index')
               ->with('success','Produk berhasil diperbarui');
    }

    // =====================
    // ADMIN - HAPUS
    // =====================
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')
               ->with('success','Produk berhasil dihapus');
    }

    // =====================
    // CUSTOMER - DETAIL
    // =====================
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.product-detail', compact('product'));
    }
}
