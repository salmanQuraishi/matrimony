<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::get();
        return view('education.index',compact('educations'));
    }

    public function create()
    {
        $education = Education::where('status','show')->get()->all();
        return view('education.create',compact('education'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:educations,name',
            'status' => 'required|string|in:show,hide'
        ]);
        
        Education::create($validated);

        return redirect()->back()->with('success', 'Education added successfully!');
    }

    public function edit($id)
    {
        $education = Education::findOrFail($id);
        return view('education.edit', compact('education'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:educations,name,' . $id . ',eid',
            'status' => 'required|string|in:show,hide',
        ]);

        $education = Education::where('eid', $id)->firstOrFail();

        $education->update($validated);

        return redirect()->route('education.index')->with('success', 'Education updated successfully!');
    }
    
}
