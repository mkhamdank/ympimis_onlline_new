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

    .bootstrap-datetimepicker-widget { background-color: #fff !important; }

    .datepicker-days > table > thead >tr>th,
    .datepicker-months > table > thead>tr>th,
    .datepicker-years > table > thead>tr>th,
    .datepicker-decades > table > thead>tr>th,
    .datepicker-centuries > table > thead>tr>th{
        background-color: white;
        color: #999 !important;
    }
</style>
@stop
@section('header')
    <div class="page-breadcrumb" style="padding-top: 10px;padding-left: 15px;padding-bottom: 10px">
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
                        <h4 style="padding-top: 0px">Filter</h4>
                            <div class="col-md-4" style="padding-left: 5px;text-align: left;display: inline-block;">
                                <label>Date From</label>
                                <div class="input-group date">
                                    <div class="input-group-addon bg-green" style="border: none; background-color: #469937; color: white;">
                                        <i class="fa fa-calendar" style="padding: 10px"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" id="date_from" name="date_from" placeholder="Select Date From">
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 5px;text-align: left;display: inline-block;">
                                <label>Date To</label>
                                <div class="input-group date">
                                    <div class="input-group-addon bg-green" style="border: none; background-color: #469937; color: white;">
                                        <i class="fa fa-calendar" style="padding: 10px"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" id="date_to" name="date_to" placeholder="Select Date To">
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;">
                                <div class="form-group">
                                    <a class="btn btn-primary col-sm-14" href="javascript:void(0)" onclick="fetchData()">Search</a>
                                </div>
                            </div>
                        <div class="col-md-12" style="padding: 10px;overflow-x: scroll;">
                            <table class="table user-table no-wrap" id="tableReport">
                                <thead>
                                    <tr>
                                        <th style="background-color: #3f50b5;color: white !important; width: 1%;">#</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 1%;">Date</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 1%;">Material Number</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 3%;">Desc</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 2%;">Qty</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 1%;">UOM</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 1%;">NG</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 1%;">Invoice</th>
                                        <th style="background-color: #3f50b5;color: white !important; width: 2%;">Created At</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableReport">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
<script src="<?php echo e(url("js/jquery.numpad.js")); ?>"></script>
<script src="{{ url("js/jquery.gritter.min.js") }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
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

    function changeMaterial() {
        $("#material").val($("#materialSelect").val());
    }
    function changeInspectionLevel() {
        $("#inspection_level").val($("#inspectionLevelSelect").val());
    }

    function fetchData() {
        var data = {
            date_from:$('#date_from').val(),
            date_to:$('#date_to').val(),
        }
        $.get('{{ url("fetch/return/kbi") }}',data,  function(result, status, xhr){
            if(result.status){
                $('#tableReport').DataTable().clear();
                $('#tableReport').DataTable().destroy();
                $("#bodyTableReport").html('');
                var tableData = '';
                var index = 1;
                $.each(result.ng_case, function(key, value) {
                    tableData += '<tr>';
                    tableData += '<td>'+ index +'</td>';
                    tableData += '<td>'+ value.dates +'</td>';
                    tableData += '<td>'+ value.material_number +'</td>';
                    tableData += '<td style="text-align: left;">'+ value.material_description +'</td>';
                    tableData += '<td>'+ value.quantity +'</td>';
                    tableData += '<td>'+ value.uom +'</td>';
                    tableData += '<td style="text-align: left;">';
                    var ngs = value.summary.split('/');
                    for(var i = 0; i < ngs.length; i++){
                        if(ngs[i] != ''){
                            tableData += '<span style="font-size: 12px; color: red;">'+ ngs[i].split('_')[1] +' = '+ngs[i].split('_')[2]+'</span><br>';
                        }
                    }
                    tableData += '</td>';
                    tableData += '<td>'+ (value.invoice || '') +'</td>';
                    tableData += '<td>'+ value.created_at +'</td>';
                    tableData += '</tr>';
                    index++;
                });
                $('#bodyTableReport').append(tableData);

                var table = $('#tableReport').DataTable({
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
                openErrorGritter('Error!','Failed Get Data');
            }
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
</script>
@endsection