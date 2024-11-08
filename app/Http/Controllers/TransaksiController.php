<?php

namespace App\Http\Controllers;

use App\Models\Transaksi as Model;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Biaya;
use App\Models\Pembayaran;
use App\Models\TransaksiDetail;
use App\Models\User;
use App\Notifications\TagihanNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

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
        $models = Model::latest();

        if($request->filled('bulan')){
            $models = $models->whereMonth('tanggal_tagihan', $request->bulan);
        }

        if($request->filled('tahun')){
            $models = $models->whereYear('tanggal_tagihan', $request->tahun);
        }

        if($request->filled('q')){
            $models = $models->search($request->q, null, true, true);
        }

        $data = [
            'models'        => $models->paginate(settings()->get('app_pagination', '50')),
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
            //'biaya'     => Biaya::get()->pluck('nama_biaya_full', 'id')
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request)
    {
        $requestData    = $request->validated();

        DB::beginTransaction();

        //get semua data siswa yang statusnya aktif
        $siswa          = Siswa::currentStatus('aktif')->get();
        foreach ($siswa as $itemSiswa) {
            $dataTagihan = [
                'siswa_id'              => $itemSiswa->id,
                'tanggal_tagihan'       => $requestData['tanggal_tagihan'],
                'tanggal_jatuh_tempo'   => $requestData['tanggal_jatuh_tempo'],
                'keterangan'            => $requestData['keterangan'],
                'status'                => 'baru'
            ];

            $tanggalTagihan     = Carbon::parse($requestData['tanggal_tagihan']);
            $tanggalJatuhTempo  = Carbon::parse($requestData['tanggal_jatuh_tempo']);
            $bulanTagihan       = $tanggalTagihan->format('m');
            $tahunTagihan       = $tanggalTagihan->format('Y');
            $cekTagihan         = Model::where('siswa_id', $itemSiswa->id)
                ->whereMonth('tanggal_tagihan', $bulanTagihan)
                ->whereYear('tanggal_tagihan', $tahunTagihan)
                ->first();

            //kalo tagihan belum pernah dibuat
            if (!$cekTagihan) {
                $tagihan = Model::create($dataTagihan);

                $wali    = User::whereIn('id', $siswa->pluck('wali_id'))->get();
                if($tagihan->siswa->wali != null){
                    Notification::send($tagihan->siswa->wali, new TagihanNotification($tagihan));
                }
                $biaya   = $itemSiswa->biaya->children;
                foreach ($biaya as $itemBiaya) {
                    $detail = TransaksiDetail::create([
                        'transaksi_id'  => $tagihan->id,
                        'nama_biaya'    => $itemBiaya->nama_biaya,
                        'jumlah_biaya'  => $itemBiaya->jumlah
                    ]);
                }
            }
        }
        DB::commit();
        //return  redirect()->route($this->routePrefix . '.index')->with('success', 'Data Transaksi berhasil di simpan.');
        return response()->json([
            'message'   => 'Data Berhasil Disimpan!'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {
        $siswa = Siswa::findOrFail($request->siswa_id);
        $tahun = $request->tahun;
        $arrayData = [];
        foreach(bulanSPP() as $bulan){
            ($bulan == 1) ?? $tahun += 1;

            $tagihan = Model::where('siswa_id',$request->siswa_id)
                ->whereYear('tanggal_tagihan', $tahun)
                ->whereMonth('tanggal_tagihan', $bulan)
                ->first();

                $tanggalBayar = '';
                if($tagihan != null && $tagihan->status != 'baru'){
                    $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/Y');
                }
                $arrayData[] = [
                    'bulan'             => namaBulan($bulan),
                    'tahun'             => $tahun,
                    'total_tagihan'     => $tagihan->total_tagihan ?? 0,
                    'status'            => ($tagihan == null ) ? false : true,
                    'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                    'tanggal_bayar'     => $tanggalBayar
                ];
        }

        $tagihan = Model::with('pembayaran')->findOrFail($id);
        $date = '01' . $request->bulan . ' ' . $request->tahun;
        $periode = Carbon::parse($date)->isoFormat('MMMM Y');
        $data = [
            'models'        => $tagihan,
            'siswa'         => $tagihan->siswa,
            'periode'       => $periode,
            'title'         => 'Detail Tagihan Siswa',
            'routePrefix'   => $this->routePrefix,
            'pembayaran'    => new Pembayaran(),
            'kartuSpp'      => collect($arrayData)
        ];
        return view('operator.' . $this->viewShow, $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Model $tagihan)
    {
        $data = [
            'title' => 'EDIT DATA TRANSAKSI'
        ];

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
