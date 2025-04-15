@extends('template')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 mt-10 rounded-2xl shadow-md">
    <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Edit Pembayaran</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('penjualans.update', $penjualan->penjualan_id) }}" method="POST" class="space-y-6">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">

        <!-- Pelanggan -->
        <div>
            <label for="pelanggan_id" class="block font-semibold text-gray-700 mb-2">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan_id"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Umum</option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->pelanggan_id }}" {{ $penjualan->pelanggan_id == $pelanggan->pelanggan_id ? 'selected' : '' }}>
                        {{ $pelanggan->nama_pelanggan }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Produk -->
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Produk</label>
            <div id="produk-container" class="space-y-4">
                @php $produkList = json_decode($penjualan->produk_id, true); @endphp
                @foreach($produkList as $key => $produkData)
                <div class="flex flex-col md:flex-row gap-3 items-center produk-item">
                    <select name="produk_id[]"
                        class="flex-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @foreach($produks as $produk)
                            <option value="{{ $produk->produk_id }}" {{ $produk->produk_id == $produkData['produk_id'] ? 'selected' : '' }}>
                                {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="jumlah[]" min="1"
                        class="w-24 border border-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ $produkData['jumlah'] }}">
                    <button type="button"
                        class="text-red-600 hover:bg-red-100 px-3 py-2 rounded-xl border border-red-500 transition remove-produk">
                        ×
                    </button>
                </div>
                @endforeach
            </div>

            <button type="button" id="tambah-produk"
                class="mt-4 inline-flex items-center gap-2 border border-blue-500 text-blue-600 px-4 py-2 rounded-xl hover:bg-blue-50 transition text-sm font-semibold">
                <span class="text-xl">+</span> Tambah Produk
            </button>
        </div>

        <!-- Jumlah Bayar -->
        <div>
            <label for="jumlah_bayar" class="block font-semibold text-gray-700 mb-2">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" min="0"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ $penjualan->jumlah_bayar }}" required>
        </div>

        <!-- Metode Pembayaran -->
        <div>
            <label for="metode_pembayaran" class="block font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="cash" {{ $penjualan->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="transfer" {{ $penjualan->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="credit_card" {{ $penjualan->metode_pembayaran == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                <option value="e_wallet" {{ $penjualan->metode_pembayaran == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="paid">Lunas</option>
                <option value="pending">Menunggu</option>
                <option value="failed">Gagal</option>
            </select>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex gap-4">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition font-semibold">
                Simpan
            </button>
            <a href="{{ route('penjualans.index') }}"
                class="bg-gray-300 text-gray-800 px-6 py-2 rounded-xl hover:bg-gray-400 transition font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>

<!-- Script Tambah Produk -->
<script>
    document.getElementById('tambah-produk').addEventListener('click', function () {
        const container = document.getElementById('produk-container');
        const item = container.querySelector('.produk-item');
        const clone = item.cloneNode(true);
        clone.querySelector('input').value = 1;
        container.appendChild(clone);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-produk')) {
            const item = e.target.closest('.produk-item');
            const allItems = document.querySelectorAll('.produk-item');
            if (allItems.length > 1) item.remove();
        }
    });
</script>
@endsection
