@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN SPP SISWA PERIODE {{ strtoupper($periode) }}</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ url($siswa->foto) }}" alt="{{ 'foto ' . $siswa->nama }}" class="d-block rounded"
                            height="100" width="100" id="uploadedAvatar" />
                        <div class="col-3 mb-sm-0 mb-2">
                            <h6 class="mb-0">{{ \Str::title($siswa->nama) }}</h6>
                            <small class="text-nowrap">{{ 'NISN : ' . $siswa->nisn }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">
                    DATA TAGIHAN {{ strtoupper($periode) }}
                </h5>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NAMA TAGIHAN</th>
                                <th>JUMLAH TAGIHAN</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($models->transaksiDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Str::title($item->nama_biaya) }}</td>
                                    <td>{{ formatRupiah($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h5 class="card-header">
                    FORM PEMBAYARAN
                </h5>
                <div class="card-body">
                    {!! Form::model($pembayaran, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                    <div class="form-group mb-2">
                        <label for="tanggal_bayar">Tanggal Pembayaran</label>
                        {!! Form::date('tanggal_bayar', $pembayaran->tanggal_bayar ?? \Carbon\Carbon::now(), [
                            'class' => 'form-control',
                            'autofocus',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jumlah_dibayar">Jumlah Bayar</label>
                        {!! Form::text('jumlah_dibayar', null, [
                            'class' => 'form-control',
                            'autofocus',
                            'placeholder' => 'Masukkan nilai pembayaran',
                            'oninput' => 'formatIDR(this)',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                    </div>
                    {!! Form::submit('SIMPAN', [
                        'class' => 'btn btn-success',
                    ]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">
                    Kartu SPP
                </h5>
                <div class="card-body">
                    Kartu SPP
                </div>
            </div>
        </div>
    </div>
@endsection
