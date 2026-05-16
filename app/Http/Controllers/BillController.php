<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bills.bill');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $bill->deleteRecord();
        return redirect()->back()->with('message','Deleted Successfully');
    }

    public function trash()
    {
        $bills = Bill::onlyDeleted()->latest('deleted_at')->get();
        return view('bills.trash', compact('bills'));
    }

    public function restore($id)
    {
        $bill = Bill::withDeleted()->findOrFail($id);
        $bill->restoreRecord();
        return redirect()->route('bills.trash')->with('message','Restored Successfully');
    }

    public function forceDelete($id)
    {
        $bill = Bill::withDeleted()->findOrFail($id);
        $bill->forceDeleteRecord();
        return redirect()->route('bills.trash')->with('message','Permanently Deleted Successfully');
    }
}
