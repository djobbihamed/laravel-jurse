@extends('layouts.app')

@section('content')
    <div class="container">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        @if ($posts->isEmpty())
            <h2>No posts available.</h2>
        @else
            <!-- Page header with logo and tagline-->
            <header class="py-5 bg-light border-bottom mb-4">
                <div class="container">
                    <div class="text-center my-5 image-banner">
                        <h1 class="fw-bolder title">Explore the World with Us!</h1>
                        <p class="lead mb-0">Discover hidden gems and exciting adventures around the globe.</p>
                    </div>
                </div>
            </header>
            <!-- Page content-->
            <div class="container">
                <div class="row">

                    <!-- Blog entries-->
                    <div class="col-lg-8">
                        {{-- <h2>Latest Posts</h2> --}}
                        @if ($posts->currentPage() == 1 && $posts->count() > 0)
                            <!-- Featured blog post-->
                            @php $featuredPost = $posts->shift() @endphp
                            <div class="card mb-4">
                                <a href="{{ route('post.show', $featuredPost->slug) }}"><img class="card-img-top"
                                        src="{{ Storage::url($featuredPost->featured_image) }}"
                                        alt="{{ $featuredPost->title }}"
                                        style="height: 350px; width:100%;max-width:850px;object-fit: cover;" /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{ $featuredPost->published_at->format('M d, Y') }}</div>
                                    <h2 class="card-title">{{ $featuredPost->title }}</h2>
                                    <p class="card-text">{{ $featuredPost->excerpt }}</p>
                                    <a class="btn btn-primary" href="{{ route('post.show', $featuredPost->slug) }}">Read
                                        more →</a>
                                </div>
                            </div>
                        @endif

                        <!-- Nested row for non-featured blog posts-->
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-6 mb-2">
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

                        <!-- Pagination-->
                        @if ($posts->hasPages())
                            <nav aria-label="Pagination">
                                <hr class="my-2" />
                                {{ $posts->links() }}
                            </nav>
                        @endif

                    </div>

                    <!-- Side widgets-->
                    <div class="col-lg-4">
                        <!-- Search widget-->
                        <div class="card mb-4">
                            <div class="card-header">Search</div>
                            <div class="card-body">
                                <form action="{{ route('search') }}" method="GET">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="query"
                                            placeholder="Enter search term..." aria-label="Enter search term..."
                                            aria-describedby="button-search" />
                                        <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Categories widget-->
                        <div class="card mb-4">
                            <div class="card-header">Categories</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @forelse ($categories as $category)
                                        <li class="list-group-item">
                                            <a href="{{ route('category.show', $category) }}" class="text-decoration-none">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No categories available.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
