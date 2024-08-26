<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id;
        $categoryId = Category::first()->id;

        foreach (range(1, 5) as $index) {
            Post::create([
                'title' => 'Blog Post Title ' . $index,
                'slug' => Str::slug('Blog Post Title ' . $index),
                'content' => 'This is the content for blog post ' . $index . '. It contains detailed information about various topics.',
                'image' => 'sample-blog-post-image.jpg',
                'user_id' => $userId,
                'category_id' => $categoryId,
            ]);
        }
    }
}
