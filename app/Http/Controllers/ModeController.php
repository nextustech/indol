<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use Illuminate\Http\Request;

class ModeController extends Controller
{
  
      public function __construct()
    {
        $this->middleware('permission:list-PaymentMode', ['only'=>['index']]);
        $this->middleware('permission:create-PaymentMode', ['only'=>['create']]);
        $this->middleware('permission:edit-create', ['only'=>['edit']]);
        $this->middleware('permission:update-create', ['only'=>['update']]);
        $this->middleware('permission:delete-create', ['only'=>['destroy']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modes = Mode::all();
        return view('modes.index',compact('modes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            'name'=>'required',

        ];
        $messages =    [
            'name.required' => 'Please Enter Service Type',
        ];

        $this->validate($request, $rules, $messages);

        $mode = new Mode();
        $mode->name = $request->name;
        $mode->note = $request->note;
        $mode->save();

        return redirect()->route('modes.index')->with('message','Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Mode $mode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mode $mode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mode $mode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mode $mode)
    {
        $mode->deleteRecord();
        return redirect()->route('modes.index')->with('message','Deleted Successfully');
    }

    public function trash()
    {
        $modes = Mode::onlyDeleted()->latest('deleted_at')->get();
        return view('modes.trash', compact('modes'));
    }

    public function restore($id)
    {
        $mode = Mode::withDeleted()->findOrFail($id);
        $mode->restoreRecord();
        return redirect()->route('modes.trash')->with('message','Restored Successfully');
    }

    public function forceDelete($id)
    {
        $mode = Mode::withDeleted()->findOrFail($id);
        $mode->forceDeleteRecord();
        return redirect()->route('modes.trash')->with('message','Permanently Deleted Successfully');
    }
}
