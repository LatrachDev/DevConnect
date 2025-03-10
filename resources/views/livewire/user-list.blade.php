<div>
    @foreach($users as $user)
    <div class="flex items-center space-x-3 mb-4">
        <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : 'https://avatar.iran.liara.run/public/boy' }}" alt="User" class="w-10 h-10 rounded-full">
        <div class="mx-auto">
            <h4 class="font-medium text-gray-100">{{ $user->name }}</h4>
            <p class="text-gray-400 text-sm">suggested for you</p>
        </div>
        @if(auth()->user()->hasPendingConnectionWith($user))
            <button disabled class="bg-gray-600 text-gray-300 rounded-md p-1 cursor-not-allowed">Pending</button>
        @else
            <form action="{{ route('connections.request', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 mx-auto text-white rounded-md p-1">Connect</button>
            </form>
        @endif
    </div>
    @endforeach
</div>
