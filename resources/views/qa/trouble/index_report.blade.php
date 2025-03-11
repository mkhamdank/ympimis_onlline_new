@extends('layouts.master')
@section('stylesheets')
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
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
    .containers {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        }

        /* Hide the browser's default radio button */
        .containers input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
        }

        /* On mouse-over, add a grey background color */
        .containers:hover input ~ .checkmark {
        background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .containers input:checked ~ .checkmark {
        background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .containers input:checked ~ .checkmark:after {
        display: block;
        }

        /* Style the indicator (dot/circle) */
        .containers .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }
</style>
@stop
@section('header')
    <div class="page-breadcrumb" style="padding: 7px">
        <div class="row align-items-center">
            <div class="col-md-12 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{$title}}<span class="text-purple"> {{$title_jp}}</span><button style="margin-right:2px;color: white" class="btn btn-sm btn-primary pull-right" onclick="$('#modalInput').modal('show');cancelAll();">Input Trouble</button></h3>
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
                                <label>Trouble Category</label>
                                <div class="form-group">
                                    <select class="form-control select2" id='categorySelect' data-placeholder="Select Category" style="width: 100%;color: black !important">
                                        <option value=""></option>
                                        <option value="Man">Man</option>
                                        <option value="Machine">Machine</option>
                                        <option value="Material">Material</option>
                                        <option value="Delivery">Delivery</option>
                                        <option value="Quality">Quality</option>
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
                            <table class="table user-table no-wrap" id="tableTrouble">
                                <thead>
                                    <tr>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">#</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Status</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Category</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Date From</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Date To</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Process / Machine</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Material</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 10%">Trouble Info</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 10%">Effect</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Apakah sudah dilakukan
                                            <br>penanganan ke semua produk lain
                                            <br>di tengah proses
                                            <br>dan siap kirim?
                                        </th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Qty WIP</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Qty Delivery</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Qty Check</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Qty OK</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 1%">Qty NG</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 10%">Penanganan</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 10%">Hasil</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 10%">Surat Jalan</th>
                                        <th style="background-color: #3f50b5;color: white !important;width: 2%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableTrouble">
                                    
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

    <div class="modal fade" id="modalInput">
        <div class="modal-dialog modal-xl" style="width: 1140px">
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightskyblue;" align="center">
                    <center><h4 class="modal-title" id="modalDetailTitle">Input Trouble</h4></center>
                </div>
                <div class="modal-body" style="min-height: 100px">
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Category <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Select Category" id="category" style="width:100%" onchange="changeCategory(this.value)">
                                <option value=""></option>
                                <option value="Man">Man</option>
                                <option value="Machine">Machine</option>
                                <option value="Material">Material</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Quality">Quality</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divMaterial">
                        <div class="col-md-3" align="right">
                            Material <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Select Material" id="material" style="width:100%">
                                <option value=""></option>
                                @foreach($material as $material)
                                    <option value="{{$material->material_number}}(Khamdan){{$material->material_description}}">{{$material->material_number}} - {{$material->material_description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divProcess">
                        <div class="col-md-3" align="right">
                            Process <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Input Process" name="process" id="process" style="width:100%; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    <div class="form-group row" id="divMachine">
                        <div class="col-md-3" align="right">
                            Machine / Tools <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Input Machine / Tools" name="machine" id="machine" style="width:100%; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Date From <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" placeholder="Date From" name="date_from" id="date_from" style="width: 100%; background-color: white; border: 1px solid darkgrey;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Date To <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" placeholder="Date To" name="date_to" id="date_to" style="width: 100%; background-color: white; border: 1px solid darkgrey;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Trouble <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Trouble" name="trouble" id="trouble" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Effect <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Effect" name="Effect" id="effect" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            Apakah sudah dilakukan penanganan ke semua produk lain di tengah proses dan siap kirim?<br><i>Have all other products been handled in the middle of the process and are they ready to be shipped??</i>  <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-8">
                            <label class="containers">Ya
                                <input type="radio" checked="checked" name="handling_choice" value="Ya">
                                <span class="checkmark"></span>
                            </label>
                            {{-- <label class="containers">Tidak
                                <input type="radio" name="handling_choice" value="Tidak">
                                <span class="checkmark"></span>
                            </label> --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Quantity Material <span class="text-red">*</span>
                        </div>
                        <div class="col-md-4">
                            <b>Quantity Tengah Proses</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-4">
                            <b>Quantity Siap Kirim</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control numpad" placeholder="Quantity Tengah Proses" name="qty_wip" id="qty_wip" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control numpad" placeholder="Quantity Siap Kirim" name="qty_delivery" id="qty_delivery" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <b>Quantity Check</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                            <b>Quantity OK</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                            <b>Quantity NG</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control numpad" placeholder="Quantity Check" name="qty_check" id="qty_check" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control numpad" placeholder="Quantity OK" name="qty_ok" id="qty_ok" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control numpad" placeholder="Quantity NG" name="qty_ng" id="qty_ng" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Surat Jalan Material Siap Kirim
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Input Surat Jalan" name="surat_jalan" id="surat_jalan" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Handling <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Handling" name="Handling" id="handling" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Results <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Results" name="Results" id="results" style="width:100%"></textarea>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                  <button onclick="$('#modalInput').modal('hide')" style="color: white;" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Close</button>
                  <button  onclick="inputTrouble()" style="color: white;" class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHandling">
        <div class="modal-dialog modal-xl" style="width: 1140px">
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightskyblue;" align="center">
                    <center><h4 class="modal-title" id="modalDetailTitle">Penanganan Trouble</h4></center>
                </div>
                <div class="modal-body" style="min-height: 100px">
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <table style="border:1px solid black; border-collapse: collapse;" width="100%">
                            <thead style="text-align: center;">
                                <tr>
                                    <th colspan="2" style="border:1px solid black;font-weight: bold;background-color: #d4e157;color: black">Details</th>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Category</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_category">
                                    </td>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px; display: none;" id="handling_id">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Date From</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_date_from">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Date To</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_date_to">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Data</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_supporting">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Material</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_material">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Trouble</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_trouble">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Effect</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_effect">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Apakah sudah dilakukan<br>
                                        penanganan ke semua produk<br>
                                        lain di tengah proses<br>
                                        dan siap kirim?
                                    </th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_handling_choice">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Qty WIP</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_qty_wip">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Qty Delivery</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_qty_delivery">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Qty Check</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_qty_check">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Qty OK</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_qty_ok">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Qty NG</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_qty_ng">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 3%;">Surat Jalan</th>
                                    <td style="border:1px solid black;text-align: left; width: 10%; color: black; padding: 5px;" id="handling_surat_jalan">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Penanganan <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Penanganan" name="handling" id="handling" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Hasil <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Hasil" name="results" id="results" style="width:100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button onclick="$('#modalHandling').modal('hide')" style="color: white;" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Close</button>
                  <button  onclick="inputHandling()" style="color: white;" class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog modal-xl" style="width: 1140px">
            <div class="modal-content">
                <div class="modal-header" style="background-color:lightskyblue;" align="center">
                    <center><h4 class="modal-title" id="modalDetailTitle">Edit Trouble</h4></center>
                </div>
                <div class="modal-body" style="min-height: 100px">
                    <input type="hidden" id="edit_trouble_id">
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Category <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Select Category" id="edit_category" style="width:100%" onchange="changeCategoryEdit(this.value)">
                                <option value=""></option>
                                <option value="Man">Man</option>
                                <option value="Machine">Machine</option>
                                <option value="Material">Material</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Quality">Quality</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divEditMaterial">
                        <div class="col-md-3" align="right">
                            Material <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control select2" data-placeholder="Select Material" id="edit_material" style="width:100%">
                                <option value=""></option>
                                @foreach($material2 as $material2)
                                    <option value="{{$material2->material_number}}(Khamdan){{$material2->material_description}}">{{$material2->material_number}} - {{$material2->material_description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="divEditProcess">
                        <div class="col-md-3" align="right">
                            Process <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Input Process" name="process" id="edit_process" style="width:100%; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    <div class="form-group row" id="divEditMachine">
                        <div class="col-md-3" align="right">
                            Machine / Tools <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Input Machine / Tools" name="machine" id="edit_machine" style="width:100%; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Date From <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" placeholder="Date From" name="date_from" id="edit_date_from" style="width:100%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Date To <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control datepicker" placeholder="Date To" name="date_to" id="edit_date_to" style="width:100%" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Trouble <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Trouble" name="trouble" id="edit_trouble" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Effect <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Effect" name="Effect" id="edit_effect" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            Apakah sudah dilakukan penanganan ke semua produk lain di tengah proses dan siap kirim?<br><i>Have all other products been handled in the middle of the process and are they ready to be shipped??</i> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-8">
                            <label class="containers">Ya
                                <input type="radio" checked="checked" name="edit_handling_choice" value="Ya">
                                <span class="checkmark"></span>
                            </label>
                            {{-- <label class="containers">Tidak
                                <input type="radio" name="edit_handling_choice" value="Tidak">
                                <span class="checkmark"></span>
                            </label> --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Quantity Material <span class="text-red">*</span>
                        </div>
                        <div class="col-md-4">
                            <b>Quantity Tengah Proses</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-4">
                            <b>Quantity Siap Kirim</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control numpad" placeholder="Quantity Tengah Proses" name="qty_wip" id="edit_qty_wip" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control numpad" placeholder="Quantity Siap Kirim" name="qty_delivery" id="edit_qty_delivery" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <b>Quantity Check</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                            <b>Quantity OK</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                            <b>Quantity NG</b> <span class="text-red">*</span>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control numpad" placeholder="Quantity Check" name="qty_check" id="edit_qty_check" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control numpad" placeholder="Quantity OK" name="qty_ok" id="edit_qty_ok" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control numpad" placeholder="Quantity NG" name="qty_ng" id="edit_qty_ng" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Handling <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Handling" name="Handling" id="edit_handling" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Results <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control" placeholder="Results" name="Results" id="edit_results" style="width:100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3" align="right">
                            Surat Jalan <span class="text-red">*</span>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Surat Jalan (Inputkan lebih dari 1 jika ada)" name="edit_surat_jalan" id="edit_surat_jalan" style="width: 100%; background-color: white; border: 1px solid darkgrey;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button onclick="$('#modalEdit').modal('hide')" style="color: white;" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Close</button>
                  <button  onclick="updateTrouble()" style="color: white;" class="btn btn-success pull-right"><i class="fa fa-pencil"></i> Update</button>
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
        // CKEDITOR.config.toolbar_MA=[ ['Bold','Italic','Underline','Image'] ];
        $('.select2').select2({
            allowClear:true
        });
        $('.datepicker').datepicker({
            <?php $tgl_max = date('Y-m-d') ?>
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,   
        });

        $('.numpad').numpad({
            hidePlusMinusButton : true,
            decimalSeparator : '.'
        });
        CKEDITOR.replace('trouble' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });
        CKEDITOR.replace('edit_trouble' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });

        CKEDITOR.replace('effect' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });
        CKEDITOR.replace('edit_effect' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });

        CKEDITOR.replace('handling' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });
        CKEDITOR.replace('edit_handling' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });

        CKEDITOR.replace('results' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });
        CKEDITOR.replace('edit_results' ,{
	        filebrowserImageBrowseUrl : '{{ url('kcfinder_master') }}',
	        height: '200px',
	        toolbar:'MA'
	    });
        fetchData();
    });

    var troubles = null;

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
            category:$('#categorySelect').val(),
        }
        $.get('{{ url("fetch/trouble/info/".$vendor) }}',data,  function(result, status, xhr){
            if(result.status){
                $('#tableTrouble').DataTable().clear();
                $('#tableTrouble').DataTable().destroy();
                $("#bodyTableTrouble").html('');

                troubles = result.trouble_info;

                var bodyTable = '';

                var index = 1;
                for(var i = 0; i < result.trouble_info.length;i++){
                    bodyTable += '<tr>';
                    bodyTable += '<td>'+index+'</td>';
                    if(result.trouble_info[i].handling == null){
                        bodyTable += '<td style="color: red;"><b><i>Belum Ditangani</i></b><br>';
                        bodyTable += '<button class="btn btn-success btn-sm" onclick="openModalHandling(\''+result.trouble_info[i].id+'\');cancelAll();" style="color:white;"><i class="fa fa-check"></i>Input Penanganan</button>';
                        bodyTable += '</td>';
                    }else{
                        bodyTable += '<td style="color: green;"><b><i>Sudah Ditangani</i></b></td>';
                    }
                    bodyTable += '<td>'+result.trouble_info[i].category+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].date_from+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].date_to+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].material+'</td>';
                    bodyTable += '<td>'+(result.trouble_info[i].supporting || '')+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].trouble+'</td>';
                    bodyTable += '<td>'+(result.trouble_info[i].effect || '')+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].handling_choice+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].qty_wip+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].qty_delivery+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].qty_check+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].qty_ok+'</td>';
                    bodyTable += '<td>'+result.trouble_info[i].qty_ng+'</td>';
                    if(result.trouble_info[i].handling == null){
                        bodyTable += '<td style="color: red;"><b><i>Belum Ditangani</i></b></td>';
                    }else{
                        bodyTable += '<td>'+(result.trouble_info[i].handling || '')+'</td>';
                    }
                    bodyTable += '<td>'+(result.trouble_info[i].results || '')+'</td>';
                    bodyTable += '<td>'+(result.trouble_info[i].surat_jalan || '')+'</td>';
                    bodyTable += '<td>';
                    // bodyTable += '<button class="btn btn-warning btn-sm" onclick="edit(\''+result.trouble_info[i].id+'\')" style="color:white;"><i class="fa fa-pencil"></i></button>';
                    bodyTable += '<button class="btn btn-danger btn-sm" onclick="deleteTrouble(\''+result.trouble_info[i].id+'\')" style="color:white;margin-left:5px;"><i class="fa fa-trash"></i></button>';
                    bodyTable += '</td>';
                    bodyTable += '</tr>';
                    index++;
                }

                $("#bodyTableTrouble").append(bodyTable);

                var table = $('#tableTrouble').DataTable({
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

    function edit(id) {
        cancelAll();
        for(var i = 0; i < troubles.length;i++){
            if (troubles[i].id == id) {
                $('#edit_trouble_id').val(troubles[i].id);
                $('#edit_category').val(troubles[i].category).trigger('change');
                if(troubles[i].category == 'Man'){
                    $('#edit_process').val(troubles[i].supporting);
                }else if(troubles[i].category == 'Machine'){
                    $('#edit_machine').val(troubles[i].supporting);
                }
                $('#edit_material').val(troubles[i].material.replace(' - ','(Khamdan)')).trigger('change');
                $("#edit_trouble").html(CKEDITOR.instances.edit_trouble.setData(troubles[i].trouble));
                $('#edit_date_from').val(troubles[i].date_from);
                $('#edit_date_to').val(troubles[i].date_to);
                $("#edit_effect").html(CKEDITOR.instances.edit_effect.setData(troubles[i].effect));
                $("#edit_handling").html(CKEDITOR.instances.edit_handling.setData(troubles[i].handling));
                $("#edit_results").html(CKEDITOR.instances.edit_results.setData(troubles[i].results));

                $("input[type=radio][name=edit_handling_choice][value="+troubles[i].handling_choice+"]").prop('checked', true);

                $('#edit_qty_wip').val(troubles[i].qty_wip);
                $('#edit_qty_delivery').val(troubles[i].qty_delivery);

                $('#edit_qty_check').val(troubles[i].qty_check);                
                $('#edit_qty_ok').val(troubles[i].qty_ok);
                $('#edit_qty_ng').val(troubles[i].qty_ng);
                $('#edit_surat_jalan').val(troubles[i].surat_jalan);
            }
        }
        $('#modalEdit').modal('show');
    }

    function openModalHandling(id) {
        cancelAll();
        for(var i = 0; i < troubles.length;i++){
            if (troubles[i].id == id) {
                $('#handling_id').html(troubles[i].id);
                $('#handling_category').html(troubles[i].category);
                $('#handling_date_from').html(troubles[i].date_from);
                $('#handling_date_to').html(troubles[i].date_to);
                $('#handling_supporting').html(troubles[i].supporting);
                $('#handling_material').html(troubles[i].material);
                $('#handling_trouble').html(troubles[i].trouble);
                $('#handling_effect').html(troubles[i].effect);
                $('#handling_handling_choice').html(troubles[i].handling_choice);
                $('#handling_qty_wip').html(troubles[i].qty_wip);
                $('#handling_qty_delivery').html(troubles[i].qty_delivery);
                $('#handling_qty_check').html(troubles[i].qty_check);
                $('#handling_qty_ok').html(troubles[i].qty_ok);
                $('#handling_qty_ng').html(troubles[i].qty_ng);
                $('#handling_surat_jalan').html(troubles[i].surat_jalan);
            }
        }
        $('#modalHandling').modal('show');
    }

    function cancelAll() {
        $('#category').val('').trigger('change');
        $("#trouble").html(CKEDITOR.instances.trouble.setData(''));
        $('#date_from').val('');
        $('#date_to').val('');

        $("#effect").html(CKEDITOR.instances.effect.setData(''));
        $("#handling").html(CKEDITOR.instances.handling.setData(''));
        $("#results").html(CKEDITOR.instances.results.setData(''));

        $('#divMaterial').hide();
        $('#divProcess').hide();
        $('#divMachine').hide();

        $('#material').val('').trigger('change');
        $('#process').val('');
        $('#machine').val('');
        $('#surat_jalan').val('');

        $('#divEditMaterial').hide();
        $('#divEditProcess').hide();
        $('#divEditMachine').hide();
        $('#edit_material').val('').trigger('change');
        $('#edit_process').val('');
        $('#edit_machine').val('');

        $('#edit_trouble_id').val('');
        $('#edit_category').val('').trigger('change');
        $('#edit_date_from').val('');
        $('#edit_date_to').val('');

        $("input[type=radio][name=handling_choice]").prop('checked', false);
        $("input[type=radio][name=edit_handling_choice]").prop('checked', false);

        $('#qty_wip').val('');
        $('#qty_delivery').val('');

        $('#qty_check').val('');
        $('#qty_ok').val('');
        $('#qty_ng').val('');

        $('#edit_qty_wip').val('');
        $('#edit_qty_delivery').val('');

        $('#edit_qty_check').val('');
        $('#edit_qty_ok').val('');
        $('#edit_qty_ng').val('');
        $('#edit_surat_jalan').val('');
    }

    function inputTrouble() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();
            var category = $("#category").val();
            var trouble = CKEDITOR.instances['trouble'].getData();
            var date_from = $("#date_from").val();
            var date_to = $("#date_to").val();
            var material = $("#material").val();
            var process = $("#process").val();
            var machine = $("#machine").val();
            var qty_wip = $("#qty_wip").val();
            var qty_delivery = $("#qty_delivery").val();
            var qty_check = $("#qty_check").val();
            var qty_ok = $("#qty_ok").val();
            var qty_ng = $("#qty_ng").val();
            var surat_jalan = $("#surat_jalan").val();
            var effect = CKEDITOR.instances['effect'].getData();
            // var handling = CKEDITOR.instances['handling'].getData();
            // var results = CKEDITOR.instances['results'].getData();

            if (category == '' || trouble == '' || date_from == '' || date_to == '' || material == '' || effect == '' || qty_wip == '' || qty_delivery == '' || qty_check == '' || qty_ok == '' || qty_ng == '') {
                openErrorGritter('Error!','Semua Harus Diisi');
                audio_error.play();
                $('#loading').hide();
                return false;
            }

            var formData = new FormData();
            formData.append('vendor','{{$vendor}}');
            formData.append('vendor_name','{{$vendor_name}}');
            formData.append('mail_to','{{$mail_to}}');
            formData.append('cc','{{$cc}}');
            formData.append('category',category);
            formData.append('trouble',trouble);
            formData.append('date_from',date_from);
            formData.append('date_to',date_to);
            if (category == 'Material' || category == 'Delivery' || category == 'Quality') {
                formData.append('supporting',material);
                formData.append('material',material);
            }else if (category == 'Man'){
                if (process == '') {
                    openErrorGritter('Error!','Semua Harus Diisi');
                    audio_error.play();
                    $('#loading').hide();
                    return false;
                }
                formData.append('supporting',process);
                formData.append('material',material);
            }else if (category == 'Machine'){
                if (machine == '') {
                    openErrorGritter('Error!','Semua Harus Diisi');
                    audio_error.play();
                    $('#loading').hide();
                    return false;
                }
                formData.append('supporting',machine);
                formData.append('material',material);
            }
            formData.append('effect',effect);
            // formData.append('handling',handling);
            // formData.append('results',results);
            formData.append('qty_wip',qty_wip);
            formData.append('qty_delivery',qty_delivery);
            formData.append('qty_check',qty_check);
            formData.append('qty_ok',qty_ok);
            formData.append('qty_ng',qty_ng);
            formData.append('surat_jalan',surat_jalan);

            var handling_choice = $('input[name="handling_choice"]:checked').val();
            formData.append('handling_choice',handling_choice);

            $.ajax({
                url:"{{ url('input/trouble/info') }}",
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
                        openSuccessGritter('Success!',"Input Trouble Succeeded");
                        $('#loading').hide();
                        $('#modalInput').modal('hide');
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

    function inputHandling() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();
            var id = $("#handling_id").text();
            var handling = CKEDITOR.instances['handling'].getData();
            var results = CKEDITOR.instances['results'].getData();

            if (handling == '' || results =='') {
                openErrorGritter('Error!','Semua Harus Diisi');
                audio_error.play();
                $('#loading').hide();
                return false;
            }

            var formData = new FormData();
            formData.append('vendor','{{$vendor}}');
            formData.append('vendor_name','{{$vendor_name}}');
            formData.append('mail_to','{{$mail_to}}');
            formData.append('cc','{{$cc}}');
            formData.append('id',id);
            formData.append('handling',handling);
            formData.append('results',results);

            $.ajax({
                url:"{{ url('input/trouble/info/handling') }}",
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
                        openSuccessGritter('Success!',"Input Handling Succeeded");
                        $('#loading').hide();
                        $('#modalHandling').modal('hide');
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

    function changeCategory(category) {
        $('#divMaterial').hide();
        $('#divProcess').hide();
        $('#divMachine').hide();
        $('#material').val('').trigger('change');
        $('#process').val('');
        $('#machine').val('');
        if (category == 'Material' || category == 'Delivery' || category == 'Quality') {
            $('#divMaterial').show();
        }else if (category == 'Man'){
            $('#divProcess').show();
            $('#divMaterial').show();
        }else if (category == 'Machine'){
            $('#divMachine').show();
            $('#divMaterial').show();
        }
    }

    function changeCategoryEdit(category) {
        $('#divEditMaterial').hide();
        $('#divEditProcess').hide();
        $('#divEditMachine').hide();
        $('#edit_material').val('').trigger('change');
        $('#edit_process').val('');
        $('#edit_machine').val('');
        if (category == 'Material' || category == 'Delivery' || category == 'Quality') {
            $('#divEditMaterial').show();
        }else if (category == 'Man'){
            $('#divEditProcess').show();
            $('#divEditMaterial').show();
        }else if (category == 'Machine'){
            $('#divEditMachine').show();
            $('#divEditMaterial').show();
        }
    }

    function updateTrouble() {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();

            var trouble_id = $("#edit_trouble_id").val();
            var category = $("#edit_category").val();
            // var trouble = $("#edit_trouble").val();
            var trouble = CKEDITOR.instances['edit_trouble'].getData();
            var date_from = $("#edit_date_from").val();
            var date_to = $("#edit_date_to").val();
            var material = $("#edit_material").val();
            var process = $("#edit_process").val();
            var machine = $("#edit_machine").val();
            var qty_wip = $("#edit_qty_wip").val();
            var qty_delivery = $("#edit_qty_delivery").val();
            var qty_check = $("#edit_qty_check").val();
            var qty_ok = $("#edit_qty_ok").val();
            var qty_ng = $("#edit_qty_ng").val();
            var surat_jalan = $("#edit_surat_jalan").val();
            var effect = CKEDITOR.instances['edit_effect'].getData();
            var handling = CKEDITOR.instances['edit_handling'].getData();
            var results = CKEDITOR.instances['edit_results'].getData();

            var formData = new FormData();
            formData.append('vendor','{{$vendor}}');
            formData.append('vendor_name','{{$vendor_name}}');
            formData.append('mail_to','{{$mail_to}}');
            formData.append('cc','{{$cc}}');
            formData.append('id',trouble_id);
            formData.append('category',category);
            formData.append('trouble',trouble);
            formData.append('date_from',date_from);
            formData.append('date_to',date_to);
            if (category == 'Material' || category == 'Delivery' || category == 'Quality') {
                formData.append('supporting',material);
                formData.append('material',material);
            }else if (category == 'Man'){
                formData.append('supporting',process);
                formData.append('material',material);
            }else if (category == 'Machine'){
                formData.append('supporting',machine);
                formData.append('material',material);
            }
            formData.append('effect',effect);
            formData.append('handling',handling);
            formData.append('results',results);
            formData.append('qty_wip',qty_wip);
            formData.append('qty_delivery',qty_delivery);
            formData.append('qty_check',qty_check);
            formData.append('qty_ok',qty_ok);
            formData.append('qty_ng',qty_ng);
            formData.append('surat_jalan',surat_jalan);

            var handling_choice = $('input[name="edit_handling_choice"]:checked').val();
            formData.append('handling_choice',handling_choice);

            $.ajax({
                url:"{{ url('update/trouble/info') }}",
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
                        openSuccessGritter('Success!',"Update Trouble Info Succeeded");
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

    function deleteTrouble(id) {
        if (confirm('Apakah Anda yakin?')) {
            $('#loading').show();

            var formData = new FormData();
            formData.append('vendor','{{$vendor}}');
            formData.append('vendor_name','{{$vendor_name}}');
            formData.append('mail_to','{{$mail_to}}');
            formData.append('cc','{{$cc}}');
            formData.append('id',id);

            $.ajax({
                url:"{{ url('delete/trouble/info') }}",
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
                        openSuccessGritter('Success!',"Delete Trouble Info Succeeded");
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