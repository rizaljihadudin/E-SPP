<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User as Model;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Model::where('akses', '<>', 'wali')->latest()->paginate(50);
        $data['models'] = $models;
        return view('operator.user_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model'     => new \App\Models\User(),
            'method'    => 'POST',
            'route'     => 'user.store',
            'button'    => 'SIMPAN'
        ];

        return view('operator.user_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name'      => 'required',
            'email'     => 'required|unique:users',
            'no_hp'     => 'required|unique:users|numeric|min:11',
            'akses'     => 'required|in:operator,admin'
        ], [
            'name.required'     => 'Nama wajib diisi!',
            'email.required'    => 'Email wajib diisi!',
            'email.unique'      => 'Email sudah terdaftar!',
            'no_hp.required'    => 'No. HP wajib diisi',
            'no_hp.unique'      => 'No. HP sudah terdaftar',
            'no_hp.numeric'     => 'No. HP harus menggunakan format angka',
            'no_hp.min'         => 'No. HP minimal 11 angka',
            'akses.required'    => 'Akses wajib diisi!'
        ]);

        $requestData['password'] = bcrypt('12345678');

        Model::create($requestData);
        return back()->with('success', 'Data berhasil di simpan.');
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
