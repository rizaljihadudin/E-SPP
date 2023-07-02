<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class WaliSiswaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'wali_id' => 'required|exists:users,id',
            'siswa_id' => 'required'
        ], [
            'wali_id.exists' => 'Nama wali belum terdaftar',
            'siswa_id.required' => 'Silahkan pilih siswa!'
        ]);


        $siswa  = Siswa::find($request->siswa_id);
        $siswa->wali_id = $request->wali_id;
        $siswa->wali_status = 'ok';
        $siswa->save();

        return back()->with('success', 'Data Siswa berhasil di tambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->wali_id = null;
        $siswa->wali_status = null;
        $siswa->save();

        return back()->with('success', 'Data Siswa berhasil di hapus.');
    }
}
