@extends('layouts.app_sneat_blank')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header"></h5>
                    <div class="card-body">
                        @include('operator.laporan_header')
                        <h4 class="mt-3">LAPORAN PEMBAYARAN</h4>
                        Laporan Berdasarkan: {{ $title }}
                        <div class="table-responsive mt-3">
                            <table class="{{ config('app.table_style') }}">
                                <thead class="{{ config('app.thead_style') }}">
                                    <tr>
                                        <th style="width: 1%">No</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Metode Bayar</th>
                                        <th>Status Konfirmasi</th>
                                        <th>Tanggal Konfirmasi</th>
                                        <th>Jumlah Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembayaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->transaksi->siswa?->nama }}</td>
                                            <td>{{ $item->transaksi->siswa?->nisn }}</td>
                                            <td>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                                            <td>{{ ucfirst($item->metode_pembayaran) }}</td>
                                            <td>{{ $item->statusKonfirmasi }}</td>
                                            <td>{{ $item->tanggal_konfirmasi?->translatedFormat('d/m/Y') ?? '---' }}</td>
                                            <td>{{ formatRupiah($item->jumlah_dibayar) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="text-align: center">
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
