<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\ServiceType;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'date'=>'required',
        ];
        $messages =    [
            'date.required' => 'Please Select Date',
        ];
        $userId = Auth::id();
        $this->validate($request, $rules, $messages);
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
        $days = 1;
        if($request['pp'] == 1){
            $amountPerDay = $request['amount'] / $request['duration'];
            $totalAmount = $request['amount']+$amountPerDay;
            $totalDuration = $request['duration'] +1;

            for($i=0; $i<$days; $i++){

                $schedule = new Schedule();
                $schedule->user_id = $userId;
                $schedule->patient_id = $request['patient_id'];
                //$schedule->pakage_id = $request['package_id'];
                $schedule->payment_id = $request['payment_id'];
                $schedule->title = $request['title'];
               // $schedule->no = $i+1;
                if($i==0){
                    $schedule->sittingDate = $request['date'];
                }
                else{
                    $schedule->sittingDate = $request['date']->addDay(1);
                }
                $schedule->attendedAt = $request['date'];
                $schedule->save();
            }

            if($schedule){
                $payment = Payment::find($request['payment_id']);
                $payment->duration = $totalDuration;
                $payment->amount = $totalAmount;
                $payment->save();
            }

        }else{
            //return $request->all();
            for($i=0; $i<$days; $i++){

                $schedule = new Schedule();
                $schedule->user_id = $userId;
                $schedule->patient_id = $request['patient_id'];
                $schedule->payment_id = $request['payment_id'];
                $schedule->title = $request['title'];
                if($i==0){
                    $schedule->sittingDate = $request['date'];
                }
                else{
                    $schedule->sittingDate = $request['date']->addDay(1);
                }
                $schedule->attendedAt = null;
                $schedule->save();

            }

        }
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {

        if(!$request['attendedAt']){
            if($request['date']){
                $dt = date("Y-m-d", strtotime($request['date']) );
            }else{
                $dt = date("Y-m-d", strtotime($schedule->attendedAt) );
            }
            $request['attendedAt'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return $schedule;
        }

        if($schedule->update($request->all())){
            return redirect()->back();
        }else{
            return'Sorry Something Went Wrong';
        }

    }

    private function ordinal(int $number): string
    {
        if (in_array($number % 100, [11, 12, 13])) {
            return $number . 'th';
        }

        return $number . match ($number % 10) {
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            default => 'th',
        };
    }


public function makeAbsent(Request $request, Schedule $schedule)
{
    DB::transaction(function () use ($schedule) {

        // Safety: already absent
        if ($schedule->status == 2) {
            return;
        }

        // 1️⃣ Mark sitting ABSENT
        $schedule->update([
            'status'     => 2, // ABSENT
            'attendedAt' => null,
        ]);

        // 2️⃣ Payment info (SOURCE OF TRUTH)
        $payment = $schedule->payment; // belongsTo
        $perDay  = (int) $payment->perDaySittings;
        $maxTotal = (int) $payment->duration;

        // 3️⃣ Base query
        $baseQuery = Schedule::where('patient_id', $schedule->patient_id)
            ->where('payment_id', $schedule->payment_id);

        // 4️⃣ Count ATTENDED + SCHEDULED (exclude ABSENT)
        $usedSittings = (clone $baseQuery)
            ->where('status', '!=', 2)
            ->count();

        // ❗ Cap check (ABSENT does NOT count)
        if ($usedSittings >= $maxTotal) {
            return;
        }

        // 5️ Find LAST sitting date (regular + extra)
        $lastMax = (clone $baseQuery)->max('sittingDate');
        $lastDate = Carbon::parse($lastMax)->startOfDay();

        // Prepare weekend/package rules
        $service = null;
        $rules = [];
        if ($payment && $payment->service_type_id) {
            $service = Branch::find($payment->branch_id);
            if ($service && !empty($service->restrict_weekend_sittings)) {
                $rules = [Carbon::SATURDAY => 1, Carbon::SUNDAY => 0];
            }
        }

        // 6️⃣ Find the next date that has capacity (respecting rules)
        $candidate = $lastDate->copy();
        while (true) {
            $dow = $candidate->dayOfWeek; // 0 (Sun) - 6 (Sat)
            $allowed = array_key_exists($dow, $rules) ? (int) $rules[$dow] : $perDay;

            $countOnCandidate = (clone $baseQuery)
                ->whereDate('sittingDate', $candidate)
                ->count();

            if ($allowed > 0 && $countOnCandidate < $allowed) {
                $extraDate = $candidate;
                break;
            }

            // move to next day
            $candidate->addDay();
        }

        // 8️⃣ Extra numbering
        $extraCount = (clone $baseQuery)
            ->where('extraSitting', 1)
            ->count();

        // 9️⃣ Add ONE extra sitting
        $visitOrder = 1;
        if ($extraDate->isSameDay($lastDate)) {
            $visitOrder = $countOnCandidate + 1;
        } else {
            $visitOrder = 1;
        }

        Schedule::create([
            'user_id'      => $schedule->user_id,
            'patient_id'   => $schedule->patient_id,
            'payment_id'   => $schedule->payment_id,
            'title'        => $this->ordinal($extraCount + 1) . ' Extra Sitting',
            'extraSitting' => 1,
            'sittingDate'  => $extraDate,
            'visit_order'  => $visitOrder,
            'status'       => 0, // scheduled
            'attendedAt'   => null,
        ]);
    });

    return redirect()->back()->with('success', 'Extra sitting added correctly');
}


    public function revertAbsent(Request $request, Schedule $schedule)
    {

        $request->all();

        $maxD = Schedule::where('patient_id',$schedule->patient_id)->where('payment_id',$schedule->payment_id)->max('sittingDate');
        $getExtraSitting = Schedule::where('patient_id',$schedule->patient_id)->where('payment_id',$schedule->payment_id)->where('extraSitting','1')->max('id');
        // return $getExtraSitting;
        $dt = date("Y-m-d", strtotime($maxD) );
        $maxDt =Carbon::createFromFormat('Y-m-d H',$dt.' 00');
        //return $maxDt;
        if($getExtraSitting){
            $schedule->update($request->all());
            Schedule::destroy($getExtraSitting);
            return redirect()->back();
        }else{
            $schedule->update($request->all());
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        Schedule::destroy($schedule->id);
        return redirect()->back();
    }


    public function biDay(){
        $date = Carbon::now();
        $days = 14;
        $a=0;
        for ($i = 0; $i < $days ; $i++){
            $sch = new Schedule();
            $sch->user_id = 1;
            $sch->patient_id = 80;
            $sch->pakage_id = 8;
            $sch->payment_id = 11;
            if($a==0){
                $sch->title = 'Moring Sitting';
                $sch->sittingDate = $date;
                $a = $a+1;
            }elseif($a==1){
                $sch->title = 'Evening Sitting';
                $sch->sittingDate = $date;
                $a = $a+1;
            }
            $sch->attendedAt = null;
            $sch->save();
            if($a==2){
                $date = $date->addDay(1);
                $a=0;
            }
        }
    }

    public function Dpc(){
        return view('patients.dpc');
    }
    public function DailyPatients(Request $request){
        $from = $request['from'];
        $upto = $request['upto'];
        $from = date("Y-m-d", strtotime($from) );
        $start =Carbon::createFromFormat('Y-m-d H',$from.' 00');
        $upto = date("Y-m-d", strtotime($upto) );

        $to =Carbon::createFromFormat('Y-m-d H',$upto.' 23');

        // return $start.'<br>'.$to;
        $DailyPatients = Schedule::whereBetween('attendedAt', [$start, $to])->orderBy('attendedAt', 'desc')->get();
        return view('patients.dailyPatient',compact('DailyPatients'));

    }
    public function todayPatients(){
        $user = Auth::user();
      $brachesId = loggedUser()->branches->pluck('id')->toArray();
        $time = Carbon::now();
        $time = $time->toDateString();
        $start = Carbon::createFromFormat('Y-m-d H', $time.' 00')->toDateTimeString();

        $dt = Carbon::now();
        $dt = $dt->toDateString();

        $to = Carbon::createFromFormat('Y-m-d H:i', $dt.' 23:59')->toDateTimeString();

        //return $start.'<br>'.$to;
//        if($user->role == 1 && $user->super == Null){
//            $DailyPatients = Schedule::where('branch_id',$user->branch_id)->whereBetween('sittingDate', [$start, $to])->orderBy('attendedAt', 'asc')->get();
//
//        }elseif($user->role == 1 && $user->super == Null){
//            $DailyPatients = Schedule::where('branch_id',$user->branch_id)->whereBetween('sittingDate', [$start, $to])->orderBy('attendedAt', 'asc')->get();
//
//        }elseif($user->super ==1){
//            $DailyPatients = Schedule::where('branch_id',$user->branch_id)->whereBetween('sittingDate', [$start, $to])->orderBy('attendedAt', 'asc')->get();
//
//        }
        $DailyPatients = Schedule::whereIn('branch_id',$brachesId)->whereBetween('sittingDate', [$start, $to])->orderBy('attendedAt', 'asc')->get();

        return view('reports.todaysPatients',compact('DailyPatients'));

    }

    public function getRefundDetail($pid,$payId){
        $patient = Patient::findOrFail($pid);
        $payment = Payment::findOrFail($payId);
        $active = Payment::where('patient_id',$patient->id)->where('active',1)->first();
        if($payment->pakage_id  != null){
            $schedules = Schedule::where('patient_id',$patient->id)->where('pakage_id',$payment->pakage_id)->where('payment_id',$payment->id)->orderBy('sittingDate','asc')->orderBy('visit_order','asc')->get();
            $visits = $schedules->count();
        }elseif($payment->pakage_id == null){
            $schedules = Schedule::where('patient_id',$patient->id)->where('payment_id',$payment->id)->orderBy('sittingDate','asc')->orderBy('visit_order','asc')->get();
            $visits = $schedules->count();
        }else{
            $schedules = null;
        }


        return view('schedules.refundDetail',compact('patient','payment','schedules','visits'));


    }

}
