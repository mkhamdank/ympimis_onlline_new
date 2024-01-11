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
    <!-- <div class="page-breadcrumb" style="padding: 7px"> -->
        <!-- <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{$title}}<span class="text-purple"> {{$title_jp}}</span></h3>
            </div>
        </div> -->
    <!-- </div> -->
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
                        <div class="col-sm-12" style="text-align: left;">
                            <h3 class="page-title mb-0 p-0" style="margin-left: 10px;margin-top: 10px;margin-bottom: 10px;">{{$title}}<span class="text-purple"> {{$title_jp}}</span></h3>
                        </div>
                       <h4 style="padding: 0px">Filter</h4>
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
                            <div class="col-md-4" style="padding-left: 5px;text-align: left;display: inline-block;padding-top: 10px">
                                <label>Material</label>
                                <div class="form-group">
                                    <select class="form-control select2" multiple="multiple" id='materialSelect' onchange="changeMaterial()" data-placeholder="Select Material" style="width: 100%;color: black !important">
                                        @foreach($materials as $material)
                                        <option value="{{$material->material_number}}">{{$material->material_number}} - {{$material->material_description}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="material" id="material" style="color: black !important" hidden>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 5px;text-align: left;display: inline-block;padding-top: 10px">
                                <label>Job Number</label>
                                <div class="form-group">
                                    <select class="form-control select2" id='serial_number' data-placeholder="Select Job Number" style="width: 100%;color: black !important">
                                        <option value=""></option>
                                        @foreach($serial_number as $sernums)
                                        <option value="{{$sernums->serial_number}}">{{$sernums->serial_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-primary col-sm-2" onclick="fetchData()">Search</button>
                                    <button class="btn btn-success col-sm-2" onclick="printPdf()"><i class="fa fa-file-pdf-o"></i> Print</button>
                                    <!-- <button class="btn btn-success"><i class="fa fa-download"></i> Export Excel Without Merge</button> -->
                                    <!-- <input class="btn btn-success" type="submit" name="publish" value="Export Excel Without Merge">
                                    <input class="btn btn-warning" type="submit" name="save" value="Export Excel With Merge"> -->
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12" style="text-align: center;">
                <div class="card">
                    <div class="card-body" style="padding: 0px">
                        <div class="col-md-12" style="padding: 10px;overflow-x: scroll;">
                            <table class="table user-table no-wrap" id="tableKensa">
                                <thead>
                                    <tr>
                                        <th style="background-color: #3f50b5;color: white !important;">Job number</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Tanggal</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Shift</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Line</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Line Clearance</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Material</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Freq</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Time</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Qty Check</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Qty Sampling</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Point Check</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Standard</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Result</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Acc</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Reject</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Qty NG</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Qty OK</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Detail NG</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Inspector</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Lot Status</th>
                                        <th style="background-color: #3f50b5;color: white !important;">Recheck Status</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableKensa">
                                    
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
    jQuery(document).ready(function() {
        $('.select2').select2({
            allowClear:true
        });
        fetchData();
        $('.datepicker').datepicker({
            <?php $tgl_max = date('Y-m-d') ?>
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,   
            endDate: '<?php echo $tgl_max ?>'
        });
    });
    function changeMaterial() {
        $("#material").val($("#materialSelect").val());
    }

    var audio_error = new Audio('{{ url("sounds/error.mp3") }}');

    function fetchData() {
        $('#loading').show();
        var data = {
            material:$('#material').val(),
            date_from:$('#date_from').val(),
            date_to:$('#date_to').val(),
            serial_number:$('#serial_number').val(),
        }
        $.get('{{ url("fetch/sampling/crestec/report") }}',data,  function(result, status, xhr){
            if(result.status){
                $('#tableKensa').DataTable().clear();
                $('#tableKensa').DataTable().destroy();
                $("#bodyTableKensa").html('');
                var bodyTable = '';
                for (var i = 0; i < result.sampling.length; i++) {
                    bodyTable += '<tr>';
                    bodyTable += '<td>'+result.sampling[i].serial_number+'</td>';
                    bodyTable += '<td>'+result.sampling[i].sampling_date+'</td>';
                    bodyTable += '<td>'+result.sampling[i].shift+'</td>';
                    bodyTable += '<td>'+result.sampling[i].line+'</td>';
                    bodyTable += '<td>'+result.sampling[i].line_clearance+'</td>';
                    bodyTable += '<td>'+result.sampling[i].material_number+' - '+result.sampling[i].material_description+'</td>';
                    bodyTable += '<td>'+result.sampling[i].frequency+'</td>';
                    bodyTable += '<td>'+result.sampling[i].check_time+'</td>';
                    bodyTable += '<td>'+result.sampling[i].qty_check+'</td>';
                    bodyTable += '<td>'+result.sampling[i].qty_sampling+'</td>';
                    if (result.sampling[i].point_check_type == result.sampling[i].point_check_name) {
                        if (result.sampling[i].point_check_name == 'types') {
                            bodyTable += '<td>'+result.sampling[i].types+'</td>';
                        }else{
                            bodyTable += '<td>'+result.sampling[i].point_check_type.toUpperCase()+'</td>';
                        }
                    }else{
                        bodyTable += '<td>'+result.sampling[i].point_check_type.toUpperCase()+' - '+result.sampling[i].point_check_name.toUpperCase()+'</td>';
                    }
                    bodyTable += '<td>'+(result.sampling[i].standard || '')+'</td>';
                    bodyTable += '<td>'+(result.sampling[i].result_check || '')+'</td>';
                    bodyTable += '<td>'+result.sampling[i].acceptance+'</td>';
                    bodyTable += '<td>'+result.sampling[i].reject+'</td>';
                    bodyTable += '<td>'+result.sampling[i].qty_ng+'</td>';
                    bodyTable += '<td>'+result.sampling[i].qty_ok+'</td>';
                    bodyTable += '<td>'+result.sampling[i].detail_ng+'</td>';
                    bodyTable += '<td>'+result.sampling[i].inspector+'</td>';
                    bodyTable += '<td>'+result.sampling[i].lot_status+'</td>';
                    if (result.sampling[i].recheck_status == null) {
                        bodyTable += '<td style="background-color:#ff9494">'+(result.sampling[i].recheck_status || '')+'</td>';
                    }else{
                        bodyTable += '<td style="background-color:#b0ffcc">'+(result.sampling[i].recheck_status || '')+'</td>';
                    }
                    bodyTable += '</tr>';
                }
                $('#bodyTableKensa').append(bodyTable);

                var table = $('#tableKensa').DataTable({
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

    function printPdf() {
        if ($('#serial_number').val() == '') {
            audio_error.play();
            openErrorGritter('Error!','Pilih Job Number');
            return false;
        }

        var serial_number = $("#serial_number").val();

        window.open('{{url("index/sampling/crestec/pdf")}}/'+serial_number, '_blank').focus();
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