<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::paginate();
        return view(
            'Pegawai.pegawai', compact(
                'data'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'level' => 'required',
        ]);

        $save = new User();
        $save->name = $request->name;
        $save->email = $request->email;
        $save->password = Hash::make($request->password);
        $save->level = $request->level;
        $save->save();

        return redirect()->back()->with(
            'message',
            'Data Pegawai ' .$request->name. 'Berhasil Ditambahkan'
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
        $data = User::find($id);
            return view('Pegawai.editPegawai', compact(

                'data'
            ));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|min:8',
            'level' => 'nullable',
        ], [
            'name.required' => 'Data wajib diisi',
            'email.email' => 'Format email tidak sesuai!!!',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $update = user::find($id);
        $update->name = $request->name;
        
        if ($request->filled('email') && $request->email != $update->email) {
            $request->validate([
                'email' => 'unique:users,email',
            ], [
                'email.unique' => 'Email sudah terdaftar'
            ]);

            $update->email = $request->email;
        }
        if ($request->filled('password')) {
            $update->password = $request->password;
        }
        if ($request->filled('level')) {
            $update->level = $request->level;
        }

        $update->save();

        return redirect('/pegawai')->with(
            'message',
            'Data'. $request->name . ' Berhasil di perbarui'
        );
    }   
        
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gpa107a = User::find($id);
        $gpa107a->delete();

        return redirect()->back()->with(
            'message',
            'Data ' . $gpa107a->name . ' Berhasil dihapus!'
        );
    }
}
