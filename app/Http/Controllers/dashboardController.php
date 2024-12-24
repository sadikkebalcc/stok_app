<?php

namespace App\Http\Controllers;

use App\Models\barangKeluarController;
use App\Models\pelanggan;
use App\Models\stok;
use App\Models\suplier;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index(){
        $getSuplier = suplier::count();
        $getPelanggan = pelanggan::count();
        $getStok = stok::count();
        $getPendapatan = barangKeluarController::count();
        return view('Dashboard.dashboard' ,compact(
            'getSuplier',
            'getPelanggan',
            'getStok',
            'getPendapatan',
        ));
    }
}
