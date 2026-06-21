<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(User $user)
    {
        return view('dashboard', [
            'user' => $user,
            'posts' => $user->posts()->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('posts.index', $user->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'user' => $user,
            'post' => $post,
        ]);
    }

    public function destroy(Post $post)
{
    $this->authorize('delete', $post);

    $post->comentarios()->delete();
    $post->delete();

    /** @var \App\Models\User $user */
    $user = Auth::user();

    //Eliminar la imagen
    $imagen_path = public_path('uploads') . '/' . $post->imagen;
    if (file_exists($imagen_path)) {
        unlink($imagen_path);
        
    }

    return redirect()->route('posts.index', $user->username);
}
}
