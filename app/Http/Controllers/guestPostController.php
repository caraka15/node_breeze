<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class guestPostController extends Controller
{
    public function index()
    {

        $title = '';
        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = ' in ' . $author->name;
        }
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }

        return view('posts.index', [
            "title" => "All Posts" . $title,
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            "post" => $post,
        ]);
    }
}
