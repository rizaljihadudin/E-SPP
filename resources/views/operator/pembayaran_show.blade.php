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
                                    <td>: {{ $model->tanggal_bayar }}</td>
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
                                        <a href="{{ url($model->bukti_bayar) }}" target="_blank">
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
                            </thead>
                        </table>
                        <a href="" class="btn btn-success mt-3">
                            Konfirmasi Pembayaran Ini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
