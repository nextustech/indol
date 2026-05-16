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
        $this->middleware('permission:delete-branch', ['only'=>['destroy', 'forceDelete']]);

    }

    public function index()
    {
        $branches = Branch::all();
        return view('branches.index',compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

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

    public function show(Branch $branch)
    {
        //
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit',compact('branch'));
    }

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
        return redirect()->route('branches.index')->with('message','Added Successfully');

    }

    public function destroy(Branch $branch)
    {
        $branch->deleteRecord();
        return redirect()->route('branches.index')->with('message','Deleted Successfully');
    }

    public function trash()
    {
        $branches = Branch::onlyDeleted()->latest('deleted_at')->get();
        return view('branches.trash', compact('branches'));
    }

    public function restore($id)
    {
        $branch = Branch::withDeleted()->findOrFail($id);
        $branch->restoreRecord();
        return redirect()->route('branches.trash')->with('message','Restored Successfully');
    }

    public function forceDelete($id)
    {
        $branch = Branch::withDeleted()->findOrFail($id);
        $branch->forceDeleteRecord();
        return redirect()->route('branches.trash')->with('message','Permanently Deleted Successfully');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Branch::whereIn('id', $request->ids)->each(fn($b) => $b->deleteRecord());
        return back()->with('message', count($request->ids) . ' branches deleted');
    }

    public function bulkRestore(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Branch::onlyDeleted()->whereIn('id', $request->ids)->each(fn($b) => $b->restoreRecord());
        return back()->with('message', count($request->ids) . ' branches restored');
    }

    public function bulkForceDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Branch::onlyDeleted()->whereIn('id', $request->ids)->each(fn($b) => $b->forceDeleteRecord());
        return back()->with('message', count($request->ids) . ' branches permanently deleted');
    }
}
