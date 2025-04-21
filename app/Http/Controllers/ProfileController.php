<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use Auth;

class ProfileController extends Controller
{
    public function index()
{
    $profiles = Auth::user()->profiles; // ini return-nya Collection
    return view('profiles.index', compact('profiles'));
}


    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();

        Profile::create($data);

        return redirect()->route('profiles.index')->with('success', 'Profile created.');
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($request->all());

        return redirect()->route('profiles.index')->with('success', 'Profile updated.');
    }

    public function destroy($id)
    {
        Profile::destroy($id);
        return redirect()->route('profiles.index')->with('success', 'Profile berhasil dihapus.');
    }
    
}