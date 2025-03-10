<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::latest()->paginate(10);
        // dd($posts);

        $posts = Post::all();

        return view('dashboard', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            // 'media_url' => 'nullable|url'
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) 
        {
            $validated['image'] = $request->file('image')->store('public/storage/image');
        }
        
        $validated['user_id'] = auth()->id();
        Post::create($validated);
        return redirect()->route('dashboard')->with('success', 'Post created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $postCount = Post::count();
        return view('profile.index', compact('post', 'postCount'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image'
        ]);
        
        $post->update($validated);
        return redirect()->route('dashboard')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully');
    }
}
