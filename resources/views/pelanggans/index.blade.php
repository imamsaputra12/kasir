@extends('template')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Daftar Pelanggan</h1>

    <!-- Tombol Tambah Pelanggan -->
    <a href="{{ route('pelanggans.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow mb-4">
        Tambah Pelanggan
    </a>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-sm text-left border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border whitespace-nowrap">No</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Nama Pelanggan</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Alamat</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Nomor Telepon</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($pelanggans as $pelanggan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 border whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $pelanggan->nama_pelanggan }}</td>
                        <td class="px-4 py-2 border">{{ $pelanggan->alamat }}</td>
                        <td class="px-4 py-2 border whitespace-nowrap">{{ $pelanggan->nomor_telepon }}</td>
                        <td class="px-4 py-2 border whitespace-nowrap flex space-x-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('pelanggans.edit', $pelanggan->pelanggan_id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs font-semibold shadow">
                                Edit
                            </a>

                            <!-- Form Hapus -->
                            <form action="{{ route('pelanggans.destroy', $pelanggan->pelanggan_id) }}"
                                  method="POST"
                                  class="inline-block delete-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold shadow">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-4 text-gray-500">Tidak ada data pelanggan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- SweetAlert2 -->
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

        @if(session('error'))
            Swal.fire({
                title: "Gagal!",
                text: "{{ session('error') }}",
                icon: "error",
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        // Konfirmasi hapus dengan SweetAlert2
        document.querySelectorAll(".delete-form").forEach(form => {
            form.addEventListener("submit", function (event) {
                event.preventDefault();

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data pelanggan akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
