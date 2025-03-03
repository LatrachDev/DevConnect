<div>
    <!-- Comment Form -->
    <form wire:submit.prevent="addComment">
        <textarea wire:model="content" placeholder="Add a comment..." class="border rounded p-2"></textarea>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Post</button>
    </form>

    <!-- Display Comments -->
    <div class="mt-4">
        @foreach($comments as $comment)
            <div class="border-b py-2">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
            </div>
        @endforeach
    </div>
</div>
