<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        td {
            padding-right: 5px;
            padding-left: 5px;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        th {
            padding-right: 5px;
            padding-left: 5px;
        }
    </style>
</head>

<body>
    <div>
        <p>
            Dear YMPI Logistic Team,<br>
            {{ $data['delivery_order']->vendor_name }} telah merilis surat jalan melalui sistem BridgeForVendor dengan
            No. <b>{{ $data['delivery_order']->delivery_order_no }}</b>.
        </p>
        <div style="width: 80%; margin: auto;">
            <table style="border:1px solid black; border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th style="border:1px solid black; background-color: #aee571;">No</th>
                        <th style="border:1px solid black; background-color: #aee571;">Kode GMC</th>
                        <th style="border:1px solid black; background-color: #aee571;">Nama Barang</th>
                        <th style="border:1px solid black; background-color: #aee571;">Qty</th>
                        <th style="border:1px solid black; background-color: #aee571;">Satuan</th>
                        <th style="border:1px solid black; background-color: #aee571;">Dokumen Order</th>
                        <th style="border:1px solid black; background-color: #aee571;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    for ($i = 0; $i < count($data['delivery_order_details']); $i++) {
                        print_r('<tr>');
                        print_r('<td style="border: 1px solid black; width: 10%; text-align: center;">' . ++$count . '</td>');
                        print_r('<td style="border: 1px solid black; width: 10%; text-align: center;">' . $data['delivery_order_details'][$i]->material_number . '</td>');
                        print_r('<td style="border: 1px solid black; width: 40%;">' . $data['delivery_order_details'][$i]->material_description . '</td>');
                        print_r('<td style="border: 1px solid black; width: 10%; text-align: right;">' . $data['delivery_order_details'][$i]->quantity . '</td>');
                        print_r('<td style="border: 1px solid black; width: 10%; text-align: center;">PCS</td>');
                        print_r('<td style="border: 1px solid black; width: 10%; text-align: center;">' . $data['delivery_order']->document_no . '</td>');
                        print_r('<td style="border: 1px solid black; width: 10%; text-align: center;">-</td>');
                        print_r('</tr>');
                    } ?>
                </tbody>
            </table>
        </div>
        <br>
        <p style="margin: 0px;">
            Mohon untuk memproses dokumen BC untuk surat jalan ini di <a
                href="https://bridgeforvendor.com">BridgeForVendor</a><br>
        </p>
        <br>
        <br>
        <p style=" font-style: italic; text-align:center; margin: 0px;">
            Ini adalah email otomatis. Mohon untuk tidak membalas email ini.<br>
            Tambahkan bridgeforvendor@ympi.co.id pada daftar kontak untuk memastikan email dari BridgeForVendor masuk ke
            inbox-mu.
        </p>
        <br>
        <br>
    </div>
</body>

</html>
