<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <style type="text/css">
        table tr td {
            border-collapse: collapse;
            vertical-align: middle;
        }

        table.table>tbody>tr>td {
            padding-top: 0px;
            padding-bottom: 0px;
            border: 1px solid black;
            font-size: 10px;
        }

        table.table-no-border>tbody>tr>td {
            padding-top: 0px;
            padding-bottom: 0px;
            font-size: 12px;
            border: 1px solid white;
        }

        table.table-material>thead>tr>th {
            padding-top: 0px;
            padding-bottom: 0px;
            padding-left: 3px;
            padding-right: 3px;
            border: none;
            border: 1px solid black !important;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        table.table-material>tbody>tr>td {
            padding-top: 0px;
            padding-bottom: 0px;
            border: 1px solid black !important;
        }

        table.table-border>tbody>tr>td {
            padding-top: 0px;
            padding-bottom: 0px;
            border: 1px solid black !important;
        }

        table.table-left>tbody>tr {
            padding-top: 0px;
            padding-bottom: 0px;
            font-size: 12px;
            border: 1px solid black !important;
        }

        table.table-right>tbody>tr {
            padding-top: 0px;
            padding-bottom: 0px;
            font-size: 12px;
            border: 1px solid black !important;
        }

        .row-border {
            border: 1px solid black !important;
        }

        .no-padding {
            padding: 0px;
        }

        @page {
            margin-top: 2%;
            vertical-align: middle;
        }

        .footer {
            font-size: 12px;
            color: #4f4d56;
            position: fixed;
            left: 0px;
            bottom: -20px;
            right: 0px;
            height: 160px;
        }

        .footer .pagenum:before {
            content: counter(page);
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        .header-tittle {
            font-size: 16pt !important;
            font-weight: bold !important;
            text-decoration: underline;
            margin: 0px;
        }

        .header-identity {
            font-size: 10pt !important;
            font-weight: normal !important;
            margin: 0px;
        }

        .header-do {
            font-size: 16pt !important;
            font-weight: bold !important;
            text-decoration: underline;
            text-align: center !important;
            margin: 0px;
            padding: 0px;
        }

        .body-do {
            font-size: 10pt !important;
            font-weight: normal !important;
            margin: 0px;
            padding: 0px;
        }

        .title {
            font-weight: bold;
            text-align: center;
            margin: 0px;
            padding: 0px;
        }

        .assign-head {
            font-size: 10pt !important;
            font-weight: normal !important;
            margin: 0px;
        }

        .assign-foot {
            font-size: 10pt !important;
            font-weight: bold !important;
            text-decoration: underline;
            margin: 0px;
        }
    </style>
</head>

<body>

    <table class="table-no-border" style="width:100%;">
        <tr>
            <th style="width: 60%;">
                <span class="header-tittle">UD. RAHAYU KUSUMA</span><br>
                <span class="header-identity">Candi Pari RT.10 RW.05 Porong</span><br>
                <span class="header-identity">Sidoarjo - Jawa Timur</span><br>
                <span class="header-identity">Kode Pos: 61274</span><br>
                <span class="header-identity">Telp/Tax: 031-8857482</span><br>
            </th>
            <th style="width: 40%;">
                <span class="header-identity" style="font-weight: bold !important;">Sidoarjo,
                    {{ date('d.m.Y', strtotime($delivery_order->shipment_date)) }}</span><br>
                <span class="header-identity">Kepada Yth : PT. YMPI</span><br>
                <span
                    class="header-identity">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pasuruan</span><br>
            </th>
        </tr>
    </table>

    <table class="table-no-border" style="width:100%;">
        <tbody>
            <tr>
                <th style="width: 20%;">
                    <span class="header-identity">Kendaraan No. Pol. :
                        <span>{{ $delivery_order->vehicle_registration_no }}</span></span>
                </th>
                <th style="width: 60%;" style="text-align: center !important;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="title" style="padding: 0px !important;">
                                <span class="header-do">SURAT JALAN</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="title" style="padding: 0px !important;">
                                <span class="header-identity">No :{{ $delivery_order->delivery_order_no }}</span>
                            </td>
                        </tr>
                    </table>
                </th>
                <th style="width: 20%;">
                </th>
            </tr>
        </tbody>
    </table>

    @php
        
        $count = 0;
        print_r('<table class="table-material" style="width: 100%; font-size: 8pt;">');
        print_r('<thead>');
        print_r('<tr>');
        print_r('<th class="body-do" style="text-align: center; width: 5%;">No.</th>');
        print_r('<th class="body-do" style="text-align: center; width: 10%;">Kode GMC</th>');
        print_r('<th class="body-do" style="text-align: center; width: 30%; text-align: left;">Nama Barang</th>');
        print_r('<th class="body-do" style="text-align: center; width: 5%;">Qty</th>');
        print_r('<th class="body-do" style="text-align: center; width: 5%;">Satuan</th>');
        
        if ($delivery_order->delivery_order_type == 'Purchase Order') {
            print_r('<th class="body-do" style="text-align: center; width: 15%;">No. PO</th>');
            print_r('<th class="body-do" style="text-align: center; width: 30%;">Keterangan</th>');
        } else {
            print_r('<th class="body-do" style="text-align: center; width: 15%;">No. JO</th>');
            print_r('<th class="body-do" style="text-align: center; width: 30%;">No. LKP</th>');
        }
        print_r('</tr>');
        print_r('</thead>');
        
        print_r('<tbody>');
        for ($i = 0; $i < count($delivery_order_detail); $i++) {
            print_r('<tr>');
            print_r('<td class="body-do" style="padding: 2px; text-align: center;">' . ++$count . '</td>');
            print_r('<td class="body-do" style="padding: 2px; text-align: center;">' . $delivery_order_detail[$i]->material_number . '</td>');
            print_r('<td class="body-do" style="padding: 2px; text-align: left;">' . $delivery_order_detail[$i]->material_description . '</td>');
            print_r('<td class="body-do" style="padding: 2px; text-align: center;">' . $delivery_order_detail[$i]->quantity . '</td>');
            print_r('<td class="body-do" style="padding: 2px; text-align: center;">PCS</td>');
            print_r('<td class="body-do" style="padding: 2px; text-align: center;">' . $delivery_order->document_no . '</td>');
            if ($delivery_order->delivery_order_type == 'Purchase Order') {
                print_r('<td class="body-do" style="padding: 2px; text-align: center;"></td>');
            } else {
                print_r('<td class="body-do" style="padding: 2px; text-align: center;">' . $delivery_order->reference_no . '</td>');
            }
            print_r('</tr>');
        }
        
        print_r('</tbody>');
        print_r('</table>');
        
    @endphp
    <br>
    <br>
    <br>

    <table class="table-no-border" style="width:100%;">
        <tr>
            <th style="width: 5%;"></th>
            <th style="width: 40%; text-align: left;">
                <span class="asign-head">Tanda Terima</span>
                <br>
                <br>
                <br>
                <span class="asign-foot">&nbsp;</span>
            </th>
            <th style="width: 40%; text-align: right;">
                <span class="asign-head">Hormat Kami</span>
                <br>
                <br>
                <br>
                <span class="asign-foot">Eko Purwanto</span>
            </th>
            <th style="width: 5%;"></th>
        </tr>
    </table>


</body>

</html>
