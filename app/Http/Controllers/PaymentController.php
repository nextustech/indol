<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Patient;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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



    public function payIndex($id){
        $payment  = Payment::findOrFail($id);
        return view('payments.index',compact('payment'));

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
        $patient = Patient::findOrFail($id);
        $packages = Pakage::all();
        return view('patients.addpackage',compact('patient','packages'));
    }
    public function crAddOn($id)
    {
        $patient = Patient::findOrFail($id);
        $packages = Pakage::all();
        return view('patients.addpackage',compact('patient','packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $userId = Auth::id();
        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
        }else{
            $date = Carbon::now();
            $request['date'] = Carbon::now();
            //return Carbon::now();
        }

        $package = Pakage::where('id',$request['pakage'])->first();
        $days = $package->timePeriod;
        function ordinal($number) {
            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
            if ((($number % 100) >= 11) && (($number%100) <= 13))
                return $number. 'th';
            else
                return $number. $ends[$number % 10];
        }

        if($request->patient_id) {
            $payment = new Payment();
            $payment->user_id = $userId;
            $payment->patient_id = $request->patient_id;
            $payment->pakage_id = $request->pakage;
            $payment->date = $request['date'];
            $payment->amount = $package->amount;
            $payment->save();

            for ($i = 0; $i < $days ; $i++) {
                $schedule = new Schedule();
                $schedule->user_id = $userId;
                $schedule->patient_id = $request->patient_id;
                $schedule->pakage_id = $package->id;
                $schedule->payment_id = $payment->id;
                $schedule->title = ordinal($i + 1) . ' Sitting ';
                if($i==0){
                    $schedule->sittingDate = $date;
                }else{
                    $schedule->sittingDate = $date->addDay(1);
                }
                $schedule->attendedAt = null;
                $schedule->save();
            }

        }

        return redirect()->route('patients.show',['id'=>$request->patient_id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {

        return view('payments.show2',compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        return view('payments.edit',compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $userId = Auth::id();

        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
        }else{
            $date = Carbon::now();
            $request['date'] = Carbon::now();
            //return Carbon::now();
        }

        if($payment->update($request->all())){
            $collection = new Collection();
            $collection->user_id = $userId;
            $collection->patient_id = $payment->patient_id;
            $collection->pakage_id = $payment->pakage_id;
            $collection->amount = $payment->pakage->amount;
            $collection->save();
            return redirect()->route('patients.show',['id'=>$payment->patient_id]);
        }else{
            return'Sorry Something Went Wrong';
        }

    }

    public function editDate(Payment $payment){
        return view('payments.edit',compact('payment'));
    }

    public function updateDate(Request $request, Payment $payment)
    {
        $userId = Auth::id();

        if($request['date']!= null){
            $dt = date("Y-m-d", strtotime($request['date']) );
            // $dt = $dt->toDateTimeString();
            $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //return  $request['date'] ;
            $date = Carbon::createFromFormat('Y-m-d H',$dt.' 00');
            //'Y-m-d H', $dtFr.' 22'
            // return $date;
        }else{
            $date = Carbon::now();
            $request['date'] = Carbon::now();
            //return Carbon::now();
        }

        if($payment->update($request->all())){
            return redirect()->route('patients.show',$payment->patient_id);
        }else{
            return'Sorry Something Went Wrong';
        }

    }

    public function makeActive(Request $request, Payment $payment){
        $patient = Patient::findOrFail($payment->patient_id);
        //$pay = $patient->payment;
        foreach($patient->payments as $p){
            $pay = Payment::find($p->id);
            //$pay->active = 1;
            if($p->id == $payment->id){
                $pay->active = 1;
            }else{
                $pay->active = null;
            }
            $pay->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $collections = Collection::where('payment_id',$payment->id)->get();
        foreach( $collections as $collection){
            Collection::destroy($collection->id);
        }
        Payment::destroy($payment->id);
        return redirect()->back()->with('message','Deleted Successfully');
      
      
    }
}
