<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\WaliBank;
use App\Notifications\PembayaranNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{

    public function index()
    {
        $models     = Pembayaran::where('wali_id', Auth::user()->id)->latest()->orderBy('tanggal_konfirmasi', 'desc')->paginate(50);
        $title      = 'DATA PEMBAYARAN';
        return view('wali.pembayaran_index', compact('models', 'title'));
    }

    public function create(Request $request)
    {
        // Jika user sudah pernah melakukan transaksi sebelumnya, dengan kondisi dia menyimpan informasi bank saat transaksi, tampilkan di select

        $listWaliBank   = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        $tagihan        = Transaksi::WaliSiswa()->findOrFail($request['tagihan_id']);
        $bankSekolah    = BankSekolah::findOrFail($request['bank_sekolah_id']);
        $listBank       = Bank::pluck('nama_bank', 'id');

        $data = [
            'tagihan'       => $tagihan,
            'bankSekolah'   => $bankSekolah,
            'title'         => 'Konfirmasi Pembayaran',
            'pembayaran'    => new Pembayaran(),
            'route'         => 'wali.pembayaran.store',
            'method'        => 'POST',
            'listBank'      => $listBank,
            'listWaliBank'  => $listWaliBank

        ];

        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        if ($request->filled('tambah_data_bank') || $request['list_wali_bank'] <= 0) {
            $this->validationInput($request);

            $bankId         = $request['bank_id_pengirim'];
            $namaRekening   = $request['nama_rekening_pengirim'];
            $nomorRekening  = $request['nomor_rekening'];
            /** kondisi jika user melakukan checked simpan data rekening */
            if ($request->filled('simpan_data_rekening')) {

                // $waliBank = new WaliBank();
                // $waliBank->wali_id          = Auth::user()->id;
                // $waliBank->bank_id          = $bankId;
                // $waliBank->nama_rekening    = $namaRekening;
                // $waliBank->nomor_rekening   = $nomorRekening;
                // $waliBank->save();

                /** refactor code, untuk mencegah double data by nomor rekening */

                $waliBank = WaliBank::firstOrCreate(
                    [
                        'nama_rekening'     => $namaRekening,
                        'nomor_rekening'    => $nomorRekening

                    ],
                    [
                        'wali_id'           => Auth::user()->id,
                        'bank_id'           => $bankId
                    ]
                );
            }
        } else {
            if (!$request['wali_bank_id']) {
                flash()->addError('Silahkan pilih Bank Pengirim!!');
                return back();
            }
            $waliBankId    = $request['wali_bank_id'];
            $waliBank       = WaliBank::findOrFail($waliBankId);
        }

        if (!$request['jumlah_bayar']) {
            flash()->addError('Silahkan masukkan nominal pembayaran!!');
            return back();
        } elseif (!$request['bukti_bayar']) {
            flash()->addError('Silahkan upload Bukti Pembayaran!!');
            return back();
        }

        $jumlahBayar = Str::replace([' ', '.', 'Rp'], '', $request['jumlah_bayar']);

        // validasi pembayaran

        $validasiPembayaran = Pembayaran::where('jumlah_dibayar', $jumlahBayar)
            ->where('transaksi_id', $request['tagihan_id'])
            //->where('status_konfirmasi', 'belum')
            ->first();
        if ($validasiPembayaran) {
            flash()->addInfo('Data pembayaran ini sudah ada, dan akan segera di konfirmasi oleh operator.');
            return redirect()->back();
        }

        // upload bukti pembayaran
        if ($request->hasFile('bukti_bayar')) {
            $foto           = $request->file('bukti_bayar');
            $namaFileBaru   = 'Bukti-Pembayaran_' . date('dmYHis') . '_' . Str::random(9) . '.' . $foto->getClientOriginalExtension();
            $pathTujuan     = 'bukti_bayar/';
            $foto->move($pathTujuan, $namaFileBaru);
            $buktiBayar      = $pathTujuan . $namaFileBaru;
        }

        // insert ke tabel pembayarans
        $dataPembayaran = [
            'transaksi_id'      => $request['tagihan_id'],
            'wali_id'           => $waliBank->wali_id,
            'bank_wali_id'      => $waliBank->id,
            'bank_sekolah_id'   => $request['bank_id'],
            'tanggal_bayar'     => $request['tanggal_bayar'],
            //'status_konfirmasi' => 'belum',
            'jumlah_dibayar'    => $jumlahBayar,
            'bukti_bayar'       => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id'           => 0
        ];

        //validasi pembayaran harus lunas
        $tagihan        = Transaksi::findOrFail($request['tagihan_id']);
        if($request->jumlah_dibayar < $tagihan->total_tagihan){
            DB::beginTransaction();
            try {
                $pembayaran     = Pembayaran::create($dataPembayaran);
                $userOperator   = User::where('akses', 'operator')->get();
                Notification::send($userOperator, new PembayaranNotification($pembayaran));

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                flash()->addError('Gagal menyimpan data pembayaran'. $th->getMessage());
                return redirect()->back();
            }
        }else{
            flash()->addError('Jumlah Pembayaran tidak boleh kurang dari total tagihan.');
            return back();
        }

        flash()->addSuccess('berhasil melakukan pembayaran dan akan segera di konfirmasi oleh operator');
        return redirect()->route('wali.pembayaran.show', $pembayaran->id);
    }

    public function validationInput($request)
    {
        $request->validate([
            'bank_id_pengirim'          => 'required',
            'nama_rekening_pengirim'    => 'required',
            'nomor_rekening'            => 'required|numeric'
        ]);
    }

    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        $data = [
            'model'     => $pembayaran,
            'title'     => 'DATA PEMBAYARAN',
        ];

        return view('wali.pembayaran_show', $data);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        //validasi pembayaran sudah di konfirmasi
        if ($pembayaran->tanggal_konfirmasi) {
            flash()->addError('Data Pembayaran ini sudah dikonfirmasi, tidak bisa dihapus.');
            return redirect()->back();
        }

        // jika data pembayaran belum di konfirmasi
        $image_path = public_path($pembayaran->bukti_bayar);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $pembayaran->delete();
        flash()->addSuccess('Berhasil melakukan Pembatalan');
        return redirect()->route('wali.pembayaran.index');
    }
}
