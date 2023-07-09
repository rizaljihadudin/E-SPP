<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\WaliBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{

    public function create(Request $request)
    {
        // Jika user sudah pernah melakukan transaksi sebelumnya, dengan kondisi dia menyimpan informasi bank saat transaksi, tampilkan di select

        $listWaliBank   = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        $tagihan        = Transaksi::WaliSiswa()->findOrFail($request['tagihan_id']);
        $bankSekolah    = BankSekolah::findOrFail($request['bank_sekolah_id']);
        $listBank       = Bank::pluck('nama_bank', 'id');

        $data = [
            'tagihan'       => $tagihan,
            'bankSekolah'   => $bankSekolah,
            'title'         => 'Konfirmasi Pembayaran',
            'pembayaran'    => new Pembayaran(),
            'route'         => 'wali.pembayaran.store',
            'method'        => 'POST',
            'bank'          => Bank::where('id', $request['bank_id'])->first(),
            'listBank'      => $listBank,
            'listWaliBank'  => $listWaliBank

        ];

        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        if ($request->filled('tambah_data_bank')) {
            $this->validationInput($request);

            $bankId         = $request['bank_id_pengirim'];
            $namaRekening   = $request['nama_rekening_pengirim'];
            $nomorRekening  = $request['nomor_rekening'];
            /** kondisi jika user melakukan checked simpan data rekening */
            if ($request->filled('simpan_data_rekening')) {

                // $waliBank = new WaliBank();
                // $waliBank->wali_id          = Auth::user()->id;
                // $waliBank->bank_id          = $bankId;
                // $waliBank->nama_rekening    = $namaRekening;
                // $waliBank->nomor_rekening   = $nomorRekening;
                // $waliBank->save();

                /** refactor code, untuk mencegah double data by nomor rekening */

                $waliBank = WaliBank::firstOrCreate(
                    [
                        'nama_rekening'     => $namaRekening,
                        'nomor_rekening'    => $nomorRekening

                    ],
                    [
                        'wali_id'           => Auth::user()->id,
                        'bank_id'           => $bankId
                    ]
                );
            }
        } else {
            $waliBankId    = $request['wali_bank_id'];
            $waliBank  = WaliBank::findOrFail($waliBankId);
        }

        dd($waliBank);
    }

    public function validationInput($request)
    {
        $request->validate([
            'bank_id_pengirim'          => 'required',
            'nama_rekening_pengirim'    => 'required',
            'nomor_rekening'            => 'required|numeric'
        ]);
    }
}
