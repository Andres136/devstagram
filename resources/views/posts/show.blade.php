@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')

<div class="container mx-auto md:flex">

    <div class="md:w-1/2">
        <img 
            class="rounded-lg w-full"
            src="{{ asset('uploads/' . $post->imagen) }}"
            alt="Imagen del post {{ $post->titulo }}"
        >

        <div class="p-3 flex items-center gap-4">

           
            @auth
            <livewire:like-post :post="$post" />

    
    @endauth
    </div>

        <div>
            <p class="font-bold">{{ $post->user->username }}</p>
            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}
                <span class="font-normal">Like</span>
            </p>

            <p class="mt-5">
                {{ $post->descripcion }}
            </p>
        </div>
        @auth
        @if(auth()->user()->id === $post->user_id)
        <form  method="POST" action="{{ route('posts.destroy', $post) }}" >
            @method('DELETE')
            @csrf
                <input 
                    type="submit"
                    value="Eliminar Publicación"
                    class="bg-red-600 hover:bg-red-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg mt-5"
                >
        </form>
        @endif

        @endauth
    </div>

    <div class="md:w-1/2 p-5">
        <div class="shadow bg-white p-5">

            @auth
                <p class="text-xl font-bold text-center mb-4">
                    Agrega un Nuevo Comentario
                </p>

                @if(session('mensaje'))
                    <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{ session('mensaje') }}
                    </div>
                @endif

                <form action="{{ route('comentarios.store', ['user' => $post->user->username, 'post' => $post->id]) }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                            Añade un comentario
                        </label>

                        <textarea
                            id="comentario"
                            name="comentario"
                            rows="3"
                            placeholder="Agrega un comentario"
                            class="border p-2 text-sm w-full rounded-lg @error('comentario') border-red-500 @enderror"
                        >{{ old('comentario') }}</textarea>

                        @error('comentario')
                            <p class="bg-red-500 hover:bg-red-600 p-2 rounded-lg  text-white text-center  font-bold mt-4 cursor-pointer">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <input 
                        type="submit"
                        value="Comentar"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                    >
                </form>
            @endauth

            <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                @if ($post->comentarios->count())
                    @foreach ($post->comentarios as $comentario)
                    
                        <div class="p-5 border-b border-gray-300">
                            <a href="{{ route('posts.index', $comentario->user->username) }}">
                               <p>{{ ($comentario->user)->username  }}</p>
                            </a>
                            <p>{{ $comentario->comentario }}</p>
                            <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="p-10 text-center">No hay comentarios aún</p>
                @endif
            </div>

        </div>
    </div>

</div>

@endsection
