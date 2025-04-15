@extends('template')
@section('content')

<div class="max-w-xl mx-auto p-6 mt-8 bg-white shadow-lg rounded-lg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Tambah Pelanggan Baru</h1>

    <form id="create-form" action="{{ route('pelanggans.store') }}" method="POST" class="space-y-5">
        {{ csrf_field() }}

        <div>
            <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                   value="{{ old('nama_pelanggan') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3"
                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      required>{{ old('alamat') }}</textarea>
        </div>

        <div>
            <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon"
                   value="{{ old('nomor_telepon') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <div class="flex items-center justify-between pt-4">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded shadow">
                Simpan
            </button>
            <a href="{{ route('pelanggans.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-2 rounded shadow">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById("create-form").addEventListener("submit", function (e) {
        e.preventDefault(); // Mencegah form terkirim langsung

        Swal.fire({
            title: "Yakin ingin menyimpan pelanggan?",
            icon: "question",
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
