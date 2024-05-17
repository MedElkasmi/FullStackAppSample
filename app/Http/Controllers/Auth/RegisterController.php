<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function register(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|string',
                'email' => 'required|email|max:255',
                'password' => 'required|min:8'
            ]);
    
            if($validator->fails()) {
                return response()->json($validator->errors(),400);
            }
    
            $user = User::Create([
                'name' => $request->name,
                'email' =>$request->email,
                'password' => Hash::make($request->password)
            ]);
    
            return response()->json(['user'=>$user],200);
        }

        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

}
