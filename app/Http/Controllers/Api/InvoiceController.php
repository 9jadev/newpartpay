<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Business;
use App\Events\NewInvoiceCreatedEvent;
use App\Invoice;
use Illuminate\Support\Collection;

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
        $inv = User::find($id)->Business->invoices->sortByDesc('id');
        // 
        $invoices = isset($inv) ? User::find($id)->Business->invoices : '{}' ;
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
			// 'serialcode' => 'required|string|max:25',
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
        $uid = Auth::id();
		// $user = User::find($uid);
        $invoice = Invoice::find($id);
        $bus = Business::find($uid);
		if ($invoice->business_id != $bus->id) {
			return response(['message' => ' You can not update this ', 'status' => false]);
		}
		return response(['invoice' => $invoice, 'status' => true]);
    }
     

    public function getInvoice($id) {
        // where('slug', $slug)->firstOrFail()
        $invoice = Invoice::where('serialcode', $id)->first();
        if ($invoice != NULL) {
            $result = ['result' => true, 'invoice' => $invoice, 'business' => $invoice->business];
            return response($result);
        }
        return response(['result' => false]);
    }

    public function updateinvoice(Invoice $invoice, $amount){
        // $invoice_amount = $invoice->paid;
        $invoice->paid += $amount;
        $invoice->save();
        // return $invoice->update(['paid' => 500000]);
        return $invoice;
    }

    public function checkInvoice($id) {
        $invoice = Invoice::where('serialcode', $id)->first();
        if ($invoice == NULL) {
            return response(['result' => false]);
        } else {
            return response(['result' => true]);
        }

        // return $invoice;


    }

    public function activateInvoice(Invoice $invoice){
        $uid = Auth::id();
        $invoice = Invoice::findOrFail($invoice->id);
        $bus = Business::find($uid);
		if ($invoice->business_id != $bus->id) {
			return response(['message' => ' You can not update this ', 'status' => false]);
		}
		$invoice->update([
			'activate' => true
        ]);
        event(new NewInvoiceCreatedEvent($invoice));
        return response(['invoice' => $invoice, 'status' => true]);
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $uid = Auth::id();
		// $user = User::find($uid);
        $invoice = Invoice::find($id);
        $bus = Business::find($uid);
		if ($invoice->business_id != $bus->id) {
			return response(['message' => ' You can not update this ', 'status' => false]);
		}
        $invoice = Invoice::findOrFail($id);
        $request->validate([
			'contact_name' => 'required|max:255|string',
			'contact_email' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:25',
            'amount' => 'required|integer',
            'threshold' => 'required|integer',
            'about' => 'required|string|max:1500',
        ]);
		$invoice->update([
			'contact_name' => $request->contact_name,
			'contact_email' => $request->contact_email,
			'contact_phone' => $request->contact_phone,
			'amount' => $request->amount,
			'threshold' => $request->threshold,
			'about' => $request->about,
		]);
		// $invoice->update($request->all());
		return response(['invoices' => $invoice, 'status' => true]);
        
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
