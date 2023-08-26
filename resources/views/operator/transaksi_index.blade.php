@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

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
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary btn-sm mb-2">Tambah
                                Data
                            </a>
                        </div>
                        <div class="col-md-10">
                            {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    {!! Form::text('q', request('q'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'Pencarian data siswa',
                                    ]) !!}
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    {!! Form::selectMonth('bulan', request('bulan'), [
                                        'class' => 'form-control select2',
                                        'placeholder' => '-- Pilih Bulan --',
                                    ]) !!}
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    {!! Form::selectRange('tahun', '2010', date('Y') + 1, request('tahun'), [
                                        'class' => 'form-control select2',
                                        'autofocus',
                                        'placeholder' => '-- Pilih Tahun --',
                                    ]) !!}
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-md btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-md btn-danger" onclick="hapusPencarian()" type="reset">
                                        <i class="fas fa-remove"></i>
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NISN</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Status</th>
                                    <th>Jumlah Tagihan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa?->nama }}</td>
                                        <td>{{ $item->siswa?->nisn }}</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('d-F-Y') }}</td>

                                        @php
                                            $class = '';
                                            if ($item->status == 'baru') {
                                                $class = 'bg-danger';
                                            } elseif ($item->status == 'lunas') {
                                                $class = 'bg-success';
                                            } elseif ($item->status == 'angsuran') {
                                                $class = 'bg-warning';
                                            }
                                            
                                        @endphp

                                        <td><span class="badge {{ $class }}">{{ $item->status }}</span></td>
                                        <td>{{ formatRupiah($item->transaksiDetails->sum('jumlah_biaya')) }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'title' => 'Hapus Data',
                                                'onsubmit' => 'return confirm("Apakah anda yakin, ingin menghapus data ini?")',
                                            ]) !!}
                                            <a title="Detail Tagihan"
                                                href="{{ route($routePrefix . '.show', [
                                                    $item->id,
                                                    'bulan' => $item->tanggal_tagihan->format('m'),
                                                    'tahun' => $item->tanggal_tagihan->format('Y'),
                                                ]) }}"
                                                class="btn btn-icon btn-info btn-sm"><i class="fa fa-info-circle"></i></a>
                                            <button class="btn btn-icon btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center">Tidak ada {{ $title }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {!! $models->links(settings()->get('app_pagination_style', 'vendor.pagination.custom')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        const hapusPencarian = () => {
            let url = window.location.origin + window.location.pathname;
            window.location.href = url;

        }

    </script>
@endsection
