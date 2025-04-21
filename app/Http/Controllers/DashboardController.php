<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Penjualan;
use App\User;
use Carbon\Carbon;

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
    $totalRevenue = Penjualan::sum('total_bayar');

    // Target progress
    $targetProductCount = 1000;
    $targetSalesCount = 10000;
    $targetUserCount = 200;
    $targetRevenue = 1000000000;

    // Hitung progress dengan pembulatan dan perlindungan dari divide by zero
    $productProgress = $targetProductCount > 0 ? ($productCount / $targetProductCount) * 100 : 0;
    $salesProgress = $targetSalesCount > 0 ? ($salesCount / $targetSalesCount) * 100 : 0;
    $userProgress = $targetUserCount > 0 ? ($userCount / $targetUserCount) * 100 : 0;
    $revenueProgress = $targetRevenue > 0 ? ($totalRevenue / $targetRevenue) * 100 : 0;

    // Penjualan Harian
    $today = Carbon::today();
    
    // Pastikan tidak ada data rusak
    Penjualan::whereNull('tanggal_penjualan')->update(['tanggal_penjualan' => Carbon::now()]);
    
    $dailySalesCount = Penjualan::whereDate('tanggal_penjualan', $today)->count();
    $dailyRevenue = Penjualan::whereDate('tanggal_penjualan', $today)->sum('total_bayar');
    $targetDailySalesCount = 300;
    $dailySalesProgress = $targetDailySalesCount > 0 ? ($dailySalesCount / $targetDailySalesCount) * 100 : 0;

    // Penjualan Bulanan
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $monthlySalesCount = Penjualan::whereBetween('tanggal_penjualan', [$startOfMonth, $endOfMonth])->count();
    $monthlyRevenue = Penjualan::whereBetween('tanggal_penjualan', [$startOfMonth, $endOfMonth])->sum('total_bayar');
    $targetMonthlySalesCount = 1000;
    $monthlySalesProgress = $targetMonthlySalesCount > 0 ? ($monthlySalesCount / $targetMonthlySalesCount) * 100 : 0;

    // Penjualan Tahunan
    $startOfYear = Carbon::now()->startOfYear();
    $endOfYear = Carbon::now()->endOfYear();
    $yearlySalesCount = Penjualan::whereBetween('tanggal_penjualan', [$startOfYear, $endOfYear])->count();
    $yearlyRevenue = Penjualan::whereBetween('tanggal_penjualan', [$startOfYear, $endOfYear])->sum('total_bayar');
    $targetYearlySalesCount = 12000;
    $yearlySalesProgress = $targetYearlySalesCount > 0 ? ($yearlySalesCount / $targetYearlySalesCount) * 100 : 0;

    // 10 pesanan terbaru dalam 7 hari terakhir
    $recentOrders = Penjualan::with('pelanggan')
        ->where('tanggal_penjualan', '>=', Carbon::now()->subDays(7))
        ->orderBy('tanggal_penjualan', 'desc')
        ->limit(10)
        ->get();

    return view('dashboard', compact(
        'productCount',
        'salesCount',
        'userCount',
        'totalRevenue',
        'productProgress',
        'salesProgress',
        'userProgress',
        'revenueProgress',
        'dailySalesProgress',
        'monthlySalesProgress',
        'yearlySalesProgress',
        'dailySalesCount',
        'monthlySalesCount',
        'yearlySalesCount',
        'dailyRevenue',
        'monthlyRevenue',
        'yearlyRevenue',
        'recentOrders',
        'targetProductCount',
        'targetSalesCount',
        'targetUserCount',
        'targetRevenue',
        'targetDailySalesCount',
        'targetMonthlySalesCount',
        'targetYearlySalesCount'
    ));
}

}