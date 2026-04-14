<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
   public function __construct()
   {
       $this->middleware('permission:list-permission', ['only'=>['index']]);
       $this->middleware('permission:create-permission', ['only'=>['create']]);
       $this->middleware('permission:edit-permission', ['only'=>['edit']]);
       $this->middleware('permission:update-permission', ['only'=>['update']]);
       $this->middleware('permission:delete-permission', ['only'=>['destroy']]);

   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $permissions = Permission::orderBy('id', 'desc')->paginate(10);
        return view('roles-permissions.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles-permissions.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            'name'=>'required|unique:permissions',

        ];
        $messages =    [
            'name.required' => 'Please Enter Permission Name',
            'name.unique' => 'Permission Already Exists',
        ];

        $this->validate($request, $rules, $messages);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('permissions.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('roles-permissions.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules =  [
            'name'=>'required|string|unique:permissions',

        ];
        $messages =    [
            'title.required' => 'Please Enter Permission Name',
            'title.unique' => 'Permission Already Exists',
        ];

        $this->validate($request, $rules, $messages);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('permissions.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back();
    }
}
