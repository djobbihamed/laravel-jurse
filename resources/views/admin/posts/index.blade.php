@extends('admin.dashboard')

@section('dashboard-content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Posts</h1>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                Create New Post
            </a>
        </div>
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100"> {{-- Make cards of equal height --}}
                        @if ($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->excerpt }}</p>
                            {{-- Publish Status and Date --}}
                            <p class="card-text mt-auto">
                                @if ($post->status)
                                    <span class="text-success">Published</span><br>
                                    @if (!is_null($post->published_at))
                                        <small>{{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</small>
                                    @else
                                        <small>Date not set</small>
                                    @endif
                                @else
                                    <span class="text-danger">Unpublished</span>
                                @endif
                            </p>

                            <div>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <button class="btn btn-danger btn-sm" onclick="confirmPostDelete({{ $post->id }})">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <p>No available posts.</p>
                </div>
            @endforelse
        </div>

        <div>
            <hr class="my-2" />
            {{ $posts->links() }}
        </div>
    </div>


    {{-- Bootstrap Modal for Deletion Confirmation --}}
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" action="{{ route('admin.posts.destroy', 0) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="post_id" id="post_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this post?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmPostDelete(postId) {
            document.getElementById('post_id').value = postId;
            new bootstrap.Modal(document.getElementById('deleteConfirmationModal')).show();
        }
    </script>
@endsection
