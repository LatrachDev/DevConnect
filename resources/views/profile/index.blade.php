<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Header Card -->
            <div class="bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="relative">
                    <div class="h-32 bg-gradient-to-r from-blue-900 to-indigo-800"></div>
                    <img src="{{ Storage::url(Auth::user()->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile" 
                         class="absolute -bottom-6 left-6 w-24 h-24 rounded-full border-4 border-gray-800 shadow-md object-cover"/>
                </div>
                <div class="pt-16 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                    </div>

                    <div class="mt-4">
                        <p class="text-gray-300" id="userBio">{{ Auth::user()->bio ?? 'Add a bio to tell others about yourself...' }}</p>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-gray-300" id="userBio" x-data="{ editing: false, content: '{{ Auth::user()->bio ?? 'Add a bio to tell others about yourself...' }}' }" x-cloak>
                            <span x-show="!editing" @click="editing = true" class="cursor-pointer">{{ Auth::user()->bio ?? 'Add a bio to tell others about yourself...' }}</span>
                            <textarea x-show="editing" 
                                     x-model="content" 
                                     @blur="editing = false; 
                                            fetch('{{ route('profile.update') }}', {
                                                method: 'PATCH',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ bio: content })
                                            })"
                                     class="w-full bg-gray-700 text-gray-200 rounded p-2"
                                     rows="3"></textarea>
                        </p>
                    </div>
                    
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ Auth::user()->github_url ?? '#' }}" 
                           @click.prevent="$refs.githubInput.showModal()"
                           class="flex items-center text-gray-300 hover:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>GitHub</span>
                        </a>
                        <a href="{{ Auth::user()->linkedin_url ?? '#' }}"
                           @click.prevent="$refs.linkedinInput.showModal()"
                           class="flex items-center text-gray-300 hover:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                            <span>LinkedIn</span>
                        </a>
                        <a href="{{ Auth::user()->website_url ?? '#' }}"
                           @click.prevent="$refs.websiteInput.showModal()"
                           class="flex items-center text-gray-300 hover:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Website</span>
                        </a>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-700">
                        <div class="flex space-x-8 text-sm">
                            <div>
                                <span class="text-gray-400">Joined</span>
                                <span class="ml-2 text-gray-200 font-medium">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Email</span>
                                <span class="ml-2 text-gray-200 font-medium">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
       

                <!-- Skills & Expertise (New Section) -->
                <div class="bg-gray-800 rounded-xl shadow-sm">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-100">Skills & Expertise</h3>
                        
                        <div class="mt-6">
                            <div class="flex flex-wrap gap-2 mb-4">
                                @forelse(Auth::user()->skills()->get() as $skill)
                                    <span class="px-3 py-1 bg-blue-900 text-blue-200 rounded-full text-sm flex items-center">
                                        {{ $skill->skill_name }}
                                    </span>
                                @empty
                                    <p class="text-gray-400">No skills added yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <!-- post -->
                @forelse(Auth::user()->posts()->get() as $post) 

                <div class="bg-white rounded-xl shadow-sm w-6/12 mx-auto mb-4">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::url(Auth::user()->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{ Auth::user()->name }}</h3>
                                    <p class="text-gray-500 text-sm font-bold">{{ $post->title }}</p>
                                    <p class="text-gray-500 text-sm">{{ $post->created_at }}</p>
                                </div>
                            </div>
                            <!-- Options Button -->
                            <div class="relative">
                                <button id="optionsButton-{{ $post->id }}" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </button>
                                <!-- Dropdown Menu -->
                                <div id="optionsDropdown-{{ $post->id }}" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Edit Post</a>
                                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2 text-red-600 hover:bg-red-100">Delete Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-700">{{ $post->content }}</p>
                            
                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">
                                <img src="{{ Storage::url($post->image) }}" alt="">
                            </div>

                            <div class="w-full mt-4 flex items-center justify-between border-t pt-4">
                                <div class=" w-full flex space-x-4">
                                    
                                    @livewire('like-button', ['post' => $post])
                                    
                                    @livewire('comment-section', ['post' => $post])
                                    <button class="text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Add event listeners for each post's options button and dropdown
                    document.getElementById("optionsButton-{{ $post->id }}").addEventListener("click", function(event) {
                        event.stopPropagation(); // Prevent the click from bubbling up
                        const dropdown = document.getElementById("optionsDropdown-{{ $post->id }}");
                        dropdown.classList.toggle("hidden");
                    });

                    // Close dropdown when clicking outside
                    window.addEventListener("click", function() {
                        const dropdown = document.getElementById("optionsDropdown-{{ $post->id }}");
                        if (!dropdown.classList.contains("hidden")) {
                            dropdown.classList.add("hidden");
                        }
                    });
                </script>

                @empty
                    <p class="text-gray-400 text-center">No posts added yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modals for editing links -->
    <dialog x-ref="githubInput" class="bg-gray-800 rounded-lg p-6 text-white">
        <form method="dialog" @submit.prevent="
            fetch('{{ route('profile.update') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ github: $event.target.url.value })
            }).then(() => window.location.reload())">
            <h3 class="text-lg font-semibold mb-4">Update GitHub URL</h3>
            <input type="url" name="url" value="{{ Auth::user()->github }}" 
                   class="w-full bg-gray-700 text-white rounded p-2 mb-4">
            <div class="flex justify-end gap-2">
                <button type="button" @click="$refs.githubInput.close()" 
                        class="px-4 py-2 bg-gray-700 rounded">Cancel</button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 rounded">Save</button>
            </div>
        </form>
    </dialog>

    <!-- Similar modals for LinkedIn and Website -->
</x-app-layout>