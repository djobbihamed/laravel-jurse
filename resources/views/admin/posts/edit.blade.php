@extends('admin.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Edit Post</h1>
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Excerpt Field --}}
            <div class="mb-3">
                <label for="excerpt" class="form-label">Excerpt</label>
                <textarea class="form-control" id="excerpt" name="excerpt">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content Field --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category Field --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Featured Image Field --}}
            <div class="mb-3">
                <label for="featured_image" class="form-label mb-0">Post Image</label>

                <div class="mb-2">
                    @if ($post->featured_image)
                        <img id="current-image" src="{{ Storage::url($post->featured_image) }}" alt="Featured Image"
                            style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;">
                    @endif
                </div>

                <input type="file" class="form-control" id="featured_image" name="featured_image"
                    onchange="updateImagePreview(this)">
                @error('featured_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Publish Status Field --}}
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="status" name="status" value="1"
                    {{ $post->status ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Publish Now</label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>

    <script>
        function updateImagePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var currentImage = document.getElementById('current-image');
                    if (!currentImage) {
                        currentImage = document.createElement('img');
                        currentImage.id = 'current-image';
                        currentImage.style = 'max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px;';
                        document.querySelector('label[for="featured_image"]').appendChild(currentImage);
                    }
                    currentImage.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
