@extends('template')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg">
    <center><h2 class="text-xl font-bold mb-4">Pembayaran</h2></center>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('penjualans.store') }}" method="POST" class="space-y-4">
        {{ csrf_field() }}

        <div>
            <label class="block font-medium mb-1">Pelanggan</label>
            <select name="pelanggan_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Pilih Pelanggan (Opsional)</option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->pelanggan_id }}">{{ $pelanggan->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Tanggal Penjualan</label>
            <input type="date" name="tanggal_penjualan" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Produk</label>
            <div id="produk-list" class="space-y-2">
                <div class="produk-item flex flex-wrap gap-2 items-center">
                    <select name="produk_id[]" class="produk-select border border-gray-300 rounded px-3 py-2" required onchange="updateSubtotal(this)">
                        <option value="">Pilih Produk</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->produk_id }}" data-harga="{{ $produk->harga }}">
                                {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="jumlah[]" class="jumlah-input border border-gray-300 rounded px-3 py-2" placeholder="Jumlah" min="1" required oninput="updateSubtotal(this)">
                    <input type="text" name="subtotal[]" class="subtotal-input border border-gray-200 bg-gray-100 rounded px-3 py-2" placeholder="Subtotal" readonly>
                    <button type="button" class="text-red-600 font-bold border border-red-400 rounded px-3 py-2 hover:bg-red-100" onclick="hapusProduk(this)">×</button>
                </div>
            </div>
            <button type="button" class="mt-2 text-sm font-medium text-blue-600 border border-blue-500 rounded px-3 py-1 hover:bg-blue-100" onclick="tambahProduk()">+ Tambah Produk</button>
        </div>

        <div>
            <label class="block font-medium mb-1">Total Bayar</label>
            <input type="text" id="total_bayar" name="total_bayar" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>
        </div>

        <div>
            <label class="block font-medium mb-1">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Kembalian</label>
            <input type="text" id="kembalian" name="kembalian" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>
        </div>
        

        <div>
            <label class="block font-medium mb-1">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
                <option value="credit_card">Credit Card</option>
                <option value="e_wallet">E-Wallet</option>
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
        
        

        <div class="flex gap-2 mt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('penjualans.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>

<script>
// Semua script tetap aman
function tambahProduk() {
    let produkList = document.getElementById("produk-list");
    let produkItem = document.createElement("div");
    produkItem.className = "produk-item flex flex-wrap gap-2 items-center mt-2";

    produkItem.innerHTML = `
        <select name="produk_id[]" class="produk-select border border-gray-300 rounded px-3 py-2" required onchange="updateSubtotal(this)">
            <option value="">Pilih Produk</option>
            @foreach($produks as $produk)
                <option value="{{ $produk->produk_id }}" data-harga="{{ $produk->harga }}">
                    {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </option>
            @endforeach
        </select>
        <input type="number" name="jumlah[]" class="jumlah-input border border-gray-300 rounded px-3 py-2" placeholder="Jumlah" min="1" required oninput="updateSubtotal(this)">
        <input type="text" name="subtotal[]" class="subtotal-input border border-gray-200 bg-gray-100 rounded px-3 py-2" placeholder="Subtotal" readonly>
        <button type="button" class="text-red-600 font-bold border border-red-400 rounded px-3 py-2 hover:bg-red-100" onclick="hapusProduk(this)">×</button>
    `;

    produkList.appendChild(produkItem);
}

function hapusProduk(button) {
    button.parentElement.remove();
    hitungTotal();
}

function updateSubtotal(element) {
    let produkItem = element.closest(".produk-item");
    let produkSelect = produkItem.querySelector(".produk-select");
    let jumlahInput = produkItem.querySelector(".jumlah-input");
    let subtotalInput = produkItem.querySelector(".subtotal-input");

    let harga = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-harga");
    let jumlah = jumlahInput.value;

    if (harga && jumlah) {
        subtotalInput.value = harga * jumlah;
    } else {
        subtotalInput.value = 0;
    }
    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    let subtotalInputs = document.querySelectorAll(".subtotal-input");

    subtotalInputs.forEach(subtotal => {
        total += parseInt(subtotal.value) || 0;
    });

    document.getElementById("total_bayar").value = total;
}
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("input[name='jumlah_bayar']").addEventListener("input", hitungKembalian);
    });
    
    function hitungKembalian() {
        let jumlahBayar = parseInt(document.querySelector("input[name='jumlah_bayar']").value) || 0;
        let totalBayar = parseInt(document.getElementById("total_bayar").value) || 0;
        let kembalian = jumlahBayar - totalBayar;
    
        document.getElementById("kembalian").value = kembalian > 0 ? kembalian : 0;
    }
    
    function updateSubtotal(element) {
        let produkItem = element.closest(".produk-item");
        let produkSelect = produkItem.querySelector(".produk-select");
        let jumlahInput = produkItem.querySelector(".jumlah-input");
        let subtotalInput = produkItem.querySelector(".subtotal-input");
    
        let harga = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-harga");
        let jumlah = jumlahInput.value;
    
        if (harga && jumlah) {
            subtotalInput.value = harga * jumlah;
        } else {
            subtotalInput.value = 0;
        }
        hitungTotal();
    }
    
    function hitungTotal() {
        let total = 0;
        let subtotalInputs = document.querySelectorAll(".subtotal-input");
    
        subtotalInputs.forEach(subtotal => {
            total += parseInt(subtotal.value) || 0;
        });
    
        document.getElementById("total_bayar").value = total;
    
        // Panggil ulang hitung kembalian setiap kali total berubah
        hitungKembalian();
    }
    </script>
    
@endsection
