<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\dataProdukResource;

use function PHPUnit\Framework\isTrue;

class ProdukController extends Controller
{
    public function index()
    {
        //tampilkan hanya nama_kategori juga hasil relasi dari tabel kategori
        $produk = Produk::with('datakategori')->get();
        if ($produk != null) {
            return dataProdukResource::collection($produk);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data produk kosong',
                'data' => $produk
            ], 400);
        }
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk != null) {
            return new dataProdukResource($produk);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data produk kosong',
                'data' => $produk
            ], 400);
        }
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
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

        if ($validasi) {
            $produk = Produk::create([
                'nama_produk' => $request->nama_produk,
                'kategori_id' => $request->kategori_id,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'deskripsi' => $request->deskripsi,
                'foto_produk' => $nama_file,
            ]);

            if ($produk) {
                return new dataProdukResource($produk);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk gagal ditambahkan',
                ], 400);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
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

        if (isTrue($validasi)) {
            $produk = Produk::findOrFail($id);
            // $produk->update([
            //     'nama_produk' => $request->nama_produk,
            //     'kategori_id' => $request->kategori_id,
            //     'harga' => $request->harga,
            //     'stok' => $request->stok,
            //     'deskripsi' => $request->deskripsi,
            //     'foto_produk' => $nama_file,
            // ]);

            $request->foto_produk->move(public_path('images/produk'), $nama_file);
            $produk->update($request->all());


            if ($produk) {
                return new dataProdukResource($produk);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk gagal diupdate',
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produk gagal diupdate',
            ], 401);
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk) {
            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produk gagal dihapus',
            ], 500);
        }
    }
}
