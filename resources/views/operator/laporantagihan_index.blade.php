@extends('layouts.app_sneat_blank')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header"></h5>
                    <div class="card-body">
                        @include('operator.laporan_header')
                        <h4 class="mt-3">LAPORAN TAGIHAN</h4>
                        Laporan Berdasarkan: {{ $title }}
                        <div class="table-responsive mt-3">
                            <table class="{{ config('app.table_style') }}">
                                <thead class="{{ config('app.thead_style') }}">
                                    <tr>
                                        <th style="width: 1%">No</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>Tanggal Tagihan</th>
                                        <th>Status</th>
                                        <th>Jumlah Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tagihan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->siswa?->nama }}</td>
                                            <td>{{ $item->siswa?->nisn }}</td>
                                            <td>{{ $item->tanggal_tagihan->translatedFormat('d-F-Y') }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ formatRupiah($item->transaksiDetails->sum('jumlah_biaya')) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" style="text-align: center">
                                                Tidak ada Data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
