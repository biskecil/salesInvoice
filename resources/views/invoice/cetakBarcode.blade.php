<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Label Customer</title>
    <style>
        @page {
            size: 80mm 30mm;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .label {
            display: flex;
            align-items: center;
            padding-left: 0mm;
            padding-right: 00mm;
            padding-top: 4mm;
            box-sizing: border-box;
        }

        .kode {
            font-size: 21px;
            font-weight: bold;
        }

        .nama {
            font-weight: bold;
            font-size: 10px;
            line-height: 1.2em;
        }

        .area {
            font-size: 10px;
            font-style: italic;
        }

        .pelanggan {
            font-weight: bold;
            font-size: 10px;
            margin-top: 3px;
        }


        .kode2 {
            font-size: 21px;
            font-weight: bold;
            margin-top: 3px;
        }
    </style>
</head>

<body>
    <table style="width:100%;  padding-top: 1mm;padding-left: 11mm;padding-right: 8mm;">
        <tr>
            <td style="text-align:left;">
                <div class="kode">LG &nbsp;&nbsp;{{ $data->carat }}</div>
                <div class="nama">{{ $data->pelanggan }}</div>
                <div class="area">{{ $data->tempat }}</div>
                <div>{{ $data->subgrosir }}</div>
                <div>{{ $data->invoice_number }} / {{ $data->totalgw }}</div>
            </td>
            <td style="text-align:center; width:80px;">
                <img src="{{ storage_path('app/public/qrcode/' . $data->invoice_number . '.png') }}" width="60"
                    height="60">
                <div class="kode2">{{$data->Grosir}}</div>
            </td>
        </tr>
    </table>
</body>


</html>
