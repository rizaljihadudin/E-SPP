<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Biaya;
use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Jurusan;
use App\Models\Siswa as Model;
use App\DataTables\SiswaDataTable;



class SiswaController extends Controller
{
    private $viewIndex      = 'siswa_index';
    private $viewCreate     = 'siswa_form';
    private $viewEdit       = 'siswa_form';
    private $viewShow       = 'siswa_show';
    private $routePrefix    = 'siswa';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, SiswaDataTable $dataTable)
    {
        $models = Model::with('wali', 'jurusan')->latest();

        if ($request->filled('q')) {
            $models = $models->search($request->q);
        }

        $data = [
            'models'        => $models->paginate(settings()->get('app_pagination', 50)),
            'title'         => 'Data Siswa',
            'routePrefix'   => $this->routePrefix
        ];
        return view('operator.' . $this->viewIndex, $data);
        // return $dataTable->render('operator.siswa_index_yajra');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama_biaya', 'id'),
            'model'     => new Model(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . '.store',
            'button'    => 'SIMPAN',
            'title'     => 'Tambah Siswa',
            'wali'      => User::where('akses', 'wali')->pluck('name', 'id')
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        $requestData = $request->validated();

        if ($request->hasFile('foto')) {
            $foto           = $request->file('foto');
            $nisn           = $requestData['nisn'];
            $nama           = str_replace(' ', '-', $requestData['nama']);
            $namaFileBaru   = $nama . '_' . $nisn . '.' . $foto->getClientOriginalExtension();
            $pathTujuan     = 'foto_siswa/';
            $foto->move($pathTujuan, $namaFileBaru);

            $requestData['foto']        = $pathTujuan . $namaFileBaru;
        }
        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }

        Model::create($requestData);

        return  redirect()->route($this->routePrefix . '.index')->with('success', 'Data Siswa berhasil di simpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'title'     => 'Detail Data Siswa',
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
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama_biaya', 'id'),
            'model'     => Model::findOrFail($id),
            'method'    => 'PUT',
            'route'     => [$this->routePrefix . '.update', $id],
            'button'    => 'UPDATE',
            'title'     => 'Update Data Siswa',
            'wali'      => User::where('akses', 'wali')->pluck('name', 'id'),
            'jurusan'   => Jurusan::pluck('nama_jurusan', 'id')
        ];

        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaRequest $request, string $id)
    {
        $requestData = $request->validated();

        $model = Model::findOrFail($id);

        if ($request->hasFile('foto')) {
            if($model->foto != null && file_exists($model->foto)){
                unlink($model->foto);
            }

            $foto           = $request->file('foto');
            $nisn           = $requestData['nisn'];
            $nama           = str_replace(' ', '-', $requestData['nama']);
            $namaFileBaru   = $nama . '_' . $nisn . '.' . $foto->getClientOriginalExtension();
            $pathTujuan     = 'foto_siswa/';
            $foto->move($pathTujuan, $namaFileBaru);
            $requestData['foto']        = $pathTujuan . $namaFileBaru;
        }

        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }
        $requestData['user_id']     = auth()->user()->id;
        $requestData['updated_at']  = date('Y-m-d H:i:s');
        $model->fill($requestData);
        $model->save();
        flash()->addSuccess('Data berhasil di update!');
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Model::findOrFail($id);
        if ($siswa->transaksi->count() >= 1) {
            return back()->with('error', 'Data tidak bisa di hapus, di karenakan masih memiliki relasi data tagihan.');
        }

        unlink($siswa->foto);
        $siswa->delete();
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil di hapus.');
    }
}
