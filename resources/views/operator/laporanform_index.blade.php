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
                            {!! Form::open(['route' => 'laporanform.show.laporantagihan', 'method' => 'GET', 'target' => 'blank']) !!}
                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <label for="angkatan">Angkatan</label>
                                    {!! Form::selectRange('angkatan', 2020, date('Y') + 1, null, [
                                        'class' => 'form-control select2',
                                        'autofocus',
                                        'placeholder' => '-- Pilih Angkatan --',
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="jurusan">Jurusan</label>
                                    {!! Form::Select('jurusan', getListJurusan(), null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => '-- Pilih Jurusan --',
                                        'autofocus',
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="status"> Status Tagihan</label>
                                    {!! Form::select('status', [
                                        '' => 'Pilih Status',
                                        'baru'      => 'Baru',
                                        'angsuran'  => 'Angsuran',
                                        'lunas'     => 'Lunas'
                                ], request('status'), [
                                    'class' => 'form-control select2'
                                ]) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="bulan">Bulan</label>
                                    {!! Form::selectMonth('bulan', request('bulan'), [
                                        'class' => 'form-control select2',
                                        'placeholder' => '-- Pilih Bulan --',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="tahun">Tahun</label>
                                    {!! Form::selectRange('tahun', '2022', date('Y') + 1, request('tahun'), [
                                        'class' => 'form-control select2',
                                        'autofocus',
                                        'placeholder' => '-- Pilih Tahun --',
                                    ]) !!}
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-md btn-primary" style="margin-top: 22px" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>Laporan Pembayaran</h5>
                            {!! Form::open(['route' => 'laporanform.show.laporanpembayaran', 'method' => 'GET', 'target' => 'blank']) !!}
                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <label for="kelas">Kelas</label>
                                    {!! Form::SelectRange('kelas', 1, 3, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => '-- Pilih Kelas --',
                                        'autofocus',
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('kelas') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="angkatan">Angkatan</label>
                                    {!! Form::selectRange('angkatan', 2020, date('Y') + 1, null, [
                                        'class' => 'form-control select2',
                                        'autofocus',
                                        'placeholder' => '-- Pilih Angkatan --',
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="status">Status Pembayaran</label>
                                    {!! Form::select('status', [
                                        '' => 'Pilih Status',
                                        'sudah-konfirm' => 'Sudah Dikonfirmasi',
                                        'belum-konfirm' => 'Belum Dikonfirmasi'
                                        ], request('status'), [
                                            'class' => 'form-control select2'
                                    ]) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="bulan">Bulan</label>
                                    {!! Form::selectMonth('bulan', request('bulan'), [
                                        'class' => 'form-control select2',
                                        'placeholder' => '-- Pilih Bulan --',
                                    ]) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="tahun">Tahun</label>
                                    {!! Form::selectRange('tahun', '2022', date('Y') + 1, request('tahun'), [
                                        'class' => 'form-control select2',
                                        'autofocus',
                                        'placeholder' => '-- Pilih Tahun --',
                                    ]) !!}
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-md btn-primary" style="margin-top: 22px" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
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
