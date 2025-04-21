@extends('template')

@section('content')
<div class="container">
    <h1>Create Profile</h1>

    <form action="{{ route('profiles.store') }}" method="POST">
        {{ csrf_field()}}

        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio') }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
        </div>

        <button type="submit" class="btn btn-success">Save Profile</button>
    </form>
</div>
@endsection
