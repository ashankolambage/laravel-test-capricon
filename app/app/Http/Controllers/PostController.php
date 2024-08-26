<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function home()
    {
        $posts = Post::all();
        $categories = Category::all();

        return Inertia::render('Home', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $categories = Category::all();
        
        $posts = Post::where('user_id', $user->id)->get();

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return Inertia::render('PostShow', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return inertia('PostCreate', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->slug = Str::slug($request->input('title'));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newFileName = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/blog'), $newFileName);
            $post->image = $newFileName;
        }

        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.create')->with('success', 'Post created successfully.');
    }
}
