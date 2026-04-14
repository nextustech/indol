<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Branch;
use App\Models\Doctor;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with(['branch','doctor','days'])->get();
        return view('slots.index', compact('slots'));
    }

    public function create()
    {
        $branches = Branch::all();
        $doctors = Doctor::all();
        return view('slots.create', compact('branches','doctors'));
    }

    public function store(Request $request)
    {
        $slot = Slot::create($request->all());

        foreach ($request->days as $day) {
            $slot->days()->create(['day' => $day]);
        }

        return back()->with('success','Slot created');
    }
}
