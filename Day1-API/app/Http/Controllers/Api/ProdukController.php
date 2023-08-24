<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function PHPUnit\Framework\isTrue;

use App\Http\Resources\dataProdukResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProdukController extends Controller
{
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
            $produk = Produk::findOrFail($id);

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
        $request->validate([
            'nama_produk' => 'required|unique:produk|max:255',
            'kategori_id' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'foto_produk' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);

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
            ]);

            return new dataProdukResource($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Produk gagal ditambahkan',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|unique:produk|max:255',
            'kategori_id' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'foto_produk' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'images/produk/';
            $file->move($tujuan_upload, $nama_file);
        }

        try {
            $produk = Produk::findOrFail($id);
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'foto_produk' => $nama_file,
            ]);

            return new dataProdukResource($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Produk gagal diupdate',
                'data' => $exception->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {

        try {
            $produk = Produk::findOrFail($id);
            $produk->delete();
            return new dataProdukResource($produk);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ada',
                'data' => $exception->getMessage()
            ], 400);
        }
    }
}
