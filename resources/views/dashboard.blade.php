@extends('template')

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
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

                <div class="row">
                    <!-- Product Count -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="card-icon bg-primary">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h5 class="text-muted">Jumlah Produk</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1 text-primary">{{ $productCount }}</h1> <!-- Displaying the product count -->
                                </div>
                                <div class="progress mt-3 progress-sm">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                                </div>
                            </div>
                            <div id="sparkline-revenue"></div>
                        </div>
                    </div>

                    <!-- Sales Count -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <h5 class="text-muted">Jumlah Penjualan</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1 text-success">{{ $salesCount }}</h1> <!-- Displaying the sales count -->
                                </div>
                                <div class="progress mt-3 progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 70%"></div>
                                </div>
                            </div>
                            <div id="sparkline-revenue2"></div>
                        </div>
                    </div>

                    <!-- User Count -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="card-icon bg-info">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="text-muted">Jumlah User</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1 text-info">{{ $userCount }}</h1> <!-- Displaying the user count -->
                                </div>
                                <div class="progress mt-3 progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                                </div>
                            </div>
                            <div id="sparkline-revenue3"></div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="card-icon bg-warning">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h5 class="text-muted">Pendapatan</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1 text-warning">Rp.{{ number_format($totalRevenue, ) }}</h1> <!-- Displaying the total revenue -->
                                </div>
                                <div class="progress mt-3 progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%"></div>
                                </div>
                            </div>
                            <div id="sparkline-revenue4"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders & Charts Row -->
                <div class="row mt-4">
                    <!-- Recent Orders -->
                    <div class="col-xl-8 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Pesanan Terbaru</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
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
                                                <td><span class="badge bg-{{ $badge }}">{{ $order->status }}</span></td>
                                                <td>{{ \Carbon\Carbon::parse($order->tanggal_penjualan)->format('d M Y') }}</td>
                                                <td>Rp.{{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                    
                    
    
    <!-- Link to FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* Enhanced Dashboard Styling */
        .dashboard-ecommerce {
            background-color: #f5f7fa;
            padding: 15px 0;
        }
        
        .page-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .pageheader-title {
            color: white;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .pageheader-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        /* Card Styling */
        .custom-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .card-icon i {
            font-size: 20px;
        }
        
        .card-body {
            padding: 25px;
            position: relative;
        }
        
        .progress-sm {
            height: 5px;
            border-radius: 5px;
        }
        
        /* Table & List Styling */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            border-top: none;
            border-bottom-width: 1px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        
        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }
        
        .list-group-item {
            border-left: 0;
            border-right: 0;
            padding: 15px 20px;
        }
        
        /* Add some color classes */
        .bg-primary {
            background-color: #4e73df !important;
        }
        
        .bg-success {
            background-color: #1cc88a !important;
        }
        
        .bg-info {
            background-color: #36b9cc !important;
        }
        
        .bg-warning {
            background-color: #f6c23e !important;
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
    </style>
@endsection