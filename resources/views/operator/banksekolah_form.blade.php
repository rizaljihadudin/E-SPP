@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Form {{ $title }}</h5>
                <div class="col-md-8 offset-2">
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
                        {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                        <div class="form-group mb-3">
                            <label for="bank_id">Nama Bank</label>
                            {!! Form::select('bank_id', $listBank, $model->bank_id ?? null, [
                                'class' => 'form-control select2',
                                'autofocus',
                                'placeholder' => '-- Pilih Bank --',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_rekening">Nama Pemilik Rekening</label>
                            {!! Form::text('nama_rekening', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi nama pemilik rekening ...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nomor_rekening">Nomor Rekening</label>
                            {!! Form::text('nomor_rekening', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi no. rekening ...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                        </div>

                        {!! Form::submit($button, ['class' => 'btn btn-success']) !!}
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
