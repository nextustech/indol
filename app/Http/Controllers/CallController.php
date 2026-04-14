<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Patient;
use Illuminate\Http\Request;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calls = Call::latest()->paginate(30);
        return view('calls.index', compact('calls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patient = Patient::find($id);
        return view('calls.create',compact('patient'));
    }
  
    public function getPatientCalls($id)
    {
        $patient = Patient::find($id);
        return view('calls.show',compact('patient'));
    }
      /**
     * Show the form for creating a new resource.
     */
    public function getCreateCall($id)
    {
        $patient = Patient::find($id);
        return view('calls.create',compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required',
            'mobile' => 'required|string|max:20',
            'call_at' => 'nullable|date',
            'response' => 'nullable|string|max:100',
            'detail' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        Call::create($validated);

        return redirect()->back()->with('success', 'Patient call record saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Call $call)
    {
        return view('calls.show', compact('call'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Call $call)
    {
        return view('calls.edit', compact('call'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Call $call)
    {
        $validated = $request->validate([
            'patient_id' => 'required',
            'mobile' => 'required|string|max:20',
            'call_at' => 'nullable|date',
            'response' => 'nullable|string|max:100',
            'detail' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        Call::update($validated);

        return redirect()->back()->with('success', 'Patient call record saved.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Call $call)
    {
        Call::destroy($call->id);
        return redirect()->back()->with('success','Deleted Successfully');

    }
}
