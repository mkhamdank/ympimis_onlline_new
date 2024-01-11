@extends('layouts.master_full')
@section('stylesheets')
    <link href="{{ url('css/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ url('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css">

    <style type="text/css">
        thead>tr>th {
            text-align: center;
            overflow: hidden;
        }

        tbody>tr>td {
            text-align: center;
        }

        tfoot>tr>th {
            text-align: center;
        }

        th:hover {
            overflow: visible;
        }

        #bodyTableMaterial tr>td:hover {
            overflow: visible;
            /* background-color: lightgreen; */
            font-weight: bold !important;
            cursor: pointer;
        }

        table.table-bordered {
            border: 1px solid lightgray;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
            vertical-align: middle;
            color: white;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid lightgray;
            vertical-align: middle;
        }

        table.table-bordered>tfoot>tr>th {
            border: 1px solid black;
            vertical-align: middle;
            background-color: rgb(126, 86, 134);
            color: #fff !important;
        }

        table.table-condensed>thead>tr>th {
            color: black;
        }

        thead {
            background-color: #fff;
            color: #fff;
        }

        td {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {
            color: white;
        }

        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            margin: 0 auto;
        }

        .loading {
            display: none;
        }
    </style>
@stop
@section('header')
    <div class="page-breadcrumb" style="padding: 10px 30px 10px 30px;">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h2 class="page-title mb-0 p-0">
                    {{ $title }}
                </h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid" style="padding: 7px;min-height: 100vh">
        <div id="loading"
            style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(0,191,255); z-index: 30001; opacity: 0.8;">
            <p style="position: absolute; color: White; top: 45%; left: 35%;">
                <span style="font-size: 40px">Please Wait...<i class="fa fa-spin fa-refresh"></i></span>
            </p>
        </div>
        <div class="row" style="padding: 5px">
            <div class="col-sm-12 " style="margin-bottom: 2%;">
                <div class="col-sm-2" style="display: inline-block; padding: 0px;">
                    <p style="text-align: left; padding-left: 15px; margin: 0px;">
                        Bulan Pengiriman :
                    </p>
                    <div class="col-sm-12">
                        <input type="text" class="form-control datepicker" id="filterMonth" placeholder="Select Month"
                            onchange="fetchData()">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 " style="text-align: center;">
                <div class="card">
                    <div class="card-body" style="padding: 0px">
                        <div class="col-md-12" style="padding: 10px; overflow-x: scroll;">
                            <table class="table table-bordered user-table no-wrap" id="tableMaterial"
                                style="font-size: 10pt !important;">
                                <thead style="background-color: #3f50b5; color: white;" id="headTableMaterial">
                                    <tr>
                                        <th style="text-align: center !important;">Tgl Pengiriman</th>
                                        <th style="text-align: center !important;">Vendor</th>
                                        <th style="text-align: center !important;">No. Surat Jalan</th>
                                        <th style="text-align: center !important;">No. Dokumen</th>
                                        <th style="text-align: center !important;">No. Pol</th>
                                        <th style="text-align: center !important;">Material</th>
                                        <th style="text-align: center !important;">Email Surat Jalan</th>
                                        <th style="text-align: center !important;">Dokumen BC</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableMaterial" style="font-size: 10pt !important;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot id="footTableMaterial">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadBcModal" aria-hidden="true" data-keyboard="false" data-backdrop="static"
        style="overflow-y: auto;">
        <div class="modal-dialog modal-lg" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        Upload Dokumen BC
                    </h4>
                    <button type="button" class="close" onclick="closeModal('uploadBcModal')" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-8" style="display: inline-block; padding: 0px;">
                        <div class="col-md-12">
                            <h4 style="font-weight: normal;">Surat Jalan</h4>
                            <embed id="deliveryOrderViewer" width='100%' height='200px'>
                            <br>
                            <br>
                            <h4 style="font-weight: normal;" id="uploadDeliveryType"></h4>
                            <embed id="documentViewer" width='100%' height='200px'>
                        </div>
                    </div>
                    <div class="col-md-3" style="display: inline-block; padding: 0px; vertical-align: top;">
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 5%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                Surat Jalan :
                            </p>
                            <div class="col-sm-12">
                                <input type="text" class="form-control datepicker" id="uploadDeliveryOrder"
                                    style="width: 100%;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 5%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                Tgl Pengiriman :
                            </p>
                            <div class="col-sm-12">
                                <input type="text" class="form-control datepicker" id="uploadDate"
                                    style="width: 100%;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 5%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                Vendor :
                            </p>
                            <div class="col-sm-12">
                                <input type="text" class="form-control datepicker" id="uploadVendor"
                                    style="width: 100%;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 10%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                No Dokumen :
                            </p>
                            <div class="col-sm-12">
                                <input type="text" class="form-control datepicker" id="uploadDocument"
                                    style="width: 100%;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 5%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                Tipe Dokumen BC <span class="text-red"><b>*</b></span> :
                            </p>
                            <div class="col-sm-12 col-sm-12">
                                <select class="form-control select2" id="uploadBcType"
                                    data-placeholder="Pilih Tipe Dokumen" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="BC 2.6.2">BC 2.6.2</option>
                                    <option value="BC 4.0">BC 4.0</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 5%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                No. Dokumen BC <span class="text-red"><b>*</b></span> :
                            </p>
                            <div class="col-xs-12 col-sm-12">
                                <input type="text" class="form-control" id="uploadBcNo"
                                    placeholder="Nomor Dokumen BC">
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 10%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                Dokumen <span style="color: #ad881a; font-weight: bold;">BC</span> dalam pdf <span
                                    class="text-red"><b>*</b></span> :
                            </p>
                            <div class="col-xs-12 col-sm-12">
                                <input type="file" class="form-control" id="uploadBcFile" accept="application/pdf"
                                    onchange="checkFile(id)">
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: inline-block; padding: 0px; margin-bottom: 5%;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px;">
                                Dokumen <span style="color: #053e6d; font-weight: bold;">SPPB</span> dalam pdf <span
                                    class="text-red"><b>*</b></span> :
                            </p>
                            <div class="col-xs-12 col-sm-12">
                                <input type="file" class="form-control" id="uploadSppbFile" accept="application/pdf"
                                    onchange="checkFile(id)">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color: grey; color: white;"
                        onclick="closeModal('uploadBcModal')">
                        Batal
                    </button>
                    <button class="btn btn-success" onclick="executeDocBc()">
                        <span>
                            <i class="fa fa-save"></i>&nbsp;&nbsp;Submit
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>



@stop
@section('scripts')
    <script src="{{ url('js/jquery.gritter.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/jquery.flot.min.js') }}"></script>
    <script src="{{ url('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('js/buttons.flash.min.js') }}"></script>
    <script src="{{ url('js/jszip.min.js') }}"></script>
    <script src="{{ url('js/vfs_fonts.js') }}"></script>
    <script src="{{ url('js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('js/buttons.print.min.js') }}"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery(document).ready(function() {

            $('.select2').select2();
            fetchData();
            $('#filterMonth').datepicker({
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months",
                autoclose: true,
                todayHighlight: true
            });
            $('#createDate').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true
            });
        });

        var audio_error = new Audio('{{ url('sounds/error.mp3') }}');

        function closeModal(id) {
            $("#" + id).modal('hide');
        }

        function executeDocBc() {

            var delivery_order = $("#uploadDeliveryOrder").val();
            var bc_type = $("#uploadBcType").val();
            var bc_no = $('#uploadBcNo').val();
            var bc_file = $('#uploadBcFile').val();
            var sppb_file = $('#uploadSppbFile').val();

            console.log(bc_type)

            if (bc_type == '') {
                openErrorGritter('Error!', 'Tipe Dokumen BC harus diisi.');
                return false;
            }

            if (bc_no == '') {
                openErrorGritter('Error!', 'Nomor Dokumen BC harus diisi.');
                return false;
            }

            if (document.getElementById("uploadBcFile").files.length == 0) {
                openErrorGritter('Error!', 'Dokumen BC harus diisi.');
                return false;
            }

            if (document.getElementById("uploadSppbFile").files.length == 0) {
                openErrorGritter('Error!', 'Dokumen SPPB harus diisi.');
                return false;
            }

            var myFormData = new FormData();
            myFormData.append('delivery_order', delivery_order);
            myFormData.append('bc_type', bc_type);
            myFormData.append('bc_no', bc_no);
            myFormData.append('bc_file', $("#uploadBcFile").prop('files')[0]);
            myFormData.append('sppb_file', $("#uploadSppbFile").prop('files')[0]);

            $('#loading').show();
            $.ajax({
                url: '{{ url('input/bc_document') }}',
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: myFormData,
                success: function(result, status, xhr) {
                    if (result.status) {
                        fetchData();
                        $("#uploadBcModal").modal('hide');
                        openSuccessGritter('Success!', result.message);
                        $('#loading').hide();
                    } else {
                        audio_error.play();
                        openErrorGritter('Error!', result.message);
                        $('#loading').hide();
                    }
                }
            });

        }

        function checkFile(id) {

            var file = $('#' + id).val().replace(/C:\\fakepath\\/i, '');
            console.log(file);

            if (!file.includes('pdf')) {
                $("#" + id).val('');
                openErrorGritter('Error!', 'Dokumen harus berformat PDF');
                return false;
            }

        }

        function showUploadBc(param) {
            var id = param.split('_')[1];

            var delivery_date = $('#' + id).find('td').eq(0).text();
            var vendor_name = $('#' + id).find('td').eq(1).text();
            var delivery_order = $('#' + id).find('td').eq(2).text();
            var delivery_order_filename = delivery_order.replaceAll("//", ".");

            $("#deliveryOrderViewer").attr(
                'src', '{{ url('files/delivery_order') }}' + '/' + delivery_order_filename + '.pdf'
            );

            var document = param.split('_')[2].split(':');
            var document_type = document[0];
            var document_filename = document[1];

            $("#uploadDeliveryType").text(document_type);
            $("#documentViewer").attr(
                'src', '{{ url('files/po') }}' + '/' + document_filename + '.pdf'
            );

            $("#uploadDeliveryType").text(document_type);

            $("#uploadDeliveryOrder").val(delivery_order);
            $("#uploadDate").val(delivery_date);
            $("#uploadVendor").val(vendor_name);
            $("#uploadDocument").val(document_filename);

            $("#uploadBcType").val('').trigger('change.select2');
            $('#uploadBcNo').val('');
            $('#uploadBcFile').val('');
            $('#uploadSppbFile').val('');

            $('#uploadBcModal').modal('show');

        }

        function downloadDeliveryOrder(filename) {
            var data = {
                filename: filename
            }

            $.get('{{ url('download/delivery_order/') }}', data, function(result, status, xhr) {
                if (result.status) {
                    window.open(result.file_path);
                } else {
                    openErrorGritter('Error!', 'Attempt to retrieve data failed <br>データ取得が失敗');
                }
            });
        }

        function downloadDoc(filename) {
            var data = {
                filename: filename
            }

            $.get('{{ url('download/document_order/') }}', data, function(result, status, xhr) {
                if (result.status) {
                    window.open(result.file_path);
                } else {
                    openErrorGritter('Error!', 'Data tidak ditemukan');
                }
            });
        }

        function fetchData() {
            $('#loading').show();

            var data = {
                month: $('#filterMonth').val(),
            }

            $.get('{{ url('fetch/delivery_order_bc') }}', data, function(result, status, xhr) {
                if (result.status) {

                    $('#tableMaterial').DataTable().clear();
                    $('#tableMaterial').DataTable().destroy();
                    $('#bodyTableMaterial').html('');

                    var tableData = '';
                    for (let i = 0; i < result.delivery_orders.length; i++) {
                        tableData += '<tr id="' + result.delivery_orders[i].id + '">';

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += result.delivery_orders[i].shipment_date;
                        tableData += '</td>';

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += result.delivery_orders[i].vendor_name;
                        tableData += '</td>';

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += '<a style="color: #208edd; cursor: pointer;" ';
                        var filename = result.delivery_orders[i].delivery_order_no.replaceAll("//", ".");
                        tableData += 'onclick="downloadDeliveryOrder(\'' + filename + '\')">';
                        tableData += result.delivery_orders[i].delivery_order_no;
                        tableData += '</a>';
                        tableData += '</td>';

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += result.delivery_orders[i].delivery_order_type + '<br>';
                        if (result.delivery_orders[i].delivery_order_type == 'Purchase Order') {
                            tableData += 'PO : ';
                            tableData += '<a style="color: #208edd; cursor: pointer;" ';
                            var filename = result.delivery_orders[i].document_no;
                            tableData += 'onclick="downloadDoc(\'' + filename + '\')">';
                            tableData += result.delivery_orders[i].document_no;
                            tableData += '</a>';

                        } else {
                            tableData += 'JO : ';
                            tableData += '<a style="color: #208edd; cursor: pointer;" ';
                            var filename = result.delivery_orders[i].document_no;
                            tableData += 'onclick="downloadDoc(\'' + filename + '\')">';
                            tableData += result.delivery_orders[i].document_no;
                            tableData += '</a>';
                            tableData += '<br>';

                            tableData += 'LKP : ' + result.delivery_orders[i].reference_no + '<br>';
                        }
                        tableData += '</td>';

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += result.delivery_orders[i].vehicle_registration_no;
                        tableData += '</td>';

                        tableData += '<td style="font-size: 10pt !important;">';
                        for (let j = 0; j < result.delivery_order_details.length; j++) {
                            if (result.delivery_orders[i].delivery_order_no ==
                                result.delivery_order_details[j].delivery_order_no) {

                                tableData += result.delivery_order_details[j].material_number + ' - ';
                                tableData += result.delivery_order_details[j].material_description + ' ';
                                tableData += '(' + result.delivery_order_details[j].quantity + ' PCs)';
                                tableData += '<br>';

                            }

                        }
                        tableData += '</td>';

                        var send = result.delivery_orders[i].delivery_order_sent_at.split(' ');
                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += '<span style="color: #059569;">Terkirim</span>';
                        tableData += '<br>' + send[0];
                        tableData += '<br>' + send[1];
                        tableData += '</td>';

                        if (result.delivery_orders[i].customs_no == null) {
                            tableData += '<td style="font-size: 10pt !important;">';
                            tableData += '<button type="button" class="btn btn-default" ';
                            tableData += 'id="btnSend_' + result.delivery_orders[i].id + '_' +
                                result.delivery_orders[i].delivery_order_type + ':' +
                                result.delivery_orders[i].document_no + '" ';
                            tableData += 'onclick="showUploadBc(id)">';
                            tableData += '<i class="fa fa-upload"></i>&nbsp;&nbsp;Upload BC Doc.';
                            tableData += '</button>';
                            tableData += '</td>';
                        } else {
                            tableData += '<td style="font-size: 10pt !important;">';
                            tableData += '<a style="color: #208edd; cursor: pointer;" ';
                            var filename = result.delivery_orders[i].customs_no;
                            tableData += 'onclick="downloadDeliveryOrder(\'' + filename + '\')">';
                            tableData += result.delivery_orders[i].customs_no;
                            tableData += '</a>';
                            tableData += '</td>';
                        }

                        tableData += '</tr>';

                    }

                    $('#bodyTableMaterial').append(tableData);

                    $('#tableMaterial tfoot th').each(function() {
                        var title = $(this).text();
                        $(this).html(
                            '<input style="width: 100%; text-align: center;" type="text" placeholder="Search ' +
                            title +
                            '"/>');
                    });

                    var table = $('#tableMaterial').DataTable({
                        'dom': 'Bfrtip',
                        'responsive': true,
                        'lengthMenu': [
                            [10, 25, 50, -1],
                            ['10 rows', '25 rows', '50 rows', 'Show all']
                        ],
                        'buttons': {
                            buttons: [{
                                    extend: 'pageLength',
                                    className: 'btn btn-default',
                                },
                                {
                                    extend: 'copy',
                                    className: 'btn btn-success',
                                    text: '<i class="fa fa-copy"></i> Copy',
                                    exportOptions: {
                                        columns: ':not(.notexport)'
                                    }
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn btn-info',
                                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                                    exportOptions: {
                                        columns: ':not(.notexport)'
                                    }
                                },
                                {
                                    extend: 'print',
                                    className: 'btn btn-warning',
                                    text: '<i class="fa fa-print"></i> Print',
                                    exportOptions: {
                                        columns: ':not(.notexport)'
                                    }
                                }
                            ]
                        },
                        'paging': true,
                        'lengthChange': true,
                        'pageLength': 10,
                        'searching': true,
                        'ordering': true,
                        'order': [],
                        'info': true,
                        'autoWidth': true,
                        'sPaginationType': 'full_numbers',
                        'bJQueryUI': true,
                        'bAutoWidth': false,
                        'processing': true,
                        'columnDefs': [{
                            "targets": [3, 5],
                            "className": "text-left",
                        }]
                    });

                    table.columns().every(function() {
                        var that = this;

                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    })

                    $('#tableMaterial tfoot tr').appendTo('#tableMaterial thead');



                    $('#loading').hide();
                } else {
                    $('#loading').hide();
                    openErrorGritter('Error!', result.message);
                }
            });
        }

        function openSuccessGritter(title, message) {
            jQuery.gritter.add({
                title: title,
                text: message,
                class_name: 'growl-success',
                image: '{{ url('images/image-screen.png') }}',
                sticky: false,
                time: '3000'
            });
        }

        function openErrorGritter(title, message) {
            jQuery.gritter.add({
                title: title,
                text: message,
                class_name: 'growl-danger',
                image: '{{ url('images/image-stop.png') }}',
                sticky: false,
                time: '3000'
            });
        }
    </script>
@endsection
