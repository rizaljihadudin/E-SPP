<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{

    public function create(Request $request)
    {
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
            'listBank'      => $listBank

        ];

        return view('wali.pembayaran_form', $data);
    }
}
