<?php

namespace App\Http\Controllers\api;

use App\Models\Toko;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TokoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lihat-toko', ['only' => ['index']]);
        $this->middleware('permission:tambah-toko', ['only' => ['store']]);
        $this->middleware('permission:edit-toko', ['only' => ['update']]);
        $this->middleware('permission:hapus-toko', ['only' => ['destroy']]);
    }
    public function index()
    {
        try {
            $data = Toko::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Toko',
                'data' => $data
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $data = Toko::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Toko',
                'data' => $data
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }


    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_toko' => 'required',
            'alamat_toko' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'no_telp' => 'required',
            'foto_toko' => 'required|mimes:jpg,png,jpeg|max:15048',
            'deskripsi_toko' => 'required',
            'tanggal_berdiri' => 'required',
            'user_id' => 'required'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak valid',
                'data' => $validasi->errors()
            ], 400);
        }

        if ($request->hasFile('foto_toko')) {
            $file = $request->file('foto_toko');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'public/images/produk/';
            $path = $request->file('foto_toko')->storeAs($tujuan_upload, $nama_file);
        }

        try {
            $toko = Toko::create([
                'nama_toko' => $request->nama_toko,
                'alamat_toko' => $request->alamat_toko,
                'no_telp' => $request->no_telp,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'foto_toko' => $nama_file,
                'deskripsi_toko' => $request->deskripsi_toko,
                'tanggal_berdiri' => $request->tanggal_berdiri,
                'user_id' => $request->user_id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data Toko',
                'data' => $toko
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak valid',
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_toko' => 'required',
            'alamat_toko' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'no_telp' => 'required',
            'foto_toko' => 'required|mimes:jpg,png,jpeg|max:15048',
            'deskripsi_toko' => 'required',
            'tanggal_berdiri' => 'required',
            'user_id' => 'required'
        ]);
        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak valid',
                'data' => $validasi->errors()
            ], 400);
        }

        if ($request->hasFile('foto_toko')) {
            $file = $request->file('foto_toko');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'public/images/produk/';
            $path = $request->file('foto_toko')->storeAs($tujuan_upload, $nama_file);
        }

        try {
            $toko = Toko::findOrFail($id);
            $toko->update([
                'nama_toko' => $request->nama_toko,
                'alamat_toko' => $request->alamat_toko,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'no_telp' => $request->no_telp,
                'foto_toko' => $nama_file,
                'deskripsi_toko' => $request->deskripsi_toko,
                'tanggal_berdiri' => $request->tanggal_berdiri,
                'user_id' => $request->user_id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data Toko',
                'data' => $toko
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak valid',
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $toko = Toko::findOrFail($id);
            $toko->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Toko Berhasil dihapus',
                'data' => $toko
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data Toko tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }
}
