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
                <div>Nota No : {{ $data->SW }}</div>
                <div>Tanggal : {{ $data->TransDate }}</div>
            </div>
            <div class="right">
                <div>Customer : {{ $data->Customer }}</div>
                <div>{{ $data->Address }}</div>
                <br>
                <div><b>Grosir : {{ $data->Grosir }}</b></div>
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
                        <td>{{ $item->caratDesc }}</td>
                        <td>{{ $item->productDesc }}</td>
                        <td>{{ $item->gw }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->nw }}</td>
                    </tr>
                @endforeach


                @for ($i = count($data->ItemList); $i < 12; $i++)
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
                    <td>{{ $data->totalgw }}</td>
                    <td></td>
                    <td>{{ $data->totalnw }}</td>
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
            *Pastikan Berat Barang yang Anda Terima sesuai dengan Nota
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
