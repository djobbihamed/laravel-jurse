<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Parsedown;

class PostController extends Controller
{
    // fetching posts for admin dashboard
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(3); // Paginate with 3 items per page
        return view('admin.posts.index', compact('posts'));
    }

    public function show($slug)
    {
        // you need to download => composer require erusev/parsedown
        $post = Post::where('slug', $slug)->firstOrFail();
        $parsedown = new Parsedown();
        $post->content = $parsedown->text($post->content); // Convert Markdown to HTML

        return view('post.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100|unique:posts',
            'excerpt' => 'nullable',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'required|image|max:2048', // 2MB max
        ]);

        $path = $request->file('featured_image')->store('public/posts');

        $post = new Post([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $path,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(), // the connected admin
            'published_at' => $request->has('status') ? now() : null,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // dd($request->has('status'), now()->format('Y-m-d'));

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all(); // Assuming you want to list categories in a dropdown
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:100|unique:posts,title,' . $post->id,
            'excerpt' => 'nullable',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'sometimes|image|max:2048', // 2MB max, optional
        ]);

        $postData = $request->only(['title', 'excerpt', 'content', 'category_id']);

        if ($request->has('status')) {
            $postData['status'] = 1;
            $postData['published_at'] = now();
        } else {
            $postData['status'] = 0;
        }

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('public/posts');
            $postData['featured_image'] = $path;
        }

        $post->update($postData);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Request $request)
    {
        $postId = $request->input('post_id');
        $post = Post::findOrFail($postId);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
