@extends('template')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-header-title">
                    <i class="fas fa-chart-bar"></i> Laporan Penjualan
                </h5>
                <div class="card-actions d-flex flex-wrap gap-2">

                
                    {{-- Form Pilih Bulan & Tahun --}}
                    <form method="GET" action="{{ route('laporans.index') }}" class="d-flex align-items-center flex-wrap gap-2">

                        {{-- Input Tanggal Awal --}}
                        <div class="mb-2">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                        </div>
                    
                        {{-- Input Tanggal Akhir --}}
                        <div class="mb-2">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                        </div>

                    
                        {{-- Tombol Submit --}}
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Terapkan
                            </button>
                            <a href="{{ route('laporans.index') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>
                        
            <div class="card-body">
                <!-- Ringkasan Info -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="p-3 border rounded-lg bg-light">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 bg-primary bg-opacity-10 me-3">
                                    <i class="fas fa-shopping-cart text-primary"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Total Transaksi</div>
                                    <div class="fw-bold">{{ count($penjualans) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded-lg bg-light">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 bg-success bg-opacity-10 me-3">
                                    <i class="fas fa-money-bill-wave text-success"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Total Pendapatan</div>
                                    <div class="fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded-lg bg-light">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 bg-warning bg-opacity-10 me-3">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Pembayaran Menunggu</div>
                                    <div class="fw-bold">{{ $penjualans->where('status', 'pending')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded-lg bg-light">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 bg-danger bg-opacity-10 me-3">
                                    <i class="fas fa-times-circle text-danger"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Pembayaran Gagal</div>
                                    <div class="fw-bold">{{ $penjualans->where('status', 'failed')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter dan Pencarian -->
                <div class="row mb-4">
                    <div class="col-md-6 d-flex align-items-center">
                        <span class="text-muted me-2">Menampilkan periode:</span>
                        <span class="badge bg-primary">{{ request('periode', 'semua') == 'semua' ? 'Semua Periode' : ucfirst(request('periode', 'semua')) }}</span>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari kode pembayaran atau pelanggan..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="laporanTable">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center">Kode Pembayaran</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Pelanggan</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Metode Pembayaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualans as $penjualan)
                                @if($penjualan->kode_pembayaran != '-')
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <span class="fw-medium">{{ $penjualan->kode_pembayaran }}</span>
                                        </td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}</td>
                                        <td>{{ $penjualan->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                                        <td>
                                            @php
                                                $produkList = json_decode($penjualan->produk_id, true);
                                                if ($produkList) {
                                                    echo '<ul class="list-unstyled mb-0">';
                                                    foreach ($produkList as $produk) {
                                                        echo '<li><span class="fw-medium">' . $produk['nama_produk'] . '</span> <span class="badge bg-light text-dark">' . $produk['jumlah'] . 'x</span></li>';
                                                    }
                                                    echo '</ul>';
                                                } else {
                                                    echo '-';
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            @if($penjualan->metode_pembayaran == 'cash')
                                            <span class=>
                                                <i class=> Cash
                                            </span>                                            
                                            @elseif($penjualan->metode_pembayaran == 'transfer')
                                                <span class=>
                                                    <i class=> Transfer
                                                </span>
                                            @elseif($penjualan->metode_pembayaran == 'e_wallet')
                                            <span class=>
                                                <i class=> E-Wallet
                                            </span>
                                            
                                            @elseif($penjualan->metode_pembayaran == 'credit_card')
                                                <span class=>
                                                    <i class=> Credit Card
                                                </span>
                                            @else
                                                <span class="badge bg-dark">
                                                    {{ ucfirst($penjualan->metode_pembayaran) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($penjualan->status == 'paid')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Lunas
                                                </span>
                                            @elseif($penjualan->status == 'pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i> Menunggu
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i> Gagal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-file-alt fa-3x mb-3 text-light"></i>
                                            <p>Tidak ada data penjualan ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="7" class="text-end">Total Pendapatan</td>
                                <td class="text-end">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Tombol Action -->
                <div class="d-flex justify-content-between align-items-center mt-4 no-print">
                    <div>
                    <button onclick="printStrukSemua()" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Print functionality
    function printStrukSemua() {
        window.print();
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('laporanTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();
            
            for (let i = 0; i < rows.length; i++) {
                const rowText = rows[i].textContent.toLowerCase();
                if (rowText.includes(searchTerm)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>

<style>
    @media print {
        .no-print,
        .dropdown,
        #periodeDropdown,
        .dropdown-menu,
        .card-actions,
        .input-group,
        [class*="col-md-"] {
            display: none !important;
        }
        
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        
        .card-header {
            text-align: center;
            border-bottom: 2px solid #333 !important;
            margin-bottom: 20px;
        }
        
        .card-header h5 {
            font-size: 24px !important;
            font-weight: bold !important;
        }
        
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        
        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }
        
        thead {
            background-color: #f5f5f5 !important;
        }
        
        tfoot {
            background-color: #f5f5f5 !important;
            font-weight: bold !important;
        }
        
        .container {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        body {
            padding-top: 0 !important;
        }
    }
</style>
@endsection