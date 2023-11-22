@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Laporan Tagihan</h5>
                            @include('operator.laporanform_tagihan')
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>Laporan Pembayaran</h5>
                            @include('operator.laporanform_pembayaran')
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>Laporan Rekap Pembayaran</h5>
                            @include('operator.laporanform_rekappembayaran')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        const hapusPencarian = () => {
            let url = window.location.origin + window.location.pathname;
            window.location.href = url;

        }

    </script>
@endsection
