@extends('template')

@section('content')

<div class="max-w-6xl mx-auto px-4 mt-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Daftar Produk</h1>

@can('admin')
    <div class="mb-6 text-left">
        <a href="{{ route('produks.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
            + Tambah Produk
        </a>
    </div>
@endcan


    <div class="grid gap-5 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @forelse($produks as $produk)
            <div class="bg-white rounded-xl shadow-md overflow-hidden border">
                <div class="h-32 bg-gray-100 flex justify-center items-center">
                    @if($produk->image)
                        <img src="{{ asset('storage/images/' . $produk->image) }}"
                             alt="Image"
                             class="h-full object-cover">
                    @else
                        <span class="text-sm text-gray-400">No Image</span>
                    @endif
                </div>

                <div class="p-3 text-center">
                    <h2 class="font-semibold text-sm truncate">{{ $produk->nama_produk }}</h2>
                    <p class="text-gray-600 text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p class="text-gray-500 text-xs">Stok: <span class="font-medium">{{ $produk->stok }}</span></p>

                    @can('admin')
                        <div class="flex justify-center gap-2 mt-3">
                            <a href="{{ route('produks.edit', $produk->produk_id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 text-xs rounded-md transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('produks.destroy', $produk->produk_id) }}" method="POST" onsubmit="return confirmDelete()">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md transition">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                Tidak ada produk.
            </div>
        @endforelse
    </div>
</div>

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

        @if(session('error'))
        Swal.fire({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error",
            timer: 2000,
            showConfirmButton: false
        });
        @endif
    });
</script>

<script>
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus produk ini?");
    }
</script>

@endsection
