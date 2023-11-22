<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('transaksi')->where('wali_id', auth()->user()->id)->orderBy('nama', 'asc')->get();
        foreach($siswa as $itemSiswa){
            $tahun          = date('Y');
            $dataTagihan    = [];
            foreach(bulanSPP() as $bulan){
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
                    'tagihan'           => $tagihan,
                    'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                    'tanggal_lunas'     => $tagihan?->tanggal_lunas ?? '-',
                    'status_bayar'      => $tagihan?->status == 'lunas' ? true : false,
                    'status_bayar_txt'  => $tagihan?->status == 'baru' ? 'Belum Bayar' : $tagihan?->status,
                ];
            }

            $dataRekap[] = [
                'siswa'         => $itemSiswa,
                'dataTagihan'   => $dataTagihan
            ];
        }
        $data['dataRekap']      = $dataRekap;
        $data['header']          = bulanSPP();
        return view('wali.beranda_index', $data);
    }
}
