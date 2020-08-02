<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Business;
use App\Events\NewInvoiceCreatedEvent;
use App\Invoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
		// return BusinessResource::collection(User::find($id)->Business);
        $business =  User::find($id)->Business;
        $invoices = isset(User::find($id)->Business->invoices) ? User::find($id)->Business->invoices : '{}' ;
		if ($business == NULL) {
		   return response(['business' => $business, 'status' => false]);
		}
		return response(['business' => $business,'invoices' => $invoices ,'status' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request)
    {
        $id = Auth::id();
		$request->user_id = $id;
        $serial = 'INV'.rand(1000000,9999999);
        
        $request->validate([
			'business_id' => 'required|max:255',
			'contact_name' => 'required|max:255|string',
			'contact_email' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:25',
            'amount' => 'required|integer',
            'threshold' => 'required|integer',
			'serialcode' => 'required|string|max:25',
            'type' => 'required|string|max:10',
            'about' => 'required|string|max:1500',
            'paid' => 'required|integer'
        ]);
        
        $invoice = new invoice;
        $business = Business::find($request->business_id);
        $invoice->business_id = $request->business_id;
        $invoice->contact_name = $request->contact_name;
        $invoice->contact_email = $request->contact_email;
        $invoice->contact_phone = $request->contact_phone;
        $invoice->amount = $request->amount;
        $invoice->threshold = $request->threshold;
        $invoice->serialcode = $serial;
        $invoice->type = $request->type;
        $invoice->about_invoice = $request->about; 
        $invoice->paid = 0;
        $invoice->complete = false;
        // return response(['All Contact' => $contact]);
        $newinvoice = $business->invoices()->save($invoice);
        
        event(new NewInvoiceCreatedEvent($newinvoice));

        return response(['newinoice' => $newinvoice, 'status' => 'true']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
