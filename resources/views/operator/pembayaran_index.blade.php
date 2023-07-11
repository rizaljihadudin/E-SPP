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
                        <div class="col-md-6">
                            {!! Form::open(['route' => 'pembayaran.index', 'method' => 'GET']) !!}
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    {!! Form::selectMonth('bulan', request('bulan'), [
                                        'class' => 'form-control select2',
                                        'placeholder' => '-- Pilih Bulan --',
                                    ]) !!}
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    {!! Form::selectRange('tahun', '2010', date('Y') + 1, request('tahun'), [
                                        'class' => 'form-control select2',
                                        'autofocus',
                                        'placeholder' => '-- Pilih Tahun --',
                                    ]) !!}
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-md btn-primary" type="submit"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="4%">No</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Nama Wali</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->transaksi->siswa->nisn }}</td>
                                        <td>{{ \Str::title($item->transaksi->siswa->nama) }}</td>
                                        <td>{{ \Str::title($item->wali->name ?? 'Belum Ada Wali') }}</td>
                                        <td>{{ ucwords($item->metode_pembayaran) }}</td>
                                        @php
                                            $class = '';
                                            if ($item->status_konfirmasi == 'Sudah Dikonfirmasi') {
                                                $class = 'bg-success';
                                            } else {
                                                $class = 'bg-danger';
                                            }
                                            
                                        @endphp
                                        <td>
                                            <span class="badge {{ $class }}">{{ $item->status_konfirmasi }}</span>
                                        </td>

                                        <td>
                                            {!! Form::open([
                                                'route' => ['pembayaran.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'title' => 'Hapus Data',
                                                'onsubmit' => 'return confirm("Apakah anda yakin, ingin menghapus data ini?")',
                                            ]) !!}
                                            <a title="Detail Tagihan" href="{{ route('pembayaran.show', $item->id) }}"
                                                class="btn btn-icon btn-info btn-sm"><i class="fa fa-info-circle"></i></a>
                                            <button class="btn btn-icon btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center">Tidak ada {{ $title }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
