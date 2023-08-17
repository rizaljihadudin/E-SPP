@extends('layouts.app_sneat_wali',  ['title' => 'Data Tagihan SPP'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</h5>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 col-sm-12">
                            <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                                <img src="{{ asset($siswa->foto ?? 'foto_siswa/no-image.png')  }}" alt="{{ 'foto ' . $siswa->nama }}" class="d-block rounded"
                                    height="100" width="100" id="uploadedAvatar" />
                                <div class="col-3 mb-sm-0 mb-2">
                                    <h6 class="mb-0">{{ \Str::title($siswa->nama) }}</h6>
                                    <small class="text-nowrap mb-0">{{ 'NISN : ' . $siswa->nisn }}</small>
                                    <small
                                        class="text-nowrap mb-0">{{ 'Jurusan : ' . $siswa->jurusan->nama_jurusan }}</small>
                                    <small class="text-nowrap mb-0">{{ 'Angkatan : ' . $siswa->angkatan }}</small>
                                    <small class="text-nowrap mb-0">{{ 'Kelas : ' . $siswa->kelas }}</small>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 align-right">
                            <table>
                                <tr>
                                    <td>No. Tagihan</td>
                                    <td>: #BKR-00{{ $tagihan->id }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl. Tagihan</td>
                                    <td>: {{ $tagihan->tanggal_tagihan->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Tgl. Pembayaran</td>
                                    <td>: {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: 
                                        @if ($tagihan->pembayaran->count() >= 1)
                                            {{ $tagihan->pembayaran->first()->tanggal_konfirmasi ? 'Sudah Dibayar.' : 'Menunggu Konfirmasi.' }}
                                        @else
                                            {{ $tagihan->getStatusTransaksiWali() }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <i class="fa fa-print"></i>
                                        <a href="{{ route('invoice.show', Crypt::encrypt($tagihan->id)) }}" target="_blank">Cetak Invoice tagihan</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <td width="1%">No</td>
                                <td>NAMA TAGIHAN</td>
                                <td class="text-end">JUMLAH TAGIHAN</td>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($tagihan->transaksiDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Str::title($item->nama_biaya) }}</td>
                                    <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data Tagihan masih Kosong!</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Total Pembayaran</td>
                                <td class="text-end fw-bold">
                                    {{ formatRupiah($tagihan->transaksiDetails->sum('jumlah_biaya')) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-secondary mt-4" role="alert"style="color: black">
                        Pembayaran Bisa dilakukan dengan cara langsung ke Operator
                        sekolah atau bisa
                        di transfer melalui
                        Rekening milik sekolah dibawah ini.
                        <br />
                        <u><i>Jangan Melakukan Transfer selain ke rekening dibawah ini.</i></u><br />
                        Silahkan lihat tata cara pembayaran melalui <a href="{{ route('panduan.pembayaran', 'atm') }}" target="_blank">ATM</a> atau <a
                        href="{{ route('panduan.pembayaran', 'internet-banking') }}" target="_blank">internet Banking</a>.
                        <br />
                        Setelah melakukan pembayaran, silahkan upload bukti pembayaran melalu tombol konfirmasi yang
                        terdapat
                        pada masing - masing bank.
                    </div>
                    <ul>
                        <li>
                            <a href="{{ route('panduan.pembayaran', 'atm') }}" target="_blank">Lihat Cara Melakukan Pembayaran Melalui ATM</a>
                        </li>
                        <li>
                            <a href="{{ route('panduan.pembayaran', 'internet-banking') }}" target="_blank">Lihat Cara Melakukan Pembayaran Melalui Internet Banking</a>
                        </li>
                    </ul>
                    <div class="row">
                        @foreach ($bankSekolah as $itemBank)
                            <div class="col-md-6">
                                <div class="alert alert-dark" role="alert">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="25%">Bank Tujuan</td>
                                                <td>: {{ $itemBank->bank->nama_bank }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>: {{ ucwords($itemBank->nama_rekening) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Atas Nama</td>
                                                <td>: {{ $itemBank->nomor_rekening }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('wali.pembayaran.create', [
                                        'tagihan_id' => $tagihan->id,
                                        'bank_sekolah_id' => $itemBank->id,
                                        'bank_id' => $itemBank->id,
                                    ]) }}"
                                        class="btn btn-sm btn-primary mt-2">Konfirmasi Pembayaran</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
