@extends('layouts.app_sneat_wali')

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
                        <div class="form-password-toggle mb-3">
                            <label class="form-label" for="basic-default-password32">Password</label>
                            <div class="input-group input-group-merge">
                                <input
                                    name="password"
                                    type="password"
                                    class="form-control"
                                    id="basic-default-password32"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="basic-default-password"
                                />
                                <span class="input-group-text cursor-pointer" id="basic-default-password">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
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
