@extends('template')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header dengan garis elegan -->
            <div class="mb-5 text-center">
                <h1 class="display-4 fw-bold text-primary mb-2">Profil Anda</h1>
                <div class="d-flex justify-content-center">
                    <div style="width: 80px; height: 3px; background: linear-gradient(to right, #6366F1, #8B5CF6);"></div>
                </div>
            </div>

            <!-- Menampilkan pesan sukses jika ada -->
            @if(session('success'))
                <div class="alert alert-success shadow-sm fade show border-0" role="alert">
                    <div class="d-flex">
                        <div class="me-2">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            <!-- Menampilkan Profil jika ada, jika tidak tampilkan tombol buat profil baru -->
            @if($profiles->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-person-plus text-primary" style="font-size: 5rem;"></i>
                    </div>
                    <h3 class="text-secondary mb-4">Belum ada profil ditemukan</h3>
                    <a href="{{ route('profiles.create') }}" class="btn btn-primary btn-lg px-4 rounded-pill">
                        <i class="bi bi-plus-circle me-2"></i> Buat Profil Baru
                    </a>
                </div>
            @else
                @foreach($profiles as $profile)
                    <div class="card border-0 shadow-lg rounded-3 overflow-hidden mb-4">
                        <div class="card-header bg-primary bg-gradient text-white p-3">
                            <h5 class="card-title mb-0"><i class="bi bi-person-circle me-2"></i>Informasi Personal</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4">
                                <div class="col-md-3 text-muted">Bio</div>
                                <div class="col-md-9 fw-medium">{{ $profile->bio }}</div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3 text-muted">Telepon</div>
                                <div class="col-md-9 fw-medium">{{ $profile->phone }}</div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-3 text-muted">Alamat</div>
                                <div class="col-md-9 fw-medium">{{ $profile->address }}</div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('profiles.edit', $profile->profile_id) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('profiles.destroy', $profile->profile_id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal-{{ $profile->profile_id }}">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Konfirmasi Hapus Profil -->
                    <div class="modal fade" id="deleteConfirmModal-{{ $profile->profile_id }}" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('profiles.destroy', $profile->profile_id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus profil ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Tombol Kembali ke Dashboard -->
            <div class="text-center mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4 rounded-pill">
                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
@endsection