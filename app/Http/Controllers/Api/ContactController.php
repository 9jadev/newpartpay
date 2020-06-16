<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Business;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Contact::get();
        return response(['All Contact' => $contact]);
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
        $request->validate([
            'business_id' => 'required|max:255',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|max:100'
        ]);

        $business = Business::find($request->business_id);
        $contact = new Contact;
        $contact->business_id = $request->business_id;
        $contact->name = $request->name;
        $contact->phone = $request->phone; 
        $contact->email = $request->email;  

        $newbiz = $business->contact()->save($contact);
        return response(['contact' => $newbiz, 'business' => $business , 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $cont = Contact::find($contact->id);
        return response(['contact' => $cont, 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $contact = Contact::find($contact->id);
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|max:100'
        ]);

        $contact->update([
           'name' => $request->name,
           'phone' => $request->phone,
           'email' => $request->email 
        ]);

        return response(['contact' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response(['message' => 'Deleted', 'status' => true]);
    }
}
