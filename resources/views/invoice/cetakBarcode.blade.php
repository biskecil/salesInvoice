<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Label Customer</title>
    <style>
        @page {
            size: 81mm 30mm;
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
            font-size: 19px;
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
    <table style="width:100%;  padding-top: 1mm;padding-left: 10.5mm;padding-right: 9mm;" border="0">
        <tr>
            <td style="text-align:left;vertical-align:top">
                <div class="kode">LG {{ $data->carat }} &nbsp;{{ $data->Grosir }}</div>
                <div class="nama">{{ $data->pelanggan }}</div>
                <div class="area">{{ $data->tempat }}</div>
                <div>{{ $data->subgrosir }}</div>
                <div>{{ $data->invoice_number }} / {{ $data->TransDate }}</div>
                <div>{{ $data->totalgw }} / {{ $data->totalnw }}</div>
            </td>
            @if ($data->Grosir == 'SA' || $data->Grosir == 'BM' || $data->Grosir == 'BMJ' || $data->Grosir == 'BMS')
            <td style="text-align:center; width:95px;">
              
                    <img src="{{ storage_path('app/public/qrcode/' . $data->invoice_number . '.png') }}" width="80"
                        height="80">
                    {{-- <div class="kode2">{{ $data->Grosir }}</div> --}}
                @else
                <div style="height:60px"></div>
              
            </td>
            @endif
        </tr>
    </table>
</body>


</html>
