<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function __construct()
    {
        // Middleware untuk hanya bisa diakses oleh kasir
        $this->middleware('role:kasir');
    }

    // Method untuk melihat produk
    public function indexProduk()
    {
        $produk = Produk::all();
        return view('produks.index', compact('produk'));
    }

    // Method untuk melakukan transaksi penjualan
    public function transaksi(Request $request)
    {
        // Implementasikan logika transaksi penjualan
    }
}