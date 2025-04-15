<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Pelanggan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware untuk hanya bisa diakses oleh admin
        $this->middleware('role:admin');
    }

    // Method untuk menambah pelanggan
    public function createPelanggan(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:pelanggans',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggans.index');
    }

    // Method untuk menambah produk
    public function createProduk(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Produk::create($request->all());

        return redirect()->route('produks.index');
    }
}