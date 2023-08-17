<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(String $id)
    {   
        if(Auth::user()->akses == 'wali') {
            $tagihan    = Transaksi::waliSiswa()->findOrFail(Crypt::decrypt($id));
        }else{
            $tagihan    = Transaksi::findOrFail(Crypt::decrypt($id));
        }
        
        $title      = "Tagihan SPP Bulan {$tagihan->tanggal_tagihan->translatedFormat('F Y')}";

        if(request('output') == 'pdf'){
            $pdf        = Pdf::loadView('invoice_pdf', compact('tagihan', 'title'));
            $namaFile   = "Invoice tagihan {$tagihan->siswa->nama} Bulan {$tagihan->tanggal_tagihan->translatedFormat('F Y')}.pdf";
            return $pdf->download($namaFile);
        }

        return view('invoice_pdf', compact('tagihan', 'title'));
    }
}
