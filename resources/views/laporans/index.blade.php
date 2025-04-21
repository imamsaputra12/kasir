@extends('template')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header dengan garis elegan -->
            <div class="mb-5 text-center">
                <h2 class="display-5 fw-bold text-primary mb-2">Laporan Penjualan</h2>
                <div class="d-flex justify-content-center">
                    <div style="width: 100px; height: 3px; background: linear-gradient(to right, #6366F1, #8B5CF6);"></div>
                </div>
            </div>

            <!-- Card Untuk Filter -->
            <div class="card shadow-sm mb-5 border-0 rounded-3">
                <div class="card-body p-4">
                    <!-- Tombol Filter -->
                    <form method="GET" action="{{ route('laporans.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="tanggal_awal" class="form-label fw-medium text-secondary small text-uppercase">Tanggal Awal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control border-0 bg-light" style="border-radius: 0 10px 10px 0;" value="{{ request('tanggal_awal') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_akhir" class="form-label fw-medium text-secondary small text-uppercase">Tanggal Akhir</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control border-0 bg-light" style="border-radius: 0 10px 10px 0;" value="{{ request('tanggal_akhir') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                    <i class="fas fa-filter me-1"></i> Terapkan
                                </button>
                                <a href="{{ route('laporans.index') }}" class="btn btn-outline-secondary px-4 rounded-pill" id="reset-button">
                                    <i class="fas fa-redo-alt me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Untuk Tabel -->
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="py-3">No</th>
                                    <th class="py-3">Kode Pembayaran</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3">Pelanggan</th>
                                    <th class="py-3">Produk</th>
                                    <th class="py-3">Metode Pembayaran</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penjualans as $penjualan)
                                    @if($penjualan->kode_pembayaran != '-')
                                        <tr class="penjualan-row {{ $penjualan->status }}">
                                            <td class="py-3">{{ $loop->iteration }}</td>
                                            <td class="py-3 fw-medium">{{ $penjualan->kode_pembayaran }}</td>
                                            <td class="py-3">{{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}</td>
                                            <td class="py-3">{{ $penjualan->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                                            <td class="py-3">
                                                @php
                                                    $produkList = json_decode($penjualan->produk_id, true);
                                                    $produkString = $produkList ? implode(', ', array_map(function($produk) {
                                                        return $produk['nama_produk'] . " ({$produk['jumlah']}x)";
                                                    }, $produkList)) : '-';
                                                @endphp
                                                {{ $produkString }}
                                            </td>
                                            <td class="py-3">{{ ucfirst($penjualan->metode_pembayaran) }}</td>
                                            <td class="py-3">
                                                @if($penjualan->status == 'paid')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Lunas</span>
                                                @elseif($penjualan->status == 'pending')
                                                    <span class="badge bg-warning rounded-pill px-3 py-2">Menunggu</span>
                                                @else
                                                    <span class="badge bg-danger rounded-pill px-3 py-2">Gagal</span>
                                                @endif
                                            </td>
                                            <td class="py-3 fw-bold">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-4">Tidak ada data penjualan untuk periode ini.</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="py-3">
                                                <i class="fas fa-file-invoice text-muted mb-3" style="font-size: 3rem;"></i>
                                                <p class="mb-0 text-muted">Tidak ada data penjualan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="6" class="text-end py-3"><strong class="text-uppercase">Subtotal</strong></td>
                                    <td colspan="2" class="py-3"><strong class="fs-5 text-primary">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>            
                    </div>
                </div>
            </div>

            <!-- Tombol Print Semua di Tengah -->
            <div class="d-flex justify-content-center mt-4">
                <button class="btn btn-primary btn-lg px-4 rounded-pill" onclick="printStrukSemua()">
                    <i class="fas fa-print me-2"></i> Print Laporan (Lunas Saja)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script Print Laporan Lunas Saja -->  
<script>
    function printStrukSemua() {
        // Sembunyikan semua baris yang tidak lunas
        document.querySelectorAll('.penjualan-row').forEach(row => {
            if (!row.classList.contains('paid')) {
                row.style.display = 'none';
            }
        });

        // Print
        window.print();

        // Tampilkan kembali setelah print
        setTimeout(() => {
            document.querySelectorAll('.penjualan-row').forEach(row => {
                row.style.display = '';
            });
        }, 1000);
    }
</script>

<style>
    @media print {
        form[action="{{ route('laporans.index') }}"],
        .btn-primary,
        .btn-outline-secondary,
        .card.shadow-sm,
        .card-body > form {
            display: none !important;
        }

        table {
            width: 100%;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
        }

        .badge {
            border: 1px solid #ddd !important;
            padding: 2px 8px !important;
        }

        .bg-primary {
            background-color: #f8f9fa !important;
            color: #212529 !important;
        }

        .text-primary {
            color: #212529 !important;
        }
    }
</style>

@endsection