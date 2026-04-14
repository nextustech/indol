<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Expense;
use App\Models\Mode;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\ServiceType;
use App\Models\Schedule;
use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-TodaysBranchDetails', ['only'=>['todayBranchDetails']]);
        $this->middleware('permission:rangeDailyReport', ['only'=>['rangeDailyReport']]);

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $branches = loggedUser()->branches;
        // return $branches;
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $newPatients = Patient::whereDate('created_at',Carbon::today())->whereHas('branches', function ($q)use($brachesId) {
            $q->whereIn('branches.id', $brachesId);
        })->count();
        $todayCash = Collection::where('mode_id',1)->whereDate('collectionDate',Carbon::today())->whereIn('branch_id', $brachesId)->sum('amount');
        $todayOnline = Collection::where('mode_id',2)->whereDate('collectionDate',Carbon::today())->whereIn('branch_id', $brachesId)->sum('amount');
        $totalAmount = Payment::whereIn('branch_id', $brachesId)->sum('amount');
        $totalCollection = Collection::whereIn('branch_id', $brachesId)->sum('amount');
        $totalDiscount = Collection::whereIn('branch_id', $brachesId)->sum('discount');
        $totalDues = $totalAmount - ( $totalCollection + $totalDiscount );

        $todayCashExp = Expense::where('mode_id',1)->whereDate('date',Carbon::today())->whereIn('branch_id', $brachesId)->sum('amount');
        $todayOnlineExp = Expense::where('mode_id',2)->whereDate('date',Carbon::today())->whereIn('branch_id', $brachesId)->sum('amount');

        $todayRefund = Collection::whereDate('collectionDate',Carbon::today())->whereIn('branch_id', $brachesId)->sum('refund');
        $todayCashRefund = Collection::where('mode_id',1)->whereDate('created_at',Carbon::today())->whereIn('branch_id', $brachesId)->sum('refund');
        $netCashToday = $todayCash - ( $todayCashExp + $todayCashRefund);
              $serviceTypes = ServiceType::with(['collections'=> function($query) use($brachesId) {
            $query->whereIn('branch_id', $brachesId);
            $query->whereDate('collectionDate',Carbon::today());
        }])->get();
        $paymentModes = Mode::with(['collections'=> function($query) use($brachesId) {
            $query->whereIn('branch_id', $brachesId);
            $query->whereDate('collectionDate',Carbon::today());
        }])->get();
       // return $serviceTypes;
        $activePackages = Payment::with('schedules')->whereIn('branch_id', $brachesId)->where('active',1)->get();
        // return $activePackages;
        return view('home',compact('branches','newPatients','todayCash','todayOnline','totalDues','todayCashExp','todayOnlineExp','todayRefund','netCashToday','serviceTypes','activePackages','paymentModes'));
 
       // return view('home',compact('branches','newPatients','todayCash','todayOnline','totalDues','todayCashExp','todayOnlineExp','todayRefund','netCashToday'));
    }
  
public function discontinued(Request $request)
{
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();

        $query = DB::table('patients as p')
            ->join('schedules as s', 's.patient_id', '=', 'p.id')
            ->select('p.id', 'p.name', 'p.mobile', DB::raw('MAX(s.AttendedAt) as last_attended')) // adjust columns
            ->groupBy('p.id', 'p.name', 'p.mobile');
            
        $dateFilter = $request->dateFilter;
        if(isset($request->branchFilter) && ($request->branchFilter != null)){
            $query->where('s.branch_id', $request->branchFilter);

        }else{
            $query->whereIn('s.branch_id', $branchIds);
        }

        if(isset($request->dateFilter) && ($request->dateFilter != null)){
            $dates = explode(' - ',$request->dateFilter);
            $startDate =  Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
            $endDate =  Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');

            $query->havingBetween('last_attended', [$startDate, $endDate]);

        }else{
            $startDate = '2022-01-01';
            $endDate = '2022-03-31';
            $query->havingBetween('last_attended', [$startDate, $endDate]);

        }


        $patients = $query->latest('last_attended')->paginate(100);
        // return  $collections;
        return view('reports.discontinuedPatients',compact('patients','branches'));

}
  
    public function crProfit(){
        return view('admin.cr_profit');
    }

    public function profit(Request $request){
        $from = $request['from'];
        $upto = $request['upto'];
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime($upto) );

        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');
        $collections = Collection::whereBetween('date', [$start, $to])->get();
        $expenses = Expense::whereBetween('date', [$start, $to])->get();
        return view('admin.profit',compact('collections','expenses'));
    }

    public function listPatients(){
        return view('super.create');
    }
    public function listPatientsResult(Request $request){
        $from = $request['from'];
        $upto = $request['upto'];
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime($upto) );
        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');

        $patients = Patient::where('status',null)->whereBetween('date', [$start, $to])->orderBy('date', 'asc')->get();

        return view('super.hidePatients',compact('patients'));
    }

    public function hidePatientsList(Request $request){
        //return $request->all();
        //$pid = array();
        $pIds = $request->input('patient_id');
        foreach($pIds as $pid){
            $patient = Patient::find($pid);
            $patient->status = 1;
            $patient->save();
        }
        return redirect()->route('hiddenPatientsLists');
    }

    public function hiddenPatientsLists(){
        $patients = Patient::where('status',1)->latest()->paginate(10);
        return view('super.hiddenPatients',compact('patients'));

    }

    public function duesDetails()
    {
        $branchesId = loggedUser()->branches->pluck('id')->toArray();
        $patients =  Patient::whereHas('branches', function ($q)use($branchesId) {
            $q->whereIn('branches.id', $branchesId);
        })->get();
        return view('reports.duesDetails',compact('patients'));
    }
    public function cashToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $collections =  Collection::where('mode_id',1)->whereDate('collectionDate',Carbon::today())->whereIn('branch_id', $brachesId)->get();
        return view('reports.cashToday',compact('collections'));
    }
    public function onlineToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $collections =  Collection::where('mode_id',2)->whereDate('collectionDate',Carbon::today())->whereIn('branch_id', $brachesId)->get();
        return view('reports.onlineToday',compact('collections'));
    }
    public function patientToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $newPatients = Patient::whereDate('created_at',Carbon::today())->whereHas('branches', function ($q)use($brachesId) {
            $q->whereIn('branches.id', $brachesId);
        })->get();
        return view('reports.patientToday',compact('newPatients'));
    }
    public function cashExpensesToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $todayCashExps = Expense::where('mode_id',1)->whereDate('date',Carbon::today())->whereIn('branch_id', $brachesId)->get();
        return view('reports.cashExpensesToday',compact('todayCashExps'));
    }
    public function onlineExpensesToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $todayOnlineExps = Expense::where('mode_id',2)->whereDate('date',Carbon::today())->whereIn('branch_id', $brachesId)->get();
        return view('reports.onlineExpensesToday',compact('todayOnlineExps'));
    }
    public function totalExpensesToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $todayExps = Expense::whereDate('created_at',Carbon::today())->whereIn('branch_id', $brachesId)->get();
        return view('reports.totalExpensesToday',compact('todayExps'));
    }
    public function refundToday()
    {
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $todayRefunds = Collection::where('refund','=!',null)->whereDate('created_at',Carbon::today())->whereIn('branch_id', $brachesId)->get();
        return view('reports.refundToday',compact('todayRefunds'));
    }
    public function netCashToday()
    {
        $branchesId = loggedUser()->branches->pluck('id')->toArray();
        $collections = Collection::where('mode_id',1)->whereDate('collectionDate',Carbon::today())->whereIn('branch_id', $branchesId)->get();
        $todayCashRefund = Collection::where('mode_id',1)->whereDate('created_at',Carbon::today())->whereIn('branch_id', $branchesId)->sum('refund');
        $todayExps = Expense::where('mode_id',1)->whereDate('created_at',Carbon::today())->whereIn('branch_id', $branchesId)->get();
        return view('reports.netCashToday',compact('collections','todayExps','todayCashRefund'));
    }


    public function todayBranchDetails($id)
    {
        $branch = Branch::where('id',$id)->first();
        $dateTm = Carbon::now()->format(' D d M y H:i A');
        $todayCashCollections = Collection::where('mode_id',1)->whereDate('collectionDate',Carbon::today())->where('branch_id', $branch->id)->sum('amount');
        $todayOnlineCollections = Collection::where('mode_id',2)->whereDate('collectionDate',Carbon::today())->where('branch_id', $branch->id)->sum('amount');
        $todayCashRefund = Collection::where('refund','!=',null)->where('mode_id',1)->whereDate('created_at',Carbon::today())->where('branch_id', $branch->id)->sum('refund');
        $todayOnlineRefund = Collection::where('refund','!=',null)->where('mode_id',2)->whereDate('created_at',Carbon::today())->where('branch_id', $branch->id)->sum('refund');
        $todayCashExps = Expense::where('mode_id',1)->whereDate('date',Carbon::today())->where('branch_id', $branch->id)->sum('amount');
        $todayOnlineExps = Expense::where('mode_id',2)->whereDate('date',Carbon::today())->where('branch_id', $branch->id)->sum('amount');
        $collections = Collection::whereDate('collectionDate',Carbon::today())->where('refund','=',null)->where('branch_id', $branch->id)->get();
        $refunds = Collection::whereDate('created_at',Carbon::today())->where('refund','!=',null)->where('branch_id', $branch->id)->get();
        $expenses = Expense::whereDate('date',Carbon::today())->where('branch_id', $branch->id)->get();
        $serviceTypes = ServiceType::with(['collections'=> function($query) use($branch) {
            $query->where('branch_id', $branch->id);
            $query->whereDate('collectionDate',Carbon::today());
        }])->get();
        $paymentModes = Mode::with(['collections'=> function($query) use($branch) {
            $query->where('branch_id', $branch->id);
            $query->whereDate('collectionDate',Carbon::today());
        }])->get();
        $expenseModes = Mode::with(['expenses'=> function($query) use($branch) {
            $query->where('branch_id', $branch->id);
            $query->whereDate('date',Carbon::today());
        }])->get();

        return view('reports.todayBranchDetails',compact('collections','expenses','todayCashCollections','todayOnlineCollections','todayCashRefund','todayOnlineRefund','todayCashExps','todayOnlineExps','serviceTypes','paymentModes','expenseModes','refunds','dateTm','branch'));
    }
    
  	public function serviceDetail($id)
    {
        $service = ServiceType::where('id',$id)->first();
        $branchesId = loggedUser()->branches->pluck('id')->toArray();
        $collections = Collection::whereDate('collectionDate',Carbon::today())->where('service_type_id', $service->id)->whereIn('branch_id', $branchesId)->get();
        return view('reports.serviceDetails',compact('collections','service'));

    }
      public function collectionDetail($id)
    {
                $branches = loggedUser()->branches;
        // return $branches;
        $branchesId = loggedUser()->branches->pluck('id')->toArray();
        $paymentMode = Mode::where('id',$id)->first();
        $collections = Collection::whereIn('branch_id',$branchesId)->whereDate('collectionDate',Carbon::today())->where('mode_id', $paymentMode->id)->get();
        return view('reports.collectionDetail',compact('collections','paymentMode'));


    }

    public function customDailyReport(Request $request)
    {
        //return Carbon::today();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $branch = Branch::where('id',$request->branchFilter)->first();
        $branchFilter = $request->branchFilter;
        $dateFilter = $request->dateFilter;
        if(isset($request->dateFilter) && ($request->dateFilter != null)){
            $dateFilter = Carbon::createFromFormat('d/m/Y', $request->dateFilter,'UTC')->startOfDay();

            $todayCashCollections = Collection::where('mode_id',1)->whereDate('collectionDate',$dateFilter)->whereIn('branch_id', $branchFilter)->sum('amount');
            $todayOnlineCollections = Collection::where('mode_id',2)->whereDate('collectionDate',$dateFilter)->whereIn('branch_id', $branchFilter)->sum('amount');
            $todayCashRefund = Collection::where('refund','!=',null)->where('mode_id',1)->whereDate('collectionDate',$dateFilter)->whereIn('branch_id', $branchFilter)->sum('refund');
            $todayOnlineRefund = Collection::where('refund','!=',null)->where('mode_id',2)->whereDate('collectionDate',$dateFilter)->whereIn('branch_id', $branchFilter)->sum('refund');
            $todayCashExps = Expense::where('mode_id',1)->whereDate('created_at',$dateFilter)->whereIn('branch_id', $branchFilter)->sum('amount');
            $todayOnlineExps = Expense::where('mode_id',2)->whereDate('created_at',$dateFilter)->whereIn('branch_id', $branchFilter)->sum('amount');
            $collections = Collection::whereDate('collectionDate',$dateFilter)->where('refund','=',null)->whereIn('branch_id', $branchFilter)->get();
            $refunds = Collection::whereDate('collectionDate',$dateFilter)->where('refund','!=',null)->whereIn('branch_id', $branchFilter)->get();
            $expenses = Expense::whereDate('created_at',$dateFilter)->whereIn('branch_id', $branchFilter)->get();
            $serviceTypes = ServiceType::with(['collections'=> function($query) use($branchFilter,$dateFilter) {
                $query->whereIn('branch_id', $branchFilter);
                $query->whereDate('collectionDate',$dateFilter);
            }])->get();
            $paymentModes = Mode::with(['collections'=> function($query) use($branchFilter,$dateFilter) {
                $query->whereIn('branch_id', $branchFilter);
                $query->whereDate('collectionDate',$dateFilter);
            }])->get();
            $expenseModes = Mode::with(['expenses'=> function($query) use($branchFilter,$dateFilter) {
                $query->whereIn('branch_id', $branchFilter);
                $query->whereDate('created_at',$dateFilter);
            }])->get();
            return view('reports.customDailyReport',compact('collections','branches','branchFilter','expenses','todayCashCollections','todayOnlineCollections','todayCashRefund','todayOnlineRefund','todayCashExps','todayOnlineExps','serviceTypes','paymentModes','expenseModes','refunds','dateFilter'));

        }

        return view('reports.customDailyReport',compact('branches','branchFilter'));
    }
  
      public function rangeDailyReport(Request $request)
    {
        //return Carbon::today();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $branch = Branch::where('id',$request->branchFilter)->first();
        $branchFilter = $request->branchFilter;
        $dateFilter = $request->dateFilter;
        if(isset($request->dateFilter) && ($request->dateFilter != null)){
            $dates = explode(' - ',$request->dateFilter);
            $startDate =  Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay();
            $endDate =  Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay();
         // return $startDate.'<br/>'.$endDate;
            $dateRange = [$startDate,$endDate];
            $todayCashCollections = Collection::where('mode_id',1)->whereBetween('collectionDate',$dateRange)->where('branch_id', $branch->id)->sum('amount');
            $todayOnlineCollections = Collection::where('mode_id',2)->whereBetween('collectionDate',$dateRange)->where('branch_id', $branch->id)->sum('amount');
            $todayCashRefund = Collection::where('refund','!=',null)->where('mode_id',1)->whereBetween('collectionDate',$dateRange)->where('branch_id', $branch->id)->sum('refund');
            $todayOnlineRefund = Collection::where('refund','!=',null)->where('mode_id',2)->whereBetween('collectionDate',$dateRange)->where('branch_id', $branch->id)->sum('refund');
            $todayCashExps = Expense::where('mode_id',1)->whereBetween('created_at',$dateRange)->where('branch_id', $branch->id)->sum('amount');
            $todayOnlineExps = Expense::where('mode_id',2)->whereBetween('created_at',$dateRange)->where('branch_id', $branch->id)->sum('amount');
            $collections = Collection::whereBetween('collectionDate',$dateRange)->where('refund','=',null)->where('branch_id', $branch->id)->get();
            $refunds = Collection::whereBetween('collectionDate',$dateRange)->where('refund','!=',null)->where('branch_id', $branch->id)->get();
            $expenses = Expense::whereBetween('created_at',$dateRange)->where('branch_id', $branch->id)->get();
            $serviceTypes = ServiceType::with(['collections'=> function($query) use($branch,$dateRange) {
                $query->where('branch_id', $branch->id);
                $query->whereBetween('collectionDate',$dateRange);
            }])->get();
            $paymentModes = Mode::with(['collections'=> function($query) use($branch,$dateRange) {
                $query->where('branch_id', $branch->id);
                $query->whereBetween('collectionDate',$dateRange);
            }])->get();
            $expenseModes = Mode::with(['expenses'=> function($query) use($branch,$dateRange) {
                $query->where('branch_id', $branch->id);
                $query->whereBetween('created_at',$dateRange);
            }])->get();
            return view('reports.rangeDailyReport',compact('collections','branches','branchFilter','expenses','todayCashCollections','todayOnlineCollections','todayCashRefund','todayOnlineRefund','todayCashExps','todayOnlineExps','serviceTypes','paymentModes','expenseModes','refunds','dateFilter'));

        }

        return view('reports.rangeDailyReport',compact('branches','branchFilter'));
    }


}
