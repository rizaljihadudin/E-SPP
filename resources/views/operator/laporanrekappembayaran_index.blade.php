@extends('layouts.app_sneat_blank')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header"></h5>
                    <div class="card-body">
                        @include('operator.laporan_header')
                        <h4 class="mt-3">LAPORAN REKAP PEMBAYARAN</h4>
                        Laporan Berdasarkan: {{ $title }}
                        <div class="table-responsive mt-3">
                            <table class="{{ config('app.table_style') }}">
                                <thead class="{{ config('app.thead_style') }}">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        @foreach ($header as $bulan)
                                            <th>{{ namaBulan($bulan) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataRekap as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['siswa']->nama }}</td>
                                            @foreach ($item['data'] as $itemTagihan)
                                                <td class="text-center">
                                                    @if ($itemTagihan['tanggal_lunas'] != '-')
                                                        {{ optional($itemTagihan['tanggal_lunas'])->format('d') }}/{{ optional($itemTagihan['tanggal_lunas'])->format('m') }}
                                                        <div>
                                                            {{ optional($itemTagihan['tanggal_lunas'])->format('Y') }}
                                                        </div>
                                                    @else
                                                        -
                                                    @endif

                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
