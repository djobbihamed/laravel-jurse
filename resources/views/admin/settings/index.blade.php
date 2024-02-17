@extends('admin.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Website Settings</h1>
        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Site Title --}}
            <div class="mb-3">
                <label for="site_title" class="form-label">Site Title</label>
                <input type="text" class="form-control" id="site_title" name="site_title"
                    value="{{ $settings['site_title'] ?? '' }}">
            </div>

            {{-- Favicon --}}
            <div class="mb-3">
                <label for="favicon" class="form-label">Favicon (PNG)</label>
                <input type="file" class="form-control" id="favicon" name="favicon">
                @error('favicon')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @if (isset($settings['favicon']))
                    <img src="{{ Storage::url($settings['favicon']) }}" alt="Favicon" style="max-height: 32px;">
                @endif
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>
    </div>
@endsection
