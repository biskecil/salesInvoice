<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nota CT</title>
<style>
    @page {
        size: 9.5in 11in landscape;
        margin: 0.5in;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
    }
    .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .header .left {
        font-weight: bold;
    }
    .header .right {
        text-align: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }
    table th, table td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        font-size: 12px;
    }
    table th {
        background: #f0f0f0;
    }
    .totals td {
        font-weight: bold;
    }
    .footer {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    .sign {
        text-align: center;
        margin-top: 40px;
    }
    .note {
        margin-top: 30px;
        font-size: 11px;
        font-style: italic;
    }
    .box {
        border: 1px solid #000;
        min-height: 60px;
        padding: 5px;
        width: 250px;
    }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="left">
            <div>NOTA CT</div>
            <div>Nota No : P05341</div>
            <div>Tanggal : 04/06/2025</div>
        </div>
        <div class="right">
            <div>Customer : BINTANG MAS</div>
            <div>JAKARTA</div>
            <br>
            <div><b>Grosir : Bintang Mas Jkt</b></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kadar</th>
                <th>Kategori</th>
                <th>Bruto</th>
                <th>%</th>
                <th>24K</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>08K</td>
                <td>Cincin</td>
                <td>303.92</td>
                <td>41.5</td>
                <td>126.126</td>
            </tr>
            <tr>
                <td>08K</td>
                <td>Cincin</td>
                <td>82.47</td>
                <td>41.5</td>
                <td>34.225</td>
            </tr>
            <!-- Empty rows for spacing -->
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
        </tbody>
        <tfoot>
            <tr class="totals">
                <td colspan="2">Total</td>
                <td>386.39</td>
                <td></td>
                <td>160.351</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="sign">
            Customer<br><br><br>
            ( _____________________ )
        </div>
        <div class="sign">
            Sales<br><br><br>
            ( _____________________ )
        </div>
        <div class="box">
            Keterangan : Bandung
        </div>
    </div>

    <div class="note">
        *Pastikan Berat Barang yang Anda Terima sesuai dengan Nota
    </div>
</div>
</body>
</html>
