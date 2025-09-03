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
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .label {
            /* width: 7cm;
            height: 3cm; */
            /* border: 1px dotted #000; */
            display: flex;
           
            align-items: center;
            padding-left: 20mm;
            padding-right: 20mm;
            padding-top: 4mm;
            box-sizing: border-box;
        }

        .left {
            width: 40mm;
        }

        .left .kode {
            font-size: 22px;
            font-weight: bold;
        }

        .left .nama {
            font-weight: bold;
            font-size: 12px;
            line-height: 1.2em;
        }

        .left .area {
            font-size: 11px;
            font-style: italic;
        }

        .left .pelanggan {
            font-weight: bold;
            font-size: 12px;
            margin-top: 3px;
        }

        .right {
            /* width: 30m; */
            text-align: center;
        }

        .qrcode {
            width: 20mm;
            height: 20mm;
            margin: 0 auto;
        }

        .right .kode2 {
            font-size: 20px;
            font-weight: bold;
            margin-top: 3px;
        }
    </style>
</head>

<body>
    <div style="display:flex; justify-content:center; align-items:center;"">
        <div class="label">
            <div class="left">
                <div class="kode">LG</div>
                <div class="nama">{{ $data->subgrosir }}</div>
                <div class="area">{{ $data->tempat }}</div>
                <div class="pelanggan">{{ $data->pelanggan }}</div>
            </div>
            <div class="right">
                <div class="qrcode"> {!! QrCode::size(80)->generate($data->QRvalue) !!}</div>
                <div class="kode2">SA</div>
            </div>
        </div>
    </div>
    {{-- <div class="label">
        11ABCDEFGHIJKLMNOPQRTSYU
    </div> --}}
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
