<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Connections</title>
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
                               class="bg-gray-700 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 transition-all duration-200 text-gray-300">
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
    <div class="pt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

        <h1 class="text-3xl font-bold text-white mt-8 mb-6">Your Network</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2">
                <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-blue-400 mb-4">Suggested Connections</h2>
                    <!-- Suggested Connections -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        @foreach ($users as $user)
                            @if ($user->id !== auth()->id() && !$user->isConnectedWith(auth()->user()))
                                <div class="bg-gray-700 p-4 rounded-lg flex items-center space-x-4">
                                    <img src="{{ Storage::url($user->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-12 h-12 rounded-full object-cover">
                                    <div class="flex-1">
                                        <h3 class="text-gray-200 font-medium">{{ $user->name }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $user->title ?? 'Developer' }}</p>
                                    </div>
                                    @php
                                        $pendingConnection = $pendingRequests->where('sender_id', $user->id)->first();
                                    @endphp
                                    @if ($pendingConnection)
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('connections.accept', $pendingConnection->id) }}" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200">Accept</button>
                                            </form>
                                            <form method="POST" action="{{ route('connections.reject', $pendingConnection->id) }}" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-500 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200">Decline</button>
                                            </form>
                                        </div>
                                    @elseif ($user->hasPendingConnectionWith(auth()->user()))
                                        <button disabled class="bg-gray-600 text-gray-300 px-4 py-2 rounded-lg text-sm cursor-not-allowed">
                                            Pending
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('connections.request', $user->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                                                Connect
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pending Requests Section -->
            <div class="space-y-6">
                <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-blue-400 mb-4">Pending Requests</h2>
                    <div class="space-y-4">
                        @forelse ($pendingRequests as $request)
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center space-x-4 mb-3">
                                    <img src="{{ Storage::url($request->sender->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" 
                                         alt="{{ $request->sender->name }}" 
                                         class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="text-gray-200 font-medium">{{ $request->sender->name }}</div>
                                        <div class="text-gray-400 text-sm">{{ $request->sender->title ?? 'Developer' }}</div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('connections.accept', $request->id) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('connections.reject', $request->id) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-gray-600 hover:bg-gray-500 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200">Decline</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">No pending requests</p>
                        @endforelse
                    </div>
                </div>

                <!-- Your Friends Section -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-blue-400 mb-4">Your Friends</h2>
                    <div class="space-y-4">
                        @forelse ($acceptedConnections as $user)
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ Storage::url($user->profile_image) ?? 'https://avatar.iran.liara.run/public/boy' }}" 
                                             alt="{{ $user->name }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <div class="text-gray-200 font-medium">{{ $user->name }}</div>
                                            <div class="text-gray-400 text-sm">{{ $user->title ?? 'Developer' }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('profile.view', $user->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                            View Profile
                                        </a>
                                        <form method="POST" action="{{ route('connections.remove', auth()->user()->getConnectionWith($user)->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-center py-4">No connections yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle profile dropdown
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (profileButton && profileDropdown) {
            profileButton.addEventListener('click', () => {
                profileDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>