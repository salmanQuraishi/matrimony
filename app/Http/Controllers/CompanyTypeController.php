<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyType;

class CompanyTypeController extends Controller
{
    public function index()
    {
        $companytypes = CompanyType::get();
        return view('companytype.index',compact('companytypes'));
    }

    public function create()
    {
        $companytype = CompanyType::where('status','show')->get()->all();
        return view('companytype.create',compact('companytype'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:company_types,name',
            'status' => 'required|string|in:show,hide'
        ]);
        
        CompanyType::create($validated);

        return redirect()->back()->with('success', 'company type added successfully!');
    }

    public function edit($id)
    {
        $companytype = CompanyType::findOrFail($id);
        return view('companytype.edit', compact('companytype'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:50|unique:company_types,name,' . $id . ',ctid',
            'status' => 'required|string|in:show,hide',
        ]);

        $companytype = CompanyType::findOrFail($id);
        $companytype->update($validated);

        return redirect()->route('companytype.index')->with('success', 'company type updated successfully!');
    }
    
}
