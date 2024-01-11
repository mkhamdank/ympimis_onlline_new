@extends('layouts.display')
@section('stylesheets')
<link href="<?php echo e(url("css/jquery.numpad.css")); ?>" rel="stylesheet">
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<link href="{{ url("css/dataTables.bootstrap4.min.css") }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url("plugins/timepicker/bootstrap-timepicker.min.css")}}">
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
		color: #FFD700;
	}
	thead {
		background-color: rgb(126,86,134);
	}
	td{
		overflow:hidden;
		text-overflow: ellipsis;
	}

	.greencolor{
		background-color: lightgreen;
	}

	.bootstrap-timepicker-widget table td a{
		color: black !important;
	}
	#ngTemp {
		height:200px;
		overflow-y: scroll;
	}

	#ngList {
		height:450px;
		overflow-y: scroll;
		/*padding-top: 5px;*/
	}

	#ngList2 {
		height:450px;
		overflow-y: scroll;
		/*padding-top: 5px;*/
	}
	#loading, #error { display: none; }
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		/* display: none; <- Crashes Chrome on hover */
		-webkit-appearance: none;
		margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
	}

	input[type=number] {
		-moz-appearance:textfield; /* Firefox */
	}
	.page-wrapper{
		padding-top: 0px;
		padding-bottom: 0px;
	}
	.datepicker-days > table > thead,
	.datepicker-days > table > thead >tr>th,
    .datepicker-months > table > thead>tr>th,
    .datepicker-years > table > thead>tr>th,
    .datepicker-decades > table > thead>tr>th,
    .datepicker-centuries > table > thead>tr>th{
        background-color: white;
        color: #696969 !important;
    }
    .dataTables_filter,.dataTables_info {
    	color: white;
    }

    .containers {
	  display: block;
	  position: relative;
	  padding-left: 20px;
	  margin-bottom: 6px;
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
</style>
@stop
@section('header')
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid" style="padding-top: 10px;padding-left: 10px;padding-right: 10px">
	<div id="loading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(0,191,255); z-index: 30001; opacity: 0.8;">
		<p style="position: absolute; color: White; top: 45%; left: 35%;">
			<span style="font-size: 40px">Please Wait...<i class="fa fa-spin fa-refresh"></i></span>
		</p>
	</div>
	
	<div class="row" style="padding-left: 10px; padding-right: 5px;">
		<div class="col-md-7" style="padding-left: 0px;padding-right: 5px;">
			<table class="table table-bordered table-striped table-hover" style="margin-bottom: 5px;">
	        	<thead style="background-color: chocolate;color: white">
	        		<tr>
	        			<th style="width: 1%;background-color: chocolate;color: white">Job Number</th>
        				<th style="width: 7%;background-color: chocolate;color: white">Material</th>
        				<th style="width: 1%;background-color: chocolate;color: white">Tanggal</th>
	        		</tr>
	        	</thead>
	        	<tbody id="bodyTableCheck" style="background-color: white">
	        		
	        	</tbody>
	        	<thead style="background-color: forestgreen;color: white">
	        		<tr>
        				<th style="width: 1%;background-color: forestgreen;color: white">Qty Check</th>
        				<th style="width: 1%;background-color: forestgreen;color: white">OK</th>
        				<th style="width: 1%;background-color: forestgreen;color: white">NG</th>
	        		</tr>
	        	</thead>
	        	<tbody id="bodyTableCheck2" style="background-color: white">
	        		
	        	</tbody>
			</table>
			<table class="table table-bordered table-striped table-hover">
	        	<thead style="background-color: mediumpurple;color: white">
	        		<tr>
	        			<th style="width: 2%;background-color: mediumpurple;color: white">Tanggal Sampling</th>
	        			<th style="width: 2%;background-color: mediumpurple;color: white">Shift</th>
	        			<th style="width: 2%;background-color: mediumpurple;color: white">Line</th>
	        			<th style="width: 2%;background-color: mediumpurple;color: white">Line Clearance</th>
	        		</tr>
	        	</thead>
	        	<tbody style="background-color: white">
	        		<tr>
	        			<td>
	        				<input type="text" name="date" id="date" readonly="readonly" class="form-control datepicker" style="width: 100%;text-align: center;" value="{{date('Y-m-d')}}">
	        			</td>
	        			<td>
	        				<select class="form-control select2" style="width: 100%" data-placeholder="Pilih Shift" id="shift">
	        					<option value=""></option>
	        					<option value="Shift 1">Shift 1</option>
	        					<option value="Shift 2">Shift 2</option>
	        				</select>
	        			</td>
	        			<td>
	        				<select class="form-control select2" style="width: 100%" data-placeholder="Pilih Line" id="line">
	        					<option value=""></option>
	        					<option value="Line 1">Line 1</option>
	        					<option value="Line 2">Line 2</option>
	        					<option value="Line 3">Line 3</option>
	        				</select>
	        			</td>
	        			<td>
	        				<select class="form-control select2" style="width: 100%" data-placeholder="Line Clearance" id="line_clearance">
	        					<option value=""></option>
	        					<option value="Yes">Yes</option>
	        					<option value="No">No</option>
	        				</select>
	        			</td>
	        		</tr>
	        	</tbody>
			</table>
		</div>
		<div class="col-md-5" style="padding-left: 5px;padding-right: 0px;background-color: white;">
			<span style="padding: 3px;">1. If found NG refer to page 2 for writing defect code</span><br>
			<span style="padding: 3px;">2. Sampling Qty = AQL Sample x 2 (No Taligate) / 3</span><br>
			<span style="padding: 3px;">3. Sampling Qty = AQL Sample x 3 (Taligate) / 3 -> Taligate Sample Quantity : <input type="number" class="form-control numpad" name="sample_qty" id="sample_qty" placeholder="Sample Qty" readonly="" style="width: 20%"> pcs. <i>(If Applicate from request of the customer, use 0 if without taligate)</i></span><br>
			<span style="padding: 3px;">4. Tick (&#10003;) OK if no defect is found, and tick (&#10003;) NG if single defect found Mix Up and Design, initiate NCMR from Ref. No. CINP-FM-QC-03-07</span>
		</div>
		<div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
			<table class="table table-bordered table-striped table-hover" style="margin-bottom: 0px;">
	        	<thead style="background-color: rgba(126,86,134,.7);color: white">
	        		<tr>
	        			<th rowspan="4" style="width: 2%;background-color: rgba(126,86,134,.7);color: white;vertical-align: middle;">Frequency of Inspection</th>
	        			<th rowspan="4" style="width: 2%;background-color: rgba(126,86,134,.7);color: white;vertical-align: middle;">Time</th>
	        			<th rowspan="4" style="width: 2%;background-color: rgba(126,86,134,.7);color: white;vertical-align: middle;">Qty Sampling (Refer to Note No. 2 & 3)</th>
	        			<th colspan="9" style="width: 2%;background-color: rgba(126,86,134,.7);color: white">In Proses Check / IPC (Refer to Note No. 1 & 4)</th>
	        		</tr>
	        		<tr>
	        			<th rowspan="3" style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Mix Up <br>(All Sample Qty)</th>
	        			<th rowspan="3" style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Design <br>(Sample Qty : 5 Pcs / every up)</th>
	        			<th rowspan="3" style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Visual Inspection <br>(All Sample Qty)</th>
	        			<th colspan="5" style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Dimension (mm)<br>(All Sample Qty)</th>
	        			<th rowspan="3" style="width: 2%;background-color: rgba(126,86,134,.7);color: white" id="th_types"><span id="types"></span> <br>(Sample Qty : 5 pcs / every up)</th>
	        		</tr>
	        		<tr>
	        			<th colspan="5" style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Specification :<br>L : 
	        				<span id="long_low" style="background-color: white;color: black"></span> - 
	        				<span id="long_up" style="background-color: white;color: black"></span>
	        				&nbsp;&nbsp;&nbsp;W : <span id="wide_low" style="background-color: white;color: black"></span> - 
	        				<span id="wide_up" style="background-color: white;color: black"></span>
	        				<span id="div_height">&nbsp;&nbsp;&nbsp;H : <span id="height_low" style="background-color: white;color: black"></span> - <span id="height_up" style="background-color: white;color: black"></span></span></th>
	        		</tr>
	        		<tr>
	        			<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Sample 1</th>
	        			<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Sample 2</th>
	        			<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Sample 3</th>
	        			<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Sample 4</th>
	        			<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Sample 5</th>
	        		</tr>
	        	</thead>
	        	<tbody id="bodyCheck">
	        	</tbody>
			</table>
		</div>
		<div class="col-md-6" style="padding: 0px;padding-top: 10px;padding-right: 5px;padding-left: 0px">
			<button class="btn btn-danger" id="btn_cancel" onclick="cancelAll();location.reload()" style="font-size: 25px;font-weight: bold;width: 100%">
				CANCEL
			</button>
		</div>
		<div class="col-md-6" style="padding: 0px;padding-top: 10px;padding-left: 5px;padding-right: 0px">
			<button class="btn btn-success" id="btn_confirm" onclick="confirmNgLog()" style="font-size: 25px;font-weight: bold;width: 100%">
				CONFIRM
			</button>
		</div>
		<div class="col-md-12" style="padding: 0px;padding-top: 30px;padding-left: 0px;padding-right: 0px">
			<button class="btn btn-primary" id="btn_confirm_all" onclick="confirmAll()" style="font-size: 25px;font-weight: bold;width: 100%">
				CLOSE SAMPLING
			</button>
		</div>
	</div>
</div>

<div class="modal modal-default fade" id="modalSerialNumber" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #ffc654;text-align: center;">
				PILIH JOB NUMBER
			</div>
			<div class="modal-body">
				<div class="row" id="divSelectSernum">
					<select class="form-control" id="select_serial_number" name="select_serial_number" data-placeholder="Pilih JOB NUMBER" style="width: 100%" onchange="selectSerialNumber(this.value)">
						<option value=""></option>
						@foreach($production_check as $production_check)
						@if($production_check->final == null)
						<option value="{{$production_check->serial_number}}[]{{$production_check->material_number}}[]{{$production_check->material_description}}[]{{$production_check->check_date}}[]{{$production_check->qty_check}}[]{{$production_check->total_ok}}[]{{$production_check->total_ng}}[]Belum"><b>{{$production_check->serial_number}}</b> ({{$production_check->material_number}} - {{$production_check->material_description}} - {{$production_check->check_date}} - {{$production_check->qty_check}} Pcs)</option>
						@else
						<option class="greencolor" value="{{$production_check->serial_number}}[]{{$production_check->material_number}}[]{{$production_check->material_description}}[]{{$production_check->check_date}}[]{{$production_check->qty_check}}[]{{$production_check->total_ok}}[]{{$production_check->total_ng}}[]Sudah"><b>{{$production_check->serial_number}}</b> ({{$production_check->material_number}} - {{$production_check->material_description}} - {{$production_check->check_date}} - {{$production_check->qty_check}} Pcs) - Inprogress</option>
						@endif
						@endforeach
					</select>
				</div>
				<table class="table table-bordered table-striped table-hover" style="margin-top: 10px;">
	        		<thead style="background-color: rgba(126,86,134,.7);color: white">
	        			<tr>
	        				<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Job Number</th>
	        				<th style="width: 4%;background-color: rgba(126,86,134,.7);color: white">Material</th>
	        				<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Tanggal</th>
	        				<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Qty Check</th>
	        				<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">OK</th>
	        				<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">NG</th>
	        				<th style="width: 2%;background-color: rgba(126,86,134,.7);color: white">Check Status</th>
	        			</tr>
	        		</thead>
	        		<tbody id="bodyTableSerialNumber">
	        		</tbody>
	        	</table>
			</div>
			<div class="modal-footer">
				<div class="col-md-12" style="margin:0px">
					<div class="row">
						<button class="btn btn-success" style="width: 100%;margin-bottom: 5px;font-size: 20px;margin-top: 10px;padding-right: 0px" id="btn_product_fix" onclick="confirmSerialNumber()">CONFIRM</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script src="{{ url("js/moment.min.js")}}"></script>
<script src="{{ url("plugins/timepicker/bootstrap-timepicker.min.js")}}"></script>
<script src="<?php echo e(url("js/jquery.numpad.js")); ?>"></script>
<script src="{{ url("js/jquery.gritter.min.js") }}"></script>
<script src="{{ url("js/jquery.dataTables.min.js") }}"></script>
<script src="{{ url("js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ url("js/jquery.flot.min.js") }}"></script>
<script src="{{ url("js/jszip.min.js")}}"></script>
<script src="{{ url("js/vfs_fonts.js")}}"></script>

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var hour;
    var minute;
    var second;
    var intervalTime;
    var intervalUpdate;
    var count_ng = 0;

    $.fn.numpad.defaults.gridTpl = '<table class="table modal-content" style="align-items:left"></table>';
	$.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in" style="opacity:.5"></div>';
	$.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" style="font-size:1.5vw; height: 50px;width:100%"/>';
	$.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-primary" style="font-size:1.5vw; width:40px;background-color:#b5ffa8;color:black"></button>';
	$.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="font-size:1.5vw; width: 100%;background-color:#ffb84d;color:black"></button>';
	$.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};

	var dimensi = <?php echo json_encode($dimensi); ?>;
	var final_check = <?php echo json_encode($final_check); ?>;
	var aql = <?php echo json_encode($aql); ?>;
	var ng_lists = <?php echo json_encode($ng_lists); ?>;

	jQuery(document).ready(function() {
		$('.datepicker').datepicker({
			<?php $tgl_max = date('Y-m-d') ?>
			autoclose: true,
			format: "yyyy-mm-dd",
			todayHighlight: true,	
			endDate: '<?php echo $tgl_max ?>',
			orientation: "bottom"
		});
		$('#div_height').hide();
		count_ng = 0;

		$('.timepicker').timepicker({
			showInputs: false,
			showMeridian: false,
			defaultTime: '0:00',
			showInputs: false,
			showMeridian: false,
			defaultTime: '0:00',
			icons: {
				time: 'fa fa-clock-o',
				date: 'fa fa-calendar',
				up: 'fa fa-plus',
				down: 'fa fa-minus',
				next: 'fa fa-chevron-left',
				previous: 'fa fa-chevron-right'
			},
		});
		$('#bodyTableSerialNumber').html('');
		$('#bodyTableCheck').html('');

		$('#modalSerialNumber').modal('show');
		$('#modalSerialNumber').modal('show');

		$('#modalSerialNumber').on('shown.bs.modal', function () {
			$('#select_serial_number').focus();
		});

		cancelAll();

		$('.select2').select2({
			allowClear:true,
		});

		$('#select_serial_number').select2({
			allowClear:true,
			dropdownParent:$('#divSelectSernum')
		});

		$('.numpad').numpad({
			hidePlusMinusButton : true,
			decimalSeparator : '.'
		});
	});

	function cancelAll() {
		$('#shift').val('').trigger('change');
		$('#line').val('').trigger('change');
		$('#line_clearance').val('').trigger('change');
		$('#sample_qty').val('');
		$('#select_serial_number').val('').trigger('change');
	}

	var types = '';

	function confirmSerialNumber() {
		$('#bodyTableCheck').html('');
		$('#bodyTableCheck2').html('');
		$('#bodyCheck').html('');

		var bodyTableCheck = '';
		var bodyTableCheck2 = '';
		var bodyCheck = '';

		var values = $("#select_serial_number").val();

		if (values != '') {
			var serial_number = values.split('[]')[0];
			var material_number = values.split('[]')[1];
			var material_description = values.split('[]')[2];
			var check_date = values.split('[]')[3];
			var qty_check = values.split('[]')[4];
			var total_ok = values.split('[]')[5];
			var total_ng = values.split('[]')[6];

			bodyTableCheck += '<tr>';
			bodyTableCheck += '<td id="serial_number">'+serial_number+'</td>';
			bodyTableCheck += '<td id="material">'+material_number+' - '+material_description+'</td>';
			bodyTableCheck += '<td id="check_date">'+check_date+'</td>';
			bodyTableCheck += '</tr>';

			bodyTableCheck2 += '<tr>';
			bodyTableCheck2 += '<td id="qty_check">'+qty_check+'</td>';
			bodyTableCheck2 += '<td id="total_ok">'+total_ok+'</td>';
			bodyTableCheck2 += '<td id="total_ng">'+total_ng+'</td>';
			bodyTableCheck2 += '</tr>';

			var height = '';

			for(var i = 0; i < dimensi.length;i++){
				if (dimensi[i].material_number == material_number) {
					$("#long_low").html(dimensi[i].point_check_upper.split('_')[0]);
					$("#long_up").html(dimensi[i].point_check_upper.split('_')[1]);
					$("#wide_low").html(dimensi[i].point_check_lower.split('_')[0]);
					$("#wide_up").html(dimensi[i].point_check_lower.split('_')[1]);
					if (dimensi[i].point_check_height != null) {
						$('#div_height').show();
						$('#height_low').html(dimensi[i].point_check_height.split('_')[0]);
						$('#height_up').html(dimensi[i].point_check_height.split('_')[1]);
						height = 'ada';
					}
					types = dimensi[i].point_check_type;
				}
			}

			$('#types').html(types);

			var index = 0;

			var start = 'start';
			var middle = 'middle';
			var end = 'end';

			bodyCheck += '<tr>';
			bodyCheck += '<td style="background-color:white;font-weight:bold;">Start (S)</td>';
			bodyCheck += '<td style="background-color:white;"><input type="text" class="form-control timepicker" style="width:100%" placeholder="Input Time" value="0:00" id="time_start"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control numpad" style="width:100%" placeholder="Qty Sampling" id="qty_start"></td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="mixup_start" id="mixup_start" value="OK">';
				bodyCheck += '<span class="checkmark" id="mixup_start"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="mixup_start" id="mixup_start" value="NG">';
				bodyCheck += '<span class="checkmark" id="mixup_start"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="design_start" id="design_start" value="OK">';
				bodyCheck += '<span class="checkmark" id="design_start"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="design_start" id="design_start" value="NG">';
				bodyCheck += '<span class="checkmark" id="design_start"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="visual_start" id="visual_start" value="OK">';
				bodyCheck += '<span class="checkmark" id="visual_start"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="visual_start" id="visual_start" value="NG">';
				bodyCheck += '<span class="checkmark" id="visual_start"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			for(var i = 0; i < 5;i++){
				bodyCheck += '<td style="background-color:white;">';
					bodyCheck += 'L: <input type="number" placeholder="Long" class="form-control" id="long_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					bodyCheck += 'W: <input type="number" placeholder="Wide" class="form-control" id="wide_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					if (height == 'ada') {
						bodyCheck += 'H: <input type="number" placeholder="Height" class="form-control" id="height_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					}
				bodyCheck += '</td>';
				index++;
			}
			if (types != 'Not Set') {
				bodyCheck += '<td style="background-color:white;" id="td_types">';
					bodyCheck += '<label class="containers">OK';
					bodyCheck += '<input type="radio" class="messageCheckbox" name="types_start" id="types_start" value="OK">';
					bodyCheck += '<span class="checkmark" id="types_start"></span>';
					bodyCheck += '</label>';
					bodyCheck += '<label class="containers">NG';
					bodyCheck += '<input type="radio" class="messageCheckbox" name="types_start" id="types_start" value="NG">';
					bodyCheck += '<span class="checkmark" id="types_start"></span>';
					bodyCheck += '</label>';
				bodyCheck += '</td>';
			}
			bodyCheck += '</tr>';

			bodyCheck += '<tr>';
			bodyCheck += '<td style="background-color:white;font-weight:bold;">Middle (M)</td>';
			bodyCheck += '<td style="background-color:white;"><input type="text" class="form-control timepicker" style="width:100%" placeholder="Input Time" value="0:00" id="time_middle"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control numpad" style="width:100%" placeholder="Qty Sampling" id="qty_middle"></td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="mixup_middle" id="mixup_middle" value="OK">';
				bodyCheck += '<span class="checkmark" id="mixup_middle"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="mixup_middle" id="mixup_middle" value="NG">';
				bodyCheck += '<span class="checkmark" id="mixup_middle"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="design_middle" id="design_middle" value="OK">';
				bodyCheck += '<span class="checkmark" id="design_middle"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="design_middle" id="design_middle" value="NG">';
				bodyCheck += '<span class="checkmark" id="design_middle"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="visual_middle" id="visual_middle" value="OK">';
				bodyCheck += '<span class="checkmark" id="visual_middle"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="visual_middle" id="visual_middle" value="NG">';
				bodyCheck += '<span class="checkmark" id="visual_middle"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			for(var i = 0; i < 5;i++){
				bodyCheck += '<td style="background-color:white;">';
					bodyCheck += 'L: <input type="number" placeholder="Long" class="form-control" id="long_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					bodyCheck += 'W: <input type="number" placeholder="Wide" class="form-control" id="wide_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					if (height == 'ada') {
						bodyCheck += 'H: <input type="number" placeholder="Height" class="form-control" id="height_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					}
				bodyCheck += '</td>';
				index++;
			}
			if (types != 'Not Set') {
				bodyCheck += '<td style="background-color:white;">';
					bodyCheck += '<label class="containers">OK';
					bodyCheck += '<input type="radio" class="messageCheckbox" name="types_middle" id="types_middle" value="OK">';
					bodyCheck += '<span class="checkmark" id="types_middle"></span>';
					bodyCheck += '</label>';
					bodyCheck += '<label class="containers">NG';
					bodyCheck += '<input type="radio" class="messageCheckbox" name="types_middle" id="types_middle" value="NG">';
					bodyCheck += '<span class="checkmark" id="types_middle"></span>';
					bodyCheck += '</label>';
				bodyCheck += '</td>';
			}
			bodyCheck += '</tr>';

			bodyCheck += '<tr>';
			bodyCheck += '<td style="background-color:white;font-weight:bold;">End (E)</td>';
			bodyCheck += '<td style="background-color:white;"><input type="text" class="form-control timepicker" style="width:100%" placeholder="Input Time" value="0:00" id="time_end"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control numpad" style="width:100%" placeholder="Qty Sampling" id="qty_end"></td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="mixup_end" id="mixup_end" value="OK">';
				bodyCheck += '<span class="checkmark" id="mixup_end"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="mixup_end" id="mixup_end" value="NG">';
				bodyCheck += '<span class="checkmark" id="mixup_end"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="design_end" id="design_end" value="OK">';
				bodyCheck += '<span class="checkmark" id="design_end"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="design_end" id="design_end" value="NG">';
				bodyCheck += '<span class="checkmark" id="design_end"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			bodyCheck += '<td style="background-color:white;">';
				bodyCheck += '<label class="containers">OK';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="visual_end" id="visual_end" value="OK">';
				bodyCheck += '<span class="checkmark" id="visual_end"></span>';
				bodyCheck += '</label>';
				bodyCheck += '<label class="containers">NG';
				bodyCheck += '<input type="radio" class="messageCheckbox" name="visual_end" id="visual_end" value="NG">';
				bodyCheck += '<span class="checkmark" id="visual_end"></span>';
				bodyCheck += '</label>';
			bodyCheck += '</td>';
			for(var i = 0; i < 5;i++){
				bodyCheck += '<td style="background-color:white;">';
					bodyCheck += 'L: <input type="number" placeholder="Long" class="form-control" id="long_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					bodyCheck += 'W: <input type="number" placeholder="Wide" class="form-control" id="wide_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					if (height == 'ada') {
						bodyCheck += 'H: <input type="number" placeholder="Height" class="form-control" id="height_'+i+'_'+index+'" onkeyup="checkLW(\''+i+'\',\''+index+'\')">';
					}
				bodyCheck += '</td>';
				index++;
			}
			if (types != 'Not Set') {
				bodyCheck += '<td style="background-color:white;">';
					bodyCheck += '<label class="containers">OK';
					bodyCheck += '<input type="radio" class="messageCheckbox" name="types_end" id="types_end" value="OK">';
					bodyCheck += '<span class="checkmark" id="types_end"></span>';
					bodyCheck += '</label>';
					bodyCheck += '<label class="containers">NG';
					bodyCheck += '<input type="radio" class="messageCheckbox" name="types_end" id="types_end" value="NG">';
					bodyCheck += '<span class="checkmark" id="types_end"></span>';
					bodyCheck += '</label>';
				bodyCheck += '</td>';
			}
			bodyCheck += '</tr>';

			bodyCheck += '<tr>';
			bodyCheck += '<td rowspan="4" style="border-top:2px solid red;background-color:white;font-weight:bold;">Composite Sample (pcs)</td>';
			bodyCheck += '<td style="border-top:2px solid red;background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="Start" readonly id="qty_start_resume"></td>';
			bodyCheck += '<td rowspan="4" style="border-top:2px solid red;background-color:white;font-weight:bold;">Check Result Sampling (pcs)</td>';
			bodyCheck += '<td style="border-top:2px solid red;background-color:white;font-weight:bold;">Acc</td>';
			bodyCheck += '<td style="border-top:2px solid red;background-color:white;font-weight:bold;">Total OK</td>';
			bodyCheck += '<td colspan="4" style="border-top:2px solid red;background-color:white;font-weight:bold;">Detail NG</td>';
			bodyCheck += '<td rowspan="4" colspan="3" style="border-top:2px solid red;background-color:white;font-weight:bold;font-size:50px;" id="lot_status"></td>';
			bodyCheck += '</tr>';

			bodyCheck += '<tr>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="Middle" readonly id="qty_middle_resume"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="Acc" readonly id="acc"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="OK" readonly id="ok"></td>';
			bodyCheck += '<td colspan="4" style="background-color:white;">';
			bodyCheck += '<select class="form-control select2" style="width: 100%" data-placeholder="Pilih Nama NG" id="select_ng_detail" multiple onchange="changeDetailNG()">';
				bodyCheck += '<option value=""></option>';
				for(var i = 0; i < ng_lists.length;i++){
					bodyCheck += '<option value="'+ng_lists[i].code+'">'+ng_lists[i].code+'</option>';
				}
			bodyCheck += '</select>';
			bodyCheck += '<input type="hidden" class="form-control" style="width:100%" placeholder="Total" readonly id="ng_detail">';
			bodyCheck += '</td>';
			bodyCheck += '</tr>';

			bodyCheck += '<tr>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="End" readonly id="qty_end_resume"></td>';
			bodyCheck += '<td style="border-top:2px solid red;background-color:white;font-weight:bold;">Re</td>';
			bodyCheck += '<td style="border-top:2px solid red;background-color:white;font-weight:bold;">Total NG</td>';
			bodyCheck += '<td colspan="4" style="background-color:white;"><input type="number" class="form-control numpad" style="width:100%;text-align:right" placeholder="Ketik Qty NG" readonly onchange="changeDetailNGQty(this.value)" id="ng_qty_detail_tiping"></td>';
			bodyCheck += '</tr>';

			bodyCheck += '<tr>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="Total" readonly id="qty_total"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control" style="width:100%" placeholder="Reject" readonly id="re"></td>';
			bodyCheck += '<td style="background-color:white;"><input type="number" class="form-control numpad" style="width:100%" placeholder="NG" readonly id="ng" onchange="checkNG()"></td>';
			bodyCheck += '<td colspan="4" style="background-color:white;"><input type="text" class="form-control" style="width:100%;text-align:right" placeholder="Total Qty NG" id="ng_qty_detail"></td>';
			bodyCheck += '</tr>';

			if (types == 'Not Set') {
				$('#th_types').hide();
			}

			$('#bodyCheck').append(bodyCheck);

			$('#select_ng_detail').select2({
				allowClear:true,
			});

			$('.timepicker').timepicker({
				showInputs: false,
				showMeridian: false,
				defaultTime: '0:00',
				icons: {
					time: 'fa fa-clock-o',
					date: 'fa fa-calendar',
					up: 'fa fa-plus',
					down: 'fa fa-minus',
					next: 'fa fa-chevron-left',
					previous: 'fa fa-chevron-right'
				},
			});
			$('.numpad').numpad({
				hidePlusMinusButton : true,
				decimalSeparator : '.'
			});

			var sample_size = 0;
			var lot_ok = 0;
			var lot_out = 0;

			for(var j = 0; j < aql.length;j++){
				if (aql[j].inspection_leves == 'AQL15') {
					if (parseInt(qty_check) < 90) {
						sample_size = 20;
						lot_ok = 0;
						lot_out = 1;
					}else if (parseInt(qty_check) >= parseInt(aql[j].lot_size_lower) && parseInt(qty_check) <= parseInt(aql[j].lot_size_upper)) {
						sample_size = aql[j].sample_size;
						lot_ok = aql[j].lot_ok;
						lot_out = aql[j].lot_out;
					}
				}
			}

			$('#qty_start').val(Math.round(sample_size/3));
			$('#qty_middle').val(Math.round(sample_size/3));
			var startmiddle = Math.round(sample_size/3)*2
			$('#qty_end').val(sample_size-startmiddle);

			$('#qty_start_resume').val(Math.round(sample_size/3));
			$('#qty_middle_resume').val(Math.round(sample_size/3));
			$('#qty_end_resume').val(sample_size-startmiddle);
			$('#qty_total').val(sample_size);

			$('#acc').val(lot_ok);
			$('#re').val(lot_out);
			$('#ok').val(sample_size);

			$('#bodyTableCheck').append(bodyTableCheck);
			$('#bodyTableCheck2').append(bodyTableCheck2);

			var index = 0;
			var index2 = 0;
			var index3 = 0;
			var index4 = 0;
			var index5 = 0;
			var index6 = 0;

			var index7 = 0;
			var index8 = 5;
			var index9 = 0;
			var index10 = 5;
			var index11 = 0;
			var index12 = 5;

			var index13 = 0;
			var index14 = 10;
			var index15 = 0;
			var index16 = 10;
			var index17 = 0;
			var index18 = 10;

			if (values.split('[]')[7] == 'Sudah') {
				for(var i = 0; i < final_check.length;i++){
					if (final_check[i].serial_number == values.split('[]')[0] && final_check[i].check_dates == values.split('[]')[3]) {
						$("#shift").val(final_check[i].shift).trigger('change');
						$("#line").val(final_check[i].line).trigger('change');
						$("#line_clearance").val(final_check[i].line_clearance).trigger('change');
						$("#sampling_date").val(final_check[i].sampling_date);

						$('#acc').val(final_check[i].acceptance);
						$('#re').val(final_check[i].reject);
						$('#ng').val(final_check[i].qty_ng);
						$('#ok').val(final_check[i].qty_ok);
						// $('#detail_ng').val(final_check[i].detail_ng);
						if (final_check[i].detail_ng != null) {
							$('#select_ng_detail').val(final_check[i].detail_ng.split('_')[0].split(',')).trigger('change');
							$('#ng_detail').val(final_check[i].detail_ng.split('_')[0]);
							$('#ng_qty_detail').val(final_check[i].detail_ng.split('_')[1]);
						}
						$('#lot_status').html(final_check[i].lot_status);
						$('#qty_total').val(final_check[i].qty_total);

						if (final_check[i].lot_status == 'LOT OUT') {
							document.getElementById('lot_status').style.backgroundColor = '#ffb5b5';
						}else{
							document.getElementById('lot_status').style.backgroundColor = '#96ffc4';
						}

						if (final_check[i].frequency == 'Start') {
							$("#time_start").val(final_check[i].check_time.split(':')[0]+':'+final_check[i].check_time.split(':')[1]);
							$('#qty_start').val(final_check[i].qty_sampling);
							$('#qty_start_resume').val(final_check[i].qty_sampling);

							if (final_check[i].point_check_type == 'mixup' && final_check[i].result_check != null) {
								$("input[name=mixup_start][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'design' && final_check[i].result_check != null) {
								$("input[name=design_start][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'visual' && final_check[i].result_check != null) {
								$("input[name=visual_start][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'types' && final_check[i].result_check != null) {
								$("input[name=types_start][value="+final_check[i].result_check+"]").prop('checked', true);
							}

							if (final_check[i].point_check_type == 'dimension') {
								if (final_check[i].point_check_name == 'long') {
									$('#long_'+index+'_'+index2).val(final_check[i].result_check);
									index2++;
									index++;
									if (index == 5) {
										index = 0;
									}
									if (index2 == 5) {
										index2 = 0;
									}
								}

								if (final_check[i].point_check_name == 'wide') {
									$('#wide_'+index3+'_'+index4).val(final_check[i].result_check);
									index4++;
									index3++;
									if (index3 == 5) {
										index3 = 0;
									}
									if (index4 == 5) {
										index4 = 0;
									}
								}

								if (final_check[i].point_check_name == 'height') {
									$('#height_'+index5+'_'+index6).val(final_check[i].result_check);
									index6++;
									index5++;
									if (index5 == 5) {
										index5 = 0;
									}
									if (index6 == 5) {
										index6 = 0;
									}
								}
							}
						}

						if (final_check[i].frequency == 'Middle') {
							$("#time_middle").val(final_check[i].check_time.split(':')[0]+':'+final_check[i].check_time.split(':')[1]);
							$('#qty_middle').val(final_check[i].qty_sampling);
							$('#qty_middle_resume').val(final_check[i].qty_sampling);

							if (final_check[i].point_check_type == 'mixup' && final_check[i].result_check != null) {
								$("input[name=mixup_middle][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'design' && final_check[i].result_check != null) {
								$("input[name=design_middle][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'visual' && final_check[i].result_check != null) {
								$("input[name=visual_middle][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'types' && final_check[i].result_check != null) {
								$("input[name=types_middle][value="+final_check[i].result_check+"]").prop('checked', true);
							}

							if (final_check[i].point_check_type == 'dimension') {
								if (final_check[i].point_check_name == 'long') {
									$('#long_'+index7+'_'+index8).val(final_check[i].result_check);
									index8++;
									index7++;
									if (index7 == 5) {
										index7 = 0;
									}
									if (index8 == 10) {
										index8 = 5;
									}
								}

								if (final_check[i].point_check_name == 'wide') {
									$('#wide_'+index9+'_'+index10).val(final_check[i].result_check);
									index10++;
									index9++;
									if (index9 == 5) {
										index9 = 0;
									}
									if (index10 == 10) {
										index10 = 5;
									}
								}

								if (final_check[i].point_check_name == 'height') {
									$('#height_'+index11+'_'+index12).val(final_check[i].result_check);
									index12++;
									index11++;
									if (index11 == 5) {
										index11 = 0;
									}
									if (index12 == 10) {
										index12 = 5;
									}
								}
							}
						}

						if (final_check[i].frequency == 'End') {
							$("#time_end").val(final_check[i].check_time.split(':')[0]+':'+final_check[i].check_time.split(':')[1]);
							$('#qty_end').val(final_check[i].qty_sampling);
							$('#qty_end_resume').val(final_check[i].qty_sampling);

							if (final_check[i].point_check_type == 'mixup' && final_check[i].result_check != null) {
								$("input[name=mixup_end][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'design' && final_check[i].result_check != null) {
								$("input[name=design_end][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'visual' && final_check[i].result_check != null) {
								$("input[name=visual_end][value="+final_check[i].result_check+"]").prop('checked', true);
							}
							if (final_check[i].point_check_type == 'types' && final_check[i].result_check != null) {
								$("input[name=types_end][value="+final_check[i].result_check+"]").prop('checked', true);
							}

							if (final_check[i].point_check_type == 'dimension') {
								if (final_check[i].point_check_name == 'long') {
									$('#long_'+index13+'_'+index14).val(final_check[i].result_check);
									index14++;
									index13++;
									if (index13 == 5) {
										index13 = 0;
									}
									if (index14 == 10) {
										index14 = 5;
									}
								}

								if (final_check[i].point_check_name == 'wide') {
									$('#wide_'+index15+'_'+index16).val(final_check[i].result_check);
									index16++;
									index15++;
									if (index15 == 5) {
										index15 = 0;
									}
									if (index16 == 10) {
										index16 = 5;
									}
								}

								if (final_check[i].point_check_name == 'height') {
									$('#height_'+index17+'_'+index18).val(final_check[i].result_check);
									index18++;
									index17++;
									if (index17 == 5) {
										index17 = 0;
									}
									if (index18 == 10) {
										index18 = 5;
									}
								}
							}
						}
					}
				}
			}
			$('#modalSerialNumber').modal('hide');
		}else{
			openErrorGritter('Error!','Pilih Job Number');
		}
	}

	function checkNG() {
		$('#ok').val($("#qty_total").val());
		var ok = $('#ok').val();
		var diff = ok - parseInt($("#ng").val());
		$('#ok').val(diff);
		var ng = parseInt($("#ng").val());
		$('#lot_status').val('');
		if (ng >= parseInt($('#re').val())) {
			$('#lot_status').html('LOT OUT');
			document.getElementById('lot_status').style.backgroundColor = '#ffb5b5';
		}else{
			$('#lot_status').html('LOT OK');
			document.getElementById('lot_status').style.backgroundColor = '#96ffc4';
		}
	}

	function checkLW(i,index) {
		var long_low = $('#long_low').text();
		var wide_low = $('#wide_low').text();
		var height_low = $('#height_low').text();
		var long_up = $('#long_up').text();
		var wide_up = $('#wide_up').text();
		var height_up = $('#height_up').text();

		if ($('#long_'+i+'_'+index).val() != '') {
			if (parseFloat($('#long_'+i+'_'+index).val()) < parseInt(long_low) || parseFloat($('#long_'+i+'_'+index).val()) > parseInt(long_up)) {
				document.getElementById('long_'+i+'_'+index).style.backgroundColor = '#ffb5b5';
			}else{
				document.getElementById('long_'+i+'_'+index).style.backgroundColor = '#96ffc4';
			}
		}

		if ($('#wide_'+i+'_'+index).val() != '') {
			if (parseFloat($('#wide_'+i+'_'+index).val()) < parseInt(wide_low) || parseFloat($('#wide_'+i+'_'+index).val()) > parseInt(wide_up)) {
				document.getElementById('wide_'+i+'_'+index).style.backgroundColor = '#ffb5b5';
			}else{
				document.getElementById('wide_'+i+'_'+index).style.backgroundColor = '#96ffc4';
			}
		}

		if ($('#height_'+i+'_'+index).val() != '') {
			if (parseFloat($('#height_'+i+'_'+index).val()) < parseInt(height_low) || parseFloat($('#height_'+i+'_'+index).val()) > parseInt(height_up)) {
				document.getElementById('height_'+i+'_'+index).style.backgroundColor = '#ffb5b5';
			}else{
				document.getElementById('height_'+i+'_'+index).style.backgroundColor = '#96ffc4';
			}
		}
	}

	// function changeQty(values,cond) {
	// 	$('#qty_'+cond+'_resume').val(values);
	// 	var total = 0;
	// 	if ($('#qty_start_resume').val() != '') {
	// 		total = total + parseInt($('#qty_start_resume').val());
	// 	}
	// 	if ($('#qty_middle_resume').val() != '') {
	// 		total = total + parseInt($('#qty_middle_resume').val());
	// 	}
	// 	if ($('#qty_end_resume').val() != '') {
	// 		total = total + parseInt($('#qty_end_resume').val());
	// 	}
	// 	$('#qty_total').val(total);
	// }

	function selectSerialNumber(values) {
		$('#bodyTableSerialNumber').html('');

		var bodySernum = '';

		if (values != '') {
			var serial_number = values.split('[]')[0];
			var material_number = values.split('[]')[1];
			var material_description = values.split('[]')[2];
			var check_date = values.split('[]')[3];
			var qty_check = values.split('[]')[4];
			var total_ok = values.split('[]')[5];
			var total_ng = values.split('[]')[6];
			var check_status = values.split('[]')[7];

			bodySernum += '<tr>';
			bodySernum += '<td>'+serial_number+'</td>';
			bodySernum += '<td>'+material_number+' - '+material_description+'</td>';
			bodySernum += '<td>'+check_date+'</td>';
			bodySernum += '<td>'+qty_check+'</td>';
			bodySernum += '<td>'+total_ok+'</td>';
			bodySernum += '<td>'+total_ng+'</td>';
			bodySernum += '<td>'+check_status+'</td>';
			bodySernum += '</tr>';
		}

		$('#bodyTableSerialNumber').append(bodySernum);
	}

	function changeDetailNG() {
		$('#ng_detail').val($("#select_ng_detail").val());
	}

	function changeDetailNGQty(value) {
		var qty = $('#ng_qty_detail').val();
		if (qty == '') {
			var qtyup = value;
		}else{
			var qtyup = qty+','+value;
		}
		$('#ng_qty_detail').val(qtyup);
		$('#ng_qty_detail_tiping').val('');
	}

	var audio_error = new Audio('{{ url("sounds/error.mp3") }}');

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

	$.date = function(dateObject) {
		var d = new Date(dateObject);
		var day = d.getDate();
		var month = d.getMonth() + 1;
		var year = d.getFullYear();
		if (day < 10) {
			day = "0" + day;
		}
		if (month < 10) {
			month = "0" + month;
		}
		var date = day + "/" + month + "/" + year;

		return date;
	};

	function addZero(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}

	function getActualFullDate() {
		var d = new Date();
		var day = addZero(d.getDate());
		var month = addZero(d.getMonth()+1);
		var year = addZero(d.getFullYear());
		var h = addZero(d.getHours());
		var m = addZero(d.getMinutes());
		var s = addZero(d.getSeconds());
		return year + "-" + month + "-" + day + " " + h + ":" + m + ":" + s;
	}

	function confirmNgLog() {
		$('#loading').show();
		if ($('#shift').val() == "" || $('#line').val() == "" || $('#line_clearance').val() == "") {
			$('#loading').hide();
			openErrorGritter('Error!','Isi Semua Data (Shift, Line, Clearance.');
			return false;
		}else{

			if ($('#ng').val() == "") {
				$('#loading').hide();
				openErrorGritter('Error!','Kolom QTY NG harus diisi.');
				return false;
			}
			var start = [];
			var middle = [];
			var end = [];

			var shift = $('#shift').val();
			var line = $('#line').val();
			var line_clearance = $('#line_clearance').val();
			var sampling_date = $('#date').val();

			var values = $("#select_serial_number").val();

			var serial_number = values.split('[]')[0];
			var material_number = values.split('[]')[1];
			var material_description = values.split('[]')[2];
			var check_date = values.split('[]')[3];
			var qty_check = values.split('[]')[4];
			var total_ok = values.split('[]')[5];
			var total_ng = values.split('[]')[6];

			var time_start = $('#time_start').val();
			var time_middle = $('#time_middle').val();
			var time_end = $('#time_end').val();

			var qty_start = $('#qty_start').val();
			var qty_middle = $('#qty_middle').val();
			var qty_end = $('#qty_end').val();

			var mixup_start = '';
			var mixup_middle = '';
			var mixup_end = '';

			$("input[name='mixup_start']:checked").each(function (i) {
	            mixup_start = $(this).val();
	        });
	        $("input[name='mixup_middle']:checked").each(function (i) {
	            mixup_middle = $(this).val();
	        });
	        $("input[name='mixup_end']:checked").each(function (i) {
	            mixup_end = $(this).val();
	        });

	        var design_start = '';
			var design_middle = '';
			var design_end = '';

			$("input[name='design_start']:checked").each(function (i) {
	            design_start = $(this).val();
	        });
	        $("input[name='design_middle']:checked").each(function (i) {
	            design_middle = $(this).val();
	        });
	        $("input[name='design_end']:checked").each(function (i) {
	            design_end = $(this).val();
	        });

	        var visual_start = '';
			var visual_middle = '';
			var visual_end = '';

			$("input[name='visual_start']:checked").each(function (i) {
	            visual_start = $(this).val();
	        });
	        $("input[name='visual_middle']:checked").each(function (i) {
	            visual_middle = $(this).val();
	        });
	        $("input[name='visual_end']:checked").each(function (i) {
	            visual_end = $(this).val();
	        });

	        var types_start = '';
	        var types_middle = '';
	        var types_end = '';

	        if (types != 'Not Set') {
	        	$("input[name='types_start']:checked").each(function (i) {
		            types_start = $(this).val();
		        });
		        $("input[name='types_middle']:checked").each(function (i) {
		            types_middle = $(this).val();
		        });
		        $("input[name='types_end']:checked").each(function (i) {
		            types_end = $(this).val();
		        });
	        }

	        var long_start = [];
	        var wide_start = [];
	        var long_middle = [];
	        var wide_middle = [];
	        var long_end = [];
	        var wide_end = [];
	    	var height_start = [];
	    	var height_middle = [];
	    	var height_end = [];

	    	var long = $('#long').text();
	    	var wide = $('#wide').text();
	    	var height = $('#height').text();

	        var index = 0;

	        for(var i = 0; i < 5;i++){
	        	long_start.push($('#long_'+i+'_'+index).val());
	        	wide_start.push($('#wide_'+i+'_'+index).val());
	        	height_start.push($('#height_'+i+'_'+index).val());
	        	index++;
	        }

	        for(var i = 0; i < 5;i++){
	        	long_middle.push($('#long_'+i+'_'+index).val());
	        	wide_middle.push($('#wide_'+i+'_'+index).val());
	        	height_middle.push($('#height_'+i+'_'+index).val());
	        	index++;
	        }

	        for(var i = 0; i < 5;i++){
	        	long_end.push($('#long_'+i+'_'+index).val());
	        	wide_end.push($('#wide_'+i+'_'+index).val());
	        	height_end.push($('#height_'+i+'_'+index).val());
	        	index++;
	        }

	        var qty_total = $('#qty_total').val();
	        var acc = $('#acc').val();
	        var re = $('#re').val();
	        var ng = $('#ng').val();
	        var ok = $('#ok').val();
	        var ng_detail = $('#ng_detail').val();
	        var ng_detail_qty = $('#ng_qty_detail').val();
	        var lot_status = $('#lot_status').text();

	        var data = {
	        	shift:shift,
				line:line,
				index:index,
				line_clearance:line_clearance,
				sampling_date:sampling_date,
				serial_number:serial_number,
				material_number:material_number,
				material_description:material_description,
				check_date:check_date,
				qty_check:qty_check,
				total_ok:total_ok,
				total_ng:total_ng,
				time_start:time_start,
				time_middle:time_middle,
				time_end:time_end,
				qty_start:qty_start,
				qty_middle:qty_middle,
				qty_end:qty_end,
				mixup_start:mixup_start,
				mixup_middle:mixup_middle,
				mixup_end:mixup_end,
				design_start:design_start,
				design_middle:design_middle,
				design_end:design_end,
				visual_start:visual_start,
				visual_middle:visual_middle,
				visual_end:visual_end,
				types_start:types_start,
				types_middle:types_middle,
				types_end:types_end,
				long_start:long_start,
				wide_start:wide_start,
				long_middle:long_middle,
				wide_middle:wide_middle,
				long_end:long_end,
				wide_end:wide_end,
				height_start:height_start,
				height_middle:height_middle,
				height_end:height_end,
				qty_total:qty_total,
				acc:acc,
				re:re,
				ng:ng,
				ok:ok,
				ng_detail:ng_detail,
				ng_detail_qty:ng_detail_qty,
				lot_status:lot_status,
				types:types,
				long:long,
				wide:wide,
				height:height,
	        }

			$.post('{{ url("input/outgoing/crestec/sampling") }}', data, function(result, status, xhr){
				if(result.status){
					cancelAll();
					openSuccessGritter('Success!',result.message);
					$('#loading').hide();
					location.reload();
				}else{
					openErrorGritter('Error!',result.message);
					$('#loading').hide();
					$('#btn_confirm').removeAttr('disabled');
				}
			});
		}
	}

	function confirmAll() {
		if (confirm('Apakah Anda yakin?')) {
			$('#loading').show();
			var values = $("#select_serial_number").val();

			var serial_number = values.split('[]')[0];

			var data = {
				serial_number:serial_number,
				check_date:values.split('[]')[3]
			}
			$.post('{{ url("input/outgoing/crestec/sampling/closing") }}', data, function(result, status, xhr){
				if(result.status){
					cancelAll();
					openSuccessGritter('Success!',result.message);
					$('#loading').hide();
					location.reload();
				}else{
					openErrorGritter('Error!',result.message);
					$('#loading').hide();
					$('#btn_confirm').removeAttr('disabled');
				}
			});
		}
	}
</script>
@endsection