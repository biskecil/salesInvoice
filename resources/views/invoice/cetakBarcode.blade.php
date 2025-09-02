<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Label Customer</title>
    <style>
        @page {
            size: 8cm 3.5cm;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .label {
            width: 8cm;
            height: 3.5cm;
            border: 1px dotted #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 6px;
            box-sizing: border-box;
        }

        .left {
            width: 5cm;
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
            width: 3cm;
            text-align: center;
        }

        .qrcode {
            width: 2cm;
            height: 2cm;
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
    <div class="label">
        <div class="left">
            <div class="kode">LMS</div>
            <div class="nama">{{ $data->subgrosir }}</div>
            <div class="area">{{ $data->tempat }}</div>
            <div class="pelanggan">{{ $data->QRvalue }}</div>
        </div>
        <div class="right">
            <div class="qrcode"> {!! QrCode::size(80)->generate($data->QRvalue) !!}</div>
            <div class="kode2">SA</div>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
