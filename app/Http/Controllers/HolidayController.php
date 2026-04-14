<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;


class HolidayController extends Controller
{
     public function index()
    {
        $holidays = Holiday::with('branch')->get();
        return view('holidays.index', compact('holidays'));
    }

    public function store(Request $request)
    {
        Holiday::create($request->all());
        return back();
    }
}
