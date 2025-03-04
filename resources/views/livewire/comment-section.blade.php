<div class="w-full">
    <!-- Comment Form -->
    <form class="w-full flex justify-between" wire:submit.prevent="addComment">
        <textarea wire:model="content" placeholder="Add a comment..." class="border rounded p-2 w-9/12"></textarea>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-32 rounded-md h-10">Post</button>
    </form>

    <!-- Display Comments -->
    <div class="mt-4">
        <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <p>{{ $post->comments()->count() }} comments</p>
        </button>
        @foreach($comments as $comment)
            <div class="border-b py-2">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
            </div>
        @endforeach
    </div>
</div>
