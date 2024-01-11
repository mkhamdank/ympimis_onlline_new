@extends('layouts.master')
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
            /* cursor: pointer; */
            /* cursor: context-menu; */
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
    <div class="page-breadcrumb" style="padding: 7px">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{ $title }}<span class="text-purple"> {{ $vendor }}</span>
                </h3>
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
        <input type="hidden" id="vendor_nickname" value="{{ $vendor_nickname }}">
        <div class="row" style="padding: 5px">
            <div class="col-sm-12 col-xs-12" style="margin-bottom: 2%;">
                <div class="col-xs-2 col-sm-2" style="display: inline-block; padding: 0px;">
                    <p style="text-align: left; padding-left: 15px; margin: 0px;">
                        Bulan Pengiriman :
                    </p>
                    <div class="col-xs-12 col-sm-12">
                        <input type="text" class="form-control datepicker" id="filterMonth" placeholder="Select Month"
                            onchange="fetchData()">
                    </div>
                </div>

                <button type="button" class="btn btn-primary pull-right" onclick="openModal()">
                    <i class="fa fa-plus-square"></i>&nbsp;&nbsp;Buat Surat Jalan
                </button>

            </div>
            <div class="col-sm-12 col-xs-12" style="text-align: center;">
                <div class="card">
                    <div class="card-body" style="padding: 0px">
                        <div class="col-md-12" style="padding: 10px; overflow-x: scroll;">
                            <table class="table table-bordered user-table no-wrap" id="tableMaterial"
                                style="font-size: 10pt !important;">
                                <thead style="background-color: #3f50b5; color: white;" id="headTableMaterial">
                                    <tr>
                                        <th style="text-align: center !important;">Hapus</th>
                                        <th style="text-align: center !important;">No. Surat Jalan</th>
                                        <th style="text-align: center !important;">Tgl Pengiriman</th>
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

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        Buat Surat Jalan
                    </h4>
                    <button type="button" class="close" onclick="closeModal('createModal')" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12" style="display: inline-block; margin-bottom: 10px;">
                            <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    Tgl Pengiriman <span class="text-red"><b>*</b></span> :
                                </p>
                                <div class="col-xs-12 col-sm-12">
                                    <input type="text" class="form-control datepicker" id="createDate"
                                        placeholder="Pilih Tanggal">
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    No. Pol. <span class="text-red"><b>*</b></span> :
                                </p>
                                <div class="col-xs-12 col-sm-12">
                                    <input type="text" class="form-control" id="createNoPol"
                                        placeholder="Input No Pol" value="L 9062 UA">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    Tipe Order <span class="text-red"><b>*</b></span> :
                                </p>
                                <div class="col-xs-12 col-sm-12">
                                    <select class="form-control select2" id="createOrderType" onchange="checkOrderType()"
                                        data-placeholder="Pilih Tipe Order" style="width: 100%;">
                                        <option value=""></option>
                                        <option value="SUBCONT">SUBCONT</option>
                                        <option value="401 SUBCONT">401 SUBCONT</option>
                                        <option value="DIRECT MATERIAL">DIRECT MATERIAL</option>
                                        <option value="401 DIRECT MATERIAL">401 DIRECT MATERIAL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-xs-12">
                        <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                No. Purchase Order (PO) <span class="text-red"><b>*</b></span> :
                            </p>
                            <div class="col-xs-12 col-sm-12">
                                <input type="text" class="form-control" id="createPo" placeholder="Input PO">
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                            <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                File Purchase Order (PO) dalam pdf <span class="text-red"><b>*</b></span> :
                            </p>
                            <div class="col-xs-12 col-sm-12">
                                <input type="file" class="form-control" id="createFilePo" accept="application/pdf"
                                    onchange="checkFile(id)">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="job_order_field">
                        <div class="col-xs-12">
                            <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    No. Job Order (JO) <span class="text-red"><b>*</b></span> :
                                </p>
                                <div class="col-xs-12 col-sm-12">
                                    <input type="text" class="form-control" id="createJo" placeholder="Input JO">
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    File Job Order (JO) dalam pdf <span class="text-red"><b>*</b></span> :
                                </p>
                                <div class="col-xs-12 col-sm-12">
                                    <input type="file" class="form-control" id="createFileJo"
                                        accept="application/pdf" onchange="checkFile(id)">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-12">
                            <div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    LKP No. <span class="text-red"><b>*</b></span> :
                                </p>
                                <div class="col-xs-12 col-sm-12">
                                    <input type="text" class="form-control" id="createRefNo"
                                        placeholder="Input No. LKP">
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-12" style="display: inline-block; padding: 0px;">
                                <p style="text-align: left; padding-left: 15px; margin: 0px; font-weight: bold;">
                                    List Material <span class="text-red"><b>*</b></span> :
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="list_material">
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-2 pull-right" style="display: inline-block; padding: 0px;">
                                <button type="button" class="btn btn-default"
                                    style="background-color: grey; color: white;" onclick="closeModal('createModal')">
                                    Batal
                                </button>
                                <button class="btn btn-success" onclick="uploadDeliveryOrder()">
                                    &nbsp;<i class="fa fa-check"></i>&nbsp;Simpan&nbsp;&nbsp;
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" id="deleteModal">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Hapus Surat Jalan
                    </h4>
                    <button type="button" class="close" onclick="closeModal('deleteModal')" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id">
                    <p>
                        Surat jalan yang belum dikirim dapat dihapus. Apakah anda yakin untuk menghapus surat jalan ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color: grey; color: white;"
                        onclick="closeModal('deleteModal')">
                        Batal
                    </button>
                    <button class="btn btn-danger" onclick="executeDelete()">
                        <span>
                            <i class="fa fa-trash"></i>&nbsp;&nbsp;Hapus
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" id="sendModal">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Kirim Surat Jalan
                    </h4>
                    <button type="button" class="close" onclick="closeModal('sendModal')" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delivery_order_no">
                    <p>
                        Sebelum mengirim surat jalan pastikan material dalam PO dan material dalam surat jalan sudah sesuai.
                        Apakah anda yakin untuk mengirim surat jalan ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color: grey; color: white;"
                        onclick="closeModal('sendModal')">
                        Batal
                    </button>
                    <button class="btn btn-primary" onclick="executeSendDeliveryOrder()">
                        <span>
                            <i class="fa fa-send"></i>&nbsp;&nbsp;Kirim
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
        var count = 0;
        var countItem = [];
        var materials = <?php echo json_encode($materials); ?>;

        function checkOrderType() {

            var type = $('#createOrderType').val();
            $("#purchase_order_field").css('display', 'none');
            $("#job_order_field").css('display', 'none');

            if (type == 'SUBCONT' || type == '401 SUBCONT') {
                $("#job_order_field").css('display', 'block');
            } else if (type == 'Job Order') {
                $("#job_order_field").css('display', 'none');
            }

        }

        function openModal() {

            count = 0;
            countItem = [];
            $('#list_material').html('');
            $('#createDate').val('');
            $('#createNoPol').val('L 9062 UA');
            $("#createOrderType").val('').trigger('change.select2');
            $('#createJo').val('');
            $('#createPo').val('');
            $('#createRefNo').val('');
            $('#createFilePo').val('');
            $('#createFileJo').val('');

            $("#purchase_order_field").css('display', 'none');
            $("#job_order_field").css('display', 'none');

            addRow();

            $("#createModal").modal('show');

        }

        function closeModal(id) {
            $("#" + id).modal('hide');
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

        function checkMaterial(id) {

            var material = $('#' + id).val();
            console.log(material);
            if (material != '') {
                var type = $('#createOrderType').val();

                if (type == '') {
                    $("#" + id).val('').trigger('change.select2');
                    openErrorGritter('Error!', 'Pilih tipe order terlebih dahulu');
                    return false;
                }

                var type = $('#createOrderType').val();
                if (type == 'SUBCONT' || type == '401 SUBCONT') {
                    if (!material.includes('SUBCONT')) {
                        $("#" + id).val('').trigger('change.select2');
                        openErrorGritter('Error!', 'Material tidak sesuai dengan tipe order');
                        return false;
                    }
                }

                if (type == 'DIRECT MATERIAL' || type == '401 DIRECT MATERIAL') {
                    if (!material.includes('YMPI')) {
                        $("#" + id).val('').trigger('change.select2');
                        openErrorGritter('Error!', 'Material tidak sesuai dengan tipe order');
                        return false;
                    }
                }
            }

        }

        function addRow() {
            count++;
            countItem.push(count);

            var content = '';
            content += '<div class="col-xs-12" id="div_' + count + '">';
            content += '<div class="col-xs-1 col-sm-1"';
            content += 'style="display: inline-block; padding: 0px; text-align: center;">';
            content += '<span style="text-align: center; font-weight: bold;" id="list_' + count + '">';
            content += (countItem.length) + '</span>';
            content += '</div>';
            content += '<div class="col-xs-5 col-sm-5" style="display: inline-block; padding: 0px;">';
            content += '<select class="form-control select3" id="createMaterial_' + count + '"';
            content += 'data-placeholder="Pilih Material" style="width: 100%;" onchange="checkMaterial(id)">';
            content += '<option value=""></option>';
            $.each(materials, function(key, value) {
                content += '<option value="' + value.material_number + '||' + value.material_description +
                    '||' +
                    value.material_type + '">';
                content += value.material_number + '-' + value.material_description;
                content += '</option>';
            });
            content += '</select>';
            content += '</div>';
            content += '<div class="col-xs-2 col-sm-2" style="display: inline-block; padding: 0px 5px 0px 5px;">';
            content += '<input type="text" class="form-control datepicker" id="createQty_' + count + '"';
            content += 'placeholder="Input Qty" style="text-align: center; border-color: #aaaaaa;">';
            content += '</div>';
            content += '<div class="col-xs-2 col-sm-2" style="display: inline-block; padding: 0px;">';
            content += '<button style="margin-right: 5px;" class="btn btn-danger" ';
            content += 'onclick="removeRow(id)" id="rem_' + count + '">';
            content += '<i class="fa fa-close"></i>';
            content += '</button>';
            content += '<button class="btn btn-success" onclick="addRow(id)" id="add_' + count + '">';
            content += '<i class="fa fa-plus"></i>';
            content += '</button>';
            content += '</div>';
            content += '</div>';

            $('#list_material').append(content);

            $('.select3').select2({
                dropdownParent: $('#createModal'),
            });

        }

        function removeRow(param) {

            var id = param.split('_')[1];
            countItem.splice(countItem.indexOf(parseInt(id)), 1);
            $('#div_' + id).remove();

            var new_index = 0;
            for (let i = 0; i < countItem.length; i++) {
                $('#list_' + countItem[i]).html(++new_index);
            }

        }

        function uploadDeliveryOrder() {

            var date = $('#createDate').val();
            var no_pol = $('#createNoPol').val();
            var type = $('#createOrderType').val();

            if (date == '' || no_pol == '' || type == '') {
                audio_error.play();
                openErrorGritter('Error!', 'Mohon input semua field yang ada');
                return false;
            }

            var po = $('#createPo').val();
            var po_file = $('#createFilePo').val();
            var jo = $('#createJo').val();
            var jo_file = $('#createFileJo').val();
            var reff = $('#createRefNo').val();

            if (po_file == '') {
                audio_error.play();
                openErrorGritter('Error!', 'Mohon upload file PO');
                return false;
            }

            if (type == 'SUBCONT' || type == '401 SUBCONT') {
                if (jo == '' || reff == '') {
                    audio_error.play();
                    openErrorGritter('Error!', 'Mohon input semua field yang ada');
                    return false;
                }

                if (jo_file == '') {
                    audio_error.play();
                    openErrorGritter('Error!', 'Mohon upload file JO');
                    return false;
                }
            }

            var delivery_materials = [];
            $.each(countItem, function(key, value) {
                var material = $('#createMaterial_' + value).val();
                var material_number = material.split('||')[0];
                var material_description = material.split('||')[1];
                var material_type = material.split('||')[2];
                var quantity = $('#createQty_' + value).val();

                if (material_number == '' || quantity == '') {
                    audio_error.play();
                    openErrorGritter('Error!', 'Mohon input semua field yang ada');
                    return false;
                }

                delivery_materials.push({
                    material_number: material_number,
                    material_description: material_description,
                    material_type: material_type,
                    quantity: quantity
                });
            });

            var myFormData = new FormData();
            myFormData.append('vendor_nickname', $('#vendor_nickname').val());
            myFormData.append('date', date);
            myFormData.append('no_pol', no_pol);
            myFormData.append('type', type);
            myFormData.append('po', po);
            myFormData.append('jo', jo);
            myFormData.append('reff', reff);
            myFormData.append('delivery_materials', JSON.stringify(delivery_materials));
            myFormData.append('po_file', $("#createFilePo").prop('files')[0]);
            if (type == 'SUBCONT' || type == '401 SUBCONT') {
                myFormData.append('jo_file', $("#createFileJo").prop('files')[0]);
            }

            $('#loading').show();
            $.ajax({
                url: '{{ url('input/delivery_order') }}',
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: myFormData,
                success: function(result, status, xhr) {
                    if (result.status) {
                        fetchData();
                        $("#createModal").modal('hide');
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

        function downloadDeliveryOrder(filename) {
            var data = {
                filename: filename
            }

            $.get('{{ url('download/delivery_order/') }}', data, function(result, status, xhr) {
                if (result.status) {
                    window.open(result.file_path);
                } else {
                    openErrorGritter('Error!', 'File tidak ditemukan');
                }
            });
        }


        function downloadBcDoc(filename) {
            var data = {
                filename: filename
            }

            $.get('{{ url('download/bc_doc/') }}', data, function(result, status, xhr) {
                if (result.status) {
                    window.open(result.file_path);
                } else {
                    openErrorGritter('Error!', 'File tidak ditemukan');
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
                    openErrorGritter('Error!', 'File tidak ditemukan');
                }
            });
        }

        function deleteDeliv(id) {

            $('#deleteModal').modal('show');
            $('#delete_id').val(id);

        }

        function executeDelete() {

            var data = {
                id: $('#delete_id').val(),
            }

            $('#loading').show();
            $.post('{{ url('delete/delivery_order') }}', data, function(result, status, xhr) {
                if (result.status) {
                    if (result.status) {

                        fetchData();
                        $('#deleteModal').modal('hide');
                        $('#loading').hide();
                        openSuccessGritter('Success', result.message);


                    } else {

                        $('#loading').hide();
                        openErrorGritter('Error!', result.message);

                    }
                }
            });

        }

        function fetchData() {
            $('#loading').show();

            var data = {
                month: $('#filterMonth').val(),
                vendor_nickname: $('#vendor_nickname').val(),
            }

            $.get('{{ url('fetch/delivery_order') }}', data, function(result, status, xhr) {
                if (result.status) {

                    $('#tableMaterial').DataTable().clear();
                    $('#tableMaterial').DataTable().destroy();
                    $('#bodyTableMaterial').html('');

                    var tableData = '';
                    for (let i = 0; i < result.delivery_orders.length; i++) {
                        tableData += '<tr>';

                        if (result.delivery_orders[i].deleted_at != null) {
                            tableData += '<td style="font-size: 10pt !important;">';
                            tableData += '<span style="color: #c9362d;">Sudah dihapus</span>';
                            tableData += '</td>';
                        } else {
                            if (result.delivery_orders[i].delivery_order_sent_at == null) {
                                tableData += '<td style="font-size: 10pt !important;">';
                                tableData += '<button type="button" class="btn btn-danger" ';
                                tableData += 'id="' + result.delivery_orders[i].id + '" ';
                                tableData += 'onclick="deleteDeliv(id)">';
                                tableData += '<i class="fa fa-trash"></i>';
                                tableData += '</button>';
                                tableData += '</td>';
                            } else {
                                tableData += '<td style="font-size: 10pt !important;">';
                                tableData += '-';
                                tableData += '</td>';
                            }
                        }

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += '<a style="color: #208edd; cursor: pointer;" ';
                        var filename = result.delivery_orders[i].delivery_order_no.replaceAll("//", ".");
                        tableData += 'onclick="downloadDeliveryOrder(\'' + filename + '\')">';
                        tableData += result.delivery_orders[i].delivery_order_no;
                        tableData += '</a>';
                        tableData += '</td>';

                        tableData += '<td style="font-size: 10pt !important;">';
                        tableData += result.delivery_orders[i].shipment_date;
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

                        if (result.delivery_orders[i].deleted_at != null) {
                            tableData += '<td style="font-size: 10pt !important;">-</td>';
                        } else {
                            if (result.delivery_orders[i].delivery_order_sent_at == null) {
                                tableData += '<td style="font-size: 10pt !important;">';
                                tableData += '<button type="button" class="btn btn-default" ';
                                var delivery_order_no = result.delivery_orders[i].delivery_order_no;
                                tableData += 'onclick="sendDeliveryOrder(\'' + delivery_order_no + '\')">';
                                tableData += '<i class="fa fa-send-o"></i>&nbsp;&nbsp;Kirim';
                                tableData += '</button>';
                                tableData += '</td>';
                            } else {
                                tableData += '<td style="font-size: 10pt !important;">';
                                tableData += '<span style="color: #059569;">Terkirim</span>';
                                tableData += '<br>' + result.delivery_orders[i].delivery_order_sent_at;
                                tableData += '</td>';
                            }
                        }


                        if (result.delivery_orders[i].deleted_at != null) {
                            tableData += '<td style="font-size: 10pt !important;">-</td>';
                        } else {
                            if (result.delivery_orders[i].customs_no == null) {
                                tableData += '<td style="font-size: 10pt !important;">';
                                tableData += 'Belum Dibuat';
                                tableData += '</td>';
                            } else {
                                tableData += '<td style="font-size: 10pt !important;">';
                                tableData += '<a style="color: #208edd; cursor: pointer;" ';
                                var filename = result.delivery_orders[i].customs_no;
                                tableData += 'onclick="downloadBcDoc(\'' + filename + '\')">';
                                tableData += result.delivery_orders[i].customs_type;
                                tableData += '</a>';
                                tableData += '<br>';
                                tableData += '<a style="color: #208edd; cursor: pointer;" ';
                                var filename = result.delivery_orders[i].customs_no + ' SPPB';
                                tableData += 'onclick="downloadBcDoc(\'' + filename + '\')">';
                                tableData += 'SPPB';
                                tableData += '</a>';
                                tableData += '</td>';
                            }
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

        function sendDeliveryOrder(id) {

            $('#sendModal').modal('show');
            $('#delivery_order_no').val(id);

        }

        function executeSendDeliveryOrder() {

            var data = {
                delivery_order_no: $('#delivery_order_no').val()
            }

            $('#loading').show();
            $.post('{{ url('send/delivery_order') }}', data, function(result, status, xhr) {
                if (result.status) {

                    fetchData();
                    $('#sendModal').modal('hide');

                    openSuccessGritter('Success!', result.message);
                    $('#loading').hide();
                } else {
                    audio_error.play();
                    openErrorGritter('Error!', result.message);
                    $('#loading').hide();
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
