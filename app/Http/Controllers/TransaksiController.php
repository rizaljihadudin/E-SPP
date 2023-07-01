<?php

namespace App\Http\Controllers;

use App\Models\Transaksi as Model;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Biaya;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    private $viewIndex      = 'transaksi_index';
    private $viewCreate     = 'transaksi_form';
    private $viewEdit       = 'transaksi_form';
    private $viewShow       = 'transaksi_show';
    private $routePrefix    = 'transaksi';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $models = Model::with('user', 'siswa')
                ->whereMonth('tanggal_tagihan', $request->bulan)
                ->whereYear('tanggal_tagihan', $request->tahun)
                ->groupBy('siswa_id')
                ->paginate(50);
        } else {
            $models = Model::with('user', 'siswa')->groupBy('siswa_id')->latest()->paginate(50);
        }

        $data = [
            'models'        => $models,
            'title'         => 'Data Tagihan',
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
            'title'     => 'Tambah Transaksi',
            'biaya'     => Biaya::get()->pluck('nama_biaya_full', 'id')
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        $requestData    = $request->validated();
        $biayaIdArray   = $requestData['biaya_id'];
        $siswa          = Siswa::query();

        if ($requestData['kelas']) {
            $siswa->where('kelas', $requestData['kelas']);
        }

        if ($requestData['angkatan']) {
            $siswa->where('angkatan', $requestData['angkatan']);
        }

        $siswa = $siswa->get();

        foreach ($siswa as $item) {
            $itemSiswa  = $item;
            $biaya      = Biaya::whereIn('id', $biayaIdArray)->get();
            foreach ($biaya as $itemBiaya) {
                $dataTagihan = [
                    'siswa_id'              => $itemSiswa->id,
                    'angkatan'              => $requestData['angkatan'],
                    'kelas'                 => $requestData['kelas'],
                    'tanggal_tagihan'       => $requestData['tanggal_tagihan'],
                    'tanggal_jatuh_tempo'   => $requestData['tanggal_jatuh_tempo'],
                    'nama_biaya'            => $itemBiaya->nama_biaya,
                    'jumlah_biaya'          => $itemBiaya->jumlah,
                    'keterangan'            => $requestData['keterangan'],
                    'status'                => 'baru'
                ];

                $tanggalTagihan     = Carbon::parse($requestData['tanggal_tagihan']);
                $tanggalJatuhTempo  = Carbon::parse($requestData['tanggal_jatuh_tempo']);
                $bulanTagihan       = $tanggalTagihan->format('m');
                $tahunTagihan       = $tanggalTagihan->format('Y');
                $cekTagihan         = Model::where('siswa_id', $itemSiswa->id)
                    ->where('nama_biaya', $itemBiaya->nama_biaya)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();

                if (!$cekTagihan) {
                    Model::create($dataTagihan);
                }
            }
        }
        return  redirect()->route($this->routePrefix . '.index')->with('success', 'Data Transaksi berhasil di simpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {
        $tagihan = Model::with('siswa')
            ->where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal_tagihan', $request->bulan)
            ->whereYear('tanggal_tagihan', $request->tahun)
            ->get();
        $siswa  = Siswa::where('id', $request->siswa_id)->first();
        $date = '01' . $request->bulan . ' ' . $request->tahun;
        $periode = Carbon::parse($date)->isoFormat('MMMM Y');
        $data = [
            'models'        => $tagihan,
            'siswa'         => $siswa,
            'periode'       => $periode,
            'title'         => 'Detail Tagihan Siswa',
            'routePrefix'   => $this->routePrefix
        ];
        return view('operator.' . $this->viewShow, $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model $tagihan)
    {
        $data = [];

        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Model $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}
