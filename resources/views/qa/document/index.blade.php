@extends('layouts.master')
@section('stylesheets')
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<!-- <link href="{{ url("css/bootstrap.css") }}" rel="stylesheet"> -->
<link href="<?php echo e(url("css/jquery.numpad.css")); ?>" rel="stylesheet">
<link href="{{ url("css/dataTables.bootstrap4.min.css") }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url("css/buttons.dataTables.min.css")}}">
<style type="text/css">
    thead>tr>th{
        text-align:center;
        overflow:hidden;
    }

    tbody>tr>td{
        text-align:center;
    }
    tfoot>tr>th{
        text-align:center;
    }
    th:hover {
        overflow: visible;
    }
    td:hover {
        overflow: visible;
    }
    table.table-bordered{
        border:1px solid black;
    }
    table.table-bordered > thead > tr > th{
        border:1px solid black;
        padding-top: 0;
        padding-bottom: 0;
        vertical-align: middle;
    }
    table.table-bordered > tbody > tr > td{
        border:1px solid black;
        padding: 0px;
        vertical-align: middle;
    }
    table.table-bordered > tfoot > tr > th{
        border:1px solid black;
        padding:0;
        vertical-align: middle;
        background-color: rgb(126,86,134);
        color: #fff !important;
    }
    thead {
        background-color: #fff;
        color: #fff;
    }
    td{
        overflow:hidden;
        text-overflow: ellipsis;
    }
    th{
        color: white;
    }
    .datepicker-days > table > thead >tr>th,
    .datepicker-months > table > thead>tr>th,
    .datepicker-years > table > thead>tr>th,
    .datepicker-decades > table > thead>tr>th,
    .datepicker-centuries > table > thead>tr>th{
        background-color: white;
        color: #999 !important;
    }
    .loading{
        display: none;
    }
</style>
@stop
@section('header')
    <div class="page-breadcrumb" style="padding: 7px">
        <div class="row align-items-center">
            <div class="col-md-12 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{$title}}<span class="text-purple"> {{$title_jp}}</span><button style="margin-right:2px;color: white" class="btn btn-sm btn-primary pull-right" onclick="$('#modalUpload').modal('show');cancelAll();">Upload Document</button></h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid" style="padding: 7px;min-height: 100vh">
        <div id="loading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(0,191,255); z-index: 30001; opacity: 0.8;">
            <p style="position: absolute; color: White; top: 45%; left: 35%;">
                <span style="font-size: 40px">Please Wait...<i class="fa fa-spin fa-refresh"></i></span>
            </p>
        </div>
        <div class="row" style="padding: 5px">
            <div class="col-sm-12 col-xs-12" style="text-align: center;">
                <div class="card">
                    <div class="card-body" style="padding: 0px">
                       <h4 style="padding-top: 10px">Filter</h4>
                            <div class="col-md-8" style="padding-left: 5px;text-align: left;display: inline-block;padding-top: 10px">
                                <label>Document Category</label>
                                <div class="form-group">
                                    <select class="form-control select2" id='categorySelect' data-placeholder="Select Category" style="width: 100%;color: black !important">
                                        <option value=""></option>
                                        <option value="FMEA">FMEA</option>
                                        <option value="PSS">PSS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-primary col-sm-14" onclick="fetchData()">Search</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" style="text-align: center;">
                <div class="card">
                    <div class="card-body" style="padding: 0px">
                        <div class="col-md-12" style="padding: 10px;overflow-x: scroll;">
                            <table class="table user-table no-wrap" id="tableDocument">
                                <thead>
                                    <tr>
                                        <th style="background-color: #3f50b5;color: white !important;width: 0.2%">#</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Doc. ID</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Category</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Doc. Number</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 10%">Title</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Mat. Number</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Desc</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 0.2%">Version</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Version Date</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Status</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 0.5%">Preview File</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableDocument">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="display: none" id="div_attach" style="margin-top: 10px;">
                <button style="width: 100%;font-weight: bold;font-size: 25px;color:white;" class="btn btn-danger btn-xs" onclick="$('#div_attach').hide();$('#attach_pdf').html('');"><i class="fa fa-close"></i>&nbsp;&nbsp;Close <small>クロス</small></button>
                <div id="attach_pdf"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpload">
        <div class="modal-dialog modal-xl" style="width: 1140px">
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightskyblue;" align="center">
                    <center><h4 class="modal-title" id="modalDetailTitle">Upload Document</h4></center>
                </div>
                <div class="modal-body" style="min-height: 100px">
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Category
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Pilih Category" id="category" style="width:100%" onchange="checkDocument(this.value)">
                                <option value=""></option>
                                <option value="FMEA">FMEA</option>
                                <option value="PSS">PSS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divAddMaterial">
                        <div class="col-md-3" align="right">
                            Material
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Pilih Material" id="material" style="width:100%">
                                <option value=""></option>
                                @foreach($material as $material)
                                <option value="{{$material->material_number}}_{{$material->material_description}}">{{$material->material_number}} - {{$material->material_description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Document Number
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Document Number" name="document_number" id="document_number" style="width:100%">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Title
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Title" name="title" id="title" style="width:100%">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Version
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control numpad" placeholder="Version" name="version" id="version" style="width:100%">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Version Date
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" placeholder="Version Date" name="version_date" id="version_date" style="width:100%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Status
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Pilih Status" id="status" style="width:100%">
                                <option value=""></option>
                                <option value="Active">Active</option>
                                <option value="Obsolete">Obsolete</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Upload PDF
                        </div>
                        <div class="col-md-8">
                            <input type="file" class="form-control" placeholder="Document" name="file" id="file" style="width:100%" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button onclick="$('#modalUpload').modal('hide')" style="color: white;" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Close</button>
                  <button  onclick="uploadDocument()" style="color: white;" class="btn btn-success pull-right"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog modal-xl" style="width: 1140px">
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightskyblue;" align="center">
                    <center><h4 class="modal-title" id="modalDetailTitle">Edit Document</h4></center>
                </div>
                <div class="modal-body" style="min-height: 100px">
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Document ID
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Document ID" name="edit_document_id" id="edit_document_id" style="width:100%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Category
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Pilih Category" id="edit_category" style="width:100%">
                                <option value=""></option>
                                <option value="FMEA">FMEA</option>
                                    <option value="PSS">PSS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divEditMaterial">
                        <div class="col-md-3" align="right">
                            Material
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Pilih Material" id="edit_material" style="width:100%">
                                <option value=""></option>
                                @foreach($material2 as $material2)
                                <option value="{{$material2->material_number}}_{{$material2->material_description}}">{{$material2->material_number}} - {{$material2->material_description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Document Number
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Document Number" name="edit_document_number" id="edit_document_number" style="width:100%">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Title
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Title" name="edit_title" id="edit_title" style="width:100%">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Version
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control numpad" placeholder="Version" name="edit_version" id="edit_version" style="width:100%">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Version Date
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" placeholder="Version Date" name="edit_version_date" id="edit_version_date" style="width:100%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Status
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Pilih Status" id="edit_status" style="width:100%">
                                <option value=""></option>
                                <option value="Active">Active</option>
                                <option value="Obsolete">Obsolete</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Upload PDF
                        </div>
                        <div class="col-md-8">
                            <input type="file" class="form-control" placeholder="Document" name="edit_file" id="edit_file" style="width:100%" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button onclick="$('#modalEdit').modal('hide')" style="color: white;" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Close</button>
                  <button  onclick="updateDocument()" style="color: white;" class="btn btn-success pull-right"><i class="fa fa-pencil"></i> Update</button>
                </div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
<script src="<?php echo e(url("js/jquery.numpad.js")); ?>"></script>
<script src="{{ url("js/jquery.gritter.min.js") }}"></script>
<script src="{{ url("js/jquery.dataTables.min.js") }}"></script>
<script src="{{ url("js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ url("js/jquery.flot.min.js") }}"></script>
<script src="{{ url("js/dataTables.buttons.min.js")}}"></script>
<script src="{{ url("js/buttons.flash.min.js")}}"></script>
<script src="{{ url("js/jszip.min.js")}}"></script>
<script src="{{ url("js/vfs_fonts.js")}}"></script>
<script src="{{ url("js/buttons.html5.min.js")}}"></script>
<script src="{{ url("js/buttons.print.min.js")}}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.fn.numpad.defaults.gridTpl = '<table class="table modal-content" style="align-items:left"></table>';
    $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in" style="opacity:.5"></div>';
    $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" style="font-size:1.5vw; height: 50px;width:100%"/>';
    $.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-primary" style="font-size:1.5vw; width:40px;background-color:#b5ffa8;color:black"></button>';
    $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="font-size:1.5vw; width: 100%;background-color:#ffb84d;color:black"></button>';
    $.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};

    var audio_error = new Audio('{{ url("sounds/error.mp3") }}');

    jQuery(document).ready(function() {
        $('.select2').select2({
            allowClear:true
        });
        $('.datepicker').datepicker({
            <?php $tgl_max = date('Y-m-d') ?>
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,   
            endDate: '<?php echo $tgl_max ?>'
        });

        $('.numpad').numpad({
            hidePlusMinusButton : true,
            decimalSeparator : '.'
        });
        fetchData();
    });

    var documents = null;

    function checkDocument(category) {
        $('#divAddMaterial').hide();
        $('#material').val('').trigger('change');
        if (category == 'PSS') {
            $('#divAddMaterial').show();
        }
    }

    function fetchData() {
        $('#loading').show();
        var data = {
            vendor:'{{$vendor}}',
            category:$('#categorySelect').val(),
        }
        $.get('{{ url("fetch/qa/document") }}',data,  function(result, status, xhr){
            if(result.status){
                $('#tableDocument').DataTable().clear();
                $('#tableDocument').DataTable().destroy();
                $("#bodyTableDocument").html('');

                var bodyTable = '';

                documents = result.document;

                var index = 1;
                for(var i = 0; i < result.document.length;i++){
                    bodyTable += '<tr>';
                    bodyTable += '<td>'+index+'</td>';
                    bodyTable += '<td>'+result.document[i].document_id+'</td>';
                    bodyTable += '<td>'+result.document[i].category+'</td>';
                    bodyTable += '<td>'+result.document[i].document_number+'</td>';
                    bodyTable += '<td>'+result.document[i].title+'</td>';
                    bodyTable += '<td>'+(result.document[i].material_number || '')+'</td>';
                    bodyTable += '<td>'+(result.document[i].material_description || '')+'</td>';
                    bodyTable += '<td>'+result.document[i].version+'</td>';
                    bodyTable += '<td>'+result.document[i].version_date+'</td>';
                    if (result.document[i].status == 'Active') {
                        var color = 'green';
                    }else{
                        var color = 'red';
                    }
                    bodyTable += '<td style="font-weight:bold;color:'+color+'">'+result.document[i].status+'</td>';
                    bodyTable += '<td><button class="btn btn-danger btn-sm" onclick="attach_pdf(\''+result.document[i].file_name_pdf+'\')" style="color:white;"><i class="fa fa-file-pdf-o"></i></button></td>';
                    bodyTable += '<td><button class="btn btn-warning btn-sm" onclick="edit(\''+result.document[i].document_id+'\')" style="color:white;"><i class="fa fa-pencil"></i></button><button class="btn btn-danger btn-sm" onclick="deleteDocument(\''+result.document[i].document_id+'\')" style="color:white;margin-left:5px;"><i class="fa fa-trash"></i></button></td>';
                    index++;
                }

                $("#bodyTableDocument").append(bodyTable);

                var table = $('#tableDocument').DataTable({
                    'dom': 'Bfrtip',
                    'responsive':true,
                    'lengthMenu': [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                    ],
                    'buttons': {
                        buttons:[
                        {
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
                    'searching': true   ,
                    'ordering': true,
                    'order': [],
                    'info': true,
                    'autoWidth': true,
                    "sPaginationType": "full_numbers",
                    "bJQueryUI": true,
                    "bAutoWidth": false,
                    "processing": true
                });

                $('#loading').hide();
            }else{
                $('#loading').hide();
            }
        });
    }

    function deleteDocument(document_id) {
        if (confirm('Apakah Anda yakin akan menghapus dokumen?')) {
            $('#loading').show();
            var data = {
                document_id:document_id
            }

            $.get('{{ url("delete/qa/document") }}',data,  function(result, status, xhr){
                if(result.status){
                    fetchData();
                    openSuccessGritter('Success','Success Delete Document');
                    $('#loading').hide();
                }else{
                    $('#loading').hide();
                    openErrorGritter('Error!',result.message);
                }
            });
        }
    }

    function edit(document_id) {
        cancelAll();
        for(var i = 0; i < documents.length;i++){
            if (documents[i].document_id == document_id) {
                $('#edit_document_id').val(documents[i].document_id);
                $('#edit_category').val(documents[i].category).trigger('change');
                $('#edit_document_number').val(documents[i].document_number);
                $('#edit_title').val(documents[i].title);
                $('#edit_version').val(documents[i].version);
                $('#edit_version_date').val(documents[i].version_date);
                $('#edit_status').val(documents[i].status).trigger('change');
                if (documents[i].category == 'PSS') {
                    $('#divEditMaterial').show();
                    $('#edit_material').val(documents[i].material_number+'_'+documents[i].material_description).trigger('change');
                }
            }
        }
        $('#modalEdit').modal('show');
    }

    function attach_pdf(file_name) {
        $("#div_attach").show();
        $('#attach_pdf').html('');
        var path = "{{asset('/qa/document/')}}"+'/'+file_name;
        $('#attach_pdf').append("<embed src='"+ path +"' type='application/pdf' width='100%' height='800px'>");
    }

    function cancelAll() {
        $('#divAddMaterial').hide();
        $('#divEditMaterial').hide();
        $('#category').val('').trigger('change');
        $('#document_number').val('');
        $('#title').val('');
        $('#version').val('');
        $('#version_date').val('');
        $('#status').val('').trigger('change');
        $("#file").val('');
        $('#material').val('').trigger('change');

        $('#edit_category').val('').trigger('change');
        $('#edit_document_number').val('');
        $('#edit_title').val('');
        $('#edit_version').val('');
        $('#edit_version_date').val('');
        $('#edit_status').val('').trigger('change');
        $("#edit_file").val('');
        $('#edit_material').val('').trigger('change');
    }

    function uploadDocument() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();
            var category = $("#category").val();
            var document_number = $("#document_number").val();
            var title = $("#title").val();
            var version = $("#version").val();
            var version_date = $("#version_date").val();
            var status = $("#status").val();

            var file = '';

            var fileData = null;

            fileData = $('#file').prop('files')[0];

            file=$('#file').val().replace(/C:\\fakepath\\/i, '').split(".");

            if (category == '' ||
                document_number == '' ||
                title == '' ||
                version == '' ||
                version_date == '' ||
                status == '' ||
                file[0] == '') {
                $('#loading').hide();
                openErrorGritter('Error!','Isi Semua Data');
                return false;
            }

            var material_number = null;
            var material_description = null;

            if (category == 'PSS') {
                material_number = $('#material').val().split('_')[0];
                material_description = $('#material').val().split('_')[1];
            }

            var formData = new FormData();
            formData.append('vendor','{{$vendor}}');
            formData.append('category',category);
            formData.append('document_number',document_number);
            formData.append('title',title);
            formData.append('version',version);
            formData.append('version_date',version_date);
            formData.append('status',status);
            formData.append('fileData', fileData);
            formData.append('material_number', material_number);
            formData.append('material_description', material_description);

            $.ajax({
                url:"{{ url('input/qa/document') }}",
                method:"POST",
                data:formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    if (data.status) {
                        $('#loading').hide();
                        openSuccessGritter('Success!',"Upload Dokumen Berhasil");
                        $('#loading').hide();
                        $('#modalUpload').modal('hide');
                        fetchData();
                    }else{
                        openErrorGritter('Error!',data.message);
                        audio_error.play();
                        $('#loading').hide();
                    }

                }
            });
        }
    }

    function updateDocument() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();

            var category = $("#edit_category").val();
            var document_number = $("#edit_document_number").val();
            var title = $("#edit_title").val();
            var version = $("#edit_version").val();
            var version_date = $("#edit_version_date").val();
            var status = $("#edit_status").val();
            var document_id = $("#edit_document_id").val();

            var file = '';

            var fileData = null;

            if ($('#edit_file').val().replace(/C:\\fakepath\\/i, '').split(".")[0] != '') {
                fileData = $('#edit_file').prop('files')[0];
                file=$('#edit_file').val().replace(/C:\\fakepath\\/i, '').split(".");
            }

            if (category == '' ||
                document_number == '' ||
                title == '' ||
                version == '' ||
                version_date == '' ||
                status == '') {
                $('#loading').hide();
                openErrorGritter('Error!','Isi Semua Data');
                return false;
            }

            var material_number = null;
            var material_description = null;

            if (category == 'PSS') {
                material_number = $('#edit_material').val().split('_')[0];
                material_description = $('#edit_material').val().split('_')[1];
            }

            var formData = new FormData();
            formData.append('vendor','{{$vendor}}');
            formData.append('category',category);
            formData.append('document_number',document_number);
            formData.append('title',title);
            formData.append('version',version);
            formData.append('version_date',version_date);
            formData.append('status',status);
            formData.append('fileData', fileData);
            formData.append('material_number', material_number);
            formData.append('material_description', material_description);
            formData.append('document_id', document_id);

            $.ajax({
                url:"{{ url('update/qa/document') }}",
                method:"POST",
                data:formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    if (data.status) {
                        $('#loading').hide();
                        openSuccessGritter('Success!',"Update Dokumen Berhasil");
                        $('#loading').hide();
                        $('#modalEdit').modal('hide');
                        fetchData();
                    }else{
                        openErrorGritter('Error!',data.message);
                        audio_error.play();
                        $('#loading').hide();
                    }

                }
            });
        }
    }

    function onlyUnique(value, index, self) {
      return self.indexOf(value) === index;
    }

    function dynamicSort(property) {
        var sortOrder = 1;
        if(property[0] === "-") {
            sortOrder = -1;
            property = property.substr(1);
        }
        return function (a,b) {
            var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
            return result * sortOrder;
        }
    }

    function uniqByKeepFirst(a, key) {
        let seen = new Set();
        return a.filter(item => {
            let k = key(item);
            return seen.has(k) ? false : seen.add(k);
        });
    }

    function openSuccessGritter(title, message){
        jQuery.gritter.add({
            title: title,
            text: message,
            class_name: 'growl-success',
            image: '{{ url("images/image-screen.png") }}',
            sticky: false,
            time: '3000'
        });
    }

    function openErrorGritter(title, message) {
        jQuery.gritter.add({
            title: title,
            text: message,
            class_name: 'growl-danger',
            image: '{{ url("images/image-stop.png") }}',
            sticky: false,
            time: '3000'
        });
    }

    function getFormattedDateTime(date) {
        var year = date.getFullYear();

        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        var month = (date.getMonth()+1).toString();
        month = month.length > 1 ? month : '0' + month;

        var day = date.getDate().toString();
        day = day.length > 1 ? day : '0' + day;

        var hour = date.getHours();
        if (hour < 10) {
            hour = "0" + hour;
        }

        var minute = date.getMinutes();
        if (minute < 10) {
            minute = "0" + minute;
        }
        var second = date.getSeconds();
        if (second < 10) {
            second = "0" + second;
        }
        
        // return day + '-' + monthNames[month] + '-' + year +'<br>'+ hour +':'+ minute +':'+ second;
        return year+'-'+month+'-'+day;
    }
</script>
@endsection