<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanRekapPembayaran extends Controller
{
    function index(Request $request)
    {
        $data['header'] = bulanSPP();
        $siswa          = Siswa::with('transaksi')->orderBy('nama', 'asc');

        #filter untuk kelas
        if($request->filled('kelas')){
            $siswa->where('kelas', $request->kelas);
        }

        $siswa          = $siswa->get();
        $dataRekap      = [];
        foreach($siswa as $itemSiswa){
            $tahun          = $request->tahun;
            $dataTagihan    = [];
            foreach($data['header'] as $bulan){
                #kondisi jika bulan == 1, maka tahun di tambahkan 1
                ($bulan == 1) ?? $tahun += 1;

                #mencari tagihan berdasarkan siswa, tahun, dan bulan
                $tagihan = $itemSiswa->transaksi->filter(function ($value) use ($bulan, $tahun) {
                    return $value->tanggal_tagihan->year == $tahun && $value->tanggal_tagihan->month == $bulan;
                })->first();

                #masukkan hasil data ke dalam array
                $dataTagihan[] = [
                    'bulan'             => namaBulan($bulan),
                    'tahun'             => $tahun,
                    'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                    'tanggal_lunas'     => $tagihan->tanggal_lunas ?? '-'
                ];
            }

            $dataRekap[] = [
                'siswa' => $itemSiswa,
                'data'  => $dataTagihan
            ];
        }
        $data['dataRekap']      = $dataRekap;
        $data['title']          = "Rekap Tagihan";
        return view('operator.laporanrekappembayaran_index', $data);
    }
}
