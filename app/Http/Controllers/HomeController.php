<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Penjualan;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        // Get the count of products, sales, users, and the total revenue
        $productCount = Produk::count();
        $salesCount = Penjualan::count();
        $userCount = User::count();
        $totalRevenue = Penjualan::sum('total_bayar');  // Assuming 'total_harga' is the revenue field

        // Pass the data to the view
        return view('auth.login', compact('productCount', 'salesCount', 'userCount', 'totalRevenue'));
    }
    }
