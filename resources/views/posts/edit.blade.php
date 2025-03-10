<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - DevConnect</title>
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
                            <img src="https://avatar.iran.liara.run/public/boy" alt="Profile" class="w-full h-full object-cover"/>
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

    <!-- Edit Post Form -->
    <div class="max-w-7xl mx-auto px-4 py-16 mt-10">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-100 mb-6">Edit Post</h2>
            <form action="{{ route('posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-gray-300 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ $post->title }}" class="bg-gray-700 text-gray-300 rounded-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 transition-all duration-200">
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-300 mb-2">Content</label>
                    <textarea name="content" id="content" rows="10" class="bg-gray-700 text-gray-300 rounded-lg w-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-600 transition-all duration-200">{{ $post->content }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-gray-100 px-4 py-2 rounded-lg hover:bg-blue-600 transition-all duration-200">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>