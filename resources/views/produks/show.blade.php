@extends('template')

@section('content')

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Detail Produk</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Gambar -->
                <div class="col-md-4 text-center">
                    @if($produk->image)
                        <img src="{{ asset('storage/images/' . $produk->image) }}" alt="Gambar Produk" class="img-fluid rounded" style="max-width: 100%;">
                    @else
                        <p class="text-muted">No Image</p>
                    @endif
                </div>

                <!-- Kolom Detail Produk -->
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th>Nama Produk</th>
                            <td>{{ $produk->nama_produk }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp.{{ number_format($produk->harga, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>{{ $produk->stok }}</td>
                        </tr>
                    </table>

                    <div class="d-flex">
                        <a href="{{ route('produks.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <a href="{{ route('produks.edit', $produk->produk_id) }}" class="btn btn-warning me-2">Edit</a>

                        <!-- Tombol Delete -->
                        <form id="delete-form" action="{{ route('produks.destroy', $produk->produk_id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                            <button type="button" class="btn btn-danger" id="btn-delete">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("btn-delete").addEventListener("click", function (event) {
        event.preventDefault();
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Produk ini akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("delete-form").submit();
            }
        });
    });
</script>

@endsection