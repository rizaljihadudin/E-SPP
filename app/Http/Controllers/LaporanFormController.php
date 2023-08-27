<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanFormController extends Controller
{
    public function create(Request $request)
    {
        $data = [
            'title' => 'Form Laporan'
        ];
        return view('operator.laporanform_index', @$data);
    }

    public function showLaporanTagihan(Request $request)
    {
        //$tagihan = Transaksi::query();

    }
}
