@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Form User</h5>
                <div class="col-md-8 offset-2">
                    <div class="card-body">
                        {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi Nama...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            {!! Form::text('email', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi Email...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_hp">No HP</label>
                            {!! Form::text('no_hp', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi No HP...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="akses">Hak Akses</label>
                            {!! Form::Select('akses', ['operator' => 'Operator Sekolah', 'admin' => 'Administrator'], null, [
                                'class' => 'form-control',
                                'autofocus',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('akses') }}</span>
                        </div>
                        {!! Form::submit($button, ['class' => 'btn btn-success']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
