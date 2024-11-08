@extends('layouts.app_sneat')
@section('js')
    <script>
        $(document).ready(function() {
            $('#loading-spinner').hide();
            $('#form-ajax').submit(function(e) {
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('#loading-spinner').show();
                        $('#loadingOverlay').removeClass("d-none");
                    },
                    success: function(response) {
                        console.log(response)
                        $('#alert-message').removeClass("d-none");
                        $('#alert-message').addClass("alert-success");
                        $('#msg-alert').html(response.message)
                        $('#loading-spinner').hide();
                        $('#loadingOverlay').addClass("d-none");
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr)
                        $('#alert-message').removeClass("d-none");
                        $('#alert-message').addClass("alert-danger");
                        $('#msg-alert').html(xhr.responseJSON.message)
                        $('#loading-spinner').hide();
                        $('#loadingOverlay').addClass("d-none");
                    }
                });
                e.preventDefault();
                return;
            });
        });
    </script>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Form {{ $title }}</h5>
                <div class="col-md-8 offset-2">
                    <div class="card-body">
                        <div class="alert alert-dismissible d-none" role="alert" id="alert-message">
                            <strong id="msg-alert"></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true, 'id' => 'form-ajax']) !!}
                        {{-- <div class="form-group mb-3">
                            <label for="biaya_id">Jenis Biaya</label>
                            {!! Form::Select('biaya_id[]', $biaya, null, [
                                'class' => 'form-control select2-multiple',
                                'multiple' => 'multiple',
                                'autofocus',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('biaya_id') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kelas">Tagihan untuk Kelas</label>
                            {!! Form::selectRange('kelas', 1, 6, null, [
                                'class' => 'form-control select2',
                                'autofocus',
                                'placeholder' => '-- Pilih Kelas --',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('kelas') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="angkatan">Tagihan untuk Angkatan</label>
                            {!! Form::selectRange('angkatan', 2010, date('Y') + 1, null, [
                                'class' => 'form-control select2',
                                'autofocus',
                                'placeholder' => '-- Pilih Angkatan --',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                        </div> --}}
                        <div class="form-group mb-3">
                            <label for="tanggal_tagihan">Tanggal Tagihan</label>
                            {!! Form::date('tanggal_tagihan', $model->tanggal_tagihan ?? date('Y-m-01'), [
                                'class' => 'form-control',
                                'rows' => 5,
                                'placeholder' => 'Silahkan isi tanggal tagihan...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_tagihan') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
                            {!! Form::date('tanggal_jatuh_tempo', $model->tanggal_jatuh_temp ?? date('Y-m-10'), [
                                'class' => 'form-control',
                                'rows' => 5,
                                'placeholder' => 'Silahkan isi tanggal jatuh tempo...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_jatuh_tempo') }}</span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="keterangan">Keterangan</label>
                            {!! Form::textarea('keterangan', null, [
                                'class' => 'form-control',
                                'autofocus',
                                'rows' => 5,
                                'placeholder' => 'Silahkan isi Keterangan...',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                        </div>


                        {{-- {!! Form::submit($button, ['class' => 'btn btn-success']) !!} --}}
                        <button class="btn btn-success" type="submit">
                            <span id="loading-spinner" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            {{ $button }}
                        </button>
                        {!! link_to(URL::previous(), 'BACK', ['class' => 'btn btn-secondary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const viewImg = (e) => {
            let output = document.getElementById('viewImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>
@endsection
