@extends('layouts.app_sneat')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Data Siswa</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
