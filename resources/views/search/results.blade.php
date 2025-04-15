@extends('template')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-6">Hasil Pencarian</h2>

    @if($pelanggans->isEmpty() && $penjualans->isEmpty() && $produks->isEmpty())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            Tidak ada hasil yang ditemukan.
        </div>
    @else
        <!-- Pelanggan -->
        @if($pelanggans->isNotEmpty())
            <div class="border rounded-lg shadow mb-6">
                <div class="bg-blue-100 px-4 py-2 rounded-t-lg">
                    <h4 class="font-semibold text-lg">Pelanggan</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center border-collapse">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama Pelanggan</th>
                                <th class="border px-4 py-2">Alamat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($pelanggans as $pelanggan)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $pelanggan->nama_pelanggan }}</td>
                                    <td class="border px-4 py-2">{{ $pelanggan->alamat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Penjualan -->
        @if ($penjualans->isEmpty())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded shadow mb-6">
            Tidak ada hasil yang ditemukan untuk pencarian "<strong>{{ request('query') }}</strong>".
        </div>
    @else
        <div class="overflow-x-auto border rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2">No</th>
                        <th class="px-3 py-2">Kode Pembayaran</th>
                        <th class="px-3 py-2">Tanggal Penjualan</th>
                        <th class="px-3 py-2">Pelanggan</th>
                        <th class="px-3 py-2">Produk</th>
                        <th class="px-3 py-2">Total Bayar</th>
                        <th class="px-3 py-2">Jumlah Bayar</th>
                        <th class="px-3 py-2">Kembalian</th>
                        <th class="px-3 py-2">Metode</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            <td class="px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2">{{ $penjualan->kode_pembayaran }}</td>
                            <td class="px-3 py-2">{{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}</td>
                            <td class="px-3 py-2">{{ $penjualan->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                            <td class="px-3 py-2">
                                @php
                                    $produkList = json_decode($penjualan->produk_id, true);
                                    $produkString = $produkList ? implode(', ', array_map(function($produk) {
                                        return $produk['nama_produk'] . " ({$produk['jumlah']}x)";
                                    }, $produkList)) : '-';
                                @endphp
                                {{ $produkString }}
                            </td>
                            <td class="px-3 py-2">Rp{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">Rp{{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">Rp{{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">{{ ucfirst($penjualan->metode_pembayaran) }}</td>
                            @php $status = strtolower(trim($penjualan->status)); @endphp
                            <td class="px-3 py-2">
                                @if($status === 'lunas')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Lunas</span>
                                @elseif($status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Menunggu</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">{{ ucfirst($status) }}</span>
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
        <!-- Produk -->
        @if($produks->isNotEmpty())
            <div class="border rounded-lg shadow mb-6">
                <div class="bg-yellow-100 px-4 py-2 rounded-t-lg">
                    <h4 class="font-semibold text-lg">Produk</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center border-collapse">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Nama Produk</th>
                                <th class="border px-4 py-2">Harga</th>
                                <th class="border px-4 py-2">Stok</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($produks as $produk)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $produk->nama_produk }}</td>
                                    <td class="border px-4 py-2">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ $produk->stok }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif

    <!-- Pagination -->
    <div class="mt-4 flex flex-wrap justify-center gap-4">
        @if($pelanggans->isNotEmpty())
            <div>{{ $pelanggans->links() }}</div>
        @endif

        @if($penjualans->isNotEmpty())
            <div>{{ $penjualans->links() }}</div>
        @endif

        @if($produks->isNotEmpty())
            <div>{{ $produks->links() }}</div>
        @endif
    </div>
</div>

<style>
    @media print {
        .container,
        .flex,
        nav,
        .mt-4 {
            display: none !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        table, th, td {
            border: 1px solid black !important;
        }

        th, td {
            padding: 8px !important;
            text-align: center !important;
        }

        h2, h4 {
            margin-top: 20px !important;
        }
    }
</style>
@endsection
