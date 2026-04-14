<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Ecat;
use App\Models\Expense;
use App\Models\Mode;
use App\Models\ServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:list-Expense', ['only'=>['index']]);
        $this->middleware('permission:create-Expense', ['only'=>['create']]);
        $this->middleware('permission:edit-Expense', ['only'=>['edit']]);
        $this->middleware('permission:update-Expense', ['only'=>['update']]);
        $this->middleware('permission:delete-Expense', ['only'=>['destroy']]);
        $this->middleware('permission:Exp-Report', ['only'=>['expData']]);
        $this->middleware('permission:Exp-ReportShow', ['only'=>['expenseReport']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $brachesId = loggedUser()->branches->pluck('id')->toArray();

        $expenses = Expense::whereIn('branch_id', $brachesId)->latest()->paginate(25);
        return view('expenses.index',compact('expenses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ecats = Ecat::all();
        $branches = loggedUser()->branches;
        $modes = Mode::all();
       // $branchesId = $branches->pluck('id')->toArray();
        return view('expenses.create',compact('ecats','modes','branches'));
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
            'title'=>'required',
            'date'=>'required',
            'amount'=>'required|integer',
            'ecat_id'=>'required',
            'branch_id'=>'required',
            'mode_id'=>'required',

        ];
        $messages =    [
            'branch_id.required' => 'Please Select Branch',
            'mode_id.required' => 'Please Select Payment Mode',
            'date.required' => 'Date Can not be blank',
            'ecat_id.required' => 'Please Select Expense Category',
            'title.required' => 'Please Enter Expense Title',
            'amount.required' => 'Amount Field Can not Be Blank ',
            'amount.integer' => 'Must Be Numerals',

        ];

        $this->validate($request, $rules, $messages);
        $request['user_id']= Auth::id();
        $user = Auth::user();
        if(!$request->branch_id){
            $request['branch_id']= $user->branch_id;

        }

        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
            //return $request['date'];
        }else{
            $date = Carbon::now();
            $request['date'] = Carbon::now();
            //return Carbon::now();
        }

        if(Expense::create($request->all())){
            return redirect()->back()->with('message', 'Successfully Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $ecats = Ecat::all();
        $branches = loggedUser()->branches;
      	$modes = Mode::all();
        return view('expenses.edit',compact('expense','ecats','branches','modes'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
            //return $request['date'];
        }
        if($expense->update($request->all())){
            return redirect()->route('expenses.index')->with('message','Expense Category Successfully Updated');
        }else{
            return'Sorry Something Went Wrong';
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        Expense::destroy($expense->id);
        return redirect()->route('expenses.index')->with('message','Deleted Successfully');

    }

    public function expData(Request $request)
    {
        $query = $request->all();
        // return $request->all();
        $branch_id = $request['branch_id'];
        $from = $request['from'];
        $upto = $request['upto'];
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime($upto) );

        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');
//        if($branch_id){
//            $expenses = Expense::where('branch_id',$branch_id)->whereBetween('date', [$start, $to])->latest()->paginate(20);
//        }else{
//            $expenses = Expense::whereBetween('date', [$start, $to])->latest()->paginate(20);
//        }

        //  $expenses = Expense::whereBetween('date', [$start, $to])->latest()->paginate(20);

        $data = DB::table('expenses');
        if( $request->branch_id){
            $data = $data->where('branch_id', $request->branch_id);
        }
        if( $request->ecat_id ){
            $data = $data->where('ecat_id', $request->ecat_id);
        }
        if( $request->from != Null && $request->upto != Null){
            $data = $data->whereBetween('date', [$start,$to]);
        }



        if($request->has('pagination')){
            $pagination = $request->pagination;
        }else{
            $pagination = 25;
        }

        $expenses = $data->paginate($pagination);
        // return $expenses;
        return view('expenses.index',compact('expenses','query'));

    }

    public function expenseReport( Request $request)
    {
        // return $request->all();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $modes = Mode::all();
        $ecats = Ecat::all();

        $query = Expense::query();
        
        $branchFilter = $request->branchFilter ;
        $ecatFilter = $request->ecatFilter;
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
        if(isset($request->ecatFilter) && ($request->ecatFilter != null)){
            $query->whereHas('ecat',function($q) use($request){
                $q->where('id',$request->ecatFilter);
            });
        }
        if(isset($request->modeFilter) && ($request->modeFilter != null)){
            $query->whereHas('mode',function($q) use($request){
                $q->where('id',$request->modeFilter);
            });
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
        $totalAmount = $query->sum('amount');
        $expenses = $query->latest()->paginate(100);
        // $expenses = $query->get();

        // return  $collections;
        return view('reports.expenseReports',compact('expenses','branches','modes','ecats','totalAmount','branchFilter','ecatFilter','modeFilter','dateFilter'));

    }
  
  	 public function expenseReportCustom(Request $request)
    {
        // return $request->all();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $modes = Mode::all();
        $ecats = Ecat::all();

        $query = Expense::query();
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
        if(isset($request->ecatFilter) && ($request->ecatFilter != null)){
            $query->whereHas('ecat',function($q) use($request){
                $q->where('id',$request->ecatFilter);
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
        $totalAmount = $query->sum('amount');
        $expenses = $query->latest()->paginate(100);
        // $expenses = $query->get();

        // return  $collections;
        return view('reports.expenseReportsCustom',compact('expenses','branches','modes','ecats','totalAmount'));

    }
}
