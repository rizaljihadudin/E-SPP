<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $data['models'] = Auth::user()->siswa;
        $data['title']  = 'Data Siswa';

        return view('wali.siswa_index', $data);
    }

    public function show($id)
    {
        $data['model']  = Siswa::with('jurusan', 'biaya')
                            ->where(
                                [
                                    'id' => $id, 
                                    'wali_id' => Auth::user()->id
                                ])
                            ->firstOrFail();
        $data['title']  = 'Detail Data Siswa';
        return view('wali.siswa_show', $data);
    }
}
