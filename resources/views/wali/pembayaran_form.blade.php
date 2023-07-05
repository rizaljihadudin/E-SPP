@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="col-md-8 offset-2">
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {!! Form::model($pembayaran, [
                            'route' => $route,
                            'method' => $method,
                            'files' => true,
                        ]) !!}
                        <fieldset class="reset mb-2">
                            <legend class="reset fw-bold"><i class="fa fa-info-circle"></i> INFORMASI REKENING PENGIRIM
                            </legend>
                            <div class="alert alert-dark mt-2" role="alert">
                                <i>Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang
                                    dilakukan
                                    oleh wali murid melalui bank.</i>
                            </div>
                            <div class="form-group mb-3">
                                <label for="bank_pengirim">Nama Bank Pengirim</label>
                                {!! Form::select('bank_pengirim', $listBank, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => '-- Pilih Bank --',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('bank_pengirim') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_pengirim">Nama Pemilik Pengirim</label>
                                {!! Form::text('nama_pengirim', null, [
                                    'class' => 'form-control',
                                    'autofocus',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('nama_pengirim') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="norek_pengirim">No Rekening Pengirim</label>
                                {!! Form::text('norek_pengirim', null, [
                                    'class' => 'form-control',
                                    'autofocus',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('norek_pengirim') }}</span>
                            </div>
                            <div class="form-check">
                                {!! Form::checkbox('simpan_data_rekening', 1, true, [
                                    'class' => 'form-check-input',
                                    'id' => 'defaultCheck3',
                                ]) !!}
                                <label class="form-check-label" for="defaultCheck3"> Simpan Data ini untuk memudahkan
                                    pembayaran selanjutnya </label>
                            </div>
                        </fieldset>
                        <fieldset class="reset mb-2">
                            <legend class="reset fw-bold"><i class="fa fa-info-circle"></i> INFORMASI REKENING TUJUAN
                            </legend>
                            <div class="form-group mb-3">
                                <label for="bank_nama">Nama Bank</label>
                                {!! Form::text('bank_nama', $bank->nama_bank, [
                                    'readonly' => true,
                                    'class' => 'form-control',
                                    'placeholder' => 'sssss',
                                ]) !!}

                                @if (request('bank_sekolah_id'))
                                    <div class="alert alert-dark mt-2" role="alert">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">Bank Tujuan</td>
                                                    <td>: {{ $bankSekolah->bank->nama_bank }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Rekening</td>
                                                    <td>: {{ ucwords($bankSekolah->nama_rekening) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Atas Nama</td>
                                                    <td>: {{ $bankSekolah->nomor_rekening }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {!! Form::hidden('bank_id', $bank->id, []) !!}
                            </div>
                        </fieldset>
                        <fieldset class="reset mb-2">
                            <legend class="reset fw-bold"><i class="fa fa-info-circle"></i> INFORMASI PEMBAYARAN</legend>
                            <div class="form-group mb-3">
                                <label for="bank_id">Tanggal Bayar</label>
                                {!! Form::date('tanggal_bayar', $pembayaran->tanggal_bayar ?? \Carbon\Carbon::now(), [
                                    'class' => 'form-control',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="bukti_bayar">Upload Bukti Bayar</label>
                                {!! Form::file('bukti_bayar', [
                                    'class' => 'form-control',
                                    'accept' => 'image/*',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                            </div>
                        </fieldset>
                        {!! Form::submit('SUBMIT', ['class' => 'btn btn-success']) !!}
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
