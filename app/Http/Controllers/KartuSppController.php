<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuSppController extends Controller
{
    public function index(Request $request)
    {

        if(Auth::user()->akses == 'wali') {
            $siswa = Siswa::where(['wali_id' => Auth::user()->id, 'id' => $request->siswa_id])->firstOrFail();
        }else{
            $siswa = Siswa::findOrFail($request->siswa_id);
        }

        $tahun = $request->tahun;
        $arrayData = [];

        foreach(bulanSPP() as $bulan){

            #kondisi jika bulan == 1, maka tahun di tambahkan 1
            ($bulan == 1) ?? $tahun += 1;

            $tagihan = Transaksi::where('siswa_id', $request->siswa_id)
                ->whereYear('tanggal_tagihan', $tahun)
                ->whereMonth('tanggal_tagihan', $bulan)
                ->first();

                $tanggalBayar = '';
                if($tagihan != null && $tagihan->status != 'baru'){
                    $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/Y');
                }
                $arrayData[] = [
                    'bulan'             => namaBulan($bulan),
                    'tahun'             => $tahun,
                    'total_tagihan'     => $tagihan->total_tagihan ?? 0,
                    'status'            => ($tagihan == null ) ? false : true,
                    'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                    'tanggal_bayar'     => $tanggalBayar
                ];
        }
        $title = 'Kartu SPP';

        if(request('output') == 'pdf'){
            $pdf        = Pdf::loadView('kartu_spp', [
                'kartuSpp' => collect($arrayData),
                'siswa' => $siswa,
                'title' => $title
            ]);
            $namaFile   = "Kartu SPP {$siswa->nama} Tahun {$request->tahun}.pdf";
            return $pdf->download($namaFile);
        }

        return view('kartu_spp', [
            'kartuSpp' => collect($arrayData),
            'siswa' => $siswa,
            'title' => $title
        ]);

    }
}
