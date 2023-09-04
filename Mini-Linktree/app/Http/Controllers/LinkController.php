<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkController extends Controller
{
    public function index()
    {
        $data = Link::orderBy('order')->get();
        return response([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // dd(Link::count());
        $validasi = Validator::make($request->all(), [
            'title' => 'required',
            'icon' => 'required',
            // 'order' => 'required',
            'link' => 'required',
            'warna' => 'required',
            // 'created_by' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi data dengan benar',
                'data' => $validasi->errors()
            ], 422);
        }
        try {

            // ambil data link jumlahnya berapa
            $data = Link::create([
                'title' => $request->title,
                'icon' => $request->icon,
                //hitung keseluruhan data lalu ditambah 1
                'order' => Link::count() + 1,
                'link' => $request->link,
                'warna' => $request->warna,
                'created_by' => Auth::user()->id,
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
                'data' => $exception->getMessage()
            ], 500);
        }
    }

    public function orderUpdate(Request $request, $id)
    {
        $link = Link::find($id);
        $data = $request->all();
        $data['updated_by'] = Auth::user()->id;



        if (!$link) {
            // Handle jika tautan dengan ID tertentu tidak ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Tautan dengan ID ' . $id . ' tidak ditemukan.'
            ]);
        }


        $posisi = $request->posisi;
        $allLinks = Link::orderBy('order')->get();
        if ($posisi == 'up') {
            if ($link->order > 1) {
                //ini adalah data yang mau diupdate
                $data_maudiup = $allLinks[$link->order - 1];
                //ini data yang harus digeser kebawah
                $data_harusgeser = $allLinks[$link->order - 2];
                //proses update data dengan cara order saat ini - 1
                $data_maudiup->update(['order' => $link->order - 1]);
                //proses update data dengan cara posisi order yang harus digeser == orderan request
                $data_harusgeser->update(['order' => $link->order]);
            } else {
                return response([
                    'success' => true,
                    'message' => 'Urutan tautan tidak bisa ditukar.',
                    'data' => $allLinks,
                ]);
            }
        } elseif ($posisi == 'down') {
            if ($link->order < count($allLinks)) {
                $data_maudidown = $allLinks[$link->order - 1];
                $data_harusgeserup = $allLinks[$link->order];
                $data_maudidown->update(['order' => $link->order + 1]);
                $data_harusgeserup->update(['order' => $link->order]);
            } else {
                return response([
                    'success' => true,
                    'message' => 'Urutan tautan tidak bisa ditukar.',
                    'data' => $allLinks,
                ]);
            }
        }

        Link::findOrFail($id)->update($data);
        return response([
            'success' => true,
            'message' => 'Urutan tautan telah diperbarui.',
            'data' => $allLinks,
        ]);
    }

    public function destroy($id)
    {


        $data = Link::findOrFail($id);
        // dd($data->order);
        $allLinks = Link::orderBy('order')->get();
        //posisi data yang diinginkan
        $cekUrutan = $data->order;
        $datadibawahnya = $allLinks[$cekUrutan];
        // dd($datadibawahnya);
        //cek jika di posisidatanya dibawahnya masih ada data lagi maka lakukan looping untuk menampilkan data tersebut
        if (!empty($datadibawahnya)) {
            for ($i = $data->order  - 1; $i < count($allLinks); $i++) {
                $data->delete();
                $cekdata = $allLinks[$i];
                $cekdata->update(['order' => $cekdata->order - 1]);
            }
            return response([
                'success' => true,
                'message' => 'data berhasil dihapus dan data dibawahnya telah diurutkan kembali',
            ]);
        } {
            $data->delete();
            return response([
                'success' => true,
                'message' => 'data berada di posisi paling bawah dan telah dihapus',
            ]);
        }
    }
}
