<?php

namespace App\Http\Controllers;

use App\Http\Resources\dataUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class LoginController extends Controller
{
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

        return dataUserResource::collection($user);
    }

    public function logout($id)
    {

        try {
            $data = User::find($id);
            if ($data->id == Auth::user()->id) {
                $data->tokens()->delete();
                return response()->json([
                    'message' => 'you are logout',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
