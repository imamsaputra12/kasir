<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use App\Penjualan;
use App\Produk;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Cek apakah query tidak kosong
        if (!$query) {
            return redirect()->back()->with('error', 'Masukkan kata kunci pencarian.');
        }
    
        // Pencarian di tabel Pelanggan
        $pelanggans = Pelanggan::where('nama_pelanggan', 'LIKE', "%{$query}%")
            ->orWhere('alamat', 'LIKE', "%{$query}%")
            ->orWhere('nomor_telepon', 'LIKE', "%{$query}%")
            ->paginate(10);  // Ganti get() dengan paginate(10)
    
        // Pencarian di tabel Penjualan
        $penjualans = Penjualan::where('kode_pembayaran', 'LIKE', "%{$query}%")
            ->orWhere('tanggal_penjualan', 'LIKE', "%{$query}%")
            ->orWhere('pelanggan_id', 'LIKE', "%{$query}%")
            ->orWhere('produk_id', 'LIKE', "%{$query}%")
            ->orWhere('total_bayar', 'LIKE', "%{$query}%")
            ->orWhere('jumlah_bayar', 'LIKE', "%{$query}%")
            ->orWhere('kembalian', 'LIKE', "%{$query}%")
            ->orWhere('metode_pembayaran', 'LIKE', "%{$query}%")
            ->orWhere('status', 'LIKE', "%{$query}%")
            ->paginate(10);  // Ganti get() dengan paginate(10)
    
        // Pencarian di tabel Produk
        $produks = Produk::where('nama_produk', 'LIKE', "%{$query}%")
            ->orWhere('harga', 'LIKE', "%{$query}%")
            ->orWhere('stok', 'LIKE', "%{$query}%")
            ->paginate(10);  // Ganti get() dengan paginate(10)
    
        return view('search.results', compact('pelanggans', 'penjualans', 'produks'));
    }
}