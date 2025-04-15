@extends('template')

@section('content')

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Detail Pelanggan</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama Pelanggan</th>
                    <td>{{ $pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $pelanggan->alamat }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon</th>
                    <td>{{ $pelanggan->nomor_telepon }}</td>
                </tr>
            </table>

            <div class="d-flex">
                <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <a href="{{ route('pelanggans.edit', $pelanggan->pelanggan_id) }}" class="btn btn-warning me-2">Edit</a>

                <!-- Tombol Delete -->
                <form id="delete-form" action="{{ route('pelanggans.destroy', $pelanggan->pelanggan_id) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="delete">
                    <button type="button" class="btn btn-danger" id="btn-delete">Hapus</button>
                </form>
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
            text: "Data pelanggan ini akan dihapus secara permanen!",
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