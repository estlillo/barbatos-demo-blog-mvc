<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\RepositoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected RepositoryService $repository;

    public function __construct(RepositoryService $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Post::with(['category', 'user'])->orderBy('posts.published_at', 'desc');

        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        $posts = $query->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));

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
            'tags' => 'array|nullable',
            'is_published' => 'boolean',
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $fileName = Str::uuid() . '.' . $image->extension();

            if (!$this->repository->uploadContent($fileName, file_get_contents($image->getRealPath()))) {
                return response()->json(['error' => 'Error saving file'], 500);
            }

            $data['image_path'] = $fileName;
        }

        $data['published_at'] = $data['is_published'] ? now() : null;
        $data['slug'] = Post::where('slug', $slug = Str::slug($data['title']))->exists()
            ? $slug . '-' . substr(md5(uniqid()), 0, 8)
            : $slug;
        $data['user_id'] = auth()->id();

        $post = Post::create($data);

        $tags = collect($request->tags ?? [])
            ->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]))
            ->all();

        $post->tags()->sync($tags);

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
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));

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
            'tags' => 'array',
            'is_published' => 'boolean',
            'image_path' => 'nullable|image|max:2048',
        ]);


        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $fileName = Str::uuid() . '.' . $image->extension();

            if (!$this->repository->uploadContent($fileName, file_get_contents($image->getRealPath()))) {
                return response()->json(['error' => 'Error saving file'], 500);
            }

            $data['image_path'] = $fileName;
        }

        $data['image_path'] = $data['image_path'] ?? $post->image_path;



        $data['slug'] = Post::where('slug', $slug = Str::slug($data['title']))
            ->where('id', '!=', $post->id)
            ->exists() ? $slug . '-' . substr(md5(uniqid()), 0, 8) : $slug;

        $data['published_at'] = $data['is_published'] && !$post->is_published ? now() : $post->published_at;

        $post->update($data);

        $tags = collect($request->tags ?? [])
            ->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]))
            ->all();

        $post->tags()->sync($tags);

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
