<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use Illuminate\Http\Request;

class pelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = pelanggan::paginate();
        return view('pelanggan.pelanggan', compact(
            'getData',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.addpelanggan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valueData = $request->validate([
            'nama_pelanggan'=> 'required',
            'telp' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
        ], [
            'nama_pelanggan.required' => 'Data wajib diisi!!',
            'telp.required' => 'Data wajib diisi!!!',
            'jenis_kelamin.required' => 'Data wajib diisi!!!',
            'alamat.required' => 'Data wajib diisi!!!',
            'kota.required' => 'Data wajib diisi!!!',
            'provinsi.required' => 'Data wajib diisi!!!',
        ]);

        pelanggan::create($valueData);

        return redirect('/pelanggan')->with(
            'message',
            '' . $request->nama_pelanggan . ' berhasil terdaftar'
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
        $getData = pelanggan::find($id);
        return view('pelanggan.editpelanggan', compact(
            'getData',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_pelanggan'=> 'required',
            'telp' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
        ], [
            'nama_pelanggan.required' => 'Data wajib diisi!!',
            'telp.required' => 'Data wajib diisi!!!',
            'jenis_kelamin.required' => 'Data wajib diisi!!!',
            'alamat.required' => 'Data wajib diisi!!!',
            'kota.required' => 'Data wajib diisi!!!',
            'provinsi.required' => 'Data wajib diisi!!!',
        ]);

        $updatePelanggan = pelanggan::find($id);
        $updatePelanggan->nama_pelanggan= $request->nama_pelanggan;
        $updatePelanggan->telp = $request->telp;
        $updatePelanggan->jenis_kelamin = $request->jenis_kelamin;
        $updatePelanggan->alamat= $request->alamat;
        $updatePelanggan->kota= $request->kota;
        $updatePelanggan->provinsi= $request->provinsi;
        $updatePelanggan->save();
    
        return redirect('/pelanggan')->with(
            'message',
            'Data pelanggan ' . $request->nama_pelanggan . ' Berhasil Diperbarhui'
        );
    
    
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = pelanggan::find($id);
        $data->delete();

        return redirect()->back()->with(
            'message', 
            'Data Berhasil dihapus'
        );
    }
}
