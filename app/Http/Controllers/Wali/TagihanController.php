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

        $tagihan        = Transaksi::waliSiswa()->latest();

        #pengkondisian search
        if(request()->filled('q')){
            $tagihan = $tagihan->search(request('q'));
        }

        $data['models'] = $tagihan->get();
        $data['title']  = 'Data Tagihan SPP';

        return view('wali.tagihan_index', $data);
    }

    public function show(String $id)
    {
        if(request('id')){
            auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        }

        $tagihan        = Transaksi::WaliSiswa()->findOrFail($id);
        if($tagihan->status == 'lunas'){
            $pembayaranId = $tagihan->pembayaran->last()->id;
            return redirect()->route('wali.pembayaran.show', $pembayaranId);
        }
        $bankSekolah    = BankSekolah::all();
        $data = [
            'tagihan'       => $tagihan,
            'siswa'         => $tagihan->siswa,
            'bankSekolah'   => $bankSekolah,
        ];

        return view('wali.tagihan_show', $data);
    }
}
