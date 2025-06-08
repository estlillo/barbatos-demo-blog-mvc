<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->orderBy('posts.published_at', 'desc')
            ->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        //handle published_at
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        $data['slug'] = Str::slug($data['title']);
        if (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
        }

        $data['user_id'] = auth()->id();

        Post::create($data);

        session()->flash('message', [
            'icon' => 'success',
            'title' => 'Publicación creada correctamente',
            'text' => 'Ya puedes ver tu publicación en la lista.',
        ]);

        return redirect()->route('posts.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['title']);
        if (Post::where('slug', $data['slug'])->where('id', '!=', $post->id)->exists()) {
            $data['slug'] .= '-' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
        }

        if ($data['is_published'] && !$post->is_published) {
            $data['published_at'] = now();
        }

        $post->update($data);

        session()->flash('message', [
            'icon' => 'success',
            'title' => 'Publicación actualizada correctamente',
            'text' => 'Los cambios se han guardado exitosamente.',
        ]);

        return redirect()->route('posts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        session()->flash('message', [
            'icon' => 'success',
            'title' => 'Publicación eliminada correctamente',
            'text' => 'La publicación ha sido eliminada de la lista.',
        ]);

        return redirect()->route('posts.index');
    }
}
