<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\userResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //validate
    public function login(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //check validation
        if ($validasi->fails()) {
            return response()->json([
                'message' => 'error',
                'error' => $validasi->errors()
            ], 401);
        }


        //check credentials
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        //get user
        // $user = $request->user();
        $user = User::where('email', $request->email)->get();
        //create token
        // $tokenResult = $user->createToken('authToken')->plainTextToken;
        //send response
        // return response()->json([
        //     'message' => 'success',
        //     'user' => $user,
        //     'token' => $tokenResult
        // ], 200);

        return userResource::collection($user);
    }
}
