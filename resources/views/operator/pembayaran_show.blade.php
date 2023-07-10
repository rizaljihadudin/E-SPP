@extends('layouts.app_sneat')

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
                                    <td>ID Tagihan</td>
                                    <td>: {{ $model->transaksi_id }}</td>
                                </tr>
                                <tr>
                                    <td>Item tagihan</td>
                                    <td>
                                        <table class="table table-sm">
                                            <thead>
                                                <th width="5%">No.</th>
                                                <th>Nama Biaya</th>
                                                <th>Jumlah</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($model->transaksi->transaksiDetails as $itemTagihan)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $itemTagihan->nama_biaya }}</td>
                                                        <td>{{ formatRupiah($itemTagihan->jumlah_biaya) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK PENGIRIM</td>
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
                                <tr>
                                    <td>Status Konfirmasi</td>
                                    <td>: {{ $model->status_konfirmasi }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: <span
                                            class="badge bg-label-primary">{{ $model->transaksi->getStatusTransaksiWali() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Konfirmasi</td>
                                    <td>: {{ optional($model->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($model->transaksi->status != 'lunas')
                            {!! Form::open([
                                'route' => $route,
                                'method' => $method,
                                'onsubmit' => 'return confirm("Apakah anda yakin, untuk melakukan Konfirmasi Pembayaran?")',
                            ]) !!}
                            {!! Form::hidden('pembayaran_id', $model->id, []) !!}
                            {!! Form::submit('KONFIRMASI PEMBAYARAN', ['class' => 'btn btn-success mt-2']) !!}
                            {!! Form::close() !!}
                        @else
                            <div class="alert alert-primary mt-2" role="alert">
                                <h4>TAGIHAN SUDAH LUNAS</h4>
                            </div>
                        @endif
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
