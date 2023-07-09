@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Halo, {{ \Str::title(Auth::user()->name) }}</h5>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    {{-- <div id="current-date" class="mt-2"></div> --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        // function getCurrentDateTime() {
        //     let currentDateElement = document.getElementById('current-date');
        //     let currentDate = new Date();

        //     let days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        //     let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
        //         'September', 'Oktober', 'November', 'Desember'
        //     ];

        //     let day = days[currentDate.getDay()];
        //     let date = currentDate.getDate();
        //     let month = months[currentDate.getMonth()];
        //     let year = currentDate.getFullYear();
        //     let time = currentDate.toLocaleTimeString();

        //     let currentDateTime =
        //         `<div class="alert alert-info"><i class="fa fa-solid fa-clock"></i> ${day}, ${date} ${month} ${year} ${time} </div>`;
        //     currentDateElement.innerHTML = currentDateTime;
        // }

        // setInterval(function() {
        //     getCurrentDateTime();
        // }, 1000);
    </script>
@endsection
