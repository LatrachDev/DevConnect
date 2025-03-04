<div class="w-full" x-data="{ showComments: false }">

    <button 
        @click="showComments = !showComments" 
        class="flex items-center mb-5 space-x-2 text-gray-500 hover:text-blue-500 transition-colors duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>
        <p>{{ $post->comments()->count() }} comments</p>
    </button>

    <div x-show="showComments" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <form class="w-full flex justify-between mb-4" wire:submit.prevent="addComment">
            <textarea 
                wire:model="content" 
                placeholder="Add a comment..." 
                class="border rounded-lg p-2 w-9/12 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500">
            </textarea>
            <button 
                type="submit" 
                class="bg-blue-500 ml-2 text-white px-4 py-2 w-32 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Post
            </button>
        </form>

        <div class="mt-4 space-y-4">
            @foreach($comments as $comment)
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center space-x-2">
                        <img
                            class="w-10 h-10 rounded-full"
                            src="{{ Storage::url($comment->user->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="">
                        <strong class="text-gray-800">{{ $comment->user->name }}</strong>
                        <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700 mt-1">{{ $comment->comment }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>