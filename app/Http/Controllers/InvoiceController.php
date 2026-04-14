<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Collection;
use App\Models\Invoice;
use App\Models\Bill;
use App\Models\Patient;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
  
      public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:viewInvoice', ['only'=>['index']]);
        $this->middleware('permission:deleteInvoice', ['only'=>['destroy']]);
    }
  
    public function invoice($id){
        $patient = Patient::findOrFail($id);
        $userId = Auth::id();
        if($patient->payments){
            $inv = Invoice::max('invoiceNo');
            $invoiceNo = $inv+1;
            $invoice = new Invoice();
            $invoice->invoiceNo = $invoiceNo;
            $invoice->branch_id = $patient->branch_id;
            $invoice->patient_id = $patient->id;
            $invoice->save();

            if($invoice){
                foreach($patient->payments as $entry){
                    $totalDiscount = Collection::where('payment_id',$entry->id)->sum('discount');
                    $totalPayable = $entry->amount - $totalDiscount;

                    $bill = new Bill();
                    $bill->invoice_id = $invoice->id;
                    $bill->user_id = $userId;
                    $bill->patient_id = $entry->patient_id;
                    $bill->payment_id = $entry->id;
                    if($entry->pakage_id){
                        $bill->pakage_id = $entry->pakage_id;
                        $bill->packageName = $entry->pakage->name;
                        $bill->duration = $entry->pakage->timePeriod;
                    }else{
                        $bill->packageName = $entry->title;
                        $bill->duration = $entry->duration;
                        if($entry->perDaySittings != NULL){
                            $bill->sittingsPerDay = $entry->perDaySittings;
                        }else{
                            $bill->sittingsPerDay = 1;
                        }

                    }
                    $bill->amount = $totalPayable;
                    $bill->date = $entry->date;
                    $bill->save();
                }
            }
        }
        return redirect()->back()->with('message','Invoice Created Successfully');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
      $invoices = Invoice::latest()->paginate(10);
        if(Auth::user()->role == 1 && Auth::user()->super == Null){
            $invoices = Invoice::latest()->paginate(10);
        }elseif(Auth::user()->role ==2 && Auth::user()->super == Null ){
            $invoices = Invoice::latest()->paginate(10);
        }elseif( Auth::user()->super == 1 ){
            $invoices = Invoice::latest()->paginate(10);
        }

        return view('bills.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $patient = Patient::findOrFail($id);
        $branches = $patient->branches;
        return view('bills.create', compact('patient','branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request->all();
        $patient = Patient::findOrFail($request['patient_id']);
        $userId = Auth::id();
        $user = Auth::user();
        $dt = date("Y-m-d", strtotime($request['date']) );
        // $dt = $dt->toDateTimeString();
       // $request['date'] = Carbon::createFromFormat('Y-m-d H',$dt.' 00');

        $date = $request['date'];
        $payments = $request['package'];
        if($patient->payments){
            $inv = Invoice::max('invoiceNo');
            $invoiceNo = $inv+1;
            $invoice = new Invoice();
            $invoice->date = $date;
            $invoice->user_id = $userId;
            $invoice->branch_id = $request['branch_id'];
            $invoice->invoiceNo = $invoiceNo;
            $invoice->patient_id = $patient->id;
            $invoice->save();

            if($invoice){
                foreach($payments as $p){
                    $entry = Payment::findOrFail($p);
                  	$totalDiscount = Collection::where('payment_id',$entry->id)->sum('discount');
                    $totalPayable = $entry->amount - $totalDiscount;
                    $bill = new Bill();
                    $bill->invoice_id = $invoice->id;
                    $bill->user_id = $userId;
                    $bill->patient_id = $entry->patient_id;
                    $bill->payment_id = $entry->id;
                    $bill->packageName = $entry->title;
                    $bill->duration = $entry->duration;
                    if($entry->perDaySittings != NULL){
                        $bill->sittingsPerDay = $entry->perDaySittings;
                    }else{
                        $bill->sittingsPerDay = 1;
                    }
                    $bill->amount = $totalPayable;
                    $bill->date = $entry->date;
                    $bill->save();


                }

            }
            return redirect()->route('invoices.show',$invoice->id)->with('message','Invoice Created Successfully');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('bills.bill',compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        Invoice::destroy($invoice->id);
        return redirect()->back();
    }
}
