<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $produks = Produk::all();
        return view('produks.index', compact('produks'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('produks.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;

        // Upload gambar
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $path = $request->image->storeAs('public/images', $imageName);
            $produk->image = $imageName;
        }

        $produk->save();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit($produk_id)
    {
        $produk = Produk::findOrFail($produk_id);
        return view('produks.edit', compact('produk'));
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->image_url = $produk->image ? Storage::url('images/' . $produk->image) : null;
        return view('produks.show', compact('produk'));
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $produk = Produk::findOrFail($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            if ($produk->image) {
                Storage::delete('public/images/' . $produk->image);
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);
            $produk->image = $imageName;
        }

        $produk->save();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy($produk_id)
    {
        $produk = Produk::findOrFail($produk_id);
        
        if ($produk->image) {
            Storage::delete('public/images/' . $produk->image);
        }

        $produk->delete();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus!');
    }
}