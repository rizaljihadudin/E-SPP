@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <!-- Account -->
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row mt-2">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="15%">NAMA</td>
                                    <td>: {{ Str::title($model->name) }}</td>
                                </tr>
                                <tr>
                                    <td>EMAIL</td>
                                    <td>: {{ $model->email }}</td>
                                </tr>
                                <tr>
                                    <td>NO. HP</td>
                                    <td>: {{ $model->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td>TGL DIBUAT</td>
                                    <td>: {{ $model->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>TGL DIUPDATE</td>
                                    <td>: {{ $model->updated_at }}</td>
                                </tr>

                            </thead>
                        </table>
                    </div>
                    <br>
                    <h5 class="card-header">Data Anak</h5>
                    {!! Form::open(['route' => $route, 'method' => 'PUT']) !!}
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            {!! Form::select('siswa_id', $siswa, null, [
                                'class' => 'form-control select2',
                                'autofocus',
                                'placeholder' => '-- Pilih Siswa --',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('siswa_id') }}</span>
                            {!! Form::hidden('wali_id', $model->id, null, []) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <button class="btn btn-md btn-primary" type="submit">Tambah Data Anak</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($model->siswa) <= 0)
                                    <tr>
                                        <td colspan="3" style="text-align: center">Data Anak Kosong!</td>
                                    </tr>
                                @else
                                    @foreach ($model->siswa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration . '.' }}</td>
                                            <td>{{ Str::title($item->nama) }}</td>
                                            <td>{{ $item->nisn }}</td>
                                            <td>
                                                {!! Form::open([
                                                    'route' => $route,
                                                    'method' => 'PUT',
                                                    'title' => 'Hapus Data Siswa',
                                                    'onsubmit' => 'return confirm("Apakah anda yakin, ingin menghapus data ini?")',
                                                ]) !!}
                                                {!! Form::hidden('siswa_id', $item->id, null, []) !!}
                                                <button class="btn btn-icon btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2" width="10%">
                        {!! link_to(URL::previous(), 'BACK', [
                            'class' => 'btn btn-secondary mt-2',
                            'style' => 'width:10%;',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
