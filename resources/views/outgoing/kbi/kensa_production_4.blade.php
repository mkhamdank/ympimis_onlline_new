@extends('layouts.display')
@section('stylesheets')
<link href="<?php echo e(url("css/jquery.numpad.css")); ?>" rel="stylesheet">
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
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
		color: #FFD700;
	}
	thead {
		background-color: rgb(126,86,134);
	}
	td{
		overflow:hidden;
		text-overflow: ellipsis;
	}
	#ngTemp {
		height:200px;
		overflow-y: scroll;
	}

	#ngList {
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
	}
    div.dataTables_filter label,
    div.dataTables_wrapper div.dataTables_info {
        color: white;
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
	<input type="hidden" id="start_time" value="">
	<input type="hidden" id="incoming_check_code" value="">
	
	<div class="row" style="padding-left: 10px; padding-right: 10px;">
		<div class="col-md-6" style="padding-right: 0; padding-left: 0">
			<table class="table table-bordered" style="width: 100%; margin-bottom: 2px;" border="1">
				<tbody>
					<tr>
						<th style="vertical-align:middle;background-color: #d1d1d1; text-align: center; color: #14213d; padding:0;font-size: 17px;width: 1%;">Date</th>
						<th style="vertical-align:middle;background-color: #d1d1d1; text-align: center; color: #14213d; padding:0;font-size: 17px;width: 1%;">Pos</th>
					</tr>
					<tr>
						<td style="background-color: #fca311; color: #14213d; text-align: center; font-size: 20px;padding-left: 2px;padding-right: 2px" id="date">{{date("Y-m-d")}}</td>
						<td style="background-color: #fca311; color: #14213d; text-align: center; font-size: 20px;padding-left: 2px;padding-right: 2px" id="pos">{{$pos}}</td>
					</tr>
                    <tr>
                        <td colspan="2" style="background-color: #d1d1d1; text-align: center; color: #14213d; padding:0;font-size: 14px;font-weight: bold;width: 1%">
							Label
						</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="color: #14213d; text-align: center; font-size: 20px;padding-left: 2px;padding-right: 2px">
							<input type="text" class="pull-right" name="label" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="label" placeholder="Label" readonly>
						</td>
                    </tr>
					<tr>
						<td style="background-color: #d1d1d1; text-align: center; color: #14213d; padding:0;font-size: 14px;font-weight: bold;width: 1%">
							Part No.
						</td>
						<td style="background-color: #d1d1d1; text-align: center; color: #14213d; padding:0;font-size: 14px;font-weight: bold;width: 5%">
							Part Name
						</td>
					</tr>
					<tr>
						<td style="color: #14213d; text-align: center; font-size: 20px;padding-left: 2px;padding-right: 2px">
							<input type="text" class="pull-right" name="material_number" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="material_number" placeholder="Part No." readonly>
						</td>
						<td style="color: #14213d; text-align: center; font-size: 20px;padding-left: 2px;padding-right: 2px">
							<input type="text" class="pull-right" name="material_description" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="material_description" placeholder="Part Name" readonly>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="table table-bordered" style="width: 100%; margin-bottom: 5px;border: 0">
				<tbody>
					<tr>
						<td style="background-color: #d1d1d1; text-align: center; color: #14213d; padding:0;font-size: 18px;font-weight: bold;width: 1%">
							QTY CHECK
						</td>
						<td style="background-color: #da96ff; text-align: center; color: #14213d; padding:0;font-size: 18px;font-weight: bold;width: 1%">
							QTY OK
						</td>
					</tr>
					<tr>
						<td>
							<input type="number" class="pull-right" name="qty_check" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="qty_check" placeholder="Quantity Check" readonly="">
						</td>
						<td>
							<input type="text" class="pull-right" name="total_ok" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="total_ok" placeholder="Qty OK" readonly value="0">
						</td>
					</tr>
                    <tr>
                        <td style="background-color: #ffe06e; text-align: center; color: #14213d; padding:0;font-size: 18px;font-weight: bold;width: 1%">
							QTY NG
						</td>
						<td style="background-color: #ff8c8c; text-align: center; color: #14213d; padding:0;font-size: 18px;font-weight: bold;width: 1%">
							NG RATIO (%)
						</td>
                    </tr>
                    <tr>
                        <td>
							<input type="text" class="pull-right" name="total_ng" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="total_ng" placeholder="Qty NG" readonly value="0">
						</td>
						<td>
							<input type="text" class="pull-right" name="ng_ratio" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="ng_ratio" placeholder="NG Ratio (%)" readonly value="0">
						</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="2">
							<button class="btn btn-success" id="btn_confirm" onclick="confirmAll()" style="font-size: 20px; font-weight: bold;width: 100%">
								CONFIRM
							</button>
						</td>
                    </tr> --}}
                    <tr>
                        <th colspan="2" style="vertical-align:middle;background-color: #0aff47; text-align: center; color: #14213d; padding:0;font-size: 17px;width: 1%;">CONFIRM</th>
                    </tr>
                    <tr>
                        <td style="background-color: #14213d; color: #fff; text-align: center; font-size: 20px;">
							<input type="text" class="pull-right" name="label_confirm" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="label_confirm" placeholder="Scan Label">
                        </td>
                        <td style="background-color: #14213d; color: #fff; text-align: center; font-size: 20px;">
							<input type="text" class="pull-right" name="inspector" style="padding: 5px; font-size: 18px; width: 100%;text-align: center;vertical-align: middle;color: #14213d" id="inspector" placeholder="Scan ID Card">
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-6" style="padding-right: 0px;padding-left: 0px">
			<div id="ngList">
				<table class="table table-bordered" style="width: 100%; margin-bottom: 2px;" border="1">
					<thead>
						<tr>
							<th style="width: 15%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >#</th>
							<th style="width: 55%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >NG Name</th>
							<th style="width: 15%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >#</th>
							<th style="width: 15%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >Qty</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; ?>
						<input type="hidden" name="ng_list_count" id="ng_list_count" value="{{count($ng_lists)}}">
						<?php for ($i=0; $i < count($ng_lists); $i++) {
                            if($ng_lists[$i]->remark == 'kbi_production_check'){?>
							<?php if ($no % 2 === 0 ) {
								$color = 'style="background-color: #fffcb7"';
							} else {
								$color = 'style="background-color: #ffd8b7"';
							}
							?>
							<tr <?php echo $color ?>>
								<td id="minus" onclick="minus({{$i+1}})" style="background-color: rgb(255,204,255); font-weight: bold; font-size: 30px; cursor: pointer;" class="unselectable">-</td>
								<td id="ng{{$i+1}}" style="font-size: 15px;">{{ $ng_lists[$i]->ng_name }}</td>
								<td id="plus" onclick="plus({{$i+1}})" style="background-color: rgb(204,255,255); font-weight: bold; font-size: 30px; cursor: pointer;" class="unselectable">+</td>
								<td style="font-weight: bold; font-size: 30px; background-color: rgb(100,100,100); color: yellow;"><span id="count{{$i+1}}">0</span></td>
							</tr>
							<?php $no+=1; ?>
                            <?php } ?>
						<?php } ?>
					</tbody>
				</table>
                <table class="table table-bordered" style="width: 100%; margin-bottom: 2px;" border="1" id="tableNgList">
                    <thead>
						<tr>
							<th style="width: 15%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >#</th>
							<th style="width: 55%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >NG Name</th>
							<th style="width: 15%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >#</th>
							<th style="width: 15%; background-color: rgb(220,220,220); padding:0;font-size: 15px;" >Qty</th>
						</tr>
					</thead>
					<tbody id="bodyTableNgList">
						<?php for ($i=0; $i < count($ng_lists); $i++) {
                            if($ng_lists[$i]->remark != 'kbi_production_check'){?>
							<?php if ($no % 2 === 0 ) {
								$color = 'style="background-color: #fffcb7"';
							} else {
								$color = 'style="background-color: #ffd8b7"';
							}
							?>
							<tr <?php echo $color ?>>
								<td id="minus" onclick="minus({{$i+1}})" style="background-color: rgb(255,204,255); font-weight: bold; font-size: 30px; cursor: pointer;" class="unselectable">-</td>
								<td id="ng{{$i+1}}" style="font-size: 15px;">{{ $ng_lists[$i]->ng_name }}</td>
								<td id="plus" onclick="plus({{$i+1}})" style="background-color: rgb(204,255,255); font-weight: bold; font-size: 30px; cursor: pointer;" class="unselectable">+</td>
								<td style="font-weight: bold; font-size: 30px; background-color: rgb(100,100,100); color: yellow;"><span id="count{{$i+1}}">0</span></td>
							</tr>
							<?php $no+=1; ?>
                            <?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="<?php echo e(url("js/jquery.numpad.js")); ?>"></script>
<script src="{{ url("js/jquery.gritter.min.js") }}"></script>

<script src="{{ url("js/jquery.dataTables.min.js") }}"></script>
<script src="{{ url("js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ url("js/jquery.flot.min.js") }}"></script>

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

    $.fn.numpad.defaults.gridTpl = '<table class="table modal-content" style="align-items:left"></table>';
	$.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in" style="opacity:.5"></div>';
	$.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" style="font-size:1.5vw; height: 50px;width:100%"/>';
	$.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-primary" style="font-size:1.5vw; width:40px;background-color:#b5ffa8;color:black"></button>';
	$.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="font-size:1.5vw; width: 100%;background-color:#ffb84d;color:black"></button>';
	$.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};

	jQuery(document).ready(function() {
		$('.datepicker').datepicker({
			<?php $tgl_max = date('Y-m-d') ?>
			autoclose: true,
			format: "yyyy-mm-dd",
			todayHighlight: true,	
			endDate: '<?php echo $tgl_max ?>'
		});
		cancelAll();

        // checkActive();

        intervalUpdate = setInterval(checkActive, 2000);

		$('.select2').select2({
            allowClear: true
		});

		$('.numpad').numpad({
			hidePlusMinusButton : true,
			decimalSeparator : '.'
		});

		$('.numpad2').numpad({
			hidePlusMinusButton : true,
			decimalSeparator : '.'
		});

        $('#tableNgList').DataTable({
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
            'paging': false,
            'lengthChange': false,
            'pageLength': -1,
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
	});

    function checkActive(){
        var data = {
            pos: $('#pos').text(),
        }
        $.get('{{ url("fetch/production_check/kbi_active") }}', data, function(result, status, xhr){
            if(result.status){
                if(result.active){
                    $('#label').val(result.active.serial_number);
                    $('#material_number').val(result.active.material_number);
                    $('#material_description').val(result.active.material_description);
                    $('#qty_check').val(result.active.qty_check);
                    $('#total_ok').val(result.active.total_ok);

                    clearInterval(intervalUpdate);

                    $('#label_confirm').val('');
				    $('#label_confirm').focus();
                }
            }else{
                openErrorGritter('Error!', result.message);
                $('#loading').hide();
            }
        });
    }

	var inspector = <?php echo json_encode($inspector); ?>;
	var serial_number = <?php echo json_encode($serial_number); ?>;

	$('#inspector').on('input', function() {
		var tag = $(this).val().toUpperCase();

		if (tag.length === 6) {
			if (tag != "") {
				var found = false;
				for (var i = 0; i < inspector.length; i++) {
					if (inspector[i].employee_id.toUpperCase() == tag || inspector[i].name.toUpperCase() == tag) {
						$('#inspector').val(inspector[i].employee_id + ' - ' + inspector[i].name);
						found = true;
						break;
					}
				}
				if (!found) {
					openErrorGritter('Error!', 'ID Karyawan tidak ditemukan!');
					$('#inspector').val('');
					return false;
				}
				confirmAll();
				openSuccessGritter('Success!', 'ID Karyawan ditemukan!');
			} else {
				openErrorGritter('Error!', 'ID Karyawan tidak boleh kosong!');
				return false;
			}
		}
	});

	$('#label_confirm').on('input', function() {
		var tag = $(this).val().toUpperCase();

		if (tag.length === 17) {
			if (tag != "") {
				var found = false;
				if(tag == $('#label').val().toUpperCase()){
					found = true;
				}
				if (!found) {
					openErrorGritter('Error!', 'Label tidak sama!');
					$('#label_confirm').val('');
					return false;
				}
				openSuccessGritter('Success!', 'Label sama!');
				$('#inspector').val('');
				$('#inspector').focus();
			} else {
				openErrorGritter('Error!', 'Label tidak boleh kosong!');
				return false;
			}
		}
	});

    function plus(id){
		var count = $('#count'+id).text();
		if ($('#qty_check').val() == "") {
			openErrorGritter('Error!','Isi semua data!');
            return false;
		}

        if($('#total_ok').val() <= 0){
            openErrorGritter('Error!','Total OK OK tidak boleh 0!');
            return false;
        }

        $('#total_ok').val(parseInt($('#total_ok').val())-1);
        $('#total_ng').val(parseInt($('#total_ng').val())+1);
        $('#ng_ratio').val(((parseInt($('#total_ng').val())/parseInt($('#qty_check').val()))*100).toFixed(1));
        $('#count'+id).text(parseInt(count)+1);
	}

	function minus(id){
		var count = $('#count'+id).text();
		if ($('#qty_check').val() == "") {
			openErrorGritter('Error!','Isi semua data!');
            return false;
		}

        if(count > 0)
        {
            $('#total_ok').val(parseInt($('#total_ok').val())+1);
            $('#total_ng').val(parseInt($('#total_ng').val())-1);
            $('#ng_ratio').val(((parseInt($('#total_ng').val())/parseInt($('#qty_check').val()))*100).toFixed(1));
            $('#count'+id).text(parseInt(count)-1);
        }
	}

    function cancelAll() {
        clearInterval(intervalUpdate);
        $('#label_confirm').val('');
        $('#qty_check').val('0');
        $('#total_ok').val('0');
        $('#total_ng').val('0');
        $('#ng_ratio').val('0');
        $('#inspector').val('');
		$('#inspector').focus();
		$('#label').val('');
		$('#material_number').val('');
		$('#material_description').val('');
    }

	function confirmAll() {
		var ng_name = [];
		var ng_qty = [];
		var jumlah_ng = '{{count($ng_lists)}}';
		console.log(jumlah_ng);
		for (var i = 1; i <= jumlah_ng; i++ ) {
			console.log($('#count'+i).text());
			console.log($('#ng'+i).text());
			if ($('#count'+i).text() != 0) {
				ng_name.push($('#ng'+i).text());
				ng_qty.push($('#count'+i).text());
			}
		}
		var data = {
			date: $('#date').text(),
			inspector: $('#inspector').val(),
			qty_check: $('#qty_check').val(),
			total_ok: $('#total_ok').val(),
			total_ng: $('#total_ng').val(),
			ng_ratio: $('#ng_ratio').val(),
			label: $('#label').val(),
			pos: $('#pos').text(),
			material_number: $('#material_number').val(),
			material_description: $('#material_description').val(),
			ng_name: ng_name,
			ng_qty: ng_qty,
		}

		if (data.type_check == "" || data.inspector == "" || data.qty_check == "" || data.total_ok == "" || data.total_ng == "" || data.ng_ratio == "" || data.label == "" || data.material_number == "" || data.material_description == "") {
			openErrorGritter('Error!','Isi semua data!');
			return false;
		}

		$.post('{{ url("input/production_check/kbi_4") }}', data, function(result, status, xhr){
			if (result.status) {
				openSuccessGritter('Success!', result.message);
				cancelAll();
                intervalUpdate = setInterval(checkActive, 2000);
				for (var i = 1; i <= jumlah_ng; i++) {
					$('#count'+i).text(0);
				}
			} else {
				openErrorGritter('Error!', result.message);
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

</script>
@endsection