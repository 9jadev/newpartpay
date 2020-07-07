<?php

namespace App\Http\Controllers\Api;
use App\User;
use  App\Business;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BusinessesController extends Controller
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
		$contacts = User::find($id)->Business->contacts;
		if ($business == NULL) {
		   return response(['business' => $business, 'status' => false]);
		}
		return response(['business' => $business,'contacts' => $contacts ,'status' => true]);
	}

 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// return response(1);
		$id = Auth::id();
		$request->user_id = $id;
		$serial = 'BUS'.rand(1000000,9999999);
		$request->validate([
			'user_id' => 'required|unique:businesses,user_id',
			'business_name' => 'required|unique:businesses|max:255|string',
			'business_type' => 'required|string|max:255',
			'business_about' => 'required|string',
			'business_image' => 'required|string',
			'bank_name' => 'required|string|max:255',
			'bank_code' => 'required|string|max:10',
			'account_number' => 'required|integer'
		]);
		
		
		$user = User::find($id);
		$business = New business;
		$business->user_id = $request->user_id; 
		$business->business_name = $request->business_name;
		$business->business_type = $request->business_type;
		$business->business_about = $request->business_about;
		$business->business_serial = $serial;
		$business->business_image = $request->business_image;
		$business->business_approved = false;
		$business->account_balance = 0;
		$business->account_total = 0;
		$business->bank_name = $request->bank_name;
		$business->bank_code = $request->bank_code;
		$business->account_number = $request->account_number;

		$newbiz = $user->business()->save($business);
		return response(['business' => $newbiz, 'user' => $user , 'status' => true]);

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
		$user = User::find($uid);
		$bus = Business::find($id);
		if ($bus->user_id != $uid) {
			return response(['message' => ' You can not update this ', 'status' => false]);
		}
		return response(['business' => $bus, 'user' => $user , 'status' => true]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function getContactsNow(Business $business){
		$contacts = Business::find($business->id)->contacts;
		// $contacts = Contact::find($business);
		return $contacts;
	} 

	public function updateBusinessName(Request $request, Business $business){
		$id = Auth::id();
		$user = User::find($id);
		if ($business->user_id != $id) {
			return response(['message' => ' Unauthorized ', 'status' => false]);
		}
		$request->validate([
			'business_name' => 'required|unique:businesses|max:255|string',
		]);
		
		$biz = Business::findOrFail($business->id);
		$biz->update([
			'business_name' => $request->business_name
		]);
		return response(['business' => $biz, 'user' => $user , 'status' => true]);
	}


	public function updateBusinessImg(Request $request, Business $business){
		$id = Auth::id();
		$user = User::find($id);
		if ($business->user_id != $id) {
			return response(['message' => ' Unauthorized ', 'status' => false]);
		}
		$request->validate([
			'business_image' => 'required|string|max:255'
		]);
		
		$biz = Business::findOrFail($business->id);
		$biz->update([
			'business_image' => $request->business_image
		]);
		return response(['business' => $biz, 'user' => $user , 'status' => true]);
	}


	
	public function update(Request $request, Business $business)
	{
		$id = Auth::id();
		$user = User::find($id);
		if ($business->user_id != $id) {
			return response(['message' => ' Unauthorized ', 'status' => false]);
		}
		
		$request->user_id = $id;
		$request->validate([
			'user_id' => 'required|integer',
			'business_type' => 'required|string|max:255',
			'business_about' => 'required|string',
			'business_image' => 'required|string|max:255',
			'bank_name' => 'required|string|max:255',
			'bank_code' => 'required|string|max:10',
			'account_number' => 'required|integer'
		]);
		
		$biz = Business::findOrFail($business->id);
		$biz->update([
			'business_type' => $request->business_type,
			'business_image' => $request->business_image,
			'business_about' => $request->business_about,
			'business_serial' => $request->business_serial,
			'bank_name' => $request->bank_name,
			'bank_code' => $request->bank_code,
			'account_number' => $request->account_number
		]);
		// $biz->update($request->all());
		return response(['business' => $biz, 'user' => $request->business_image, 'status' => true]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Business $business)
	{
		$id = Auth::id();
		if ($business->user_id != $id) {
			return response(['message' => ' You can not deleted this ', 'status' => false]);
		}
	   $business->delete();
	   return response(['message' => 'Deleted', 'status' => true]);
	   
	}
}
