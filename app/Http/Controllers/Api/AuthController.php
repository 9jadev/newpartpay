<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\RegistedSuccessful;

class AuthController extends Controller
{
    public function register(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:16', 'unique:users,phone'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        // 'password_confirmation' remenber to use this as a field will validating
        ]);
      
        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        $name = $request->firstname.' '.$request->lastname;
        $user->notify(new RegistedSuccessful($user));
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'accessToken' => $accessToken, 'status' => true]);
    }


    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();
    
        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    
    }
    
    public function login(Request $request)
    {

        $logindata = $request->validate([
            'email' => ['required','email',],
            'password' => ['required'],

        ]);
        
        
        if (!auth()->attempt($logindata)) {
            return response(['message' => 'Invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;;
         return response(['user' => auth()->user(), 'accessToken' => $accessToken, 'status' => true]);

    }
}
