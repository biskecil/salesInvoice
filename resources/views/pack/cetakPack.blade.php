<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Label Customer</title>
    <style>
        @page {
            size: 100mm 50mm;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            /* font-weight: bold; */
            font-size: 16px;
            padding-left: 15px;
            padding-top: 16px;
        }

        /* body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

      


        .kode2 {
            font-size: 21px;
            font-weight: bold;
            margin-top: 3px;
        } */
    </style>
</head>

<body>
    <table style="width:100%; " border="0">
        <tr>
            <td style="text-align:left;font-weight: bold;font-size:28px;">LG</td>
            <td style="text-align:left;font-size:28px;" rowspan="2">Kadar&nbsp;: <b>{{ $data->carat }}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align:left;">Grosir&nbsp;: {{ $data->Grosir }}</td>

        </tr>
        <tr>
            <td style="text-align:left;">Ket&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->noNota }}</td>
            <td style="text-align:left;font-size:18px;">Berat&nbsp;&nbsp;: <b>{{$data->wbruto_form}}</b></td>
        </tr>
        <tr>
            <td style="text-align:left;">&nbsp;</td>

        </tr>
       
        <tr>
            <td colspan="2" style="text-align:center; font-size:25px; vertical-align:bottom;">
                {{ $data->Customer }}<br>
                <p style="font-size:15px; margin:0; line-height:18px;"><i>{{$data->Address}}</i></p>
            </td>
        </tr>

    </table>

</body>

{{-- <table style="width:100%; font-family: Arial, sans-serif; font-size:12px; border-collapse:collapse;" border="1">
    <tr>
       
        <td style="width:60%; vertical-align:top; padding:4px;">
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <tr>
                    <td style="width:40%; text-align:left;">Nama</td>
                    <td style="width:5%; text-align:center;">:</td>
                    <td style="text-align:left; font-weight:bold;">Lestari</td>
                </tr>
                <tr>
                    <td style="text-align:left;">Grosir</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:left; font-weight:bold;">SA</td>
                </tr>
                <tr>
                    <td style="text-align:left;">Ket</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:left; font-weight:bold;">IIC1909001</td>
                </tr>
            </table>
        </td>

       
        <td style="width:40%; vertical-align:top; padding:4px;">
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <tr>
                    <td style="text-align:left;">Kadar</td>
                    <td style="width:5%; text-align:center;">:</td>
                    <td style="text-align:left; font-weight:bold;">16K</td>
                </tr>
                <tr>
                    <td style="text-align:left;">Berat</td>
                    <td style="text-align:center;">:</td>
                    <td style="text-align:left; font-weight:bold;">175.56</td>
                </tr>
            </table>
        </td>
    </tr>

   
    <tr>
        <td colspan="2" style="text-align:center; padding-top:10px;">
            <div style="font-size:22px; font-weight:bold; letter-spacing:1px;">Mahkota</div>
            <div style="font-size:14px; color:#555; margin-top:2px;">Surabaya</div>
        </td>
    </tr>
</table> --}}

</html>
