<?php

namespace App\Http\Controllers;

use App\Models\SosialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class sosialmediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SosialMedia::where('users_id', Auth::user()->id)->get();
        if (empty($data)) {
            return response()->json([
                'message' => 'Tidak Ada Data'
            ]);
        }
        return response([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'title' => 'required',
            'icon' => 'required',
            'link' => 'required',

        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data dengan benar',
                'data' => $validasi->errors()
            ], 422);
        }

        try {
            $data = SosialMedia::create([
                'title' => $request->title,
                'icon' => $request->icon,
                'link' => $request->link,
                'users_id' => Auth::user()->id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'data berhasil ditambahkan',
                'data' => $data
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'data gagal ditambahkan',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $data = SosialMedia::find($id);
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'data berhasil dihapus',
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'data gagal dihapus',
            ]);
        }
    }
}
