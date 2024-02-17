@extends('admin.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Edit User</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Admin Checkbox --}}
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1"
                    {{ $user->is_admin ? 'checked' : '' }}>
                <label class="form-check-label" for="is_admin">Admin</label>
            </div>

            {{-- Update Button --}}
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
