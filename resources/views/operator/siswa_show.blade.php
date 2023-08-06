@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Detail Siswa</h5>
                <!-- Account -->
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
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset($model->foto) }}" alt="user-avatar" class="d-block rounded"
                            style="height: 10%; width:10%;" />
                    </div>
                    <div class="row mt-2">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="15%">STATUS SISWA</td>
                                    <td>:
                                        <span class="badge {{ $model->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $model->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="15%">NAMA</td>
                                    <td>: {{ Str::title($model->nama) }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>: {{ $model->nisn }}</td>
                                </tr>
                                <tr>
                                    <td>Jurusan</td>
                                    <td>: {{ $model->jurusan->nama_jurusan }}</td>
                                </tr>
                                <tr>
                                    <td>KELAS</td>
                                    <td>: {{ $model->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>ANGKATAN</td>
                                    <td>: {{ $model->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td>TGL DIBUAT</td>
                                    <td>: {{ $model->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>TGL DIUPDATE</td>
                                    <td>: {{ $model->updated_at }}</td>
                                </tr>
                                <tr>
                                    <td>DIBUAT OLEH</td>
                                    <td>: {{ $model->user->name }}</td>
                                </tr>

                            </thead>
                        </table>
                    </div>
                    <h6 class="mt-3">TAGIHAN SPP</h6>
                    <div class="row">
                        <div class="col-md-5">
                            <table class="table table-sm table-hover table-bordered mb-3">
                                <thead>
                                    <tr>
                                        <th width="3%">NO</th>
                                        <th>ITEM TAGIHAN</th>
                                        <th>JUMLAH TAGIHAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($model->biaya->children as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($item->nama_biaya) }}</td>
                                            <td class="text-end">{{ formatRupiah($item->jumlah) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" style="text-align: center">Tidak Ada Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-center">TOTAL TAGIHAN</td>
                                        <td class="text-end fw-bold">
                                            {{ formatRupiah($model->biaya?->total_tagihan) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('status.update', [
                                'model' => 'siswa',
                                'id' => $model->id,
                                'status' => $model->status == 'aktif' ? 'non-aktif' : 'aktif',
                            ]) }}"
                                class="btn btn-info btn-sm" onclick="return confirm('ingin mengupdate siswa ini?')">
                                {{ $model->status == 'aktif' ? 'Non-aktifkan Siswa Ini' : 'Aktifkan Siswa Ini' }}
                            </a>
                        </div>
                    </div>
                    <div class="row" width="10%">
                        <div class="col-md-12">
                            {!! link_to(URL::previous(), 'BACK', [
                                'class' => 'btn btn-secondary mt-2',
                                'style' => 'width:10%;',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
