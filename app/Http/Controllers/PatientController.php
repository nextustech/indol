<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Image;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:list-Patient', ['only'=>['index']]);
        $this->middleware('permission:show-PatientProfile', ['only'=>['show']]);
        $this->middleware('permission:edit-PatientProfile', ['only'=>['edit']]);
        $this->middleware('permission:update-PatientProfile', ['only'=>['update']]);
        $this->middleware('permission:delete-PatientProfile', ['only'=>['destroy']]);
        $this->middleware('permission:getChangeBranch', ['only'=>['getChangeBranch']]);
        $this->middleware('permission:changeBranch', ['only'=>['changeBranch']]);


    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = loggedUser();

        $brnches = $user->branches;
        $branchIds = $brnches->pluck('id');

        $patients = Patient::query()
            ->with('branches')

            // ✅ Restrict to user's branches
            ->whereHas('branches', function ($q) use ($branchIds) {
                $q->whereIn('branches.id', $branchIds);
            });

        // -----------------------
        // 🔐 ACCESS CONTROL
        // -----------------------
        if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
            $patients->where('created_by', $user->id);
        }

        // -----------------------
        // 🏢 BRANCH FILTER
        // -----------------------
        if ($request->filled('branch_id')) {
            $patients->whereHas('branches', function ($q) use ($request) {
                $q->where('branches.id', $request->branch_id);
            });
        }

        // -----------------------
        // 📅 DATE RANGE FILTER
        // -----------------------
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $patients->whereBetween('date', [
                $request->date_from . " 00:00:00",
                $request->date_to . " 23:59:59"
            ]);
        }

        // -----------------------
        // 🚀 FINAL RESULT
        // -----------------------
        $patients = $patients
            ->orderByDesc('date')
            ->paginate(20);

        return view('patients.index', compact('patients', 'brnches'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    // public function show(Patient $patient)
    // {
    //     $now = Carbon::now();
    //     $dt = Carbon::createFromFormat('Y-m-d H', $now->toDateString().'00')->toDateTimeString();
    //     $active = Payment::where('patient_id',$patient->id)->where('active',1)->first();
    //     if($active){
    //             if($active->pakage_id  != null){
    //             $schedules = Schedule::where('patient_id',$patient->id)->where('pakage_id',$active->pakage_id)->where('payment_id',$active->id)->orderBy('sittingDate', 'asc')->orderBy('visit_order','asc')->get();
    //         }elseif($active->pakage_id == null){
    //             $schedules = Schedule::where('patient_id',$patient->id)->where('payment_id',$active->id)->orderBy('sittingDate', 'asc')->orderBy('visit_order','asc')->get();
    //         }else{
    //             $schedules = null;
    //         }
    //         $attendedSittings = Schedule::where('patient_id',$patient->id)->where('payment_id',$active->id)->whereNotNull('attendedAt')->count();

    //     }
    //     else{
    //         $schedules = null;
    //         $attendedSittings = NULL;
    //     }
    //     // return $schedules;
    //   $productImages = Image::where('patient_id',$patient->id)->get();

    //     return view('patients.show',compact('patient','dt','schedules','active','attendedSittings','productImages'));

    //    // return view('patients.show', compact('patient'));
    // }

    public function show(Patient $patient)
{
    $user = loggedUser();

    // -----------------------
    // 🔐 ACCESS CONTROL (IMPORTANT)
    // -----------------------
        if ($user->roles->pluck('name')->contains('HomePhysiotherapist')
            && $patient->created_by !== $user->id) {

            abort(403, 'Unauthorized access');
        }
    // -----------------------
    // 📅 CURRENT DATE START
    // -----------------------
    $dt = now()->startOfDay();

    // -----------------------
    // 💳 ACTIVE PAYMENT
    // -----------------------
    $active = Payment::where('patient_id', $patient->id)
        ->where('active', 1)
        ->latest()
        ->first();

    $schedules = collect(); // default empty collection
    $attendedSittings = 0;

    if ($active) {

        // -----------------------
        // 📅 SCHEDULE QUERY (optimized)
        // -----------------------
        $scheduleQuery = Schedule::where('patient_id', $patient->id)
            ->where('payment_id', $active->id);

        if (!empty($active->pakage_id)) {
            $scheduleQuery->where('pakage_id', $active->pakage_id);
        }

        $schedules = $scheduleQuery
            ->orderBy('sittingDate')
            ->orderBy('visit_order')
            ->get();

        // -----------------------
        // ✅ ATTENDED COUNT (no duplicate base query)
        // -----------------------
        $attendedSittings = (clone $scheduleQuery)
            ->whereNotNull('attendedAt')
            ->count();
    }

    // -----------------------
    // 🖼️ IMAGES
    // -----------------------
    $productImages = Image::where('patient_id', $patient->id)->get();

    return view('patients.show', compact(
        'patient',
        'dt',
        'schedules',
        'active',
        'attendedSittings',
        'productImages'
    ));
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit',compact('patient',));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
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

        if($request->hasFile('file')){
            $image = $request->file('file');
            $request['image'] = time().'-'.$image->getClientOriginalName();
            $destinationPath = public_path('/images/patients/');
            $image->move($destinationPath, $request['image']);
            $request['image'] = 'images/patients/'.$request['image'];
        }else{
            $request['image'] = $patient->image;
        }

        if($patient->update($request->all())){
            return redirect()->route('patients.index')->with('message','Patient Successfully Updated');
        }else{
            return'Sorry Something Went Wrong';
        }

    }

    public function Schedule(Patient $patient){
        $now = Carbon::now();
        $dt = Carbon::createFromFormat('Y-m-d H', $now->toDateString().'00')->toDateTimeString();
        $active = Payment::where('patient_id',$patient->id)->where('active',1)->first();
        if($active){
                if($active->pakage_id  != null){
                $schedules = Schedule::where('patient_id',$patient->id)->where('pakage_id',$active->pakage_id)->where('payment_id',$active->id)->orderBy('sittingDate','asc')->orderBy('visit_order','asc')->get();
                $visits = $schedules->count();
            }elseif($active->pakage_id == null){
                $schedules = Schedule::where('patient_id',$patient->id)->where('payment_id',$active->id)->orderBy('sittingDate','asc')->orderBy('visit_order','asc')->get();
                $visits = $schedules->count();
            }else{
                $schedules = null;
            }

        }
        else{
            $schedules = null;
        }
        // return $schedules;

        $branch = $patient->branches()->first();
        return view('schedules.show',compact('patient','dt','schedules','active','visits','branch'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        Patient::destroy($patient->id);
        return redirect()->route('patients.index')->with('message','Deleted Successfully');
    }


    public function cr(){
        return view('patients.search');
    }
    public function search(Request $request){
        if($request->ajax()){
            $user = Auth::user();
            $Output = "";
            $patient = Patient::where('name','LIKE','%'.$request->search.'%')
                ->orWhere('phone','LIKE','%'.$request->search.'%')
                ->orWhere('mobile','LIKE','%'.$request->search.'%')
                ->orWhere('patientId','LIKE','%'.$request->search.'%')
                ->get();
            if($patient){
                foreach( $patient as $k => $c ){
                    $dt = $c->created_at;
                    $date = $dt->format('m/y');
                    $Output .= '<tr>'.

                        '<td >' .'GPC-'.$c->patientId.$date.'</td>'.
                        '<td>'.$c-> name.'</td>'.
                        '<td>'.$c-> age .'</td>'.
                        '<td>'.$c-> mobile.'</td>'.
                        '<td><a href="'.route('patients.show',['id' => $c->id]).'" class="btn btn-success btn-sm">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                            <a href="'.route('patients.edit',['id' => $c->id]).'" class="btn btn-warning btn-sm">
                                                                <i class="fa fa-pencil"></i>
                                                            </a></td>'.
                        '</tr>';
                }
            }else{
                $Output .= '<tr>'.
                    '<td>No Record Found</td>'.
                    '</tr>';
            }
            return Response($Output);

        }
    }

public function searchP(Request $request)
{
    $branchIds = loggedUser()->branches->pluck('id')->toArray();

    $patients = Patient::whereHas('branches', function ($q) use ($branchIds) {
        $q->whereIn('branches.id', $branchIds);
    })
    ->when($request->type == 1, function ($q) use ($request) {
        $q->where('name', 'LIKE', '%' . $request->search . '%');
    })
    ->when($request->type == 2, function ($q) use ($request) {
        $q->where(function ($sub) use ($request) {
            $sub->where('phone', $request->search)
                ->orWhere('mobile', $request->search);
        });
    })
    ->when($request->type != 1 && $request->type != 2, function ($q) use ($request) {
        $q->where('patientId', $request->search);
    })
    ->get();

    return view('patients.results', compact('patients'));
}

    public function hidePatient(Request $request, Patient $patient){

        $patient = Patient::find($patient->id);
        $patient->status = $request->status;
        $patient->save();
        if ($request->ajax()){
            return ['success'=>1, 'msg'=>trans('Settings were saved successfully')];
        }
        return redirect()->back();
    }

    public function hiddenPatients(){
        $patients = Patient::where('status',1)->latest()->paginate(10);
        return view('patients.index',compact('patients'));
    }

    public function searchPatientByReg(){
        return view('patients.searchPatientByReg');
    }

    Public function searchPatientByRegDate(Request $request){
        $from = $request['from'];
        $upto = $request['upto'];
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime($upto) );
        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');
      	$brachesId = loggedUser()->branches->pluck('id')->toArray();
       //$user = Auth::user();
//        if(Auth::user()->role == 1 && Auth::user()->super == Null){
//            $patients = Patient::where('branch_id',$user->branch_id )->whereBetween('date', [$start, $to])->orderBy('date', 'asc')->get();
//        }elseif(Auth::user()->role ==2 && Auth::user()->super == Null ){
//            $patients = Patient::where('branch_id',$user->branch_id )->whereBetween('date', [$start, $to])->orderBy('date', 'asc')->get();
//        }elseif( Auth::user()->super == 1 ){
//            $patients = Patient::whereBetween('date', [$start, $to])->orderBy('date', 'asc')->get();
//
//        }
       // $patients = Patient::whereBetween('date', [$start, $to])->orderBy('date', 'asc')->get();
        $patients = Patient::whereBetween('date', [$start, $to])->whereHas('branches', function ($q)use($brachesId) {
            $q->whereIn('branches.id', $brachesId);
        })->get();
        return view('patients.searchPatientByRegDate',compact('patients'));
    }

    Public function todaysPatient(){
        $from = Carbon::now();
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime(Carbon::now()) );
        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');

        $Schedule = Schedule::whereBetween('attendedAt', [$start, $to])->orderBy('attendedAt', 'asc')->get();

        return view('patients.todaysPatient',compact('Schedule'));
    }

    public function getChangeBranch($id)
    {
        $patient = Patient::findOrfail($id);
        $branches = Branch::all();
        return view('patients.changeBranch',compact('patient','branches'));

    }

  	public function changeBranch(Request $request){
        $patient = Patient::findOrFail($request->patient_id);
        $branch = Branch::findOrFail($request->branch_id);
        if($request->type == 1){
            $patient->branches()->sync($branch->id);

        }elseif ($request->type == 2 ){
            $patient->branches()->sync($branch->id);
            $payment = Payment::where('patient_id',$patient->id)->where('active',1)->first();
            Payment::where('id',$payment->id)->update(['branch_id' => $branch->id]);
            Collection::where('patient_id',$patient->id)->where('payment_id',$payment->id)->update(['branch_id' => $branch->id]);
            Schedule::where('patient_id',$patient->id)->where('payment_id',$payment->id)->update(['branch_id' => $branch->id]);
        }elseif ($request->type == 3 ){
            $patient->branches()->sync($branch->id);
            Payment::where('patient_id',$patient->id)->update(['branch_id' => $branch->id]);
            Collection::where('patient_id',$patient->id)->update(['branch_id' => $branch->id]);
            Schedule::where('patient_id',$patient->id)->update(['branch_id' => $branch->id]);

        }
        return redirect()->back()->with('message','Done Successfully');
    }

}
