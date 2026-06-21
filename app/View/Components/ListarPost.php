<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListarPost extends Component
{
    public $posts;

    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    public function render()
    {
        return view('components.listar-post');
    }
}
