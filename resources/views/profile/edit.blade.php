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
                    <img src="{{ Auth::user()->profile_photo_url ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile" 
                         class="absolute -bottom-6 left-6 w-24 h-24 rounded-full border-4 border-gray-800 shadow-md object-cover"/>
                </div>
                <div class="pt-16 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                        <div class="flex space-x-3">
                            <a href="#" id="editProfileBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-gray-300" id="userBio">{{ Auth::user()->bio ?? 'Add a bio to tell others about yourself...' }}</p>
                    </div>
                    
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ Auth::user()->github_url ?? '#' }}" class="flex items-center text-gray-300 hover:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>GitHub</span>
                        </a>
                        <a href="{{ Auth::user()->linkedin_url ?? '#' }}" class="flex items-center text-gray-300 hover:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                            <span>LinkedIn</span>
                        </a>
                        <a href="{{ Auth::user()->website_url ?? '#' }}" class="flex items-center text-gray-300 hover:text-blue-400 transition-colors">
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Update Profile Information -->
                <div class="md:col-span-2 bg-gray-800 rounded-xl shadow-sm">
                    <div class="p-6">

                        <div class="mt-6">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Skills & Expertise (New Section) -->
                <div class="bg-gray-800 rounded-xl shadow-sm">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-100">Skills & Expertise</h3>
                        <p class="text-sm text-gray-400 mt-1">Add your technical skills to highlight your expertise.</p>
                        
                        <div class="mt-6">
                            <!-- Input for adding new skills -->
                            <div class="flex items-center gap-2 mb-4">
                                <input 
                                    type="text" 
                                    id="skillInput" 
                                    placeholder="Add a skill" 
                                    class="px-3 py-1 bg-gray-700 text-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                                <button 
                                    id="addSkillButton" 
                                    class="px-3 py-1 bg-gray-700 text-gray-200 rounded-full text-sm flex items-center hover:bg-gray-600 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Skill
                                </button>
                            </div>

                            <!-- Display added skills -->
                            <div id="skillsContainer" class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-blue-900 text-blue-200 rounded-full text-sm flex items-center">
                                    JavaScript
                                    <button class="ml-1 hover:text-blue-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </span>
                                <span class="px-3 py-1 bg-green-900 text-green-200 rounded-full text-sm flex items-center">
                                    Laravel
                                    <button class="ml-1 hover:text-green-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>



            <!-- Password Update -->
            <div class="bg-gray-800 rounded-xl shadow-sm">
                <div class="p-6">
                    <div class="mt-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-gray-800 rounded-xl shadow-sm">
                <div class="p-6">
                    <div class="mt-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-100">Edit Profile</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="bio" class="block text-sm font-medium text-gray-300 mb-1">Bio</label>
                        <textarea id="bio" name="bio" rows="4" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ Auth::user()->bio }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="github_url" class="block text-sm font-medium text-gray-300 mb-1">GitHub URL</label>
                        <input type="url" id="github_url" name="github_url" value="{{ Auth::user()->github_url }}" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    
                    <div class="mb-4">
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-300 mb-1">LinkedIn URL</label>
                        <input type="url" id="linkedin_url" name="linkedin_url" value="{{ Auth::user()->linkedin_url }}" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    
                    <div class="mb-6">
                        <label for="website_url" class="block text-sm font-medium text-gray-300 mb-1">Personal Website</label>
                        <input type="url" id="website_url" name="website_url" value="{{ Auth::user()->website_url }}" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" id="cancelBtn" class="px-4 py-2 border border-gray-600 rounded-lg text-gray-300 mr-2 hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editProfileModal');
            const editBtn = document.getElementById('editProfileBtn');
            const closeBtn = document.getElementById('closeModal');
            const cancelBtn = document.getElementById('cancelBtn');
            
            editBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });
            
            closeBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            
            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>