@extends('template')
@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-2xl shadow-lg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Edit Data Pelanggan</h1>

    <form id="edit-form" action="{{ route('pelanggans.update', $pelanggan->pelanggan_id) }}" method="POST" class="space-y-5">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">

        <!-- Nama Pelanggan -->
        <div>
            <label for="nama_pelanggan" class="block font-medium text-gray-700 mb-2">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block font-medium text-gray-700 mb-2">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3"
                      class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
        </div>

        <!-- Nomor Telepon -->
        <div>
            <label for="nomor_telepon" class="block font-medium text-gray-700 mb-2">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('nomor_telepon', $pelanggan->nomor_telepon) }}" required>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-between mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-xl transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('pelanggans.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-xl transition">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById("edit-form").addEventListener("submit", function (e) {
        e.preventDefault(); // Mencegah form terkirim langsung

        Swal.fire({
            title: "Yakin ingin menyimpan perubahan?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, simpan!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit(); // Kirim form jika dikonfirmasi
            }
        });
    });
</script>
@endsection
