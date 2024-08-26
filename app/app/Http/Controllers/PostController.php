<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        
        $slug = Str::slug($request->input('title'));
        $originalSlug = $slug;

        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $post->slug = $slug;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newFileName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/blog'), $newFileName);
            $post->image = $newFileName;
        }

        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.create')->with('success', 'Post created successfully.');
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id !== auth()->id()) {
                return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this post.');
            }
            
            if ($post->image && file_exists(public_path('uploads/blog/' . $post->image))) {
                unlink(public_path('uploads/blog/' . $post->image));
            }

            $post->delete();
            return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
        } catch (ModelNotFoundException $e) {
            Log::error('Post not found: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Post not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'There was an error deleting the post.');
        }
    }

    public function edit($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id !== auth()->id()) {
                return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this post.');
            }

            $categories = Category::all();
            return Inertia::render('PostsEdit', [
                'post' => $post,
                'categories' => $categories
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Post not found: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Post not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:categories,id',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $post = Post::findOrFail($id);

            if ($post->user_id !== auth()->id()) {
                return redirect()->route('dashboard')->with('error', 'You are not authorized to edit this post.');
            }

            $post->title = $validated['title'];
            $post->category_id = $validated['category_id'];
            $post->content = $validated['content'];

            if ($request->hasFile('image')) {
                if ($post->image && file_exists(public_path('uploads/blog/' . $post->image))) {
                    unlink(public_path('uploads/blog/' . $post->image));
                }

                $image = $request->file('image');
                $imageName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/blog'), $imageName);
                $post->image = $imageName;
            }

            $post->save();
            return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
        } catch (ModelNotFoundException $e) {
            Log::error('Post not found: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Post not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating post: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'There was an error updating the post.');
        }
    }
}
