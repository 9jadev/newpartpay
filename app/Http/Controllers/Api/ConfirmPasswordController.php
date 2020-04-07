<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function confirm(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // $this->resetPasswordConfirmationTimeout($request);

        if($request->wantsJson()){
            return response(['message' => 'Sucessful', "status" => 204]);
        }

        // return $request->wantsJson()
        //             ? new Response('', 204)
        //             : redirect()->intended($this->redirectPath());
    }
}
