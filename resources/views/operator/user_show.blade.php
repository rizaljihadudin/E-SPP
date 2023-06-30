@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <!-- Account -->
                <div class="card-body">
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
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
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
