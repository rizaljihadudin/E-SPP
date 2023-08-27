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
				padding-bottom: 10px;
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
                padding:8px;
                min-height:20px; 
                min-width: 80px;
                text-decoration: none;
            }

            .image {
                max-width: 50%;
                height: auto;
            }

            .table-tagihan {
                border: 1px solid black;
                border-collapse: collapse;
            }

            .table-tagihan th {
                background: #eee;
                border: 1px solid black;
                padding: 4px;
            }

            .table-tagihan td {
                padding: 4px;
                border: 1px solid black;
            }

            .hidden {
                visibility:hidden;
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
									Nama Siswa : {{ $siswa->nama }} ( {{ $siswa->nisn }} )<br />
									Kelas : {{ $siswa->kelas }}<br />
									Jurusan : {{ $siswa->jurusan->nama_jurusan }} ({{ $siswa->jurusan->kode_jurusan }})
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
                    <td colspan="2">
                        <table width="100%" class="table-tagihan">
                            <tr>
                                <th style="text-align:center">No</th>
                                <th style="text-align:start;">Bulan</th>
                                <th style="text-align:end;">Jumlah Tagihan</th>
                                <th>Tanggal Bayar</th>
                                <th>Paraf</th>
                                <th>Keterangan</th>
                            </tr>
                            @foreach ($kartuSpp as $item)
                            <tr>
                                <td style="text-align:center">{{ $loop->iteration }}.</td>
                                <td style="text-align:start;">{{ $item['bulan'] . ' ' . $item['tahun'] }}</td>
                                <td style="text-align:end;">{{ formatRupiah($item['total_tagihan']) }}</td>
                                <td>{{ $item['tanggal_bayar'] }}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <br/>
                    <br/>
                    <td colspan="3">
                        Jakarta, {{ now()->translatedFormat('d F Y') }}<br/>
                        Mengetahui, <br/>
                        <br/>
                        <br/>
                        Bendahara
                    </td>
                </tr>
			</table>
            <div class="download-pdf" id="download-pdf">
                <a href="{{ url()->full().'&output=pdf' }}" class="button" target="blank" onclick="hideButton()">Download PDF</a>
                <a href="#" onclick="window.print()" class="button" >Cetak</a>
            </div>
		</div>
        <script>
            hideButton = () => {
                $('#download-pdf').addClass(hidden);
            } 
        </script>
	</body>
</html>