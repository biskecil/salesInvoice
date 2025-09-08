<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota CT</title>
    <style>
        @page {
            size: 140mm 210mm landscape;
            margin-top: 5mm;
            margin-left: 4mm;
            margin-right: 10mm;
            margin-bottom: 1mm;
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

        .items-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .items-list th,
        .items-list td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            font-size: 12px;
        }

        .items-list th {
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
            margin-top: 10px;
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
        <table style=" width: 100%;" border="0">
            <tr>
                <td width="70%" style="font-size: 17px;" ><b><u>NOTA CT</u></b></td>
                <td width="10%" style="text-align: right;" >Customer :</td>
                <td> {{ $data->Customer }}</td>
            </tr>
            <tr>
                <td>Nota No : {{ $data->SW }}</td>
                <td></td>
                <td> {{ $data->Address }}
                </td>
            </tr>
            <tr>
                <td>Tanggal : {{ $data->TransDate }}</td>
                <td></td>
                <td> {{ $data->Phone }}</td>
            </tr>
            @if ($data->Grosir != '')
                <tr>
                    <td></td>
                    <td style="text-align: right;"><b>Grosir:</b></td>
                    <td> {{ $data->Grosir }}</td>
                </tr>
            @endif

        </table>
        {{-- <table style=" width: 100%;" border="1">
            <tr>
                <td style="text-align: left" rowspan="2"  width="70%">
                    <div style="font-size: 17px; margin-bottom: 8px;"><b><u>NOTA CT</u></b></div>
                    <div style="margin-bottom: 4px;">Nota No : {{ $data->SW }}</div>
                    <div>Tanggal : {{ $data->TransDate }}</div>
                </td>
                <td style="text-align: right; vertical-align: center;" width="10%">
                    Customer :
                </td>
                <td style="text-align: left; vertical-align: center;" width="20%">
                    {{ $data->Customer }}<br>
                    {{ $data->Address }}

                </td>
            </tr>
            <td  style="text-align: right; vertical-align: center;" >
                <b>Grosir:</b>
            </td>
            <td  style="text-align: left; vertical-align: center;">
                {{ $data->Grosir }}
                

            </td>
            <tr>

            </tr>
        </table> --}}

        <table class="items-list">
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
                        <td style="text-align: center;">{{ $item->caratDesc }}</td>
                        <td style="text-align: left;padding-left:10px">{{ $item->productDesc }}</td>
                        <td style="text-align: right;padding-right:10px">{{ $item->gw }}</td>
                        <td>{{ $item->price }}</td>
                        <td style="text-align: right;padding-right:10px">{{ $item->nw }}</td>
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
                    <td style="text-align: right;padding-right:10px">{{ $data->totalgw }}</td>
                    <td></td>
                    <td style="text-align: right;padding-right:10px">{{ $data->totalnw }}</td>
                </tr>
            </tfoot>
        </table>
        <table style="width: 101%" border="0">
            <tr>
                <td style="vertical-align: bottom; text-align: center; height: 70px;">
                    Customer<br><br><br><br><br><br>
                    ( _____________________ )<br>
                </td>
                <td style="vertical-align: bottom; text-align: center; height: 70px;">
                    Sales<br><br><br><br><br><br>
                    ( _____________________ )<br>
                </td>
                <td style="text-align: left; vertical-align: top; width: 270px; border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black;"
                    rowspan="2">
                    {{-- <div class="box" style="height: 120px;">
                        Keterangan : {{ $data->Remarks }}
                    </div> --}}
                    Keterangan : {{ $data->Venue }}
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    style="text-align: left; vertical-align: top; padding: 0; font-size: 10px; line-height: 1;padding-top:5px">
                    <u>*Pastikan Berat Barang yang Anda Terima sesuai dengan Nota</u>
                </td>
                <td style="border: none;"></td> <!-- empty to align with remarks column -->
            </tr>
        </table>
    </div>
</body>

</html>
