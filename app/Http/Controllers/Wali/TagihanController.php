<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index()
    {
        $siswaIds = Auth::user()->siswa->pluck('id');
        $tagihan = Transaksi::whereIn('siswa_id', $siswaIds)->get();
        $data['models'] = $tagihan;
        $data['title']  = 'Data Tagihan SPP';

        return view('wali.tagihan_index', $data);
    }
}
