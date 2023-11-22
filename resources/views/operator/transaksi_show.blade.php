@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN SPP SISWA PERIODE {{ strtoupper($periode) }}</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ url($siswa->foto ?? 'foto_siswa/no-image.png') }}" alt="{{ 'foto ' . $siswa->nama }}" class="d-block rounded"
                            height="100" width="100" id="uploadedAvatar" />
                        <div class="col-3 mb-sm-0 mb-2">
                            <h6 class="mb-0">{{ \Str::title($siswa->nama) }}</h6>
                            <small class="text-nowrap">{{ 'NISN : ' . $siswa->nisn }}</small>
                            <br/>
                            <small class="text-nowrap">{{ 'KELAS : ' . $siswa->kelas }}</small>
                            <br/>
                            <small class="text-nowrap">{{ 'JURUSAN : ' . $siswa->jurusan->nama_jurusan . ' ( '. $siswa->jurusan->kode_jurusan .' ) '}}</small>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header pb-0">
                    DATA TAGIHAN {{ strtoupper($periode) }}
                </h5>
                <div class="card-body">
                    @include('operator.tagihan_tabletagihan')
                    <a href="{{ route('invoice.show', Crypt::encrypt($models->id)) }}" target="blank">
                        <i class="fa fa-file-pdf"></i> Download Invoice
                    </a>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header pb-0">
                    INFORMASI PEMBAYARAN
                </h5>
                <div class="card-body">
                    @include('operator.tagihan_tablepembayaran')
                    <h5 class="mt-2">Status Pembayaran : {{ strtoupper($models->status) }}</h5>
                </div>
                <h5 class="card-header pt-0">
                    FORM PEMBAYARAN
                </h5>
                @include('operator.tagihan_formpembayaran')
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Kartu SPP</h5>
                @include('operator.tagihan_kartuspp')
            </div>
        </div>
    </div>
@endsection
