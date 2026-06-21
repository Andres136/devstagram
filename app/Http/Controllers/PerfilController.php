<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)

    {
     //Modificar el request
    $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->id(), 'min:3', 'max:20',
            'not_in:editar-perfil'],
        
        ]);

        if($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            $imagenServidor = Image::decode($imagen)->cover(1000, 1000);
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }
        
        //Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //Redireccionar
        return redirect()->route('perfil.index', $usuario->username);
    }
}