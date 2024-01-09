<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GuestPostController extends Controller
{
    public function index()
    {
        $title = '';

        // Membuat key unik untuk cache berdasarkan parameter request
        $cacheKey = 'posts.' . md5(request()->fullUrl());

        // Menggunakan Cache::remember untuk menyimpan dan mengambil data dari cache
        $posts = Post::where('public', 1)
            ->latest()
            ->filter(request(['search', 'category', 'author']))
            ->paginate(7)
            ->withQueryString();

        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = ' in ' . $author->name;
        }
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }

        if (!Cache::has($cacheKey)) {
            Log::info('Data diambil dari cache.'); // Log jika data diambil dari cache
        }

        return view('posts.index', [
            "title" => "All Posts" . $title,
            "posts" => $posts,
            "cache" => Cache::has($cacheKey)
        ]);
    }

    public function show(Post $post)
    {

        return view('posts.show', [
            "post" => $post,
            "title" => $post->name,
        ]);
    }
}
