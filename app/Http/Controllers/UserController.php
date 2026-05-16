<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-user', ['only'=>['index']]);
        $this->middleware('permission:create-user', ['only'=>['create']]);
        $this->middleware('permission:edit-user', ['only'=>['edit']]);
        $this->middleware('permission:update-user', ['only'=>['update']]);
        $this->middleware('permission:delete-user', ['only'=>['destroy', 'forceDelete']]);
        $this->middleware('permission:view-trash-user', ['only'=>['trash']]);
        $this->middleware('permission:restore-user', ['only'=>['restore', 'bulkRestore']]);
        $this->middleware('permission:force-delete-user', ['only'=>['forceDelete', 'bulkForceDelete']]);

    }

    public function index()
    {
        $users = User::get();
        return view('users.index',compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $branches = Branch::all();
        return view('users.create',compact('roles','branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:25',
            'roles' => 'required',
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->syncRoles($request->roles);
        $user->branches()->sync($request->branches);

        return redirect()->back();
    }

    public function show(string $id)
    {
        //
    }

    public function edit( User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $branches = Branch::all();
        return view('users.edit',compact('user','roles','branches'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|max:25',
            'roles' => 'required',
            'branches' => 'required',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ];

        if(!empty($request->password)){
            $data += [
                'password' => Hash::make($request->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);
        $user->branches()->sync($request->branches);

        return redirect()->route('users.index')->with('message','User Updated Successffully');
    }

    public function destroy( User $user )
    {
        $user->deleteRecord();
        return redirect()->route('users.index')->with('message','User Deleted Successffully');
    }

    public function trash()
    {
        $users = User::onlyDeleted()->latest('deleted_at')->get();
        return view('users.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::withDeleted()->findOrFail($id);
        $user->restoreRecord();
        return redirect()->route('users.trash')->with('message','User Restored Successffully');
    }

    public function forceDelete($id)
    {
        $user = User::withDeleted()->findOrFail($id);
        $user->forceDeleteRecord();
        return redirect()->route('users.trash')->with('message','User Permanently Deleted Successffully');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        User::whereIn('id', $request->ids)->each(fn($u) => $u->deleteRecord());
        return back()->with('message', count($request->ids) . ' users deleted');
    }

    public function bulkRestore(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        User::onlyDeleted()->whereIn('id', $request->ids)->each(fn($u) => $u->restoreRecord());
        return back()->with('message', count($request->ids) . ' users restored');
    }

    public function bulkForceDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        User::onlyDeleted()->whereIn('id', $request->ids)->each(fn($u) => $u->forceDeleteRecord());
        return back()->with('message', count($request->ids) . ' users permanently deleted');
    }

}
