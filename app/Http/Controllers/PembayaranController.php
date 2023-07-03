<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Transaksi;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $requestData['status_konfirmasi'] = 'sudah';
        $requestData['metode_pembayaran'] = 'manual';

        /** cek jumlah tagihan */
        $tagihan = Transaksi::findOrFail($requestData['transaksi_id']);
        if ($requestData['jumlah_dibayar'] >= $tagihan->transaksiDetails->sum('jumlah_biaya')) {
            $tagihan->status = 'lunas';
        } else {
            $tagihan->status = 'angsuran';
        }
        $tagihan->save();

        Pembayaran::create($requestData);
        return  redirect()->back()->with('success', 'Data Pembayaran berhasil di simpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        //
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
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
