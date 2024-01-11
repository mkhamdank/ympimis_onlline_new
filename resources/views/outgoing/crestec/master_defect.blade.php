@extends('layouts.master')
@section('stylesheets')
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<!-- <link href="{{ url("css/bootstrap.css") }}" rel="stylesheet"> -->
<link href="{{ url("css/dataTables.bootstrap4.min.css") }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url("css/buttons.dataTables.min.css")}}">
<style type="text/css">
    thead>tr>th{
        text-align:center;
        overflow:hidden;
    }
    tbody>tr>td{
        text-align:left;
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
        border:1px solid grey;
    }
    table.table-bordered > thead > tr > th{
        border:1px solid grey;
        padding-top: 0;
        padding-bottom: 0;
        vertical-align: middle;
    }
    table.table-bordered > tbody > tr > td{
        padding: 0px;
        vertical-align: middle;
    }
    table.table-bordered > tfoot > tr > th{
        padding:0;
        vertical-align: middle;
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
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{$title}}<span class="text-purple"> {{$title_jp}}</span></h3>
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
                        <div class="col-md-12" style="padding: 10px;overflow-x: scroll;">
                            <button class="btn btn-success pull-right" style="margin-left: 10px;" onclick="$('#modalAdd').modal('show')"><i class="fa fa-plus"></i> Add Defect</button>
                            <table class="table user-table no-wrap" id="tableMaster">
                                <thead>
                                    <tr>
                                        <th style="background-color: #3f50b5;color: white !important;">#</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Cat</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Code</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Defect</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableMaster">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ffc654;text-align: center;font-weight: bold;">
                    <span style="width: 100%">EDIT DEFECT</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <label><b>Category</b></label>
                        </div>
                        <div class="col-xs-8">
                            <input type="hidden" name="id" id="id">
                            <input type="text" name="edit_category" id="edit_category" class="form-control" placeholder="Input Category" style="width: 100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label><b>Code</b></label>
                        </div>
                        <div class="col-xs-8">
                            <input type="text" name="edit_code" id="edit_code" class="form-control" placeholder="Input Code" style="width: 100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label><b>Defect</b></label>
                        </div>
                        <div class="col-xs-8">
                            <input type="text" name="edit_ng_name" id="edit_ng_name" class="form-control" placeholder="Input Defect" style="width: 100%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="margin:0px">
                        <div class="row">
                            <button class="btn btn-success" style="width: 100%;margin-bottom: 5px;font-size: 20px;margin-top: 10px;padding-right: 0px" onclick="update()">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ffc654;text-align: center;font-weight: bold;">
                    <span style="width: 100%">ADD DEFECT</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <label><b>Category</b></label>
                        </div>
                        <div class="col-xs-8">
                            <input type="text" name="add_category" id="add_category" class="form-control" placeholder="Input Category" style="width: 100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label><b>Code</b></label>
                        </div>
                        <div class="col-xs-8">
                            <input type="text" name="add_code" id="add_code" class="form-control" placeholder="Input Code" style="width: 100%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label><b>Defect</b></label>
                        </div>
                        <div class="col-xs-8">
                            <input type="text" name="add_ng_name" id="add_ng_name" class="form-control" placeholder="Input Defect" style="width: 100%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12" style="margin:0px">
                        <div class="row">
                            <button class="btn btn-success" style="width: 100%;margin-bottom: 5px;font-size: 20px;margin-top: 10px;padding-right: 0px" onclick="add()">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
<!-- <script src="{{ url("js/jquery-3.5.1.js") }}"></script> -->
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
    jQuery(document).ready(function() {
        $('.select2').select2();
        fetchData();
        $('.datepicker').datepicker({
            <?php $tgl_max = date('Y-m-d') ?>
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,   
            endDate: '<?php echo $tgl_max ?>'
        });
    });

    var audio_error = new Audio('{{ url("sounds/error.mp3") }}');

    function fetchData() {
        $('#loading').show();
        // var data = {
        //     material:$('#material').val(),
        //     date_from:$('#date_from').val(),
        //     date_to:$('#date_to').val(),
        // }
        $.get('{{ url("fetch/outgoing/crestec/master_defect") }}',  function(result, status, xhr){
            if(result.status){
                $('#tableMaster').DataTable().clear();
                $('#tableMaster').DataTable().destroy();
                $("#bodyTableMaster").html('');
                var bodyTable = '';
                var index = 1;
                for (var i = 0; i < result.defect.length; i++) {
                    bodyTable += '<tr>';
                    bodyTable += '<td>'+index+'</td>';
                    bodyTable += '<td>'+result.defect[i].category+'</td>';
                    bodyTable += '<td>'+result.defect[i].code+'</td>';
                    bodyTable += '<td>'+result.defect[i].ng_name+'</td>';
                    bodyTable += '<td>';
                    bodyTable += '<button onclick="edit(\''+result.defect[i].id+'\',\''+result.defect[i].category+'\',\''+result.defect[i].code+'\',\''+result.defect[i].ng_name+'\')" class="btn btn-warning">Edit</button>';
                    bodyTable += '<button onclick="deleteDefect(\''+result.defect[i].id+'\')" class="btn btn-danger" style="margin-left:5px;">Delete</button>';
                    bodyTable += '</td>';
                    bodyTable += '</tr>';
                    index++;
                }
                $('#bodyTableMaster').append(bodyTable);

                var table = $('#tableMaster').DataTable({
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
                openErrorGritter('Error!',result.message);
            }
        });
    }

    function edit(id,category,code,ng_name) {
        $('#id').val(id);
        $('#edit_category').val(category);
        $('#edit_code').val(code);
        $('#edit_ng_name').val(ng_name);
        $('#modalEdit').modal('show');
    }

    function update() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();
            var data = {
                category:$('#edit_category').val(),
                code:$('#edit_code').val(),
                id:$('#id').val(),
                ng_name:$('#edit_ng_name').val(),
            }

            $.post('{{ url("update/outgoing/crestec/master_defect") }}',data,  function(result, status, xhr){
                if(result.status){
                    $('#loading').hide();
                    $('#modalEdit').modal('hide');
                    fetchData();
                    openSuccessGritter('Success!',result.message);
                }else{
                    $('#loading').hide();
                    openErrorGritter('Error!',result.message);
                }
            });
        }
    }

    function add() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();
            var data = {
                category:$('#add_category').val(),
                code:$('#add_code').val(),
                ng_name:$('#add_ng_name').val(),
            }

            $.post('{{ url("input/outgoing/crestec/master_defect") }}',data,  function(result, status, xhr){
                if(result.status){
                    $('#loading').hide();
                    $('#modalAdd').modal('hide');
                    fetchData();
                    openSuccessGritter('Success!',result.message);
                }else{
                    $('#loading').hide();
                    openErrorGritter('Error!',result.message);
                }
            });
        }
    }

    function deleteDefect(id) {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();
            var data = {
                id:id
            }

            $.post('{{ url("delete/outgoing/crestec/master_defect") }}',data,  function(result, status, xhr){
                if(result.status){
                    $('#loading').hide();
                    fetchData();
                    openSuccessGritter('Success!',result.message);
                }else{
                    $('#loading').hide();
                    openErrorGritter('Error!',result.message);
                }
            });
        }
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