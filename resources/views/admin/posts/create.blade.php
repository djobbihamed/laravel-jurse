@extends('admin.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Create New Post</h1>
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title Field --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title"
                    value="{{ old('title') }}">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Excerpt Field --}}
            <div class="mb-3">
                <label for="excerpt" class="form-label">Excerpt</label>
                <textarea class="form-control" id="excerpt" name="excerpt" placeholder="Enter a short excerpt">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content Field --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" placeholder="Enter post content">{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category Field --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Select a category</option>
                    @forelse ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @empty
                        <option disabled>No categories available. Please create one first.</option>
                    @endforelse
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Featured Image Field --}}
            <div class="mb-3">
                <label for="featured_image" class="form-label">Post Image</label>

                {{-- Image Preview Container --}}
                <div id="image-preview-container" class="mb-2" style="max-width: 200px;"></div>

                <input type="file" class="form-control" id="featured_image" name="featured_image"
                    onchange="updateImagePreview(this)">
                @error('featured_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                @if ($errors->any())
                    <small class="text-muted">Please re-select the image.</small>
                @endif
            </div>

            {{-- Publish Status Field --}}
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="status" name="status" value="1">
                <label class="form-check-label" for="status">Publish Now</label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
    <script>
        function updateImagePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imagePreviewContainer = document.getElementById('image-preview-container');
                    imagePreviewContainer.innerHTML = ''; // Clear existing content

                    var newImage = document.createElement('img');
                    newImage.src = e.target.result;
                    newImage.style = 'max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;';

                    imagePreviewContainer.appendChild(newImage);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
