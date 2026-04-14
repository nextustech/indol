<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
        public function __construct()
    {
        $this->middleware('permission:list-ServiceType', ['only'=>['index']]);
        $this->middleware('permission:create-ServiceType', ['only'=>['create']]);
        $this->middleware('permission:edit-ServiceType', ['only'=>['edit']]);
        $this->middleware('permission:update-ServiceType', ['only'=>['update']]);
        $this->middleware('permission:delete-ServiceType', ['only'=>['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = ServiceType::where('parentId',NULL)->get(); //where('parentId',NULL)->get();
        $servicetypes = ServiceType::all();
        return view('service_types.index',compact('servicetypes','parents'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = ServiceType::where('parentId',NULL)->get(); //where('parentId',NULL)->get();
        $servicetypes = ServiceType::all();
        return view('service_types.create',compact('servicetypes','parents'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules =  [
            'name'=>'required',
            'amount' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'days' => 'required|integer',
            'note' => 'nullable|string',

        ];
        $messages =    [
            'name.required' => 'Please Enter Service Type',
        ];

        $this->validate($request, $rules, $messages);

        $serviceType = new ServiceType;
        $serviceType->parentId = $request->parentId;
        $serviceType->name = $request->name;
        $serviceType->amount = $request->amount;
        $serviceType->discount = $request->discount;
        $serviceType->days = $request->days;
        $serviceType->note = $request->note;
        $serviceType->save();

        return redirect()->route('servicetypes.index')->with('message','Added Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceType $serviceType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceType $servicetype)
    {
       return view('service_types.edit',compact('servicetype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceType $servicetype)
    {
         $rules =  [
            'name'=>'required',
            'amount' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'days' => 'required|integer',
            'note' => 'nullable|string',
        ];
        $messages =    [
            'name.required' => 'Please Enter Service Type',
        ];

        $this->validate($request, $rules, $messages);

        $serviceType = ServiceType::findOrFail($servicetype->id);
        $serviceType->parentId = $request->parentId;
        $serviceType->name = $request->name;
        $serviceType->amount = $request->amount;
        $serviceType->discount = $request->discount;
        $serviceType->days = $request->days;
        $serviceType->note = $request->note;
        $serviceType->save();

        return redirect()->route('servicetypes.index')->with('message','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $serviceType)
    {
        //
    }
  
      public function checkService(Request $request)
    {
        // return $request->all();
        $q = $request->get('q');

        $services = ServiceType::where('name', 'like', "%{$q}%")
            ->orWhere('days', 'like', "%{$q}%")
            ->limit(20)
            ->get();
        return response()->json($services);
    }
}
