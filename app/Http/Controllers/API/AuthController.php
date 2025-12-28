<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->all()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user['token'] = $user->createToken('myToken')->plainTextToken;

        // echo '<pre>'; print_r($request->all()); exit;
        return response()->json([
            'status' => 1,
            'message' => 'User Created',
            'data' => $user
        ]);
    } 

    // login
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->all()
            ]);
        }

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            $user = Auth::user();
            $user['token'] = $user->createToken('mytoken')->plainTextToken;
            return response()->json([
            'status'=> 1,
            'message' => 'User Loggedin',
            'data' => $user,

        ]);
        } else{
            return response()->json([
                'status'=> 0,
                'message' => 'login failed'
            ]);
        }

        

    }
}
