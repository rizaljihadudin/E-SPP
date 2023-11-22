@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row">
        <div class="col-lg-10 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang, {{ ucwords(auth()->user()->name) }} 🎉</h5>
                            <p class="mb-4">
                                Kamu mendapat <span class="fw-bold">{{ auth()->user()->unreadNotifications->count() }}</span>
                                notifikasi yang belum kamu lihat. Klik tombol dibawah untuk melihat informasi pembayaran.
                            </p>

                            <a href="{{ route('wali.tagihan.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Data Pembayaran
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('sneat/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('sneat/assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Anak</span>
                            <h3 class="card-title mb-2">{{ auth()->user()->siswa->count() }} Anak</h3>
                            <small class="text-success fw-semibold"> Peserta Didik</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- kartu spp --}}
        @foreach ($dataRekap as $item)
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">KARTU SPP <strong>{{ strtoupper($item['siswa']->nama) }}</strong></h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-secondary">
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Bulan</h6>
                                    </div>
                                    <span>
                                        Status
                                    </span>
                                </div>
                            </li>
                            @foreach ($item['dataTagihan'] as $itemTagihan)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $itemTagihan['bulan'] }}</h6>
                                        </div>
                                        @if ($itemTagihan['tagihan'])
                                            <span class="badge badge-pill {{ $itemTagihan['status_bayar_txt'] == 'lunas' ? ' bg-primary' : 'bg-danger' }}">
                                                <a href="{{ route('wali.tagihan.show', $itemTagihan['tagihan']->id) }}" class="text-white">
                                                    {{ $itemTagihan['status_bayar_txt'] }}
                                                </a>
                                            </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- end kartu spp --}}
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Notifikasi Baru</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach (auth()->user()->unreadNotifications->take(5) as $notification)
                            <li
                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                <a
                                    href="{{ url($notification->data['url'] . '?id=' . $notification->id) }}">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $notification->data['title'] }}
                                            </h6>
                                            <p class="mb-0">
                                                {!! \Str::title($notification->data['messages']) !!}
                                            </p>
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                            <a href="javascript:void(0)"
                                                class="dropdown-notifications-read"><span
                                                    class="badge badge-dot"></span></a>
                                            {!! Form::open([
                                                'route' => ['wali.notifikasi.update', $notification->id],
                                                'method' => 'PUT',
                                            ]) !!}
                                            <button type="submit"
                                            class="btn dropdown-notifications-archive"><span
                                                class="bx bx-x"></span></button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
