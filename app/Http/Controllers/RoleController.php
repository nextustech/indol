<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
   public function __construct()
   {
       $this->middleware('permission:list-role', ['only'=>['index']]);
       $this->middleware('permission:create-role', ['only'=>['create']]);
       $this->middleware('permission:edit-role', ['only'=>['edit']]);
       $this->middleware('permission:update-role', ['only'=>['update']]);
       $this->middleware('permission:delete-role', ['only'=>['destroy']]);

   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->paginate(10);
        return view('roles-permissions.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles-permissions.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            'name'=>'required|unique:roles',

        ];
        $messages =    [
            'title.required' => 'Please Enter role Name',
            'title.unique' => 'role Already Exists',
        ];

        $this->validate($request, $rules, $messages);

        $role = new Role;
        $role->name = $request->name;
        $role->save();
        return redirect()->route('roles.index');

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
        $role = Role::findOrFail($id);
        return view('roles-permissions.roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules =  [
            'name'=>'required|string|unique:roles',
        ];
        $messages =    [
            'title.required' => 'Please Enter role Name',
            'title.unique' => 'role Already Exists',
        ];

        $this->validate($request, $rules, $messages);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();
        return redirect()->route('roles.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back();
    }

    public function givePerminssion($role_id){
        $permissions = Permission::all();
        $role  = Role::findOrFail($role_id);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id',$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('roles-permissions.roles.addPermissionToRole',compact('permissions','role','rolePermissions'));
    }

    public function addPermissionsToRole(Request $request, $role_id){
        $role  = Role::findOrFail($role_id);
        $role->syncPermissions($request->permissions);
        // return $request->all();
        return redirect()->back();
    }
}
