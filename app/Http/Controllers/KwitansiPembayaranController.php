<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KwitansiPembayaranController extends Controller
{
    public function print(String $id)
    {
        $data = [
            'pembayaran' => Pembayaran::findOrFail($id)
        ];

        return view('operator.kwitansi_pembayaran', $data);
    }
}
