@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">{{ $category->name }}</h1>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-lg-4 mb-2">
                    <!-- Blog post-->
                    <div class="card mb-4 h-100">
                        <a href="{{ route('post.show', $post->slug) }}"><img class="card-img-top"
                                src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                style="height: 200px; width:100%;max-width:700px;object-fit: cover;" /></a>
                        <div class="card-body">
                            <div class="small text-muted">{{ $post->published_at->format('M d, Y') }}</div>
                            <h2 class="card-title h4 ">{{ $post->title }}</h2>
                            <p class="card-text">{{ $post->excerpt }}</p>
                            {{-- <a class="btn btn-primary" href="#!">Read more →</a> --}}
                            <a class="btn btn-primary" href="{{ route('post.show', $post->slug) }}">Read
                                more →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        @if ($posts->hasPages())
            <div>
                <hr class="my-2" />
                {{ $posts->links() }}
            </div>
        @endif

    </div>
@endsection
