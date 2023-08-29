<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KategoriController extends Controller
{
    public function __construct()
    {

        //    panggil semua permission yang telah dibuat untuk kategori
        $this->middleware('permission:lihat-kategori', ['only' => ['index']]);
        $this->middleware('permission:tambah-kategori', ['only' => ['store']]);
        $this->middleware('permission:edit-kategori', ['only' => ['update']]);
        $this->middleware('permission:hapus-kategori', ['only' => ['destroy']]);
    }

    public function index()
    {

        try {
            $kategori = Kategori::all();
            return response()->json([
                'success' => true,
                'message' => 'Daftar data kategori',
                'data' => $kategori
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
    }

    public function show($id)
    {

        try {
            $kategori = Kategori::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail data kategori',
                'data' => $kategori
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data kategori kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategori|max:255',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data dengan benar',
                'data' => $validasi->errors()
            ], 422);
        }
        try {

            $kategori = Kategori::create([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal ditambahkan',
                'data' => $exception->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategori|max:255',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data dengan benar',
                'data' => $validasi->errors()
            ], 422);
        }
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diupdate',
                'data' => $kategori
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal diupdate',
                'data' => $exception->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {

        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus',
                'data' => $kategori
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal dihapus',
                'data' => $exception->getMessage()
            ], 500);
        }
    }
}
