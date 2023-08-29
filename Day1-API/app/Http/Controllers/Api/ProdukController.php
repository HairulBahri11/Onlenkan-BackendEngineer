<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use App\Http\Resources\dataProdukResource;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function __construct()
    {
        //    panggil semua permission yang telah dibuat
        $this->middleware('permission:lihat-produk', ['only' => ['index']]);
        $this->middleware('permission:tambah-produk', ['only' => ['store']]);
        $this->middleware('permission:edit-produk', ['only' => ['update']]);
        $this->middleware('permission:hapus-produk', ['only' => ['destroy']]);
    }
    public function index()
    {
        try {
            $produk = Produk::with('datakategori')->get();
            return dataProdukResource::collection($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data produk kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            $produk = Produk::where('user_id', Auth::user()->id)->findOrFail($id);
            return new dataProdukResource($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data produk kosong',
                'data' => $exception->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_produk' => 'required|unique:produk|max:255',
            'kategori_id' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'foto_produk' => 'required|mimes:jpg,png,jpeg|max:15048'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422); // 422 adalah kode status untuk Unprocessable Entity
        }

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'images/produk/';
            $file->move($tujuan_upload, $nama_file);
        }

        try {
            $produk = Produk::create([
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'foto_produk' => $nama_file,
                //user_id ngambil dari user yang login
                'user_id' => Auth::user()->id

            ]);

            return new dataProdukResource($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Produk gagal ditambahkan',
                'data' => $exception->getMessage()
            ], 400);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Hak akses ditolak',
                'data' => $exception->getMessage()
            ], 403);
        }
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_produk' => 'required|unique:produk|max:255',
            'kategori_id' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'foto_produk' => 'required|mimes:jpg,png,jpeg|max:15048'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validasi->errors()
            ], 422); // 422 adalah kode status untuk Unprocessable Entity
        }

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'images/produk/';
            $file->move($tujuan_upload, $nama_file);
        }


        // if (!empty($produk)) {
        //     // $produk = Produk::where('user_id', Auth::user()->id)->findOrFail($id);
        //     $produk->update([
        //         'nama_produk' => $request->nama_produk,
        //         'kategori_id' => $request->kategori_id,
        //         'harga' => $request->harga,
        //         'stok' => $request->stok,
        //         'deskripsi' => $request->deskripsi,
        //         'foto_produk' => $nama_file,
        //         'user_id' => Auth::user()->id
        //     ]);
        //     return new dataProdukResource($produk);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Produk tidak ditemukan',
        //         'data' => ''
        //     ], 400);
        // }

        try {
            // $produk = Produk::where('user_id', Auth::user()->id)->findOrFail($id);
            $produk = Produk::where('user_id', Auth::user()->id)->findOrFail($id);
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'foto_produk' => $nama_file,
                'user_id' => Auth::user()->id
            ]);
            return new dataProdukResource($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan untuk dilakukan proses update',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {

        try {
            $produk = Produk::where('user_id', Auth::user()->id)->findOrFail($id);
            $produk->delete();
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus',
                'data' => $produk
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }
}
