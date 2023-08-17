<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
        <title>
            {{ $title ?? '' }} |
            {{ settings()->get('app_name', 'E-SPP') }}
        </title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 25px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

            .download-pdf{
                margin-top: 20px;
            }

            .button {
                background-color:rgb(15, 97, 230);
                color: #fff;
                border:none; 
                border-radius:8px; 
                padding:15px;
                min-height:30px; 
                min-width: 120px;
                text-decoration: none;
            }

            .image {
                max-width: 50%;
                height: auto;
            }


		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td width="80">
                        @if (request('output') == 'pdf')
                            <img src="{{ public_path('logo/sdit.png') }}" style="width: 100%;" />
                        @else
                            <img src="{{ asset('logo/sdit.png') }}" style="width: 100%;" />
                        @endif
					</td>
                    <td style="text-align: left;vertical-align:middle;" colspan="1">
                        <div style="font-size:20px;font-weight:bold;">
                            {{ settings()->get('app_name') }}
                        </div>
                        <div>
                            {{ settings()->get('app_address') }}
                        </div>
                    </td>
				</tr>
                <tr>
                    <td colspan="3">
                        <hr>
                    </td>
                </tr>
				<tr class="information">
					<td colspan="3">
						<table>
							<tr>
								<td>
									Tagihan Untuk : {{ $tagihan->siswa->nama }} ( {{ $tagihan->siswa->nisn }} )<br />
									Kelas : {{ $tagihan->siswa->kelas }}<br />
									Jurusan : {{ $tagihan->siswa->jurusan->nama_jurusan }} ({{ $tagihan->siswa->jurusan->kode_jurusan }})
								</td>

								<td>
									Invoice #: {{ $tagihan->id }}<br />
									Tanggal Tagihan: {{ $tagihan->tanggal_tagihan->translatedFormat('d F Y') }}<br />
									Tanggal Jatuh Tempo: {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
                    <td style="width:5px;text-align:center">No</td>
					<td style="width:600px;text-align:start;">Item Tagihan</td>
					<td style="width:150px;text-align:end;">Sub-Total</td>
				</tr>
                @foreach ($tagihan->transaksiDetails as $item)
				<tr class="item">
                    <td style="width:5px;text-align:center">{{ $loop->iteration }}.</td>
					<td style="width:600px;text-align:start;">{{ $item->nama_biaya }}</td>
					<td style="width:150px;text-align:end;">{{ formatRupiah($item->jumlah_biaya) }}</td>
				</tr>
                @endforeach
				<tr class="total" style="background: #eee">
					<td colspan="2" style="text-align: center;font-weight:bold;">TOTAL</td>
					<td>{{ formatRupiah($tagihan->total_tagihan) }}</td>
				</tr>
                <tr>
                    <td colspan="3">
                        Terbilang : <i>{{ ucwords(terbilang($tagihan->total_tagihan) . 'Rupiah') }}</i>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Jakarta, {{ now()->translatedFormat('d F Y') }}<br/>
                        Mengetahui, <br/>
                        <br/>
                        <br/>
                        Bendahara
                    </td>
                </tr>
			</table>
            <div class="download-pdf">
                <a href="{{ url()->current().'?output=pdf' }}" class="button" target="blank">Download PDF</a>
                <a href="#" onclick="window.print()" class="button" >Cetak</a>
            </div>
		</div>
	</body>
</html>