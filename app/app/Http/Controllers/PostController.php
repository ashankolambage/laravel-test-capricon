<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function home()
    {
        $posts = Post::all();

        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return Inertia::render('PostShow', [
            'post' => $post,
        ]);
    }
}
