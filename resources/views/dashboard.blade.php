@extends('template')

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
                @can('admin')
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">E-commerce Dashboard</h2>
                        <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end pageheader  -->
            <!-- ============================================================== -->
            <div class="ecommerce-widget">

                <!-- Progress Bar Produk -->
                <div class="row">

                    <!-- Produk -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm luxury-card">
                            <div class="card-body">
                                <div class="card-icon-wrapper product-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h5 class="card-title elegant-title">Produk</h5>
                                <p class="metric-text">{{ $productCount }} dari {{ $targetProductCount }} produk</p>
                                <div class="progress progress-elegant">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $productProgress }}%;" aria-valuenow="{{ $productProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($productProgress, 2) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Penjualan -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm luxury-card">
                            <div class="card-body">
                                <div class="card-icon-wrapper sales-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <h5 class="card-title elegant-title">Penjualan</h5>
                                <p class="metric-text">{{ $salesCount }} dari {{ $targetSalesCount }} penjualan</p>
                                <div class="progress progress-elegant">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $salesProgress }}%;" aria-valuenow="{{ $salesProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($salesProgress, 2) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pendapatan -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm luxury-card">
                            <div class="card-body">
                                <div class="card-icon-wrapper revenue-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h5 class="card-title elegant-title">Pendapatan</h5>
                                <p class="metric-text">{{ number_format($totalRevenue, 0, ',', '.') }} dari {{ number_format($targetRevenue, 0, ',', '.') }}</p>
                                <div class="progress progress-elegant">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $revenueProgress }}%;" aria-valuenow="{{ $revenueProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($revenueProgress, 2) }}%
                                    </div>
                                </div>
                                <!-- Menambahkan tampilan pendapatan di bawah progress bar -->
                                <div class="mt-3">
                                    <p class="total-value"><strong>Total Pendapatan: </strong>Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Penjualan Bulanan -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm luxury-card">
                            <div class="card-body">
                                <div class="card-icon-wrapper monthly-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <h5 class="card-title elegant-title">Penjualan Bulanan</h5>
                                <p class="metric-text">{{ $monthlySalesCount }} dari {{ $targetMonthlySalesCount }}</p>
                                <div class="progress progress-elegant">
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $monthlySalesProgress }}%;" aria-valuenow="{{ $monthlySalesProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($monthlySalesProgress, 2) }}%
                                    </div>
                                </div>
                                <!-- Menambahkan tampilan pendapatan bulanan di bawah progress bar -->
                                <div class="mt-3">
                                    <p class="total-value"><strong>Total Pendapatan Bulanan: </strong>Rp. {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Penjualan Tahunan -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm luxury-card">
                            <div class="card-body">
                                <div class="card-icon-wrapper yearly-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <h5 class="card-title elegant-title">Penjualan Tahunan</h5>
                                <p class="metric-text">{{ $yearlySalesCount }} dari {{ $targetYearlySalesCount }}</p>
                                <div class="progress progress-elegant">
                                    <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $yearlySalesProgress }}%;" aria-valuenow="{{ $yearlySalesProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($yearlySalesProgress, 2) }}%
                                    </div>
                                </div>
                                <!-- Menambahkan tampilan pendapatan tahunan di bawah progress bar -->
                                <div class="mt-3">
                                    <p class="total-value"><strong>Total Pendapatan Tahunan: </strong>Rp. {{ number_format($yearlyRevenue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                
                <!-- Recent Orders & Charts Row -->
                <div class="row mt-4">
                    <!-- Recent Orders -->
                    <div class="col-xl-8 col-lg-8">
                        <div class="card luxury-table-card">
                            <div class="card-header elegant-header">
                                <div class="card-header elegant-header">
                                    <h5 class="mb-0 text-white"><i class="fas fa-clipboard-list me-2"></i>Pesanan Terbaru</h5>
                                </div>                              </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover elegant-table">
                                        <thead class="elegant-thead">
                                            <tr>
                                                <th>Kode Pay</th>
                                                <th>Pelanggan</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                            @php
                                                $badge = 'secondary';
                                                if ($order->status == 'Selesai') {
                                                    $badge = 'success';
                                                } elseif ($order->status == 'Proses') {
                                                    $badge = 'warning';
                                                } elseif ($order->status == 'Dikirim') {
                                                    $badge = 'primary';
                                                }
                                            @endphp
                                        
                                            <tr>
                                                <td>{{ $order->kode_pembayaran }}</td>
                                                <td>{{ isset($order->pelanggan) ? $order->pelanggan->nama_pelanggan : 'Umum' }}</td>
                                                <td><span class="badge bg-{{ $badge }} status-badge">{{ $order->status }}</span></td>
                                                <td>{{ \Carbon\Carbon::parse($order->tanggal_penjualan)->format('d M Y') }}</td>
                                                <td class="price-column">Rp.{{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach                                        
                                        
                                        </tbody>
                                        @endcan
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                    
                    
    
    <!-- Link to FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* Enhanced Dashboard Styling - Elegant & Luxury Version */
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f8f9fc;
        }
        
        .dashboard-ecommerce {
            background-color: #f8f9fc;
            padding: 20px 0;
        }
        
        /* Elegant Header */
        .page-header {
            background: linear-gradient(135deg, #2c3e50 0%, #1a2a3a 100%);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .page-header:before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 100%;
            background: rgba(255, 255, 255, 0.05);
            transform: skewX(-30deg);
        }
        
        .pageheader-title {
            color: white;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 2.5rem;
            letter-spacing: 0.5px;
        }
        
        .pageheader-text {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            font-weight: 300;
            line-height: 1.6;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 15px 0 0;
        }
        
        /* Luxury Card Styling */
        .luxury-card {
            border-radius: 15px;
            border: none;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            overflow: hidden;
            position: relative;
        }
        
        .luxury-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .luxury-card:after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 100%);
            transform: skewX(-30deg);
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .luxury-card:hover:after {
            opacity: 1;
            animation: shine 1.5s infinite;
        }
        
        @keyframes shine {
            0% {
                transform: translateX(-200%) skewX(-30deg);
            }
            100% {
                transform: translateX(200%) skewX(-30deg);
            }
        }
        
        .card-body {
            padding: 30px;
            position: relative;
        }
        
        /* Icon Styling */
        .card-icon-wrapper {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .product-icon {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        
        .sales-icon {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }
        
        .revenue-icon {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        }
        
        .daily-icon {
            background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
        }
        
        .monthly-icon {
            background: linear-gradient(135deg, #858796 0%, #60616f 100%);
        }
        
        .yearly-icon {
            background: linear-gradient(135deg, #3a3b45 0%, #1c1d22 100%);
        }
        
        /* Typography Styling */
        .elegant-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        
        .metric-text {
            color: #555;
            font-size: 15px;
            margin-bottom: 15px;
            font-weight: 500;
        }
        
        .total-value {
            color: #2c3e50;
            font-weight: 500;
            font-size: 16px;
            margin-top: 5px;
        }
        
        .total-value strong {
            font-weight: 600;
        }
        
        /* Progress Bar Styling */
        .progress-elegant {
            height: 8px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .progress-bar {
            border-radius: 10px;
            position: relative;
        }
        
        /* Table Styling */
        .luxury-table-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }
        
        .elegant-header {
            background: linear-gradient(135deg, #2c3e50 0%, #1a2a3a 100%);
            color: white;
            padding: 20px 25px;
            border: none;
        }
        
        .elegant-header h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            margin: 0;
        }
        
        .elegant-table {
            margin-bottom: 0;
        }
        
        .elegant-thead {
            background-color: #f8f9fc;
        }
        
        .elegant-table thead th {
            border-top: none;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #5a5c69;
            padding: 15px 20px;
        }
        
        .elegant-table tbody tr {
            border-bottom: 1px solid #f0f0f7;
            transition: all 0.2s ease;
        }
        
        .elegant-table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.03);
        }
        
        .elegant-table tbody tr td {
            padding: 15px 20px;
            vertical-align: middle;
            color: #5a5c69;
            font-weight: 400;
        }
        
        .price-column {
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Status Badge Styling */
        .status-badge {
            padding: 8px 12px;
            font-weight: 500;
            font-size: 0.75rem;
            border-radius: 30px;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Extra Design Elements */
        @media (min-width: 992px) {
            .dashboard-content {
                padding: 0 15px;
            }
            
            .col-md-4 {
                transition: all 0.3s ease;
            }
            
            .col-md-4:hover {
                transform: translateY(-5px);
            }
        }
        
        /* Custom Color Classes - Keep these but enhance them */
        .bg-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        }
        
        .bg-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%) !important;
        }
        
        .bg-info {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%) !important;
        }
        
        .bg-warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%) !important;
        }
        
        .bg-danger {
            background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%) !important;
        }
        
        .bg-secondary {
            background: linear-gradient(135deg, #858796 0%, #60616f 100%) !important;
        }
        
        .bg-dark {
            background: linear-gradient(135deg, #3a3b45 0%, #1c1d22 100%) !important;
        }
        
        .text-primary {
            color: #4e73df !important;
        }
        
        .text-success {
            color: #1cc88a !important;
        }
        
        .text-info {
            color: #36b9cc !important;
        }
        
        .text-warning {
            color: #f6c23e !important;
        }

        .text-white {
    color: #f4f5f8 !important; /* Sesuaikan dengan warna navigasi yang Anda gunakan */
}

.elegant-header {
    background: #3f6fff; /* Warna biru solid */
    /* atau jika Anda ingin tetap menggunakan gradien: */
    /* background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); */
    color: white;
    padding: 20px 25px;
    border: none;
}

    </style>
    
@endsection