<?php

namespace App\Http\Controllers;

use App\Models\Ecat;
use Illuminate\Http\Request;

class EcatController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-ExpenseCategory', ['only'=>['index']]);
        $this->middleware('permission:create-ExpenseCategory', ['only'=>['create']]);
        $this->middleware('permission:edit-ExpenseCategory', ['only'=>['edit']]);
        $this->middleware('permission:update-ExpenseCategory', ['only'=>['update']]);
        $this->middleware('permission:delete-ExpenseCategory', ['only'=>['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecats = Ecat::all();
        return view('ecat.index', compact('ecats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'name'=>'required|unique:ecats',

        ];
        $messages =    [
            'name.required' => 'Please Enter Category Name',
            'name.unique' => 'Category Already Exists',
        ];

        $this->validate($request, $rules, $messages);

        if(Ecat::create($request->all())){
            return redirect()->back()->with('message','Category Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ecat  $ecat
     * @return \Illuminate\Http\Response
     */
    public function show(Ecat $ecat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ecat  $ecat
     * @return \Illuminate\Http\Response
     */
    public function edit(Ecat $ecat)
    {
        return view('ecat.edit',compact('ecat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ecat  $ecat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ecat $ecat)
    {
        if($ecat->update($request->all())){
            return redirect()->route('ecat.index')->with('message','Expense Successfully Updated');
        }else{
            return'Sorry Something Went Wrong';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ecat  $ecat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ecat $ecat)
    {
        Ecat::destroy($ecat->id);
        return redirect()->route('ecat.index')->with('message','Deleted Successfully');
    }
}
