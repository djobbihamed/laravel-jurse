<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // Fetch posts related to the category with pagination
        $posts = $category->posts()->where('status', 1)->paginate(4);

        return view('category.show', compact('category', 'posts'));
    }
}
