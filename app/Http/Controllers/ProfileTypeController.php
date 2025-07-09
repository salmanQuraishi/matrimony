<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileType;

class ProfileTypeController extends Controller
{
    public function index()
    {
        $profiletypes = ProfileType::get();
        return view('profiletype.index',compact('profiletypes'));
    }

    public function create()
    {
        $profiletype = ProfileType::where('status','show')->get()->all();
        return view('profiletype.create',compact('profiletype'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:profile_types,name',
            'status' => 'required|string|in:show,hide'
        ]);
        
        ProfileType::create($validated);

        return redirect()->back()->with('success', 'Profile Type added successfully!');
    }

    public function edit($id)
    {
        $profiletype = ProfileType::findOrFail($id);
        return view('profiletype.edit', compact('profiletype'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:profile_types,name,' . $id . ',ptid',
            'status' => 'required|string|in:show,hide',
        ]);

        $profiletype = ProfileType::findOrFail($id);
        $profiletype->update($validated);

        return redirect()->route('profiletype.index')->with('success', 'Profile Type updated successfully!');
    }
    
}
