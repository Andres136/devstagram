<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240',
        ]);

        $imagen = $request->file('file');
        $nombreImagen = Str::uuid() . '.' . $imagen->getClientOriginalExtension();

        $imagenProcesada = Image::decode($imagen)
            ->resize(1000, 1000);

        $ruta = public_path('uploads/' . $nombreImagen);
        $imagenProcesada->save($ruta);

        return response()->json([
            'imagen' => $nombreImagen
        ]);
    }
}