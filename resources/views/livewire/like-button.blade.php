<div>
    <button wire:click="toggleLike" 
        class="flex items-center space-x-2 
               {{ $isLiked ? 'text-blue-500' : 'text-gray-500' }}">
        <svg class="w-5 h-5" 
            fill="{{ $isLiked ? '#3B82F6' : 'none' }}" 
            stroke="{{ $isLiked ? '#3B82F6' : '#6B7280' }}" 
            stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" 
                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
        </svg>
        <span>{{ $post->likes->count() }}</span>
    </button>
</div>
