<?php

namespace App\Http\Controllers;

use App\Models\stok;
use App\Models\suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Termwind\Components\Raw;

class stokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $r)
    {
        $search = $r->input('search');
        $getData = stok::with('getSuplier')
        ->where('kode_barang', 'like', "%{$search}%")
        ->orWhere('nama_barang', 'like', "%{$search}%")
        ->paginate(6);        
        return view('stok.stok', compact(
            'getData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getSuplier = suplier::all();
        return view('stok.addStok', compact(
            'getSuplier'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       $request->validate([
        'kode_barang'=> 'required',
        'nama_barang'=> 'required',
        'harga'=> 'required',
        'stok'=> 'required',
        'suplier'=> 'required',
        'cabang'=> 'required',
       ], [
            'kode_barang.required' => 'Data Wajib diisi!!!',
            'nama_barang.required'=> 'Data Wajib diisi!!!',
            'harga.required'=>'Data Wajib diisi!!!',
            'stok.required' => 'Data Wajib diisi!!!',
            'suplier.required'=> 'Data Wajib diisi!!!',
            'cabang.required'=> 'Data Wajib diisi!!!', 
       ]);
        $saveStok = new stok();
        $saveStok->kode_barang = $request->kode_barang;
        $saveStok->nama_barang = $request->nama_barang;
        $saveStok->harga = $request->harga;
        $saveStok->stok = $request->stok;
        $saveStok->suplier_id = $request->suplier;
        $saveStok->cabang = $request->cabang;
        $saveStok->save();
    
       return redirect('/stok')->with(
        'message',
        'Data barang ' . $request->nama_barang. ' berhasil ditambahkan'
       );
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
        //
    }
}
