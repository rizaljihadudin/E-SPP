@extends('layouts.app_sneat_wali')

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
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Periode Tagihan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Jumlah Tagihan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->siswa->nama) }}</td>
                                        <td>{{ $item->siswa->jurusan->nama_jurusan }}</td>
                                        <td>{{ $item->siswa->kelas }}</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('F Y') }}</td>

                                        @php
                                            $class = '';
                                            if ($item->getStatusTransaksiWali() == 'Belum dibayar') {
                                                $class = 'bg-danger';
                                            } elseif ($item->getStatusTransaksiWali() == 'Sudah dibayar') {
                                                $class = 'bg-success';
                                            } else {
                                                $class = 'bg-warning';
                                            }
                                            
                                        @endphp
                                        <td style="text-align: center">
                                            @if ($item->pembayaran->count() >= 1)
                                                <a
                                                    href="{{ route('wali.pembayaran.show', $item->pembayaran->first()->id) }}">
                                                    <span class="badge {{ $class }}">
                                                        {{ $item->pembayaran->first()->tanggal_konfirmasi ?  'Sudah Di Bayar.' : ' Menunggu Konfirmasi.' }}
                                                    </span>
                                                </a>
                                            @else
                                                <span class="badge {{ $class }}">
                                                    {{ $item->getStatusTransaksiWali() }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ formatRupiah($item->transaksiDetails->sum('jumlah_biaya')) }}</td>
                                        <td style="width: 20%" class="text-center">
                                            @if ($item->status == 'baru' || $item->status == 'angsuran')
                                                <a href="{{ route('wali.tagihan.show', $item->id) }}"
                                                    class="btn btn-outline-primary">Lakukan Pembayaran</a>
                                            @else
                                                <p class="mb-0 text-left"><mark>LUNAS</mark></p>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center">Tidak ada {{ $title }}
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
@endsection
