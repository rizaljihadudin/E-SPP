@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI TAGIHAN</td>
                                </tr>
                                <tr>
                                    <td width="18%">No</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>Invoice Tagihan</td>
                                    <td>:
                                        <a href="{{ route('invoice.show', Crypt::encrypt($model->transaksi_id)) }}" target="_blank">
                                            <i class="fa fa-print"></i> Cetak Invoice tagihan
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Tagihan</td>
                                    <td>: {{ formatRupiah($model->transaksi->transaksiDetails->sum('jumlah_biaya')) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI SISWA</td>
                                </tr>
                                <tr>
                                    <td>Nama Siswa</td>
                                    <td>: {{ ucwords($model->transaksi->siswa->nama) }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Wali</td>
                                    <td>: {{ ucwords($model->wali->name) }}</td>
                                </tr>
                                @if ($model->metode_pembayaran == 'transfer')
                                    <tr>
                                        <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK PENGIRIM
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bank Pengirim</td>
                                        <td>: {{ $model->waliBank->bank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Rekening</td>
                                        <td>: {{ $model->waliBank->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->waliBank->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK TUJUAN
                                            TRANSFER</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Tujuan Transfer</td>
                                        <td>: {{ $model->BankSekolah->bank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Rekening</td>
                                        <td>: {{ $model->BankSekolah->nama_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->BankSekolah->nomor_rekening }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI PEMBAYARAN</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>: {{ strtoupper($model->metode_pembayaran) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Bayar</td>
                                    <td>: {{ optional($model->tanggal_bayar)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Total tagihan</td>
                                    <td>: {{ formatRupiah($model->transaksi->transaksiDetails->sum('jumlah_biaya')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jumlah Yang Dibayar</td>
                                    <td>: {{ formatRupiah($model->jumlah_dibayar) }}</td>
                                </tr>
                                @if ($model->bukti_bayar != null)
                                <tr>
                                    <td>Bukti Bayar</td>
                                    <td>:
                                        <a href="javascript:;"
                                            onclick="popupCenter({'url': '{{ url($model->bukti_bayar) }}',
                                            title: 'Bukti Bayar' , w: 900, h: 500});">
                                            <i class="fa fa-file"></i> Lihat Bukti Bayar
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Status Konfirmasi</td>
                                    <td>: {{ $model->status_konfirmasi }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: <span
                                            class="badge bg-success">{{ $model->transaksi->getStatusTransaksiWali() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Konfirmasi</td>
                                    <td>: {{ optional($model->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($model->transaksi->status == 'lunas')
                            <div class="alert alert-primary mt-2" role="alert">
                                <h4>TAGIHAN SUDAH LUNAS</h4>
                            </div>
                            <a href="{{ route('kwitansipembayaran.print', Crypt::encrypt($model->id)) }}" target="blank"> <i class="fa fa-file-pdf"></i> Download Kwitansi </a>
                        @endif
                        {!! Form::open([
                            'route' => ['wali.pembayaran.destroy', $model->id],
                            'method' => 'DELETE',
                            'title' => 'Hapus Data',
                            'class' => 'mt-3',
                            'onsubmit' => 'return confirm("Apakah anda yakin, ingin menghapus data ini?")',
                        ]) !!}
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-dark']) !!}
                        @if ($model->status_konfirmasi != 'Sudah Dikonfirmasi')
                            <button class="btn btn-danger btn-md">
                                <i class="fa fa-xmark fa-xl"></i> Batalkan Konfirmasi Pembayaran ini
                            </button>
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const popupCenter = ({
            url,
            title,
            w,
            h
        }) => {
            // Fixes dual-screen position                             Most browsers      Firefox
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      `
            )

            if (window.focus) newWindow.focus();
        }
    </script>
@endsection
