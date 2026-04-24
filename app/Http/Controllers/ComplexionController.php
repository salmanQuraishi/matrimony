<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complexion;

class ComplexionController extends Controller
{
    public function index()
    {
        $complexions = Complexion::get();
        return view('complexion.index',compact('complexions'));
    }

    public function create()
    {
        return view('complexion.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:complexions,name',
            'hindi_name' => 'required|string|min:1|max:50|unique:complexions,hindi_name',
            'status' => 'required|string|in:show,hide'
        ]);

        Complexion::create($validated);

        return redirect()->back()->with('success', 'Complexion added successfully!');
    }

    public function edit($id)
    {
        $complexion = Complexion::findOrFail($id);
        return view('complexion.edit', compact('complexion'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:complexions,name,' . $id . ',cid',
            'hindi_name' => 'required|string|min:1|max:50|unique:complexions,hindi_name,' . $id . ',cid',
            'status' => 'required|string|in:show,hide'
        ]);

        $complexion = Complexion::findOrFail($id);
        $complexion->update($validated);

        return redirect()->route('complexion.index')->with('success', 'Complexion updated successfully!');
    }
    
}
