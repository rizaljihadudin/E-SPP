<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index(String $via)
    {
        if($via == 'atm'){
            return view('panduan_pembayaran_atm');
        }

        if($via == 'internet-banking'){
            return view('panduan_pembayaran_internet_banking');
        }

        abort(404);
    }
}
