<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Penjualan;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Mengambil jumlah produk, penjualan, pengguna, dan total pendapatan
        $productCount = Produk::count();
        $salesCount = Penjualan::count();
        $userCount = User::count();
        $totalRevenue = Penjualan::sum('total_bayar');  // Pastikan 'total_bayar' adalah field yang benar

        // Mengambil 10 pesanan terbaru
        $recentOrders = Penjualan::with('pelanggan') // Asumsi relasi sudah ada
            ->orderBy('tanggal_penjualan', 'desc')
            ->limit(10)
            ->get();

        // Mengirim data ke tampilan dashboard
        return view('dashboard', compact(
            'productCount',
            'salesCount',
            'userCount',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
