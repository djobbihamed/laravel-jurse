<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function posts()
    {
        return view('admin.posts');
    }

    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit_category', compact('category'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:25|unique:categories,name',
            'description' => 'required',
        ]);

        // Correctly generate the slug
        $slug = Str::slug($request->input('name'), '-');

        Category::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description')
        ]);

        session()->flash('success', 'Category added successfully.');
        return redirect()->route('admin.categories.index');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            // ignore the category name being updated
            'name' => 'required|max:25|unique:categories,name,' . $category->id,
            'slug' => 'required|max:25|unique:categories,slug,' . $category->id,
            'description' => 'required',
        ]);

        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('slug')), // replace spaces with dashes using Str
            'description' => $request->input('description')
        ]);

        session()->flash('success', 'Category updated successfully.');
        return redirect()->route('admin.categories.index');
    }



    public function destroyCategory(Category $category)
    {
        $category->delete();

        session()->flash('success', 'Category deleted successfully.');
        return redirect()->route('admin.categories.index');
    }

    public function users()
    {
        $users = User::where('id', '!=', Auth::id())->paginate(10); // Fetch users except the current user
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            // 'is_admin' => 'boolean',
        ]);
        $user->update([
            'name' => $request->name,
            // 'is_admin' => $request->has('is_admin'),
            'is_admin' => $request->has('is_admin') ? 1 : 0,
        ]);
        // dd($user);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        // Add logic to handle if the admin tries to delete themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}
