<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota CT</title>
    <style>
        @page {
            size: 140mm 220mm landscape;
            margin-top: 2mm;
            margin-left: 4mm;
            margin-right: 4mm;
            margin-bottom: 2mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }



        .header .right {
            text-align: right;
        }

        .info-cust {
            display: flex;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table th,
        table td {
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
            margin-top: 10px;
        }

        .sign {
            text-align: center;
            margin-top: 40px;
        }

        .note {
            margin-top: 30px;
            font-size: 10px;
            font-weight: bold;
        }

        .box {
            border: 1px solid #000;
            min-height: 2px;
            padding: 5px;
            width: 250px;
        }

        .qrcode {
            width: 20mm;
            height: 20mm;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="left">
                <div style="font-size: 17px;"><b><u>NOTA CT</u></b></div>
                <div>Nota No : {{ $data->SW }}</div>
                <div>Tanggal : {{ $data->TransDate }}</div>
            </div>
            <div class="info-cust">
                <div class="qrcode"> {!! QrCode::size(60)->generate($data->QRvalue) !!}</div>
                <div class="right">
                    <div>Customer : {{ $data->Customer }}</div>
                    <div>{{ $data->Address }}</div>
                    <br>
                    <div><b>Grosir : {{ $data->Grosir }}</b></div>
                </div>

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
                @foreach ($data->ItemList as $item)
                    <tr>
                        <td style="text-align: left;">{{ $item->caratDesc }}</td>
                        <td  style="text-align: left;">{{ $item->productDesc }}</td>
                        <td  style="text-align: right;">{{ $item->gw }}</td>
                        <td>{{ $item->price }}</td>
                        <td  style="text-align: right;">{{ $item->nw }}</td>
                    </tr>
                @endforeach


                @for ($i = count($data->ItemList); $i < 10; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="2">Total</td>
                    <td  style="text-align: right;">{{ $data->totalgw }}</td>
                    <td></td>
                    <td  style="text-align: right;">{{ $data->totalnw }}</td>
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
                Keterangan : {{ $data->Remarks }}
            </div>
        </div>

        <div class="note">
            <u> *Pastikan Berat Barang yang Anda Terima sesuai dengan Nota </u>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
