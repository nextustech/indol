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
        $this->middleware('permission:delete-user', ['only'=>['destroy']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $branches = Branch::all();
        return view('users.create',compact('roles','branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
    public function edit( User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $branches = Branch::all();
        return view('users.edit',compact('user','roles','branches'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( User $user )
    {
        $user->delete();
        return redirect()->route('users.index')->with('message','User Deleted Successffully');
    }
}
