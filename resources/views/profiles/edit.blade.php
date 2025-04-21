@extends('template')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header dengan garis elegan -->
            <div class="mb-5 text-center">
                <h1 class="display-4 fw-bold text-primary mb-2">Edit Profil</h1>
                <div class="d-flex justify-content-center">
                    <div style="width: 80px; height: 3px; background: linear-gradient(to right, #6366F1, #8B5CF6);"></div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger shadow-sm border-0 mb-4">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>
                            <strong>Mohon periksa form berikut:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
                <div class="card-header bg-primary bg-gradient text-white p-3">
                    <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-2"></i>Perbarui Informasi</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profiles.update', $profile->profile_id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                        <div class="mb-4">
                            <label for="bio" class="form-label fw-medium">Bio <span class="text-muted small">(Ceritakan tentang diri Anda)</span></label>
                            <textarea class="form-control border-0 bg-light" id="bio" name="bio" rows="3" style="border-radius: 10px;">{{ old('bio', $profile->bio) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label fw-medium">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control border-0 bg-light" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="address" class="form-label fw-medium">Alamat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control border-0 bg-light" id="address" name="address" value="{{ old('address', $profile->address) }}" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="bi bi-check2-circle me-1"></i> Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection