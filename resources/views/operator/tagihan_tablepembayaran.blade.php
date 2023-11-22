<table class="{{ config('app.table_style') }}">
    <thead class="{{ config('app.thead_style') }}">
        <tr>
            <th width="10%">TANGGAL</th>
            <th width="10%">METODE</th>
            <th width="60%" class="text-end">JUMLAH</th>
            <th width="20%">#</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($models->pembayaran as $item)
            <tr>
                <td>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                <td>{{ $item->metode_pembayaran }}</td>
                <td class="text-end">{{ formatRupiah($item->jumlah_dibayar) }}</td>
                <td>
                    {!! Form::open([
                        'route' => ['pembayaran.destroy', $item->id],
                        'method' => 'DELETE',
                        'title' => 'Hapus Data',
                        'onsubmit' => 'return confirm("Apakah anda yakin, ingin menghapus data ini?")',
                    ]) !!}
                    <button class="btn btn-icon btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </button>
                    <a href="{{ route('kwitansipembayaran.print', Crypt::encrypt($item->id)) }}" target="_blank">
                        <i class="fa fa-print"></i>
                    </a>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Data belum ada.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        @if(count($models->pembayaran) > 0)
            <tr>
                <td colspan="2" class="text-start">Total Pembayaran</td>
                <td class="text-end">{{ formatRupiah($models->total_pembayaran) }}</td>
                <td></td>
            </tr>
        @endif
    </tfoot>
</table>
