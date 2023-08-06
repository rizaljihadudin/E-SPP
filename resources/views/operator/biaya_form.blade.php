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
                        @if (request()->filled('parent_id'))
                            <h3>INFO {{ ucwords($parentData->nama_biaya) }}</h3>
                            {!! Form::hidden('parent_id', $parentData->id, []) !!}
                            <table class="table table-sm table-hover table-bordered mb-3">
                                <thead>
                                    <tr>
                                        <td width="4%">No</td>
                                        <td width="48%">Nama Biaya</td>
                                        <td width="38%">Jumlah</td>
                                        <td widht="10%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($parentData->children as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item->nama_biaya }}</td>
                                            <td>{{ formatRupiah($item->jumlah) }}</td>
                                            <td align="center">
                                                <a href="{{ route('delete.biaya.item', $item->id) }}"
                                                    class="btn btn-icon btn-danger btn-sm"
                                                    onclick="return confirm('ingin menghapus data ini?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" style="text-align: center;">Tidak Ada Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
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
@endsection
