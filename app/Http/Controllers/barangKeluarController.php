<?php

namespace App\Http\Controllers;

use App\Models\barangKeluar;
use App\Models\barangKeluarController as ModelsBarangKeluarController;
use App\Models\pelanggan;
use App\Models\stok;
use Illuminate\Http\Request;

class barangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('barangKeluar.barangKeluar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ModelsBarangKeluarController::all();
        
        $lastId = ModelsBarangKeluarController::max('id');
        $lastId = $lastId ? $lastId : 0;

        if ($data->isEmpty()) {
            $nextId = $lastId + 1;
            $date = now()->format('d/m/Y');
            $kode_transaksi = 'TRK' .$nextId . '/' . $date;
            $pelanggan = pelanggan::all();
        }
        
        return view('barangKeluar.addbarangKeluar', compact(
            'data',
            'kode_transaksi',
            'pelanggan'
        ));
        
        $latestItem = ModelsBarangKeluarController::latest()->first();
        $id = $latestItem->id;
        $date = $latestItem->created_at->format('d/m/Y');
        $kode_transaksi = 'TRK' . ($id+1) . '/' .$date;
        $pelanggan = pelanggan::all();
    
        return view('barangKeluar.addbarangKeluar', compact(
            'data',
            'kode_transaksi',
            'pelanggan'
        ));
    }   

    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_faktur' => 'required',
            'tgl_jatuh_tempo' => 'required',
            'pelanggan_id' => 'required',
            'jenis_pembayaran' => 'required',
        ], [
            'tgl_faktur.required' => 'required',
            'tgl_jatuh_tempo.required' => 'required',
            'pelanggan_id.required' => 'required',
            'jenis_pembayaran.required' => 'required',
        ]);
        
        $kode_transaksi = $request->kode_transaksi;
        $tgl_faktur = $request->tgl_faktur;
        $tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $pelanggan_id = $request->pelanggan_id;
        
        $getNamaPelanggan = pelanggan::find($pelanggan_id);
        $namaPelanggan = $getNamaPelanggan->nama_pelanggan;
        $jenis_pembayaran = $request->jenis_pembayaran;

        $getBarang = stok::all();

        return view('transaksi.transaksi', compact(
            'kode_transaksi',
            'tgl_faktur',
            'tgl_jatuh_tempo',
            'pelanggan_id',
            'namaPelanggan',
            'jenis_pembayaran',
            'getBarang',
        ));
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
