<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Mode;
use App\Models\Patient;
use App\Models\ServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:DueReport', ['only'=>['dueReport']]);
        $this->middleware('permission:DueReportCustom', ['only'=>['dueReportCustom']]);

    }

    public function dueReport(Request $request){
        // return $request->all();
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $branchesId = loggedUser()->branches->pluck('id')->toArray();
//        $patients =  Patient::whereHas('branches', function ($q)use($branchesId) {
//            $q->whereIn('branches.id', $branchesId);
//        })->get();

        $query = Patient::query();
        $branchFilter = $request->branchFilter ;
        $dateFilter = $request->dateFilter;
        if(isset($request->branchFilter) && ($request->branchFilter != null)){
            $query->whereHas('branches',function($q) use($request){
                $q->where('branches.id',$request->branchFilter);
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

        $patients = $query->get();

        // return  $collections;
        return view('reports.dueReport',compact('patients','branches','branchFilter','dateFilter'));
    }
    public function dueReportCustom(Request $request){
        // return $request->all();
        // $endDate =  ;

        // return $startDate . '<br/>' . $endDate . '<br/>';
        $branchIds = loggedUser()->branches->pluck('id')->toArray();
        $branches = Branch::whereIn('id',$branchIds)->get();
        $modes = Mode::all();
        $serviceTypes = ServiceType::all();

        $query = Collection::query();
        $dateFilter = $request->dateFilter;
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
        if(isset($request->dateFilter) && ($request->dateFilter != null)){
            $dates = explode(' - ',$request->dateFilter);
            $startDate =  Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
            $endDate =  Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');

            $query->whereDate('created_at','>=',$startDate)
                ->whereDate('created_at','<=',$endDate);
        }

        $collections = $query->get();

        // return  $collections;
        return view('reports.dueReportCustom',compact('collections','branches','modes','serviceTypes'));
    }

}
