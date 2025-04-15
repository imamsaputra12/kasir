@extends('template')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <center><h2 class="text-2xl font-bold mb-6">Daftar Penjualan</h2></center>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 border border-red-400 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <a href="{{ route('penjualans.create') }}"
       class="inline-block mb-4 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
        + Buat Pembayaran
    </a>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full border border-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-800 text-white text-center text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 border">No</th>
                    <th class="px-4 py-3 border">Kode Pembayaran</th>
                    <th class="px-4 py-3 border">Tanggal</th>
                    <th class="px-4 py-3 border">Pelanggan</th>
                    <th class="px-4 py-3 border">Produk</th>
                    <th class="px-4 py-3 border">Total</th>
                    <th class="px-4 py-3 border">Dibayar</th>
                    <th class="px-4 py-3 border">Kembalian</th>
                    <th class="px-4 py-3 border">Metode</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualans as $penjualan)
                <tr class="border-b hover:bg-gray-50 text-center">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $penjualan->kode_pembayaran }}</td>
                    <td class="px-4 py-2 border whitespace-nowrap">
                        {{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}
                    </td>                    
                    <td class="px-4 py-2 border">
                        {{ $penjualan->pelanggan ? $penjualan->pelanggan->nama_pelanggan : 'Umum' }}
                    </td>
                    <td class="px-4 py-2 border whitespace-nowrap overflow-x-auto max-w-xs truncate">
                        @php
                            $produkList = json_decode($penjualan->produk_id, true);
                            $produkString = $produkList ? implode(', ', array_map(function($produk) {
                                return $produk['nama_produk'] . " ({$produk['jumlah']}x)";
                            }, $produkList)) : '-';
                        @endphp
                        {{ $produkString }}
                    </td>
                    <td class="px-4 py-2 border">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border"><i class=>{{ ucfirst($penjualan->metode_pembayaran) }}</td>

                    {{-- Status --}}
                    <td class="px-4 py-2 border">
                        @if($penjualan->status === 'paid')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-semibold">Lunas</span>
                    @elseif($penjualan->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-semibold">Menunggu</span>
                    @elseif($penjualan->status === 'failed')
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-semibold">Gagal</span>
                    @else
                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full font-semibold">Tidak Diketahui</span>
                    @endif
                    
                    </td>                    

                    {{-- Aksi --}}
                    <td class="px-4 py-2 border">
                        <div class="flex flex-wrap gap-2 justify-center">
                            @can('admin')
                            <a href="{{ route('penjualans.edit', $penjualan->penjualan_id) }}"
                               class="w-24 text-center bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded text-xs font-semibold">
                                Edit
                            </a>
                            <form action="{{ route('penjualans.destroy', $penjualan->penjualan_id) }}"
                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit"
                                        class="w-24 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                            @endcan
                    
                            <a href="{{ route('penjualans.show', $penjualan->penjualan_id) }}"
                               class="w-24 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-xs font-semibold">
                                Detail
                            </a>
                        </div>
                    </td>                    
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
