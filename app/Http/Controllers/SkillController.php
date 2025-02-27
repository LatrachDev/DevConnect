<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $skills = $user ? $user->skills : [];
        return view('profile.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'skill_name' => ['required', 'string'],
        ]);

        $skill = Skill::create([
            'skill_name' => $request->skill_name,
            'user_id' => auth()->id(),
        ]);

        if (!$skill) 
        {
            return redirect()->route('/profile')->with('error', 'Skill not created');
        }
        return redirect()->route('profile.update')->with('success', 'Skill created successfully');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->back()->with('status', 'Skill deleted successfully!');
    }
}
