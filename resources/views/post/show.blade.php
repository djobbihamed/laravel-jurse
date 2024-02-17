@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Post Title -->
                <h1 class="fw-bolder mb-4">{{ $post->title }}</h1>

                <!-- Featured Image -->
                @if ($post->featured_image)
                    <div class="text-center mb-4">
                        <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid rounded"
                            alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                    </div>
                @endif

                <!-- Post Content -->
                <article>
                    <div class="mb-4 text-muted">
                        <small>Published on {{ $post->published_at->format('F d, Y') }}</small>
                    </div>
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection
