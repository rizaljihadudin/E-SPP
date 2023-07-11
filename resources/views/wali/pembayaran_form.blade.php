@extends('layouts.app_sneat_wali')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="col-md-10 offset-md-1 col-sm-12 offset-sm-0 offset-xs-0">
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
                        @if ($message = Session::get('info'))
                            <div class="alert alert-info alert-dismissible" role="alert">
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
                        {!! Form::hidden('tagihan_id', request('tagihan_id'), []) !!}
                        <fieldset class="reset mb-2">
                            <legend class="reset fw-bold" style="color: red"><i class="fa fa-info-circle"></i> INFORMASI
                                REKENING PENGIRIM
                            </legend>
                            <div class="alert alert-dark mt-2" role="alert">
                                <i>Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang
                                    dilakukan
                                    oleh wali murid melalui bank.</i>
                            </div>
                            @if (count($listWaliBank) > 0)
                                <div id="showBankPengirim">
                                    <div class="form-group mb-3">
                                        <label for="wali_bank_id">Nama Bank Pengirim</label>
                                        {!! Form::select('wali_bank_id', $listWaliBank, null, [
                                            'class' => 'form-control select2',
                                            'placeholder' => '-- Pilih No Rekening Pengirim --',
                                        ]) !!}
                                        <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mb-2">
                                        {!! Form::checkbox('tambah_data_bank', 1, false, [
                                            'class' => 'form-check-input',
                                            'id' => 'tambahBankBaru',
                                        ]) !!}
                                        <label class="form-check-label" for="tambahBankBaru"> Input Data Baru </label>
                                    </div>
                                </div>
                            @endif
                            <div id="form_bank_pengirim">
                                <div class="form-group mb-3">
                                    <label for="bank_id_pengirim" style="width: 100%">Nama Bank Pengirim</label>
                                    {!! Form::select('bank_id_pengirim', $listBank, null, [
                                        'class' => 'form-control',
                                        'placeholder' => '-- Pilih Bank --',
                                        'id' => 'bank_pengirim_style',
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('bank_id_pengirim') }}</span>
                                </div>
                                <div class="form-group mb-3 col-sm-12">
                                    <label for="nama_rekening_pengirim">Nama Pemilik Pengirim</label>
                                    {!! Form::text('nama_rekening_pengirim', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Silahkan Isi Nama Rekening Pengirim',
                                        'autofocus',
                                    ]) !!}
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nomor_rekening">No Rekening Pengirim</label>
                                    {!! Form::text('nomor_rekening', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Silahkan isi No Rekening Pengirim',
                                        'autofocus',
                                    ]) !!}
                                    <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                                </div>
                                <div class="form-check">
                                    {!! Form::checkbox('simpan_data_rekening', 1, true, [
                                        'class' => 'form-check-input',
                                        'id' => 'defaultCheck3',
                                    ]) !!}
                                    <label class="form-check-label" for="defaultCheck3"> Simpan Data ini untuk memudahkan
                                        pembayaran selanjutnya </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="reset mb-2">
                            <legend class="reset fw-bold" style="color: red"><i class="fa fa-info-circle"></i> INFORMASI
                                REKENING TUJUAN
                            </legend>
                            <div class="form-group mb-3">
                                <label for="bank_nama">Nama Bank</label>
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
                                                    <td>: {{ ucwords($bankSekolah->nomor_rekening) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Atas Nama</td>
                                                    <td>: {{ $bankSekolah->nama_rekening }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {!! Form::hidden('bank_id', $bankSekolah->id, []) !!}
                                {!! Form::hidden('list_wali_bank', count($listWaliBank), []) !!}
                            </div>
                        </fieldset>
                        <fieldset class="reset mb-2">
                            <legend class="reset fw-bold" style="color: red"><i class="fa fa-info-circle"></i> INFORMASI
                                PEMBAYARAN</legend>
                            <div class="form-group mb-3">
                                <label for="tanggal_bayar">Tanggal Bayar</label>
                                {!! Form::date('tanggal_bayar', $pembayaran->tanggal_bayar ?? \Carbon\Carbon::now(), [
                                    'class' => 'form-control',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                {!! Form::text('jumlah_bayar', $tagihan->transaksiDetails->sum('jumlah_biaya'), [
                                    'class' => 'form-control rupiah',
                                    'placeholder' => 'Masukkan nominal pembayaran',
                                    'autofocus',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('jumlah_bayar') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="bukti_bayar">
                                    Upload Bukti Bayar
                                    <span class="text-danger">*File harus berukuran JPG, JPEG, dan PNG. Ukuran file, maks:
                                        5mb</span>
                                </label>
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
    <script>
        $(function() {
            @if (count($listWaliBank) > 0)
                $('#form_bank_pengirim').hide();
                $('#bank_pengirim_style').select2('destroy');
            @else
                $('#form_bank_pengirim').show();
                $('#bank_pengirim_style').addClass('select2');
            @endif
        })

        $("#tambahBankBaru").click(function() {
            if ($(this).is(":checked")) {
                $('#showBankPengirim').fadeOut()
                $("#form_bank_pengirim").show('slow');
                $('#bank_pengirim_style').select2({
                    selectionCssClass: 'form-control',
                    width: '100%'
                });
            } else {
                $('#showBankPengirim').fadeIn()
                $("#form_bank_pengirim").hide('slow');
                $('#bank_pengirim_style').select2('destroy');
            }
        });
    </script>
@endsection
