<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnualIncome;

class AnnualIncomeController extends Controller
{
    public function index()
    {
        $annualincomes = AnnualIncome::get();
        return view('annualincome.index',compact('annualincomes'));
    }

    public function create()
    {
        $annualincome = AnnualIncome::where('status','show')->get()->all();
        return view('annualincome.create',compact('annualincome'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'range' => 'required|string|min:1|max:50|unique:annual_incomes,range',
            'status' => 'required|string|in:show,hide'
        ]);
        
        AnnualIncome::create($validated);

        return redirect()->back()->with('success', 'annual income added successfully!');
    }

    public function edit($id)
    {
        $annualincome = AnnualIncome::findOrFail($id);
        return view('annualincome.edit', compact('annualincome'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'range' => 'required|string|min:1|max:50|unique:annual_incomes,range,' . $id . ',aid',
            'status' => 'required|string|in:show,hide',
        ]);

        $annualincome = AnnualIncome::findOrFail($id);
        $annualincome->update($validated);

        return redirect()->route('annualincome.index')->with('success', 'annual income updated successfully!');
    }
}
