@extends('layouts.app_sneat_blank')
@section('content')

<style>
    body{margin-top:20px;
        color: #2e323c;
        background: #f5f6fa;
        position: relative;
        height: 100%;
    }
    .invoice-container {
        padding: 1rem;
    }
    .invoice-container .invoice-header .invoice-logo {
        margin: 0.8rem 0 0 0;
        display: inline-block;
        font-size: 1.6rem;
        font-weight: 700;
        color: #2e323c;
    }
    .invoice-container .invoice-header .invoice-logo img {
        max-width: 130px;
    }
    .invoice-container .invoice-header address {
        font-size: 0.9rem;
        color: black;
        margin: 0;
    }
    .invoice-container .invoice-details {
        margin: 1rem 0 0 0;
        padding: 1rem;
        line-height: 180%;
        background: #f5f6fa;
    }
    .invoice-container .invoice-details .invoice-num {
        text-align: right;
        font-size: 0.9rem;
    }
    .invoice-container .invoice-body {
        padding: 1rem 0 0 0;
    }
    .invoice-container .invoice-footer {
        text-align: center;
        font-size: 0.7rem;
        margin: 5px 0 0 0;
    }

    .invoice-status {
        text-align: center;
        padding: 1rem;
        background: #ffffff;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        margin-bottom: 1rem;
    }
    .invoice-status h2.status {
        margin: 0 0 0.8rem 0;
    }
    .invoice-status h5.status-title {
        margin: 0 0 0.8rem 0;
        color: #9fa8b9;
    }
    .invoice-status p.status-type {
        margin: 0.5rem 0 0 0;
        padding: 0;
        line-height: 150%;
    }
    .invoice-status i {
        font-size: 1.5rem;
        margin: 0 0 1rem 0;
        display: inline-block;
        padding: 1rem;
        background: #f5f6fa;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
    }
    .invoice-status .badge {
        text-transform: uppercase;
    }

    @media (max-width: 767px) {
        .invoice-container {
            padding: 1rem;
        }
    }


    .custom-table {
        border: 1px solid #e0e3ec;
    }
    /* .custom-table thead {
        background: #b400e1d1;
    } */
    .custom-table thead th {
        border: 0;
        color: #ffffff;
    }
    .custom-table > tbody tr:hover {
        background: #fafafa;
    }
    .custom-table > tbody tr:nth-of-type(even) {
        background-color: #ffffff;
    }
    .custom-table > tbody td {
        border: 1px solid #e6e9f0;
    }


    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }

    .text-success {
        color: #00bb42 !important;
    }

    .text-muted {
        color: #9fa8b9 !important;
    }

    .custom-actions-btns {
        margin: auto;
        display: flex;
        justify-content: flex-end;
    }

    .custom-actions-btns .btn {
        margin: .3rem 0 .3rem .3rem;
    }
</style>

<div class="container">
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <!-- Row start -->
                            {{-- <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="custom-actions-btns mb-5">
                                        <a href="#" class="btn btn-primary">
                                            <i class="icon-download"></i> Download
                                        </a>
                                        <a href="#" class="btn btn-secondary">
                                            <i class="icon-printer"></i> Print
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    <a href="index.html" class="invoice-logo">
                                        {{ settings()->get('app_name', 'E-SPP') }}
                                    </a>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <address class="text-right">
                                        {{ strtoupper(settings()->get('app_address')) }}<br>
                                        {{ settings()->get('app_phone') }}<br>
                                        {{ settings()->get('app_email') }}
                                    </address>
                                </div>
                            </div>
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <address>
                                            Tagihan Untuk : {{ $tagihan->siswa->nama }} ( {{ $tagihan->siswa->nisn }} )<br>
                                            Kelas : {{ $tagihan->siswa->kelas }}<br>
                                            Jurusan : {{ $tagihan->siswa->jurusan->nama_jurusan }} ({{ $tagihan->siswa->jurusan->kode_jurusan }})
                                        </address>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <div class="invoice-num">
                                            <div>Nomor Tagihan - #{{ $tagihan->id }}</div>
                                            <div>Tanggal Tagihan - {{ $tagihan->tanggal_tagihan->translatedFormat('d F Y') }}</div>
                                            <div>Tanggal Jatuh Tempo - {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</div>
                                        </div>
                                    </div>													
                                </div>
                            </div>
                            <!-- Row end -->
                        </div>
                        <div class="invoice-body">
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table custom-table m-0">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th width="60%">Items</th>
                                                    <th class="text-end">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tagihan->transaksiDetails as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_biaya }}</td>
                                                        <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <h5 class="text-success"><strong>Total Tagihan</strong></h5>
                                                    </td>			
                                                    <td>
                                                        <h5 class="text-success text-end"><strong>{{ formatRupiah($tagihan->total_tagihan) }}</strong></h5>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                        </div>
                        <div class="invoice-footer">
                           Terima kasih.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection