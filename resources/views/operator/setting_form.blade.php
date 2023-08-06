@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="col-md-12">
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
                        <fieldset class="reset mb-2 p-4 rounded">
                            <legend class="reset fw-bold" style="color: green"><i class="fa fa-info-circle"></i> PENGATURAN
                                INSTANSI
                            </legend>
                            {!! Form::open([
                                'route' => $route,
                                'method' => $method,
                            ]) !!}
                            <div class="form-group mb-3">
                                <label for="app_name">Nama Instansi</label>
                                {!! Form::text('app_name', settings()->get('app_name'), [
                                    'class' => 'form-control',
                                    'autofocus',
                                    'placeholder' => 'Silahkan isi Nama Aplikasi...',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_name') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="app_alias">Nama Singkatan Instansi</label>
                                {!! Form::text('app_alias', settings()->get('app_alias'), [
                                    'class' => 'form-control',
                                    'autofocus',
                                    'placeholder' => 'Silahkan isi Nama Alias Aplikasi...',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_alias') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="app_email">Email Instansi</label>
                                {!! Form::text('app_email', settings()->get('app_email'), [
                                    'class' => 'form-control',
                                    'autofocus',
                                    'placeholder' => 'Silahkan isi Email Aplikasi...',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_email') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="app_phone">Nomor Telepon Instansi</label>
                                {!! Form::text('app_phone', settings()->get('app_phone'), [
                                    'class' => 'form-control',
                                    'autofocus',
                                    'placeholder' => 'Silahkan isi No. Telpon Aplikasi...',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_phone') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="app_address">Alamat Instansi</label>
                                {!! Form::textarea('app_address', settings()->get('app_address'), [
                                    'class' => 'form-control',
                                    'rows' => 4,
                                    'cols' => 54,
                                    'style' => 'resize:none',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_address') }}</span>
                            </div>
                        </fieldset>
                        <fieldset class="reset mb-2 p-4 rounded">
                            <legend class="reset fw-bold" style="color: green"><i class="fa fa-info-circle"></i> PENGATURAN
                                APLIKASI

                            </legend>
                            <div class="form-group mb-3">
                                <label for="app_pagination">Data Per-Halaman</label>
                                {!! Form::number('app_pagination', settings()->get('app_pagination'), [
                                    'class' => 'form-control',
                                    'autofocus',
                                    'placeholder' => 'Silahkan isi batas Pagination...',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_pagination') }}</span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="app_pagination_style">Pagination Style</label>
                                {!! Form::select('app_pagination_style', $lists, settings()->get('app_pagination_style'), [
                                    'class' => 'form-control select2',
                                    'placeholder' => '--Pilih Style Pagination--',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('app_pagination_style') }}</span>
                            </div>
                        </fieldset>
                        {!! Form::submit($button, ['class' => 'btn btn-success']) !!}
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
