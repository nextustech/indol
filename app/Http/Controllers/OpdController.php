<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ServiceType;
use Carbon\Carbon;
use App\Services\SittingScheduler;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class OpdController extends Controller
{
      public function __construct()
    {
        $this->middleware('permission:Opd-Registration', ['only'=>['create']]);

    }
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
        $user = Auth::user();
        $patients = Patient::all();
        $branches =  $user->branches->pluck('id')->toArray();

        $patients = branch::with('patients')->whereIn('id',$branches)->get();

            $patients = Patient::all();
            $patientId = Patient::max('patientId')+1;
            return view('opd.create',compact('patients','patientId','user'));
    }

    public function oldOpd()
    {
        $user = Auth::user();
        $brachesId = loggedUser()->branches->pluck('id')->toArray();
       // $patients = Patient::all();
        $branches =  $user->branches->pluck('id')->toArray();

       // $patients = branch::with('patients')->whereIn('id',$branches)->get();
        $patients = Patient::whereHas('branches', function ($q)use($brachesId) {
            $q->whereIn('branches.id', $brachesId);
        })->get();

           // $patients = Patient::all();
        $patientId = Patient::max('patientId')+1;
        return view('opd.oldOpd',compact('patients','patientId','user'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // return $request->all();
        if($request['dob']!= null){
            $dt = date("Y-m-d", strtotime($request['dob']) );
            // $dt = $dt->toDateTimeString();
            $request['dob'] = Carbon::createFromFormat('Y-m-d',$dt);
            $request['age'] = Carbon::parse($request['dob'])->age;
        }

        $rules =  [
            'name'=>'required',
            'age'=>'required|integer',
            'amount'=>'required',
            'mobile'=>'required|unique:patients',
            'branch_id'=>'required',
        ];
        $messages =    [
            'name.required' => 'Please Enter Patient Name',
            'age.required' => 'Patient Age Can not be blank',
            'age.integer' => 'Patient Age ',
            'amount.required' => 'Please Enter Amount',
            'mobile.required' => 'Patient Mobile No. Not Available',
            'mobile.unique' => 'Patient Already Exists With This Mobile No.',
            'branch_id.required' => 'Please Select Branch',
        ];

        $this->validate($request, $rules, $messages);

        if($request['paid'] == 1){
            if($request['PaidAmount'] != null){
                $PaidAmount = $request['PaidAmount'];
            }else{
                $PaidAmount = $request['amount'];
            }
        }else{
            $PaidAmount = 0;
        }
        if($request['address'] == null){
            $request['address'] = 'N.A';
        }
        if($request['from']!= null){
            $dt = date("Y-m-d", strtotime($request['from']) );
            $tm = $request['time'];
            $dte = date('Y-m-d h:i:s A', strtotime("$dt $tm"));
            // $dt = $dt->toDateTimeString();
            $request['from'] = Carbon::createFromFormat('Y-m-d H:i:s a',$dte);
            // $request['from'] = date('Y-m-d H:i:s A', strtotime("$dt $tm"));
            // return  $request['from'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            //  return $date;
        }
        if($request['dob']!= null){
            $dt = date("Y-m-d", strtotime($request['dob']) );
            // $dt = $dt->toDateTimeString();
            $request['dob'] = Carbon::createFromFormat('Y-m-d',$dt);
        }
        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
        }else{
            $request['date'] = Carbon::now();
        }


        // return $request['date'];
        $dailyVisits = $request['dailyVisits'];
        $satDefault = $dailyVisits > 0 ? max(0, $dailyVisits - 1) : 0;
        $satSittings = $request->input('saturday_sittings');
        $satSittings = ($satSittings !== null && $satSittings !== '') ? (int) $satSittings : $satDefault;
        $sunSittings = $request->input('sunday_sittings');
        $sunSittings = ($sunSittings !== null && $sunSittings !== '') ? (int) $sunSittings : 0;
        $totalSessions = $request->input('total_sessions');
        $totalSessions = ($totalSessions !== null && $totalSessions !== '') ? (int) $totalSessions : null;
        $request['name'] = ucwords($request['name']);
        $patientId = Patient::max('patientId');
        $pId = ($patientId)+1;
        $patId = str_pad($pId, 4, '0', STR_PAD_LEFT);
        $request['patientId'] = $patId;
        if( $request->hasFile('file')){
            $image = $request->file('file');
            $request['image'] = time().'-'.$image->getClientOriginalName();
            $destinationPath = public_path('/images/patients/');
            $image->move($destinationPath, $request['image']);
            $request['image'] = 'images/patients/'.$request['image'];
        }else{
            $request['image'] = 'images/patients/package.png';
        }
        if(!$request['title']){
            $request['title'] = 'OPD / Consultation';
        }
        $days = $request['days'];
        $userId = Auth::id();
        $type = $request['service_type_id'];
        $patient = Patient::create($request->except('branch_id'));
        $branch_id = $request['branch_id'];
        $patient->branches()->attach($branch_id);

        if($request['ptype'] == 1){
            if($patient){
                $payment = new Payment();
                $payment->user_id = $userId;
                $payment->patient_id = $patient->id;
                $payment->branch_id = $branch_id;
                $payment->title = $request['title'];
                $payment->amount = $request['amount'];
                $payment->date = $request['date'];
                $payment->duration = $request['days'];
				$payment->perDaySittings = $request['dailyVisits'];
                $payment->total_sessions = $totalSessions;
                $payment->saturday_sittings = $satSittings;
                $payment->sunday_sittings = $sunSittings;
                $payment->active = 1;
                $payment->service_type_id = $type;
                $payment->save();
            }
            $schedule = new Schedule();
            $schedule->user_id = $userId;
            $schedule->branch_id = $branch_id;
            $schedule->patient_id = $patient->id;
            $schedule->payment_id = $payment->id;
            $schedule->title = 'Sitting 1';
            $schedule->sittingDate = $request['date'];
            $schedule->attendedAt = $request['date'];
            $schedule->save();

        }else{
            if($patient){
                $payment = new Payment();
                $payment->user_id = $userId;
                $payment->patient_id = $patient->id;
                $payment->branch_id = $branch_id;
                $payment->title = $request['title'];
                $payment->amount = $request['amount'];
                $payment->date = $request['date'];
                $payment->duration = $request['days'];
                $payment->perDaySittings = $request['dailyVisits'];
                $payment->total_sessions = $totalSessions;
                $payment->saturday_sittings = $satSittings;
                $payment->sunday_sittings = $sunSittings;
                $payment->active = 1;
                $payment->service_type_id = $type;
                $payment->save();

                if($payment){
                    $collection = new Collection();
                    $collection->user_id = $userId;
                    $collection->patient_id = $patient->id;
                    $collection->service_type_id = $request['service_type_id'];
                    $collection->branch_id = $branch_id;
                    $collection->payment_id = $payment->id;
                    $collection->amount = $PaidAmount;
                    $collection->discount = $request['discount'];
                    $collection->collectionDate = $request['date'];
                    $collection->mode_id = $request['cash'];
					$collection->paymentNote = $request['paymentNote'];
                    $collection->save();
                }

                if ($request['schedule'] == 'dt') {
                    $rules = [
                        Carbon::SATURDAY => $satSittings,
                        Carbon::SUNDAY => $sunSittings,
                    ];

                    $start = $request['from'];

                    if ($dailyVisits > 0) {
                        $items = SittingScheduler::generateSittings($start, (int)$days, (int)$dailyVisits, ['weekendRules' => $rules, 'totalSessions' => $totalSessions]);
                        foreach ($items as $idx => $item) {
                            $schedule = new Schedule();
                            $schedule->user_id = $userId;
                            $schedule->branch_id = $branch_id;
                            $schedule->payment_id = $payment->id;
                            $schedule->patient_id = $patient->id;
                            $schedule->visit_order = $idx + 1;
                            $schedule->title = 'Visit ' . ($idx + 1);
                            $schedule->sittingDate = $item['date'];
                            $schedule->attendedAt = null;
                            $schedule->save();
                        }
                    } else {
                        $items = SittingScheduler::generateSittings($start, (int)$days, 1, ['weekendRules' => $rules, 'totalSessions' => $totalSessions]);
                        foreach ($items as $i => $item) {
                            $schedule = new Schedule();
                            $schedule->user_id = $userId;
                            $schedule->branch_id = $branch_id;
                            $schedule->payment_id = $payment->id;
                            $schedule->patient_id = $patient->id;
                            $schedule->visit_order = $i + 1;
                            $schedule->title = 'Sitting ' . ($i + 1);
                            $schedule->no = $i + 1;
                            $schedule->sittingDate = $item['date'];
                            $schedule->attendedAt = null;
                            $schedule->save();
                        }
                    }
                } else {
                    $schedule = new Schedule();
                    $schedule->user_id = $userId;
                    $schedule->branch_id = $branch_id;
                    $schedule->patient_id = $patient->id;
                    $schedule->payment_id = $payment->id;
                    $schedule->title = 'OPD / Consultation ';
                    $schedule->sittingDate = $request['date'];
                    $schedule->attendedAt = $request['date'];
                    $schedule->save();
                }
                // return redirect()->route('collectionPrint',['id'=>$collection->id])->with('message','Patient Successfully Registered');
                return redirect()->route('patients.show',$patient->id);

            }else{
                return'Sorry Something Went Wrong';
            }

        }

        return redirect()->route('patients.show',['id'=>$patient->id]);

    }

    /**
     * Display the specified resource.
     */
    public function old(Request $request){

        $userId = Auth::id();
        if($request['paid'] == 1){
            if($request['PaidAmount'] != null){
                $PaidAmount = $request['PaidAmount'];
            }else{
                $PaidAmount = $request['amount'];
            }
        }else{
            $PaidAmount = 0;
        }

        if($request['from']!= null){
            $dt = date("Y-m-d", strtotime($request['from']) );
            // $dt = $dt->toDateTimeString();
            $request['from'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
        }else{
            $request['from'] = Carbon::now();

        }
        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
        }else{
            $request['date'] = Carbon::now();
        }
        if(!$request['title']){
            $request['title'] = 'OPD / Consultation';
        }


        $dailyVisits = $request['dailyVisits'];
        $satDefault = $dailyVisits > 0 ? max(0, $dailyVisits - 1) : 0;
        $satSittings = $request->input('saturday_sittings');
        $satSittings = ($satSittings !== null && $satSittings !== '') ? (int) $satSittings : $satDefault;
        $sunSittings = $request->input('sunday_sittings');
        $sunSittings = ($sunSittings !== null && $sunSittings !== '') ? (int) $sunSittings : 0;
        $totalSessions = $request->input('total_sessions');
        $totalSessions = ($totalSessions !== null && $totalSessions !== '') ? (int) $totalSessions : null;

        $patient_id = $request['patient_id'];
        $patient = Patient::findOrFail($request['patient_id']);
        $branch_id = Payment::where('patient_id',$patient->id)->pluck('branch_id')->first();
       // return $branch_id;
        $type = $request['ptype'];
        if($request['ptype'] == 1){
            if($request['patient_id']){
                $payment = new Payment();
                $payment->user_id = $userId;
                $payment->patient_id = $patient_id;
                $payment->branch_id = $branch_id;
                $payment->service_type_id = $request['service_type_id'];
                $payment->title = $request['title'];
                $payment->amount = $request['amount'];
                $payment->date = $request['date'];
                $payment->duration = $request['days'];
                $payment->perDaySittings = $request['dailyVisits'];
                $payment->total_sessions = $totalSessions;
                $payment->saturday_sittings = $satSittings;
                $payment->sunday_sittings = $sunSittings;
                $payment->type = $type;
                $payment->save();
            }
            $schedule = new Schedule();
            $schedule->user_id = $userId;
            $schedule->branch_id = $branch_id;
            $schedule->patient_id = $patient_id;
            $schedule->payment_id = $payment->id;
            $schedule->title = 'Sitting 1';
            $schedule->sittingDate = $request['date'];
            $schedule->attendedAt = $request['date'];
            $schedule->save();

            return redirect()->route('patients.show',['id'=>$request['patient_id']]);
        }else{
            if($request['patient_id']){
                $payment = new Payment();
                $payment->user_id = $userId;
                $payment->patient_id = $request['patient_id'];
                $payment->service_type_id = $request['service_type_id'];
                $payment->branch_id = $branch_id;
                $payment->title = $request['title'];
                $payment->amount = $request['amount'];
                $payment->date = $request['date'];
                $payment->duration = $request['days'];
                $payment->perDaySittings = $request['dailyVisits'];
                $payment->total_sessions = $totalSessions;
                $payment->saturday_sittings = $satSittings;
                $payment->sunday_sittings = $sunSittings;
                $payment->save();

                if($payment){
                    $collection = new Collection();
                    $collection->user_id = $userId;
                    $collection->patient_id = $request['patient_id'];
                    $collection->service_type_id = $request['service_type_id'];
                    $collection->branch_id = $branch_id;
                    $collection->payment_id = $payment->id;
                    $collection->collectionDate = $request['date'];
                    $collection->amount = $PaidAmount;
                    $collection->mode_id = $request['cash'];
					$collection->discount = $request['discount'];
					$collection->paymentNote = $request['paymentNote'];
                    $collection->save();
                }
                $days = $request['days'];

                if ($request['schedule'] == 'dt') {
                    $rules = [
                        Carbon::SATURDAY => $satSittings,
                        Carbon::SUNDAY => $sunSittings,
                    ];

                    $start = $request['from'];

                    if ($dailyVisits > 0) {
                        $dates = SittingScheduler::generateSittings($start, (int)$days, (int)$dailyVisits, ['weekendRules' => $rules, 'totalSessions' => $totalSessions]);
                        foreach ($dates as $idx => $d) {
                            $schedule = new Schedule();
                            $schedule->user_id = $userId;
                            $schedule->branch_id = $branch_id;
                            $schedule->payment_id = $payment->id;
                            $schedule->patient_id = $request['patient_id'];
                            $schedule->title = 'Visit ' . ($idx + 1);
                            $schedule->sittingDate = $d['date'];
                            $schedule->attendedAt = null;
                            $schedule->save();
                        }
                    } else {
                        $dates = SittingScheduler::generateSittings($start, (int)$days, 1, ['weekendRules' => $rules, 'totalSessions' => $totalSessions]);
                        foreach ($dates as $i => $d) {
                            $schedule = new Schedule();
                            $schedule->user_id = $userId;
                            $schedule->branch_id = $branch_id;
                            $schedule->payment_id = $payment->id;
                            $schedule->patient_id = $request['patient_id'];
                            $schedule->title = 'Sitting ' . ($i + 1);
                            $schedule->no = $i + 1;
                            $schedule->sittingDate = $d['date'];
                            $schedule->attendedAt = null;
                            $schedule->save();
                        }
                    }
                } else {
                    $schedule = new Schedule();
                    $schedule->user_id = $userId;
                    $schedule->branch_id = $branch_id;
                    $schedule->patient_id = $request['patient_id'];
                    $schedule->payment_id = $payment->id;
                    $schedule->title = 'OPD / Consultation ';
                    $schedule->sittingDate = $request['date'];
                    $schedule->attendedAt = $request['date'];
                    $schedule->save();
                }


            }

            return redirect()->route('collectionPrint',['id'=>$collection->id])->with('message','Patient Successfully Registered');

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getServiceType($id)
    {
        $data = ServiceType::find($id);
        if ($data) {
            return response()->json([
                'name' => $data->name
            ]);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }
}
