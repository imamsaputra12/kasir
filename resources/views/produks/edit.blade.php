@extends('template')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit Produk</h2>

    <form action="{{ route('produks.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">

        <div>
            <label class="block mb-1 font-medium">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Harga</label>
            <input type="number" name="harga" value="{{ $produk->harga }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" min="0" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Stok</label>
            <input type="number" name="stok" value="{{ $produk->stok }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" min="0" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Gambar Produk</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @if($produk->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/images/' . $produk->image) }}" alt="Image" class="w-24 rounded shadow">
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                Update
            </button>
            <a href="{{ route('produks.index') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-400 transition font-medium">
                Kembali
            </a>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            Swal.fire({
                title: "Sukses!",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection
