<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeButton extends Component
{
    public $post;
    public $isLiked;

    public function mount($post)
    {
        $this->post = $post;
        $this->isLiked = $this->post->isLikedBy(Auth::user());
    }

    public function toggleLike()
    {
        if ($this->isLiked) {
            $this->post->likes()->where('user_id', Auth::user()->id)->delete();
            $this->isLiked = false;
        } else {
            $this->post->likes()->create(['user_id' => Auth::user()->id]);
            $this->isLiked = true;
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}