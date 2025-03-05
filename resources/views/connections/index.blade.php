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
                            <a href="/my_profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Profile</a>
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Update Profile</a>
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

        <h1 class="text-3xl font-bold text-white mt-8">Connections</h1>
        <div class="mt-6 bg-gray-800 p-6 rounded-lg shadow-md">
            <!-- Pending Connections -->
            <h2 class="text-xl font-semibold text-blue-400 mb-4">Pending Requests</h2>
            <!-- Loop through pending requests -->
            <div class="space-y-4">
                @foreach ($pendingRequests as $request)
                    <div class="flex justify-between items-center bg-gray-700 p-4 rounded-lg">
                        <div class="text-gray-300">{{ $request->sender->name }}</div>
                        <div class="space-x-2">
                            <form method="POST" action="{{ route('connections.accept', $request->id) }}">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('connections.reject', $request->id) }}">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Reject</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Accepted Connections -->
            <h2 class="text-xl font-semibold text-blue-400 mt-8 mb-4">Accepted Connections</h2>
            <!-- Loop through accepted connections -->
            <div class="space-y-4">
                @foreach ($acceptedConnections as $connection)
                    <div class="flex justify-between items-center bg-gray-700 p-4 rounded-lg">
                        <div class="text-gray-300">{{ $connection->receiver->name }}</div>
                        <form method="POST" action="{{ route('connections.remove', $connection->id) }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</body>
</html> 