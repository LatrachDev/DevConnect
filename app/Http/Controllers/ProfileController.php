<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Connection;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'sometimes',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);

        Auth::user();
        $imagePath = null;
        if ($request->hasFile('profile_image'))
        {
            $imagePath = $request->file('profile_image')->store('public/storage/image');
            $validated['profile_image'] = $imagePath;
        }
        $user = $request->user();
        $user->update($validated);

        return Redirect::to('/profile')->with('success', 'Profile updated successfully');
        
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function index()
    {
        return view('profile.index');
    }

    /**
     * Display a user's public profile.
     */
    public function view(User $user): View
    {
        // Get connection status with the authenticated user
        $connection = null;
        if (auth()->check()) {
            $connection = Connection::where(function($query) use ($user) {
                    $query->where(function($q) use ($user) {
                        $q->where('sender_id', auth()->id())
                          ->where('receiver_id', $user->id);
                    })->orWhere(function($q) use ($user) {
                        $q->where('sender_id', $user->id)
                          ->where('receiver_id', auth()->id());
                    });
                })
                ->first();
        }

        return view('profile.view', [
            'user' => $user,
            'connection' => $connection,
            'posts' => $user->posts()->with('user')->latest()->get(),
            'skills' => $user->skills
        ]);
    }
}
