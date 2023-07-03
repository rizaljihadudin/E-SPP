@extends('layouts.app_sneat_blank')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="text-uppercase">Invoice</h1>
                            <div class="billed"><span class="font-weight-bold text-uppercase">Nama Sekolah : </span><span
                                    class="ml-1">STM Baskara</span></div>
                            <div class="billed"><span class="font-weight-bold text-uppercase">Tanggal Tagihan : </span><span
                                    class="ml-1">{{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}</span></div>
                            <div class="billed"><span class="font-weight-bold text-uppercase">Pembayaran ID : </span><span
                                    class="ml-1">#PAY-{{ $pembayaran->id }}</span></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>TANGGAL PEMBAYARAN</th>
                                        <th>METODE PEMBAYARAN</th>
                                        <th>JUMLAH PEMBAYARAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $pembayaran->tanggal_bayar->translatedFormat('d/m/y') }}</td>
                                        <td>{{ $pembayaran->metode_pembayaran }}</td>
                                        <td>{{ formatRupiah($pembayaran->jumlah_dibayar) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right mb-3 fst-italic">
                        Terbilang :{{ ucwords(terbilang($pembayaran->jumlah_dibayar) . 'Rupiah') }}
                    </div>
                    <div class="text-left">
                        Depok, {{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}
                        <br />
                        <br />
                        <br />
                        <u> {{ ucwords($pembayaran->user->name) }} </u>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
@endsection
