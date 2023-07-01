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
                        {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}
                        <div class="form-group mb-3">
                            <label for="nama_biaya">Nama Biaya</label>
                            {!! Form::text('nama_biaya', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi Nama Biaya...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama_biaya') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jumlah">Jumlah / Nominal</label>
                            {!! Form::text('jumlah', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi Jumlah...',
                                'oninput' => 'formatIDR(this)',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                        </div>
                        {!! Form::submit($button, ['class' => 'btn btn-success']) !!}
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const formatIDR = (input) => {
            let nominal = input.value;
            nominal = nominal.replace(/\D/g, '');
            let parts = nominal.split('.');
            let decimal = parts[1] ? '.' + parts[1] : '';
            let thousands = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            let formattedNominal = `Rp. ${thousands}${decimal}`;

            input.value = formattedNominal;
        }
    </script>
@endsection
