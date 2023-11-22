<table class="{{ config('app.table_style') }}">
    <thead class="{{ config('app.thead_style') }}">
        <tr>
            <th>No</th>
            <th>NAMA TAGIHAN</th>
            <th class="text-end">JUMLAH TAGIHAN</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($models->transaksiDetails as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Str::title($item->nama_biaya) }}</td>
                <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: center">Total Tagihan</td>
            <td>{{ formatRupiah($models->total_tagihan) }}</td>
        </tr>
    </tfoot>
</table>
