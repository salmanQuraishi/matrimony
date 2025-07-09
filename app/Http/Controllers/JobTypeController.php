<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobType;

class JobTypeController extends Controller
{
    public function index()
    {
        $jobtypes = JobType::get();
        return view('jobtype.index',compact('jobtypes'));
    }

    public function create()
    {
        $jobtype = JobType::where('status','show')->get()->all();
        return view('jobtype.create',compact('jobtype'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:job_types,name',
            'status' => 'required|string|in:show,hide'
        ]);
        
        JobType::create($validated);

        return redirect()->back()->with('success', 'jobtype added successfully!');
    }

    public function edit($id)
    {
        $jobtype = JobType::findOrFail($id);
        return view('jobtype.edit', compact('jobtype'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:job_types,name,' . $id . ',jtid',
            'status' => 'required|string|in:show,hide',
        ]);

        $jobtype = JobType::findOrFail($id);
        $jobtype->update($validated);

        return redirect()->route('jobtype.index')->with('success', 'jobtype updated successfully!');
    }
    
}
