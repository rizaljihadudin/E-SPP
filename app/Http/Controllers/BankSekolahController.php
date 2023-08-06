<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankSekolahRequest;
use App\Http\Requests\UpdateBankSekolahRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\BankSekolah as Model;



class BankSekolahController extends Controller
{
    private $viewIndex      = 'banksekolah_index';
    private $viewCreate     = 'banksekolah_form';
    private $viewEdit       = 'banksekolah_form';
    private $viewShow       = 'banksekolah_show';
    private $routePrefix    = 'banksekolah';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $models = Model::latest()->paginate(settings()->get('app_pagination', 50));
        $data = [
            'models'        => $models,
            'title'         => 'Data Rekening Sekolah',
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
            'title'     => 'Tambah Data Rekening Sekolah',
            'listBank'  => Bank::pluck('nama_bank', 'id')
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankSekolahRequest $request)
    {
        Model::create($request->validated());
        return  redirect()->route($this->routePrefix . '.index')->with('success', 'Data Bank berhasil di simpan.');
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
            'title'     => 'Update Data Rekening Sekolah',
            'listBank'  => Bank::pluck('nama_bank', 'id')
        ];

        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankSekolahRequest $request, string $id)
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
