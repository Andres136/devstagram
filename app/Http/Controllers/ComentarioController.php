<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request,  user $user, Post $post)
    {
        
        // Validar
        $request->validate([
            'comentario' => 'required|max:255'
        ]);
        // Almacenar el comentario
        Comentario::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);
        //Imprimir un mensaje
        return back()->with('mensaje', 'Comentario agregado correctamente');

      
    }
}