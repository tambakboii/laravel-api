<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('judul','asc')->get();

        return response()->json([
            'status'=> true,
            'message' =>'data ditemukan',
            'data' => $data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataBuku = new Buku;

        $rules = [
            'judul'&&'pengarang'&&'tanggal_publikasi'=> 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=>'Gagal Memasukkan data',
                'data' => $validator-> errors()
            ]);
        }


        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;

        $post = $dataBuku -> save();

        return response()->json([
            'status'=>true,
            'message'=> 'sukses memasukkan data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);

        if($data){
            return response()->json([
                'status'=>true,
                'message'=>"data ditemukan",
                'data'=>$data
            ],200);
        }
        else{
            return response()->json([
                'status'=>false,
                'message'=>'data tidak dapat ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataBuku = Buku::find($id);
        if(empty($dataBuku)) {
            return response()->json([
                'status'=>false,
                'message'=>'Data Tidak Ditemukan',
                
            ], 404);
        }

        $rules = [
            'judul'&&'pengarang'&&'tanggal_publikasi'=>'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=>'Gagal update data',
                'data' => $validator-> errors()
            ]);
        }


        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tanggal_publikasi = $request->tanggal_publikasi;

        $post = $dataBuku -> save();

        return response()->json([
            'status'=>true,
            'message'=> 'sukses update data'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataBuku = Buku::find($id);
        if(empty($dataBuku)) {
            return response()->json([
                'status'=>false,
                'message'=>'Data Tidak Ditemukan',
                
            ], 404);
        }


        $post = $dataBuku -> delete();

        return response()->json([
            'status'=>true,
            'message'=> 'sukses delete data'
        ]);
    }
}
