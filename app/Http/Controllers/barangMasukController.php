<?php

namespace App\Http\Controllers;

use App\Models\barangMasuk;
use App\Models\stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = barangMasuk::with(
            'getStok',
            'getSuplier',
            'getAdmin' ,   
        );
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_faktur', [$request->tanggal_awal, $request->tanggal_akhir,]);
        }
        
        $query->orderBy('created_at', 'desc'); //ascending / descending
        $getData = $query->paginate(5);

        return view('Barang.barangMasuk.barangMasuk', compact(
            'getData',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getnama_barang_id = stok::with('getSuplier')->get();
        return view('Barang.barangMasuk.addbarangMasuk', compact(
            'getnama_barang_id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang_id' => 'required',
            //'harga' => 'required',
            'jumlah' => 'required',
            'tanggal_faktur' => 'required',
        ]);
        
        $updateStok = stok::find($request->nama_barang_id);
        if ($request->filled('harga')) {
            $harga_beli = $request->harga;
        }else {
            $harga_beli = $updateStok->harga;
        
        }
    
        $savebarangMasuk = new barangMasuk();
        $savebarangMasuk->tanggal_faktur = $request->tanggal_faktur;
        $savebarangMasuk->nama_barang_id = $request->nama_barang_id;
        $savebarangMasuk->suplier_id = $updateStok->suplier_id;
        $savebarangMasuk->harga_beli = $harga_beli;
        $savebarangMasuk->jumlah_barang_masuk = $request-> jumlah;
        $savebarangMasuk->admin_id = Auth::user()->id;
        //dd($savebarangMasuk);
        $savebarangMasuk->save();
    
        $hitung = $updateStok->stok + $request->jumlah;
    $updateStok->stok = $hitung;
    // dd($savebarangMasuk);
    $updateStok->save();
    
    
    return redirect('/barang-masuk')->with(
        'message',
        'data Barang' . $updateStok->nama_barang . ' berhasil ditambahkan'
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
        $barangMasuk = barangMasuk::find($id);
            $get_id_Stok = $barangMasuk->nama_barang_id;
            $get_jumlah_barang_masuk = $barangMasuk->jumlah_barang_masuk;
        
       $getItemBarang = stok::find($get_id_Stok);
            $getStok = $getItemBarang->stok;

            $updateDataStok = $getStok - $get_jumlah_barang_masuk;
        
           $getItemBarang->stok = $updateDataStok;
        $getItemBarang->save();

    $barangMasuk->delete();

    return redirect()->back()->with(
        'message',
        'Data barang masuk ' . $getItemBarang->nama_barang . ' berhasil dihapus'
    );

    }
}
