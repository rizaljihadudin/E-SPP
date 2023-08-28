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
                            <label for="nama">Nama Siswa</label>
                            {!! Form::text('nama', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi Nama...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="biaya_id">Tagihan</label>
                            {!! Form::select('biaya_id', $listBiaya, null, [
                                'class' => 'form-control select2',
                                'placeholder' => '-- Pilih Biaya --',
                                'autofocus',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('biaya_id') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="wali_murid">Wali Murid (Optional)</label>
                            {!! Form::Select('wali_id', $wali, null, [
                                'class' => 'form-control select2',
                                'placeholder' => '-- Pilih Wali Murid --',
                                'autofocus',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('wali_murid') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nisn">NISN</label>
                            {!! Form::text('nisn', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => 'Silahkan isi NISN...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nisn') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jurusan_id">Jurusan</label>
                            {!! Form::Select('jurusan_id', getListJurusan(), null, [
                                'class' => 'form-control select2',
                                'placeholder' => '-- Pilih Jurusan --',
                                'autofocus',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('jurusan_id') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            {!! Form::selectRange('kelas', 1, 3, $model->kelas ?? null , [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => '-- Pilih Kelas --',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('kelas') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="angkatan">Angkatan</label>
                            {!! Form::selectRange('angkatan', 2010, date('Y') + 1, null, [
                                'class' => 'form-control',
                                'autofocus',
                                'placeholder' => '-- Pilih Angkatan --',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="foto">Foto <b>(Format: jpg, png, Ukuran Maks:5mb)</b></label>
                            {!! Form::file('foto', [
                                'class' => 'form-control',
                                'accept' => 'image/*',
                                'onchange' => 'viewImg(event)',
                            ]) !!}
                            @if ($model->foto)
                                <img src="{{ asset($model->foto) }}" id="viewImage" alt="your image"
                                    style="width: 50%; height:auto;" class="mt-2">
                            @else
                                <img src="#" id="viewImage" alt="your image" style="width: 50%; height:auto;"
                                    class="mt-2">
                            @endif
                            <span class="text-danger">{{ $errors->first('foto') }}</span>
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
        const viewImg = (e) => {
            let output = document.getElementById('viewImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>
@endsection
