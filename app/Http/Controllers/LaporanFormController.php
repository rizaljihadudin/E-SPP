<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Jurusan;
use App\Models\Pembayaran;

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

        $tagihan        = Transaksi::query();
        $jurusan        = Jurusan::query();
        $title          = '';

        if($request->filled('bulan')){
            $tagihan    = $tagihan->whereMonth('tanggal_tagihan', $request->bulan);
            $title      = "Bulan ".namaBulan($request->bulan);
        }

        if($request->filled('tahun')){
            $tagihan    = $tagihan->whereYear('tanggal_tagihan', $request->tahun);
            $title      = "{$title} Tahun {$request->tahun}";
        }

        if($request->filled('status')){
            $tagihan    = $tagihan->where('status', $request->status);
            $title      = "{$title} Status Tagihan {$request->status}";
        }

        if($request->filled('jurusan')){
            $tagihan    = $tagihan->whereHas('siswa', function ($q) use ($request){
                $q->where('jurusan_id', $request->jurusan);
            });
            $namaJurusan    = $jurusan->where('id', $request->jurusan)->first();
            $title          = "{$title} Jurusan {$namaJurusan->nama_jurusan}";
        }

        if($request->filled('angkatan')){
            $tagihan    = $tagihan->whereHas('siswa', function ($q) use ($request){
                $q->where('angkatan', $request->angkatan);
            });
            $title      = "{$title} Angkatan {$request->angkatan}";
        }

        $tagihan = $tagihan->paginate(settings()->get('app_pagination', '50'));

        return view('operator.laporantagihan_index', compact('tagihan', 'title'));

    }


    public function showLaporanPembayaran(Request $request)
    {
        $pembayaran     = Pembayaran::query();
        $jurusan        = Jurusan::query();
        $title          = '';

        if($request->filled('bulan')){
            $pembayaran = $pembayaran->whereMonth('tanggal_bayar', $request->bulan);
            $title      = "Bulan ".namaBulan($request->bulan);
        }

        if($request->filled('tahun')){
            $pembayaran = $pembayaran->whereYear('tanggal_bayar', $request->tahun);
            $title      = "{$title} {$request->tahun}";
        }

        if($request->filled('status')){
            if($request->status == 'sudah-konfirm'){
                $pembayaran = $pembayaran->whereNotNull('tanggal_konfirmasi');
            }elseif($request->status == 'belum-konfirm'){
                $pembayaran = $pembayaran->whereNull('tanggal_konfirmasi');
            }

            $title      = "{$title} Status Tagihan {}";
        }

        if($request->filled('angkatan')){
            $pembayaran    = $pembayaran->whereHas('transaksi', function ($q) use ($request){
                $q->whereHas('siswa', function ($q) use ($request){
                    $q->where('angkatan', $request->angkatan);
                });
            });
            $title      = "{$title} Angkatan {$request->angkatan}";
        }

        if($request->filled('kelas')){
            $pembayaran    = $pembayaran->whereHas('transaksi', function ($q) use ($request){
                $q->whereHas('siswa', function ($q) use ($request){
                    $q->where('kelas', $request->kelas);
                });
            });
            $title      = "{$title} Kelas {$request->kelas}";
        }

        $pembayaran = $pembayaran->paginate(settings()->get('app_pagination', '50'));
        return view('operator.laporanpembayaran_index', compact('pembayaran', 'title'));
    }
}
