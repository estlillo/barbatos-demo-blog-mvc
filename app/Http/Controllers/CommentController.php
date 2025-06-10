<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
        ]);

        session()->flash('message', [
            'icon' => 'success',
            'title' => 'Comentario agregado',
            'text' => 'Tu comentario ha sido agregado correctamente.',
        ]);

        return redirect()->back();
    }
}
