@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Data User</h5>

                <div class="card-body">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data</a>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No. Hp</th>
                                    <th>Email</th>
                                    <th>Akses</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $item->name }}</th>
                                        <th>{{ $item->no_hp }}</th>
                                        <th>{{ $item->email }}</th>
                                        <th>{{ $item->akses }}</th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data User masih kosong!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
