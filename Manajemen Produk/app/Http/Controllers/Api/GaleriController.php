<?php

namespace App\Http\Controllers\api;

use App\Models\Galeri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GaleriController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:lihat-galeri', ['only' => ['index']]);
        $this->middleware('permission:tambah-galeri', ['only' => ['store']]);
        $this->middleware('permission:edit-galeri', ['only' => ['update']]);
        $this->middleware('permission:hapus-galeri', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = Galeri::all();

        try {
            return response()->json([
                'success' => true,
                'message' => 'Data galeri',
                'data' => $data
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data galeri tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $data = Galeri::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data galeri',
                'data' => $data
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data galeri tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'file_galeri' => 'required|mimes:jpg,png,jpeg|max:15048',
            'jenis_file' => 'required',
            'produk_id' => 'required'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'message' => 'error',
                'error' => $validasi->errors()
            ], 401);
        }

        if ($request->file('file_galeri')) {
            $file = $request->file('file_galeri');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'public/images/produk/';
            // $file->move($tujuan_upload, $nama_file);
            $path = $request->file('file_galeri')->storeAs($tujuan_upload, $nama_file);
        }

        try {
            $data = Galeri::create([
                'file_galeri' => $nama_file,
                'jenis_file' => $request->jenis_file,
                'produk_id' => $request->produk_id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data galeri',
                'data' => $data
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data galeri tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'file_galeri' => 'required|mimes:jpg,png,jpeg|max:15048',
            'jenis_file' => 'required',
            'produk_id' => 'required'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'message' => 'error',
                'error' => $validasi->errors()
            ], 401);
        }

        if ($request->file('file_galeri')) {
            $file = $request->file('file_galeri');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'public/images/produk/';
            // $file->move($tujuan_upload, $nama_file);
            $path = $request->file('file_galeri')->storeAs($tujuan_upload, $nama_file);
        }

        try {
            $data = Galeri::findOrFail($id);
            $data->update([
                'file_galeri' => $nama_file,
                'jenis_file' => $request->jenis_file,
                'produk_id' => $request->produk_id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data galeri',
                'data' => $data
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data galeri tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $data = Galeri::findOrFail($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data galeri Berhasil dihapus',
            'data' => $data
        ]);
    }
}
