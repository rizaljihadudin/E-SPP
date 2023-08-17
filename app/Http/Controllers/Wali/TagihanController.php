<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihan = Transaksi::WaliSiswa()->get();
        $data['models'] = $tagihan;
        $data['title']  = 'Data Tagihan SPP';

        return view('wali.tagihan_index', $data);
    }

    public function show(String $id)
    {
        $tagihan        = Transaksi::WaliSiswa()->findOrFail($id);
        $bankSekolah    = BankSekolah::all();
        $data = [
            'tagihan'       => $tagihan,
            'siswa'         => $tagihan->siswa,
            'bankSekolah'   => $bankSekolah,
        ];

        return view('wali.tagihan_show', $data);
    }
}
