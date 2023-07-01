@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN SPP SISWA PERIODE {{ strtoupper($periode) }}</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ url($siswa->foto) }}" alt="{{ 'foto ' . $siswa->nama }}" class="d-block rounded"
                            height="100" width="100" id="uploadedAvatar" />
                        <div class="col-3 mb-sm-0 mb-2">
                            <h6 class="mb-0">{{ \Str::title($siswa->nama) }}</h6>
                            <small class="text-nowrap">{{ 'NISN : ' . $siswa->nisn }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">
                    Data Tagihan
                </h5>
                <div class="card-body">
                    Data Tagihan
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">
                    Kartu SPP
                </h5>
                <div class="card-body">
                    Kartu SPP
                </div>
            </div>
        </div>
    </div>
@endsection
