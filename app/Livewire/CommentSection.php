<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Livewire\Component;
use SebastianBergmann\CodeUnit\FunctionUnit;

class CommentSection extends Component
{

    public $post;
    public $comments;
    public $content;

    protected $rules = [
        'content' => 'required|max:255',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->comments = $post->comments()->get();
    }
    
    public function addComment()
    {
        $this->validate();

        $comment = Comment::create([
            'comment' => $this->content,
            'post_id' => $this->post->id,
            'user_id' => auth()->id()
        ]);

        $post = Post::find($this->post->id);
        if ($post->user->id !== auth()->id())
        {
            $post->user->notify(new CommentNotification($comment));
        }

        // $post->user->notify(new CommentNotification($comment));

        

        $this->content = '';
        $this->comments = $this->post->comments()->latest()->get();
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
