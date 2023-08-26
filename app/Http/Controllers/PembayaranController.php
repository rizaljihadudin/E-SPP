<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Models\Transaksi;
use App\Notifications\PembayaranKonfirmasiNotification;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models     = Pembayaran::latest()->orderBy('tanggal_konfirmasi', 'desc')->paginate(50);
        $title      = 'DATA PEMBAYARAN';
        return view('operator.pembayaran_index', compact('models', 'title'));
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
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        
        //$requestData['status_konfirmasi']   = 'sudah';
        $requestData['tanggal_konfirmasi']  = now();
        $requestData['metode_pembayaran']   = 'manual';         

        /** cek jumlah tagihan */
        $tagihan = Transaksi::findOrFail($requestData['transaksi_id']);
        if ($requestData['jumlah_dibayar'] >= $tagihan->transaksiDetails->sum('jumlah_biaya')) {
            $tagihan->status = 'lunas';
        } else {
            $tagihan->status = 'angsuran';
        }
        $tagihan->save();
        $pembayaran = Pembayaran::create($requestData);
        $wali = $pembayaran->wali;
        $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        return  redirect()->back()->with('success', 'Data Pembayaran berhasil di simpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        // untuk melakukan update notifikasi
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        $data = [
            'model'     => $pembayaran,
            'title'     => 'DATA PEMBAYARAN',
            'route'     => ['pembayaran.update', $pembayaran->id],
            'method'    => 'PUT'
        ];

        return view('operator.pembayaran_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        // untuk update data di tabel pembayarans

        $wali = $pembayaran->wali;
        $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        $pembayaran->tanggal_konfirmasi = now();
        $pembayaran->user_id = auth()->user()->id;
        $pembayaran->save();

        //update data di tabel transaksis
        $pembayaran->transaksi->status = 'lunas';
        $pembayaran->transaksi->save();
        return  redirect()->back()->with('success', 'Data Pembayaran berhasil di konfirmasi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
