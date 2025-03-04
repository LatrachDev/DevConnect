<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-gray-800 text-gray-100 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</div>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search developers, posts, or #tags" 
                               class="bg-gray-700 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 transition-all duration-200 text-gray-300"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <!-- Navigation icons remain the same -->
                    <div class="relative">
                        <button id="profileButton" class="h-8 w-8 rounded-full overflow-hidden focus:outline-none">
                            <img src="{{ Storage::url(Auth::user()->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile" class="w-full h-full object-cover"/>
                        </button>
                        
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-lg py-1 z-50">
                            <a href="/my_profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Profile</a>
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Update Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!profileButton.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-20 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Profile Card -->
            <div class="space-y-6">
                <div class="bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-900 to-indigo-800"></div>
                        <img src="{{ Storage::url(Auth::user()->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile" 
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-gray-800 shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-100">{{ Auth::user()->name }}</h2>
                            <div class="flex space-x-2">
                                <a href="{{ Auth::user()->github_url ?? '#' }}" target="_blank" class="text-gray-400 hover:text-blue-400">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                                <a href="{{ Auth::user()->linkedin_url ?? '#' }}" target="_blank" class="text-gray-400 hover:text-blue-400">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                <a href="{{ Auth::user()->website_url ?? '#' }}" target="_blank" class="text-gray-400 hover:text-blue-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <span class="text-gray-400">Joined</span>
                        <span class="ml-2 text-gray-200 font-medium">{{ Auth::user()->created_at->format('M Y') }}</span>
                        <p class="text-gray-500 text-sm mt-2">{{ Auth::user()->bio }}</p>
                        
                        <div class="mt-4 flex flex-wrap gap-2">
                            @forelse(Auth::user()->skills()->get() as $skill)
                                <span class="px-2 py-1 bg-blue-900 text-blue-200 rounded-full text-xs">
                                    {{ $skill->skill_name }}
                                </span>
                            @empty
                                <p class="text-gray-400">No skills added yet.</p>
                            @endforelse
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Connections</span>
                                <span class="text-blue-400 font-medium">487</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-400">Posts</span>
                                <span class="text-blue-400 font-medium">{{ Auth::user()->posts()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="bg-gray-800 rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold text-gray-100 mb-4">Trending Tags</h3>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center justify-between hover:bg-gray-700 p-2 rounded-lg transition-colors">
                            <span class="text-gray-300">#javascript</span>
                            <span class="text-gray-500 text-sm">2.4k</span>
                        </a>
                        <!-- Add more tags -->
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Creation -->
                <div class="bg-gray-800 rounded-xl shadow-sm p-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ Storage::url(Auth::user()->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="User" class="w-12 h-12 rounded-full"/>
                        <a href="{{ route('posts.create') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-400 text-left rounded-lg px-4 py-3 flex-grow transition-colors duration-200">
                            Share your knowledge or ask a question...
                        </a>
                    </div>
                    <!-- Post buttons remain similar with updated colors -->
                </div>

                <!-- post -->
                @forelse($posts as $post) 

                <div class="bg-white rounded-xl shadow-sm mx-auto mb-4">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::url($post->user->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{ $post->user->name }}</h3>
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
                    <p class="text-gray-400">No posts added yet.</p>
                @endforelse
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Job Recommendations -->
                <div class="bg-gray-800 rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold text-gray-100 mb-4">Job Recommendations</h3>
                    <div class="space-y-4">
                        <div class="p-3 hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="flex items-start space-x-3">
                                <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                <div>
                                    <h4 class="font-medium text-gray-100">Senior Full Stack Developer</h4>
                                    <p class="text-gray-400 text-sm">TechStart Inc.</p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded-full text-xs">React</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suggested Connections -->
                <div class="bg-gray-800 rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold text-gray-100 mb-4">Suggested Connections</h3>
                    <div class="flex items-center justify-between hover:bg-gray-700 p-2 rounded-lg">
                        @livewire('user-list')
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>