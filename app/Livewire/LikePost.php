<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isliked;
    public $likes;

    public function mount($post)
    {
        $this->post = $post;
        $this->isliked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }
    
    public function like()
    {
       if($this->post->checkLike(auth()->user())) {
           auth()->user()->likes()->where("post_id", $this->post->id)->delete();
           $this->isliked = false;
           $this->likes--;
        
       }else{
        $this->post->likes()->create([
        "user_id"=> auth()->user()->id,
  ]);
       $this->isliked = true;
       $this->likes++;
       }

       $this->post = $this->post->fresh('likes');
       $this->isliked = $this->post->checkLike(auth()->user());
       $this->likes = $this->post->likes->count();
    }
    public function render()
    {
        return view('livewire.like-post');
    }
}
