<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar data kategori',
            'data' => $kategori
        ], 200);
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail data kategori',
            'data' => $kategori
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori|max:255',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori|max:255',
        ]);
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diupdate',
                'data' => $kategori
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal diupdate',
            ], 500);
        }



        // $kategori = Kategori::findOrFail($id);

        // if ($kategori) {
        //     $kategori->update([
        //         'nama_kategori' => $request->nama_kategori,
        //     ]);

        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Kategori berhasil diupdate',
        //         'data' => $kategori
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Kategori gagal diupdate',
        //     ], 500);
        // }
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal dihapus',
            ], 500);
        }
    }
}
