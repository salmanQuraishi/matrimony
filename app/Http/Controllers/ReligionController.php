<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Religion;

class ReligionController extends Controller
{
    public function index()
    {
        $religions = Religion::get();
        return view('religion.index',compact('religions'));
    }

    public function create()
    {
        return view('religion.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:religions,name',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|in:show,hide'
        ]);

        Religion::create($validated);

        return redirect()->back()->with('success', 'Religion added successfully!');
    }

    public function edit($id)
    {
        $religion = Religion::findOrFail($id);
        return view('religion.edit', compact('religion'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:religions,name,' . $id . ',rid',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|in:show,hide'
        ]);

        $religion = Religion::findOrFail($id);
        $religion->update($validated);

        return redirect()->route('religion.index')->with('success', 'Religion updated successfully!');
    }
    
}
