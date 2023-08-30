<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isFalse;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:lihat-admin', ['only' => ['index']]);
        // $this->middleware('permission:tambah-admin', ['only' => ['store']]);
        // $this->middleware('permission:edit-admin', ['only' => ['update']]);
        // $this->middleware('permission:hapus-admin', ['only' => ['destroy']]);
    }

    // public function index()
    // {
    //     try {
    //         $admin = User::all();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Daftar data admin',
    //             'data' => $admin
    //         ], 200);
    //     } catch (ModelNotFoundException $exception) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data admin kosong',
    //             'data' => $exception->getMessage()
    //         ], 404);
    //     }
    // }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422);
        }

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            $user->assignRole($request->input('role'));

            // $data = $request->all();
            // $data['password'] = Hash::make($data['password']);

            // $user = User::create($data);
            // $user->assignRole($request->input('role'));

            return response()->json([
                'success' => true,
                'message' => 'admin berhasil ditambahkan',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'admin gagal ditambahkan',
                'data' => $exception->getMessage()
            ], 500);
        }
    }
}
