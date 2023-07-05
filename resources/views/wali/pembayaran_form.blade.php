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
                        <div class="form-group mb-3">
                            <label for="bank_id">Tanggal Bayar</label>
                            {!! Form::date('tanggal_bayar', $pembayaran->tanggal_bayar ?? \Carbon\Carbon::now(), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group mb-3">
                            <label for="bank_id">Upload Bukti Bayar</label>
                            {!! Form::file('bukti_bayar', [
                                'class' => 'form-control',
                                'accept' => 'image/*',
                            ]) !!}
                        </div>
                        {!! Form::submit('SUBMIT', ['class' => 'btn btn-success']) !!}
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
