<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class KwitansiPembayaranController extends Controller
{
    public function print(String $id)
    {
        $pembayaran = Pembayaran::findOrFail(Crypt::decrypt($id));

        $data = [
            'pembayaran'    => $pembayaran,
            'title'         => "Kwitansi Pembayaran No #{$pembayaran->id}"
        ];

        if(request('output') == 'pdf'){
            $pdf        = Pdf::loadView('kwitansi_pembayaran', $data);
            $namaFile   = "Invoice tagihan {$pembayaran->transaksi->siswa->nama} Bulan {$pembayaran->transaksi->tanggal_tagihan->translatedFormat('F Y')}.pdf";
            return $pdf->download($namaFile);
        }

        return view('kwitansi_pembayaran', $data);
    }
}
