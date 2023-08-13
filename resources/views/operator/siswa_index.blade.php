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
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data</a>

                    <!-- Search pagination -->
                    {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Cari Nama Siswa"
                            aria-label="cari nama" aria-describedby="button-addon2" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-outline-primary" id="button-addon2">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                    {!! Form::close() !!}

                    <div class="table-responsive mt-3">
                        <table class="{{ config('app.table_style') }}">
                            <thead class="{{ config('app.thead_style') }}">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Wali Murid</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Angkatan</th>
                                    <th>Tagihan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::title($item->wali->name) }}</td>
                                        <td>{{ Str::title($item->nama) }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->jurusan->nama_jurusan }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td>{{ formatRupiah($item->biaya?->total_tagihan) }}</td>
                                        <td>

                                            {!! Form::open([
                                                'route' => [$routePrefix . '.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'title' => 'Hapus Data',
                                                'onsubmit' => 'return confirm("Apakah anda yakin, ingin menghapus data ini?")',
                                            ]) !!}
                                            <a title="Edit Data" href="{{ route($routePrefix . '.edit', $item->id) }}"
                                                class="btn btn-icon btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <a title="Detail Data" href="{{ route($routePrefix . '.show', $item->id) }}"
                                                class="btn btn-icon btn-info btn-sm"><i class="fa fa-info-circle"></i></a>

                                            <button class="btn btn-icon btn-danger btn-sm my-2">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" style="text-align: center">Data Siswa masih kosong!</td>
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
@endsection
