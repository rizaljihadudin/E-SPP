@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN SPP SISWA PERIODE {{ strtoupper($periode) }}</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ url($siswa->foto ?? 'foto_siswa/no-image.png') }}" alt="{{ 'foto ' . $siswa->nama }}" class="d-block rounded"
                            height="100" width="100" id="uploadedAvatar" />
                        <div class="col-3 mb-sm-0 mb-2">
                            <h6 class="mb-0">{{ \Str::title($siswa->nama) }}</h6>
                            <small class="text-nowrap">{{ 'NISN : ' . $siswa->nisn }}</small>
                            <br/>
                            <small class="text-nowrap">{{ 'KELAS : ' . $siswa->kelas }}</small>
                            <br/>
                            <small class="text-nowrap">{{ 'JURUSAN : ' . $siswa->jurusan->nama_jurusan . ' ( '. $siswa->jurusan->kode_jurusan .' ) '}}</small>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header pb-0">
                    DATA TAGIHAN {{ strtoupper($periode) }}
                </h5>
                <div class="card-body">
                    <table class="{{ config('app.table_style') }}">
                        <thead class="{{ config('app.thead_style') }}">
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
                        <tfoot>
                            <tr>
                                <td colspan="2" style="text-align: center">Total Pembayaran</td>
                                <td>{{ formatRupiah($models->transaksiDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="{{ route('invoice.show', Crypt::encrypt($models->id)) }}" target="blank">
                        <i class="fa fa-file-pdf"></i> Download Invoice
                    </a>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header pb-0">
                    INFORMASI PEMBAYARAN
                </h5>
                <div class="card-body">
                    <table class="{{ config('app.table_style') }}">
                        <thead class="{{ config('app.thead_style') }}">
                            <tr>
                                <th width="1%">#</th>
                                <th>TANGGAL</th>
                                <th>JUMLAH</th>
                                <th>METODE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models->pembayaran as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('kwitansipembayaran.print', Crypt::encrypt($item->id)) }}" target="_blank"><i
                                                class="fa fa-print"></i></a>
                                    </td>
                                    <td>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                                    <td>{{ formatRupiah($item->jumlah_dibayar) }}</td>
                                    <td>{{ $item->metode_pembayaran }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5 class="mt-2">Status Pembayaran : {{ strtoupper($models->status) }}</h5>
                </div>
                <h5 class="card-header pt-0">
                    FORM PEMBAYARAN
                </h5>
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
                    {!! Form::model($pembayaran, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                    <div class="form-group mb-2">
                        {!! Form::hidden('transaksi_id', $models->id, []) !!}
                        {!! Form::hidden('wali_id', $siswa->wali_id, []) !!}
                        <label for="tanggal_bayar">Tanggal Pembayaran</label>
                        {!! Form::date('tanggal_bayar', $pembayaran->tanggal_bayar ?? \Carbon\Carbon::now(), [
                            'class' => 'form-control',
                            'autofocus',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jumlah_dibayar">Jumlah Bayar</label>
                        {!! Form::text('jumlah_dibayar', $models->total_tagihan, [
                            'class' => 'form-control',
                            'autofocus',
                            'placeholder' => 'Masukkan nilai pembayaran',
                            'oninput' => 'formatIDR(this)',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                    </div>
                    @if ($models->status != 'lunas')
                        {!! Form::submit('SIMPAN', [
                            'class' => 'btn btn-success'
                        ]) !!}
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Kartu SPP</h5>
                <div class="card-body">
                    <a href="{{ route('kartuspp.index', ['siswa_id' => $siswa->id, 'tahun' => request('tahun')]) }}"
                        class="mb-3" target="_blank"><i class="fa fa-print"></i>
                        Cetak Kartu SPP {{ request('tahun') }}
                    </a>
                    <table width="100%" class="{{ config('app.table_style') }} mt-2" style="font-size: 14px;">
                        <thead class="{{ config('app.thead_style') }}">
                            <tr style="height: 50px;">
                                <th style="width:1%;text-align:center">No</th>
                                <th style="text-align:start;">Bulan</th>
                                <th style="text-align:end;">Jumlah Tagihan</th>
                                <th>Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kartuSpp as $item)
                            <tr>
                                <td style="text-align:center">{{ $loop->iteration }}.</td>
                                <td style="text-align:start;">{{ $item['bulan'] . ' ' . $item['tahun'] }}</td>
                                <td style="text-align:end;">{{ formatRupiah($item['total_tagihan']) }}</td>
                                <td>{{ $item['tanggal_bayar'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
