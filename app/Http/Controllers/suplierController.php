<?php

namespace App\Http\Controllers;

use App\Models\suplier;
use Illuminate\Http\Request;

class suplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $data = suplier::where(
            'nama_suplier', 
            'like',
            "%{$search}%"
        )->orWhere(
            'telp',
            'like',
            "&($search)&"
        )->paginate();
        
        return view('Suplier.suplier', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Suplier.addSuplier');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_suplier' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'tgl_terdaftar' => 'required',
            'status' => 'required',
        ], [
            'nama_suplier.required' => 'Data Wajib Diisi',
            'email.required' => 'Data Wajib Diisi',
            'email.email' => 'Format email tidak sesuai',
            'telp.required' => 'Data Wajib Diisi',
            'tgl_terdaftar.required' => 'Data Wajib Diisi',
            'Status.required' => 'Data Wajib Diisi',
        ]);
        $saveSuplier = new suplier();
        $saveSuplier->nama_suplier = $request->nama_suplier;
        $saveSuplier->alamat = $request->alamat;
        $saveSuplier->telp = $request->telp;
        $saveSuplier->email = $request->email;
        $saveSuplier->tgl_terdaftar = $request->tgl_terdaftar;
        $saveSuplier->status = $request->status;
        $saveSuplier->save();
        
        return redirect('/suplier')->with(
            'message',
            'Data ', $request->nama_suplier . ' berhasil ditambahkan!'
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