<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)->whereNotNull('published_at')->with('user', 'category', 'tags')->latest()->paginate(10);
        return view('home', compact('posts'));
    }
}
