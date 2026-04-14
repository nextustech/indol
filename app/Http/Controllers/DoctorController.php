<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Branch;


class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('branch')->latest()->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('doctors.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'branch_id' => 'required'
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor added');
    }
}
