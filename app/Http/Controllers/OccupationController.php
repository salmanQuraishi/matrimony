<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Occupation;

class OccupationController extends Controller
{
    public function index()
    {
        $occupations = Occupation::get();
        return view('occupation.index',compact('occupations'));
    }

    public function create()
    {
        $occupation = Occupation::where('status','show')->get()->all();
        return view('occupation.create',compact('occupation'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:occupations,name',
            'status' => 'required|string|in:show,hide'
        ]);
        
        Occupation::create($validated);

        return redirect()->back()->with('success', 'occupation added successfully!');
    }

    public function edit($id)
    {
        $occupation = Occupation::findOrFail($id);
        return view('occupation.edit', compact('occupation'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:occupations,name,' . $id . ',oid',
            'status' => 'required|string|in:show,hide',
        ]);

        $occupation = Occupation::findOrFail($id);
        $occupation->update($validated);

        return redirect()->route('occupation.index')->with('success', 'occupation updated successfully!');
    }
}
