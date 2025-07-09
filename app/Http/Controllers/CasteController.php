<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caste;
use App\Models\Religion;

class CasteController extends Controller
{
    public function index()
    {
        $castes = Caste::with('religion')->get();
        return view('caste.index',compact('castes'));
    }

    public function create()
    {
        $religions = Religion::where('status','show')->get()->all();
        return view('caste.create',compact('religions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'religion_id' => 'required',
            'name' => 'required|string|min:1|max:50|unique:castes,name',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|in:show,hide'
        ]);
        
        Caste::create($validated);

        return redirect()->back()->with('success', 'Caste added successfully!');
    }

    public function edit($id)
    {
        $religions = Religion::get()->all();
        $caste = Caste::findOrFail($id);
        return view('caste.edit', compact('caste','religions'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'religion_id' => 'required',
            'name' => 'required|string|min:1|max:50|unique:castes,name,' . $id . ',cid',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|in:show,hide',
        ]);

        $caste = Caste::findOrFail($id);
        $caste->update($validated);

        return redirect()->route('caste.index')->with('success', 'Caste updated successfully!');
    }
    
}
