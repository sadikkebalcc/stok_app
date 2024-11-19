<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\supplierController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AuthController::class, 'index']);
Route::post('/', [AuthController::class, 'login_proses']);

Route::middleware(['auth', 'cekLevel:superadmin,admin'])->group(function(){
    
    /**
     * ini routing tombol logout!!
     */
    Route::get('/logout', [AuthController::class, 'logout']);

    /**
     * ini routing dashboard Controller
     */
    Route::get('/dashboard', [dashboardController::class, 'index']);


    /**
     * ini routing untuk pegawai controller
     */
    Route::controller(pegawaiController::class)->group(function(){

        Route::get('/pegawai', 'index');
        
        Route::post('/pegawai/add', 'store')->name('savePegawai');
        
        Route::get('/pegawai/edit/{id}', 'edit');
        Route::post('/pegawai/edit/{id}', 'update');

        Route::get('/pegawai/{id}', 'destroy');


    });
    /**
     * ini route stok
     */


     /**
      * ini route barang masuk
      */


    /**
     * ini route barang keluar
     */


    /**
     * ini route pelanggan
     */

    /**
     * ini route supplier
     */
    Route::controller(supplierController::class)->group(function(){
        Route::get('/supplier', 'index');
    });
});

