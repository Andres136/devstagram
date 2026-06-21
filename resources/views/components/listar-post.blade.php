<div>
     @if($posts->count())
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($posts as $post)
                <div class="overflow-hidden rounded-lg">
                    <a href="{{ route ('posts.show', ['post' => $post, 'user' =>$post->user]) }}">
                        <img 
                            class="w-full h-64 object-cover"
                            src="{{ asset('uploads/' . $post->imagen) }}"
                            alt="Imagen del post {{ $post->titulo }}"
                        >
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-center">No hay Posts, Sigue a alguien para ver sus publicaciones</p>
    @endif
</div>