<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $data['models'] = Auth::user()->siswa;
        $data['title']  = 'Data Siswa';

        return view('wali.siswa_index', $data);
    }
}
