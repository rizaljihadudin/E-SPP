<div class="card-body">
    <a href="{{ route('kartuspp.index', ['siswa_id' => $siswa->id, 'tahun' => request('tahun')]) }}" class="mb-3"
        target="_blank"><i class="fa fa-print"></i>
        Cetak Kartu SPP {{ request('tahun') }}
    </a>
    <table width="100%" class="{{ config('app.table_style') }} mt-2" style="font-size: 14px;">
        <thead class="{{ config('app.thead_style') }}">
            <tr style="height: 50px;">
                <th style="width:1%;text-align:center">No</th>
                <th style="text-align:start;">Bulan</th>
                <th style="text-align:end;">Jumlah Tagihan</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kartuSpp as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}.</td>
                    <td style="text-align:start;">{{ $item['bulan'] . ' ' . $item['tahun'] }}</td>
                    <td style="text-align:end;">{{ formatRupiah($item['total_tagihan']) }}</td>
                    <td>{{ $item['tanggal_bayar'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
