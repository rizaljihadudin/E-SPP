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
                    {!! Form::model($pembayaran, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                    <div class="form-group mb-2">
                        {!! Form::hidden('transaksi_id', $models->id, []) !!}
                        {!! Form::hidden('wali_id', $siswa->wali_id, []) !!}
                        <label for="tanggal_bayar">Tanggal Pembayaran</label>
                        {!! Form::date('tanggal_bayar', $pembayaran->tanggal_bayar ?? \Carbon\Carbon::now(), [
                            'class' => 'form-control',
                            'autofocus',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jumlah_dibayar">Jumlah Bayar</label>
                        {!! Form::text('jumlah_dibayar', $models->total_tagihan, [
                            'class' => 'form-control',
                            'autofocus',
                            'placeholder' => 'Masukkan nilai pembayaran',
                            'oninput' => 'formatIDR(this)',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                    </div>
                    @if ($models->status != 'lunas')
                        {!! Form::submit('SIMPAN', [
                            'class' => 'btn btn-success'
                        ]) !!}
                    @endif
                    {!! Form::close() !!}
                </div>
