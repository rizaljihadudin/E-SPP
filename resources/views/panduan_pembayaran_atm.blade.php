<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tata Cara Transfer via ATM</title>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      width: 100%;
      position: fixed;
      text-align: center;
    }
    h1 {
      color: #333;
    }
    p {
      color: #555;
      line-height: 0.5;
    }
    ul {
      list-style-type: disc;
      padding-left: 20px;
      text-align: left;
    }
    .illustration {
      max-width: 100%;
      height: auto;
      margin-top: 20px;
    }
    .company-info {
      margin-top: 30px;
      font-size: 14px;
    }
    .company-name {
      font-weight: bold;
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Tata Cara Transfer melalui ATM</h1>
    <p>Berikut adalah langkah-langkah untuk melakukan transfer melalui ATM:</p>
    <ul>
      <li>Masukkan kartu ATM Anda ke mesin ATM.</li>
      <li>Masukkan PIN ATM Anda untuk masuk ke menu utama.</li>
      <li>Pilih menu "Transfer" atau "Transfer antar Bank".</li>
      <li>Masukkan kode bank tujuan dan nomor rekening penerima.</li>
      <li>Masukkan jumlah uang yang ingin Anda transfer.</li>
      <li>Konfirmasi rincian transfer dan pilih "Ya" atau "Lanjut".</li>
      <li>Simpan struk sebagai bukti transfer.</li>
      <li>Selesai! Transfer Anda akan diproses sesuai waktu yang berlaku.</li>
    </ul>
    <div class="company-info">
      <p class="company-name">{{ settings()->get('app_name', 'E-SPP') }}</p>
      <p>Nomor Telepon: {{ settings()->get('app_phone') }}</p>
      <p>Alamat: {{ settings()->get('app_address') }}</p>
      <p>Email: {{ settings()->get('app_email') }}</p>
    </div>
  </div>
</body>
</html>
