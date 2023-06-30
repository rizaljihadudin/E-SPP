<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User as Model;



class WaliController extends Controller
{
    private $viewIndex      = 'user_index';
    private $viewCreate     = 'user_form';
    private $viewEdit       = 'user_form';
    private $viewShow       = 'user_show';
    private $routePrefix    = 'wali';

    public function index()
    {
        $models = Model::where('akses', 'wali')->latest()->paginate(50);
        $data = [
            'models'        => $models,
            'title'         => 'Data Wali Murid',
            'routePrefix'   => $this->routePrefix
        ];
        return view('operator.' . $this->viewIndex, $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model'     => new Model(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . '.store',
            'button'    => 'SIMPAN',
            'title'     => 'Tambah Wali Murid'
        ];

        return view('operator.' . $this->viewCreate, $data);
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
            'akses'     => 'required'
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
        $models = Model::with('siswa')->wali()->findOrfail($id);
        $data = [
            'model'        => $models,
            'title'         => 'Detail Wali Murid',
            'routePrefix'   => $this->routePrefix
        ];
        return view('operator.' . $this->viewShow, $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'model'     => Model::findOrFail($id),
            'method'    => 'PUT',
            'route'     => [$this->routePrefix . '.update', $id],
            'button'    => 'UPDATE',
            'title'     => 'Update Wali Murid'
        ];

        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestData = $request->validate([
            'name'      => 'required',
            'email'     => 'required|unique:users,email,' . $id,
            'no_hp'     => 'required|unique:users, no_hp,' . $id,
            'no_hp'     => 'numeric|min:11',
            'akses'     => 'required'
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

        $model = Model::findOrFail($id);
        $model->fill($requestData);
        $model->save();
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Model::where('akses', 'wali')->findOrFail($id);

        $model->delete();
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil di hapus.');
    }
}
