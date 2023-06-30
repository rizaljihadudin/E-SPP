@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Detail Siswa</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset($model->foto) }}" alt="user-avatar" class="d-block rounded"
                            style="height: 50%; width:auto;" />
                    </div>
                    <div class="row mt-2">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="15%">NAMA</td>
                                    <td>: {{ Str::title($model->nama) }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>: {{ $model->nisn }}</td>
                                </tr>
                                <tr>
                                    <td>Jurusan</td>
                                    <td>: {{ $model->jurusan->nama_jurusan }}</td>
                                </tr>
                                <tr>
                                    <td>KELAS</td>
                                    <td>: {{ $model->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>ANGKATAN</td>
                                    <td>: {{ $model->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td>TGL DIBUAT</td>
                                    <td>: {{ $model->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>TGL DIUPDATE</td>
                                    <td>: {{ $model->updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>DIBUAT OLEH</td>
                                    <td>: {{ $model->user->name }}</td>
                                </tr>

                            </thead>
                        </table>
                        <div class="row" width="10%">
                            {!! link_to(URL::previous(), 'BACK', [
                                'class' => 'btn btn-secondary mt-2',
                                'style' => 'width:10%;',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
