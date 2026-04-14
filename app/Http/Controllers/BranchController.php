<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-branch', ['only'=>['index']]);
        $this->middleware('permission:create-branch', ['only'=>['create']]);
        $this->middleware('permission:edit-branch', ['only'=>['edit']]);
        $this->middleware('permission:update-branch', ['only'=>['update']]);
        $this->middleware('permission:delete-branch', ['only'=>['destroy']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        return view('branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            'branchName'=>'required',
            'address'=>'required|string',
            'branchPhone'=>'required',
            'branchEmail'=>'required',

        ];
        $messages =    [
            'branchName.required' => 'Please Enter Branch Name',
            'address.required' => 'Please Enter Address',
            'address.string' => 'Please Enter ',
            'branchPhone.required' => 'Please Enter Branch Phone No.',
            'branchEmail.required' => 'Please Enter Branch Email',
        ];

        $this->validate($request, $rules, $messages);
        $user = Auth::user();
        $branch = new Branch;
        $branch->branchName = $request->branchName;
        $branch->logo = $request->logo;
        $branch->address = $request->address;
        $branch->branchPhone = $request->branchPhone;
        $branch->branchEmail = $request->branchEmail;
        $branch->save();
        $branch->users()->attach($user);

        return redirect()->route('branches.index')->with('message','Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $rules =  [
            'branchName'=>'required',
            'address'=>'required|string',
            'branchPhone'=>'required',
            'branchEmail'=>'required',

        ];
        $messages =    [
            'branchName.required' => 'Please Enter Branch Name',
            'address.required' => 'Please Enter Address',
            'address.string' => 'Please Enter ',
            'branchPhone.required' => 'Please Enter Branch Phone No.',
            'branchEmail.required' => 'Please Enter Branch Email',
        ];

        $this->validate($request, $rules, $messages);
        $user = Auth::user();
        $branch = Branch::findOrFail($branch->id);
        $branch->branchName = $request->branchName;
        $branch->logo = $request->logo;
        $branch->address = $request->address;
        $branch->branchPhone = $request->branchPhone;
        $branch->branchEmail = $request->branchEmail;
        $branch->save();
       // $branch->users()->attach($user);
        return redirect()->route('branches.index')->with('message','Added Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
