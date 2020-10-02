<?php

namespace App\Http\Controllers\Api;

use App\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use Illuminate\Support\Collection;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 12345675643;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|max:15',
            'invoices_id' => 'required|max:15',
            'tran_x' => 'required|string|max:15',
            'amount' => 'required|integer',
            // 'payment_status' => 'required|boolean'
        ]);
        
        $payment = New payment;
        $payment->business_id = $request->business_id;
        $payment->invoices_id = $request->invoices_id;
        $payment->tran_x = $request->tran_x;
        $payment->amount = $request->amount;
        $payment->payment_status = false;
        $payment->save();

        // return $payment;
        return response(['Payment' => $payment,'status' => true]);
    }

    public function markpaid(Payment $payment, Invoice $invoice){
        // $payment = Payment::where('tran_x', $payment->id);
        // return $payment;
        if ($payment->payment_status == false) {
            $payment->update(['payment_status' => true]);
            $inv = new InvoiceController(); 
            $new_invoice = $inv->updateinvoice($invoice, $payment->amount);
            return response(['status' => true, 'message' => ' Updated successful ' , 'invoice' => $new_invoice,'payment' => $payment,'amount' => $payment->amount]);
        } else {
            return response(['status' => false, 'message' => 'Updated unsuccessful']);
        }
        // $invoice_amount = $invoice->paid;
        // $invoice = $payment->invoice();
        // $oldinvoice  = $invoice;
        // $paid = intval($oldinvoice->paid);
        // $newpaid = $paid + (int)$request->amount;
        // $invoice->update(['paid' => 5000]);
        // return $payment;
        // return response(['invoice' => $new_invoice,'payment' => $payment,'amount' => intval($request->amount)]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
