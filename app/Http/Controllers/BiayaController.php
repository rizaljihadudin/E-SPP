<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Jurusan;
use App\Models\Biaya as Model;
use Illuminate\Support\Str;



class BiayaController extends Controller
{
    private $viewIndex      = 'biaya_index';
    private $viewCreate     = 'biaya_form';
    private $viewEdit       = 'biaya_form';
    private $viewShow       = 'biaya_show';
    private $routePrefix    = 'biaya';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->filled('q')) {
            $models = Model::with('user')->search($request->q)->paginate(50);
        } else {
            /** eager loading pake (with untuk relasi) */
            $models = Model::with('user')->latest()->paginate(50);
        }

        $data = [
            'models'        => $models,
            'title'         => 'Data Biaya',
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
            'title'     => 'Tambah Biaya'
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBiayaRequest $request)
    {
        Model::create($request->validated());
        return  redirect()->route($this->routePrefix . '.index')->with('success', 'Data Biaya berhasil di simpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'title'     => 'Detail Data Biaya',
            'model'     =>  Model::findOrFail($id)
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
            'title'     => 'Update Data Biaya'
        ];

        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBiayaRequest $request, string $id)
    {
        $model = Model::findOrFail($id);
        $model->fill($request->validated());
        $model->save();
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil di hapus.');
    }
}
