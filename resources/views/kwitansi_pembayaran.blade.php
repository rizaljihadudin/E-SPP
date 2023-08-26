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
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: left;
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

            table tr td{
                border-bottom: 1px solid black;
            }

            .download-pdf{
                margin-top: 8%;
                text-align: center;
            }

            .button {
                background-color:rgb(15, 97, 230);
                color: #fff;
                border:none; 
                padding:8px;
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
                    <td width="25%">No.</td>
                    <td>: #{{ $pembayaran->id }}</td>
                </tr>
                <tr>
                    <td>Telah terima dari</td>
                    <td>: {{ $pembayaran->transaksi->siswa->nama }}</td>
                </tr>
                <tr>
                    <td>Uang Sejumlah</td>
                    <td>: <i>{{ ucwords(terbilang($pembayaran->jumlah_dibayar)) }}Rupiah</i></td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>: SPP {{ $pembayaran->transaksi->tanggal_tagihan->translatedFormat('F Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%">
                            <tr>
                                <td colspan="2" style="vertical-align:bottom;" width="400">
                                    <div style="background: #eee;width:150px;padding:10px;font-weight:bold;text-align:center;">
                                        {{ formatRupiah($pembayaran->jumlah_dibayar) }}
                                    </div>
                                </td>
                                <td>
                                    Jakarta, {{ now()->translatedFormat('d F Y') }}<br/>
                                    Mengetahui, <br/>
                                    <br/>
                                    <br/>
                                    Bendahara
                                </td>
                            </tr>
                        </table>
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