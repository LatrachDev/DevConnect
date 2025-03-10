<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - DevConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-gray-800 text-gray-100 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <!-- Navigation icons -->
                    <div class="relative">
                        <button id="profileButton" class="h-8 w-8 rounded-full overflow-hidden focus:outline-none">
                            <img src="{{ Storage::url(Auth::user()->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile" class="w-full h-full object-cover"/>
                        </button>
                        
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-lg py-1 z-50">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Profile</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Update Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <!-- Profile Header -->
            <div class="relative h-48 bg-gradient-to-r from-blue-500 to-purple-600">
                <div class="absolute -bottom-16 left-8">
                    <div class="h-32 w-32 rounded-full border-4 border-gray-800 overflow-hidden">
                        <img src="{{ Storage::url($user->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="pt-20 px-8 pb-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                        <p class="text-gray-400 mt-1">{{ $user->title ?? 'Developer' }}</p>
                    </div>
                    
                    @if(auth()->id() !== $user->id)
                        @if($connection)
                            @if($connection->status === 'pending')
                                @if($connection->receiver_id === auth()->id())
                                    <div class="flex space-x-2">
                                        <form method="POST" action="{{ route('connections.accept', $connection->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                                                Accept Request
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('connections.reject', $connection->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                                                Decline
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <button disabled class="bg-gray-600 text-gray-300 px-4 py-2 rounded-lg text-sm cursor-not-allowed">
                                        Request Pending
                                    </button>
                                @endif
                            @elseif($connection->status === 'accepted')
                                <form method="POST" action="{{ route('connections.remove', $connection->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                                        Remove Connection
                                    </button>
                                </form>
                            @endif
                        @else
                            <form method="POST" action="{{ route('connections.request', $user->id) }}">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                                    Connect
                                </button>
                            </form>
                        @endif
                    @endif
                </div>

                @if($user->bio)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-blue-400 mb-2">About</h2>
                        <p class="text-gray-300">{{ $user->bio }}</p>
                    </div>
                @endif

                
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-blue-400 mb-4">Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills as $skill)
                                <span class="px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-sm">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
             

                <div class="grid grid-cols-3 gap-4 mb-8">
                    @if($user->github_url)
                        <a href="{{ $user->github_url }}" target="_blank" class="flex items-center space-x-2 text-gray-300 hover:text-blue-400 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                            </svg>
                            <span>GitHub</span>
                        </a>
                    @endif

                    @if($user->linkedin_url)
                        <a href="{{ $user->linkedin_url }}" target="_blank" class="flex items-center space-x-2 text-gray-300 hover:text-blue-400 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <span>LinkedIn</span>
                        </a>
                    @endif

                    @if($user->website_url)
                        <a href="{{ $user->website_url }}" target="_blank" class="flex items-center space-x-2 text-gray-300 hover:text-blue-400 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <span>Website</span>
                        </a>
                    @endif
                </div>

                <!-- Posts Section -->
                @if($posts->count() > 0)
                    <div>
                        <h2 class="text-xl font-semibold text-blue-400 mb-4">Recent Posts</h2>
                        <div class="space-y-4">
                            @foreach($posts as $post)

                                

                                
<!--  -->
                <div class="bg-white rounded-xl shadow-sm mx-auto mb-4 w-5/12">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::url($post->user->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                    <p class="text-gray-500 text-sm font-bold">{{ $post->title }}</p>
                                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
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

<!--  -->
                                   
                            
                            @endforeach
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <script>
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (profileButton && profileDropdown) {
            profileButton.addEventListener('click', () => {
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
