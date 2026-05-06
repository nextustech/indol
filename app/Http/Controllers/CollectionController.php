<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Mode;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\ServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-Collection', ['only'=>['crd']]);
        $this->middleware('permission:collection-lst', ['only'=>['collData']]);
        $this->middleware('permission:edit-branch', ['only'=>['edit']]);
        $this->middleware('permission:update-branch', ['only'=>['update']]);
        $this->middleware('permission:deleteCollection', ['only'=>['destroy']]);
        $this->middleware('permission:view-collectionReport', ['only'=>['collectionReport']]);
        $this->middleware('permission:view-CustomCollectionReport', ['only'=>['collectionReportCustom']]);
        $this->middleware('permission:view-RefundReport', ['only'=>['refundReport']]);

    }
    public function crd(){
        return view('collections.crd');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collData(Request $request)
    {
        $query = $request->all();
        $branch_id = $request['branch_id'];
        $from = $request['from'];
        $upto = $request['upto'];
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime($upto) );

        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');
        $user = loggedUser();

        $data = DB::table('collections');
        $rdata =  DB::table('collections');
        if( $request->branch_id){
            $data = $data->where('branch_id', $request->branch_id);
            $rdata = $rdata->where('branch_id', $request->branch_id);
        }
        if( $request->from != Null && $request->upto != Null){
            $data = $data->whereBetween('date', [$start,$to]);
            $rdata = $rdata->where('refundDate', $request->branch_id);
        }

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $data = $data->where('user_id', $user->id);
            $rdata = $rdata->where('user_id', $user->id);
        }


        if($request->has('pagination')){
            $pagination = $request->pagination;
        }else{
            $pagination = 1500;
        }

        $collections = $data->paginate($pagination);
        $refunds = $rdata->paginate($pagination);

        return view('collections.index',compact('collections','refunds','query'));
    }
    public function index()
    {
        $user = loggedUser();
        $query = Collection::query();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $query->where('user_id', $user->id);
        }

        $collections = $query->latest()->paginate(25);
        return view('collections.index',compact('collections'));
    }


    public function collectionPrint($id){
        $collection = Collection::findOrFail($id);
        $payment = Payment::findOrFail($collection->payment_id);
        $totalDiscount = Collection::where('payment_id',$collection->payment_id)->whereBetween('created_at', [$payment->created_at,$collection->created_at])->sum('discount');
        $totalCollection = Collection::where('payment_id',$collection->payment_id)->whereBetween('created_at', [$payment->created_at,$collection->created_at])->sum('amount');
        $totalRefund = Collection::where('payment_id',$collection->payment_id)->sum('refund');
        return view('collections.print',compact('collection','payment','totalCollection','totalRefund','totalDiscount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function cr($id)
    {
        $todaysDate = Carbon::now();
        $payment = Payment::findOrFail($id);
        // return $payment->collections->sum('amount');
        $patient = Patient::where('id',$payment->patient_id)->first();
        // $package = Pakage::where('id',$payment->pakage_id)->first();
        return view('collections.create',compact('payment','patient','todaysDate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //  return $request['collectionDate'];
        if($request['collectionDate']!= null){
            $dt = date("Y-m-d", strtotime($request['collectionDate']) );
             // $dt = $dt->toDateTimeString();
            $request['collectionDate'] = Carbon::createFromFormat('Y-m-d H',$dt." 06", 'Asia/Kolkata');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
            //return $request['date'];
        }else{
            $date = Carbon::now();
            $request['collectionDate'] = Carbon::now();
            //return Carbon::now();
        }

        $patient = Patient::findOrFail($request->patient_id);
        //$request['branch_id'] = $patient->branch_id;


        $this->validate($request, Collection::rules(), Collection::messages());

        $request['user_id'] = Auth::id();
      // return $request->all();

        if(Collection::create($request->all())){
           return redirect()->route('patients.show',$request->patient_id);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
public function edit(Collection $collection)
    {
        $user = loggedUser();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            if ($collection->user_id !== $user->id) {
                abort(403, 'Unauthorized access');
            }
        }

        return view('collections.edit',compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        $user = loggedUser();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            if ($collection->user_id !== $user->id) {
                abort(403, 'Unauthorized access');
            }
        }

       	if($request->collectionDate == null ){
           $request['collectionDate'] = $collection->collectionDate;
         }
       	// return $request->all();
         $collection->update($request->all());
         return redirect()->route('payIndex',$collection->payment_id)->with('message','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $user = loggedUser();

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            if ($collection->user_id !== $user->id) {
                abort(403, 'Unauthorized access');
            }
        }

Collection::destroy($collection->id);
        return redirect()->back()->with('message','Deleted Successfully');
    }


    public function getRefund($id){
        $payment = Payment::findOrFail($id);
        $patient = Patient::where('id',$payment->patient_id)->first();
        $collections = Collection::where('payment_id',$id)->where('patient_id',$payment->patient_id)->get();
        $branch_id = $payment->branch_id;
        //return $collections->sum('amount');
        return view('collections.refund',compact('payment','patient','branch_id','collections'));
    }
    public function storeRefund(Request $request){
        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['collectionDate'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            $request['refundDate'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');

            //'Y-m-d H', $dtFr.' 22'
            // return $date;
            //return $request['date'];
        }else{
            $date = Carbon::now();
            $request['collectionDate'] = Carbon::now();
            //return Carbon::now();
        }

        //$this->validate($request, Collection::rules(), Collection::messages());

        $request['user_id'] = Auth::id();
        $collection = Collection::create($request->all());
        if($collection){
            $pay = Payment::find($collection->payment_id);
            $pay->active = null;
            $pay->save();
            return redirect()->route('patients.show',$request->patient_id);
        }

    }

    public function cashOfDay(){
        $time = Carbon::now();
        $time = $time->toDateString();
        $start = Carbon::createFromFormat('Y-m-d H', $time.' 00')->toDateTimeString();

        $dt = Carbon::now();
        $dt = $dt->toDateString();

        $to = Carbon::createFromFormat('Y-m-d H:i', $dt.' 23:59')->toDateTimeString();

        $cashOfDay = DB::table('collections')
            ->select('cash', DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('date', [$start, $to])
            ->groupBy('cash')
            ->get();
        return $cashOfDay;
    }


    public function todayCash(){
        $user = loggedUser();
        $time = Carbon::now();
        $time = $time->toDateString();
        $start = Carbon::createFromFormat('Y-m-d H', $time.' 00')->toDateTimeString();

        $dt = Carbon::now();
        $dt = $dt->toDateString();

        $to = Carbon::createFromFormat('Y-m-d H:i', $dt.' 23:59')->toDateTimeString();

        $isHomePhysio = $user->roles->pluck('name')->first() === 'HomePhysiotherapist';
        $userBranchIds = $user->branches->pluck('id')->toArray();

        if($isHomePhysio){
            $DailyCash = Collection::where('cash',1)->whereIn('branch_id', $userBranchIds)->where('user_id', $user->id)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->get();
            $otherPayments = Collection::whereIn('branch_id', $userBranchIds)->where('user_id', $user->id)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->get();
            $refunds = Collection::whereIn('branch_id', $userBranchIds)->where('user_id', $user->id)->whereBetween('refundDate', [$start, $to])->get();
            $DailyExpenses = Expense::whereIn('branch_id', $userBranchIds)->where('user_id', $user->id)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->get();
            $CashExpense = Expense::whereIn('branch_id', $userBranchIds)->where('user_id', $user->id)->where('mode_id',1)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->sum('amount');
            $CashRefunds = Collection::whereIn('branch_id', $userBranchIds)->where('user_id', $user->id)->where('cash',1)->whereBetween('refundDate', [$start, $to])->sum('refund');
            $modeWisePayments = DB::table('collections')
                ->select('cash', DB::raw('SUM(amount) as total_amount'))
                ->whereIn('branch_id', $userBranchIds)
                ->where('user_id', $user->id)
                ->whereBetween('date', [$start, $to])
                ->groupBy('cash')
                ->get();
            $modeWiseRefunds = DB::table('collections')
                ->select('cash', DB::raw('SUM(refund) as total_refund'))
                ->whereIn('branch_id', $userBranchIds)
                ->where('user_id', $user->id)
                ->whereBetween('date', [$start, $to])
                ->groupBy('cash')
                ->get();
            return view('reports.cashToday',compact('modeWisePayments','modeWiseRefunds','CashRefunds','DailyCash','refunds','DailyExpenses','otherPayments','CashExpense'));
        }else{
            $DailyCash = Collection::where('cash',1)->whereIn('branch_id', $userBranchIds)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->get();
            $otherPayments = Collection::whereIn('branch_id', $userBranchIds)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->get();
            $refunds = Collection::whereIn('branch_id', $userBranchIds)->whereBetween('refundDate', [$start, $to])->get();
            $DailyExpenses = Expense::whereIn('branch_id', $userBranchIds)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->get();
            $CashExpense = Expense::whereIn('branch_id', $userBranchIds)->where('mode_id',1)->whereBetween('date', [$start, $to])->orderBy('date', 'desc')->sum('amount');
            $CashRefunds = Collection::whereIn('branch_id', $userBranchIds)->where('cash',1)->whereBetween('refundDate', [$start, $to])->sum('refund');
            $modeWisePayments = DB::table('collections')
                ->select('cash', DB::raw('SUM(amount) as total_amount'))
                ->whereIn('branch_id', $userBranchIds)
                ->whereBetween('date', [$start, $to])
                ->groupBy('cash')
                ->get();
            $modeWiseRefunds = DB::table('collections')
                ->select('cash', DB::raw('SUM(refund) as total_refund'))
                ->whereIn('branch_id', $userBranchIds)
                ->whereBetween('date', [$start, $to])
                ->groupBy('cash')
                ->get();
            return view('reports.cashToday',compact('modeWisePayments','modeWiseRefunds','CashRefunds','DailyCash','refunds','DailyExpenses','otherPayments','CashExpense'));
        }
    }

    public function monthWise(){

        $monthWise = \DB::select('select year(date) as year, month(date) as month, sum(amount) as total_amount from collections group by year(date), month(date)');


        return view('reports.monthWise',compact('monthWise'));


    }

    public function collectionReport(Request $request){
       // return $request->all();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $modes = Mode::all();
        $serviceTypes = ServiceType::all();
        $user = loggedUser();

        $query = Collection::query();
        $branchFilter = $request->branchFilter ;
        $serviceTypeFilter = $request->serviceTypeFilter;
        $modeFilter = $request->modeFilter;
        $dateFilter = $request->dateFilter;
        if(isset($request->branchFilter) && ($request->branchFilter != null)){
            $query->whereHas('branch',function($q) use($request){
                $q->where('id',$request->branchFilter);
            });
        }else{
            $query->whereHas('branch',function($q) use($branchIds){
                $q->where('id',$branchIds);
            });
        }
        if(isset($request->serviceTypeFilter) && ($request->serviceTypeFilter != null)){
            $query->whereHas('serviceType',function($q) use($request){
                $q->where('id',$request->serviceTypeFilter);
            });
        }
        if(isset($request->modeFilter) && ($request->modeFilter != null)){
            $query->whereHas('mode',function($q) use($request){
                $q->where('id',$request->modeFilter);
            });
        }

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $query->where('user_id', $user->id);
        }

        switch($dateFilter){
            case 'today':
                $query->whereDate('created_at',Carbon::today());
                break;
            case 'yesterday':
                $query->whereDate('created_at',Carbon::yesterday());
                break;
            case 'this_week':
                $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()]);
                break;
            case 'this_month':
                $query->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('created_at',[Carbon::now()->subMonth()->startOfMonth(),Carbon::now()->subMonth()->endOfMonth()]);
                break;
            case 'this_year':
                $query->whereYear('created_at',Carbon::now()->year);
                break;
            case 'last_year':
                $query->whereYear('created_at',Carbon::now()->subYear()->year);
                break;
            default ;
                $query->whereDate('created_at',Carbon::today());
                break;
        }

       // $collections = $query->get();

       // return  $collections;
        // return view('reports.collectionReport',compact('collections','branches','modes','serviceTypes','branchFilter','serviceTypeFilter','modeFilter','dateFilter'));
         $totalAmount = $query->sum('amount');
         $collections = $query->latest()->paginate(100);
        // return  $collections;
        return view('reports.collectionReport',compact('collections','branches','modes','serviceTypes','branchFilter','serviceTypeFilter','modeFilter','dateFilter','totalAmount'));


    }
public function collectionReportCustom(Request $request){
         // return $request->all();
        // $endDate =  ;

        // return $startDate . '<br/>' . $endDate . '<br/>';
         $branchIds = loggedUser()->branches->pluck('id')->toArray();
         $branches = Branch::whereIn('id',$branchIds)->get();
         $modes = Mode::all();
         $serviceTypes = ServiceType::all();
         $user = loggedUser();

         $query = Collection::query();
         $dateFilter = $request->dateFilter;
         if(isset($request->branchFilter) && ($request->branchFilter != null)){
             $query->whereHas('branch',function($q) use($request){
                 $q->where('id',$request->branchFilter);
             });
         }else{
            $query->whereHas('branch',function($q) use($branchIds){
                $q->where('id',$branchIds);
            });
        }
         if(isset($request->serviceTypeFilter) && ($request->serviceTypeFilter != null)){
             $query->whereHas('serviceType',function($q) use($request){
                 $q->where('id',$request->serviceTypeFilter);
             });
         }
         if(isset($request->modeFilter) && ($request->modeFilter != null)){
             $query->whereHas('mode',function($q) use($request){
                 $q->where('id',$request->modeFilter);
             });
         }
         if(isset($request->dateFilter) && ($request->dateFilter != null)){
             $dates = explode(' - ',$request->dateFilter);
             $startDate =  Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
             $endDate =  Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');

             $query->whereDate('created_at','>=',$startDate)
                    ->whereDate('created_at','<=',$endDate);
         }else{
             $query->whereDate('created_at','>=',Carbon::today())
                 ->whereDate('created_at','<=',Carbon::today());

         }

         if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
             $query->where('user_id', $user->id);
         }

         $totalAmount = $query->sum('amount');
         $collections = $query->latest()->paginate(100);
        // return  $collections;
         return view('reports.collectionReportCustom',compact('collections','branches','modes','serviceTypes','totalAmount'));

      //   $collections = $query->get();

        // return  $collections;
      //   return view('reports.collectionReportCustom',compact('collections','branches','modes','serviceTypes'));
    }

    public function refundReport(Request $request)
    {
        // return $request->all();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $modes = Mode::all();
        $serviceTypes = ServiceType::all();
        $user = loggedUser();

        $query = Collection::query();
        $dateFilter = $request->dateFilter;
        $query->where('refund','!=', null);
        if(isset($request->branchFilter) && ($request->branchFilter != null)){
            $query->whereHas('branch',function($q) use($request){
                $q->where('id',$request->branchFilter);
            });
        }
        if(isset($request->serviceTypeFilter) && ($request->serviceTypeFilter != null)){
            $query->whereHas('serviceType',function($q) use($request){
                $q->where('id',$request->serviceTypeFilter);
            });
        }
        if(isset($request->modeFilter) && ($request->modeFilter != null)){
            $query->whereHas('mode',function($q) use($request){
                $q->where('id',$request->modeFilter);
            });
        }

        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $query->where('user_id', $user->id);
        }

        switch($dateFilter){
            case 'today':
                $query->whereDate('created_at',Carbon::today());
                break;
            case 'yesterday':
                $query->whereDate('created_at',Carbon::yesterday());
                break;
            case 'this_week':
                $query->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at',[Carbon::now()->subWeek(),Carbon::now()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at',Carbon::now()->month);
                break;
            case 'last_month':
                $query->whereMonth('created_at',Carbon::now()->subMonth()->month);
                break;
            case 'this_year':
                $query->whereYear('created_at',Carbon::now()->year);
                break;
            case 'last_year':
                $query->whereYear('created_at',Carbon::now()->subYear()->year);
                break;
        }

        $collections = $query->get();

        // return  $collections;
        return view('reports.refundReports',compact('collections','branches','modes','serviceTypes'));

    }
}
