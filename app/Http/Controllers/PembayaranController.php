<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Models\Transaksi;
use App\Notifications\PembayaranKonfirmasiNotification;
use Illuminate\Http\Request;
use Nicolaslopezj\Searchable\SearchableTrait;

class PembayaranController extends Controller
{

    public function index(Request $request)
    {
        $models     = Pembayaran::latest()->orderBy('tanggal_konfirmasi', 'desc');

        if($request->filled('bulan')){
            $models = $models->whereMonth('tanggal_bayar', $request->bulan);
        }

        if($request->filled('tahun')){
            $models = $models->whereYear('tanggal_bayar', $request->tahun);
        }

        if($request->filled('q')){
            $models = $models->search($request->q, null, true, true);
        }

        if($request->filled('status')){
            if($request->status == 'sudah-konfirm'){
                $models = $models->whereNotNull('tanggal_konfirmasi');
            }elseif($request->status == 'belum-konfirm'){
                $models = $models->whereNull('tanggal_konfirmasi');
            }
        }

        $models     = $models->paginate(settings()->get('app_pagination', '50'));
        $title      = 'DATA PEMBAYARAN';
        return view('operator.pembayaran_index', compact('models', 'title'));
    }


    public function create()
    {
        //
    }


    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        $requestData['tanggal_konfirmasi']  = now();
        $requestData['metode_pembayaran']   = 'manual';

        #cek jumlah tagihan
        $tagihan = Transaksi::findOrFail($requestData['transaksi_id']);
        $requestData['wali_id'] = $tagihan->siswa->wali_id ?? 0;

        #simpan pembayaran
        $pembayaran = Pembayaran::create($requestData);

        #kirim notifikasi ke wali murid
        $wali = $pembayaran->wali;
        if($wali){
            $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        }
        flash()->addSuccess('Data Pembayaran berhasil di simpan.');
        return  redirect()->back();
    }

    public function show(Pembayaran $pembayaran)
    {
        # untuk melakukan update notifikasi
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        $data = [
            'model'     => $pembayaran,
            'title'     => 'DATA PEMBAYARAN',
            'route'     => ['pembayaran.update', $pembayaran->id],
            'method'    => 'PUT'
        ];

        return view('operator.pembayaran_show', $data);
    }

    public function edit(Pembayaran $pembayaran)
    {
        //
    }


    public function update(Request $request, Pembayaran $pembayaran)
    {
        #untuk update data di tabel pembayarans
        $wali = $pembayaran->wali;
        $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        $pembayaran->tanggal_konfirmasi = now();
        $pembayaran->user_id = auth()->user()->id;
        $pembayaran->save();

        #update data di tabel transaksis
        flash()->addSuccess('Data Pembayaran berhasil di konfirmasi.');
        return  redirect()->back();
    }

    public function destroy(Pembayaran $pembayaran)
    {
        #delete pembayaran
        $pembayaran->delete();
        flash()->addSuccess('Data Pembayaran berhasil di hapus.');
        return  redirect()->back();
    }
}
