@extends('layouts.master')
@section('stylesheets')
<link href="{{ url('css/jquery.gritter.css') }}" rel="stylesheet">
<style type="text/css">
	#loading,
	#error {
		display: none;
	}

	table.table-bordered>thead>tr>th {
		color: white;
		background-color: black;
	}

	table.table-bordered>tbody>tr>td {
		color: black;
		background-color: white;
	}

	#loading {
		display: none;
	}

	.radio {
		display: inline-block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 16px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	/* Hide the browser's default radio button */
	.radio input {
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
		background-color: #ccc;
		border-radius: 50%;
	}

	/* On mouse-over, add a grey background color */
	.radio:hover input~.checkmark {
		background-color: #ccc;
	}

	/* When the radio button is checked, add a blue background */
	.radio input:checked~.checkmark {
		background-color: #2196F3;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.radio input:checked~.checkmark:after {
		display: block;
	}

	/* Style the indicator (dot/circle) */
	.radio .checkmark:after {
		top: 9px;
		left: 9px;
		width: 8px;
		height: 8px;
		border-radius: 50%;
		background: white;
	}

	#tableResult>thead>tr>th {
		border: 1px solid black;
	}

	#tableResult>tbody>tr>td {
		border: 1px solid #b0bec5;
	}

	hr {
		margin-top: 2px;
		margin-bottom: 2px;
		border-color: black;
	}
</style>
@stop
@section('header')
@stop
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="content" style="padding: 10px">
	<div id="loading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(0,191,255); z-index: 30001; opacity: 0.8; display: none">
		<p style="position: absolute; color: white; top: 45%; left: 35%;">
			<span style="font-size: 40px">Loading, Please Wait . . . <i class="fa fa-spin fa-refresh"></i></span>
		</p>
	</div>

	<div class="row">
		<div class="col-md-10">
			<input type="hidden" id="green">
			<h1>
				Audit Molding
			</h1>
		</div>
		<div class="col-md-2">
			<buton class="btn btn-primary" style="width: 100%;" onclick="openModal('modal_history')"><i class="fa fa-book"></i> Riwayat Pengecekan</button>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="col-xs-12" style="padding-right: 0; padding-left: 0;">
				<table class="table table-bordered" style="width: 100%; margin-bottom: 10px">
					<thead>
						<tr>
							<th style="width:15%; background-color: white; color: black; text-align: center; padding:0;font-size: 18px;border: 1px solid black" colspan="3">General Information</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="padding: 0px; background-color: #3f51b5; text-align: center; color: white; font-size:20px; width: 30%;border: 1px solid black">Tanggal Audit</td>
							<td colspan="2" style="padding: 0px; background-color: #01579b; text-align: center; color: white; font-size: 20px;border: 1px solid black"><?= date("d F Y") ?></td>
						</tr>
						<tr>
							<td style="padding: 0px; background-color: #3f51b5; text-align: center; color: white; font-size:20px; width: 30%;border: 1px solid black">Nama Molding</td>
							<td colspan="2" style="padding: 0px; background-color: #01579b; text-align: center; color: white; font-size: 20px;border: 1px solid black" id="molding_name"></td>
						</tr>
						<tr>
							<td style="padding: 0px; background-color: #3f51b5; text-align: center; color: white; font-size:20px; width: 30%;border: 1px solid black">PIC</td>
							<td colspan="2" style="padding: 0px; background-color: #01579b; text-align: center; color: white; font-size: 20px;border: 1px solid black" id="employee_name"></td>
						</tr>
						<tr>
							<td style="padding: 0px; background-color: #3f51b5; text-align: center; color: white; font-size:20px; width: 30%;border: 1px solid black">Lokasi</td>
							<td colspan="2" style="padding: 0px; background-color: #01579b; text-align: center; color: white; font-size: 20px;border: 1px solid black" id="location">ARISA</td>
						</tr>
					</tbody>
				</table>
			</div>

			<input type="hidden" id="employee_id">

			<div class="col-md-12" style="padding: 0">
				<div class="row">
					<div class="col-md-8">
						<h2>Pengecekan Molding</h2>
					</div>
					<div class="col-md-2" style="padding: 0 5px 0 5px"><button style="color: white; width: 100%" class="btn bg-purple" onclick="openModal('modal_problem_log')"><i class="fa fa-book"></i> Riwayat Temuan</button></div>
					<div class="col-md-2" style="padding: 0 5px 0 5px"><button style="width: 100%" class="btn btn-success" id="add_check" onclick="add_point()"><i class="fa fa-plus"></i> Tambah Pengecekan</button></div>
				</div>
				<table class="table table-bordered" style="width: 100%; color: white;" id="tableResult">
					<thead style="font-weight: bold; background-color: #f20000">
						<tr>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 15%;">Nama Part</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 15%;">Poin Cek</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 17%;">Standar</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 17%;">Cara Pengecekan</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 17%;">Cara Penanganan</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 20%;">Eviden</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 20%;">Judgement</th>
							<th style="border-right: 1px solid white;background-color:#f20000;width: 1%;">Action</th>
						</tr>
					</thead>
					<tbody id="body_cek">
					</tbody>
				</table>

				<br>
				<button class="btn btn-success" style="width: 100%;font-size: 25px" onclick="cek()"><i class="fa fa-check"></i> Submit</button>
			</div>
		</div>
	</div>
</section>

<div class="modal modal-default fade" id="molding_select">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<center>Pilih PIC & Molding</center>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-3">
						<label>Pilih PIC</label>
					</div>
					<div class="col-xs-9">
						<select class="select2" id="pic" style="width: 100%" data-placeholder="Pilih PIC">
							<option value=""></option>
							@foreach($pics as $pic)
							<option value="{{ $pic->employee_id }}">{{ $pic->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Pilih Molding</label>
					</div>
					<div class="col-xs-9">
						<select class="select2" id="moldings" style="width: 100%" data-placeholder="Pilih Type Molding">
							<option value=""></option>
							@foreach($moldings as $molding)
							<option value="{{ $molding->molding_name }}">{{ $molding->molding_name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<br>
						<button class="btn btn-success pull-right" onclick="selectMolding()"><i class="fa fa-check"></i> OK</button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 1200px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<center>
					<h4 class="modal-title">Riwayat Pengecekan</h4>
				</center>
				<!-- <button class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button> -->
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3">
						<span style="font-weight: bold;">Tanggal Dari</span>
						<div class="form-group">
							<input type="text" class="form-control datepicker2" id="date_from" name="date_from" placeholder="Select Date From" autocomplete="off">
						</div>
					</div>
					<div class="col-md-3">
						<span style="font-weight: bold;">Tanggal Sampai</span>
						<div class="form-group">
							<input type="text" class="form-control datepicker2" id="date_to" name="date_to" placeholder="Select Date To" autocomplete="off">
						</div>
					</div>

					<div class="col-md-6">
						<span style="font-weight: bold;">Molding</span>
						<div class="form-group">
							<select class="form-control select4" multiple="multiple" id='molding_select' data-placeholder="Pilih Molding" style="width: 100%;color: black !important">
								@foreach($moldings as $molding)
								<option value="{{ $molding->molding_name }}">{{ $molding->molding_name }}</option>
								@endforeach
							</select>
							<input type="hidden" name="type_molding" id="type_molding">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<span style="font-weight: bold;">PIC</span>
						<div class="form-group">
							<select class="select4" id="pic_select" multiple="multiple" style="width: 100%" data-placeholder="Pilih PIC">
								@foreach($pics as $pic)
								<option value="{{ $pic->employee_id }}">{{ $pic->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-primary pull-right" onclick="fetchDetailRecord()"><i class="fa fa-search"></i> Cari</button>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12" style="overflow-x: scroll; margin-top: 5px">
						<table class="table table-bordered" id="tableDetail">
							<thead style="border-bottom:3px solid black;border-top:3px solid black;background-color:#cddc39">
								<tr>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>Id</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>Tanggal</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>Molding</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>PIC</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>Poin Cek</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" colspan="3">
										<center>Eviden</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>Judgement</center>
									</th>
									<th style="font-weight: bold; vertical-align: middle;" rowspan="2">
										<center>Status</center>
									</th>
								</tr>
								<tr>
									<th style="font-weight: bold;">
										<center>Before</center>
									</th>
									<th style="font-weight: bold;">
										<center>After</center>
									</th>
									<th style="font-weight: bold;">
										<center>Aktifitas</center>
									</th>
								</tr>
							</thead>
							<tbody id="bodyTableDetail">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-default fade" id="modal_problem">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<center>Tuliskan Permasalahan</center>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-3">
						<label>Nama Molding</label>
					</div>
					<div class="col-xs-6">
						<input type="text" id="nama_molding" class="form-control" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Nama Part</label>
					</div>
					<div class="col-xs-4">
						<input type="text" class="form-control" id="nama_part" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Permasalahan</label>
					</div>
					<div class="col-xs-9">
						<textarea class="form-control" id="permasalahan"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Permasalahan Foto</label>
					</div>
					<div class="col-xs-9">
						<input type="file" id="permasalahan1" class="permasalahan1" accept="image/*" onchange="readURL2(this,'img_permasalahan1')" hidden>
						<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,'permasalahan1')"><i class="fa fa-camera"></i> Photo 1</button>
						<input type="file" id="permasalahan2" class="permasalahan2" accept="image/*" onchange="readURL2(this,'img_permasalahan2')" hidden>
						&nbsp;<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,'permasalahan2')"><i class="fa fa-camera"></i> Photo 2</button>
						<br>
						<img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_permasalahan1">
						&nbsp; <img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_permasalahan2">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Perbaikan Sementara</label>
					</div>
					<div class="col-xs-9">
						<textarea class="form-control" id="perbaikan_sementara"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Perbaikan Foto</label>
					</div>
					<div class="col-xs-9">
						<input type="file" id="perbaikan1" class="perbaikan1" accept="image/*" onchange="readURL2(this,'img_perbaikan1')" hidden>
						<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,'perbaikan1')"><i class="fa fa-camera"></i> Photo 1</button>
						<input type="file" id="perbaikan2" class="perbaikan2" accept="image/*" onchange="readURL2(this,'img_perbaikan2')" hidden>
						&nbsp;<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,'perbaikan2')"><i class="fa fa-camera"></i> Photo 2</button>
						<br>
						<img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_perbaikan1">
						&nbsp; <img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_perbaikan2">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Catatan</label>
					</div>
					<div class="col-xs-9">
						<textarea class="form-control" id="note"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3">
						<br>
						<label>Status</label>
					</div>
					<div class="col-xs-3" id="status_div">
						<select class="select5" id="status" style="width: 100%" data-placeholder="Pilih Status">
							<option value=""></option>
							<option value="Open">Open</option>
							<option value="Temporary Close">Temporary Close</option>
							<option value="Close">Close</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<br>
						<button class="btn btn-success pull-right" onclick="simpanTemuan()"><i class="fa fa-check"></i> Simpan Temuan</button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal modal-default fade" id="modal_problem_log">
	<div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<center>Riwayat Temuan</center>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-md-5 control-label">Tanggal Dari</label>
							<div class="col-md-7">
								<input type="text" class="form-control datepicker2" id="riwayat_dari" placeholder="Masukkan Tanggal">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="col-md-5 control-label">Tanggal Sampai</label>
							<div class="col-md-7">
								<input type="text" class="form-control datepicker2" id="riwayat_sampai" placeholder="Masukkan Tanggal">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<br>
						<button class="btn btn-info pull-right" onclick="cariTemuan()"><i class="fa fa-search"></i> Cari</button>
					</div>
					<div class="col-xs-12">
						<table class="table table-bordered" id="tableMasalah">
							<thead style="background-color: #d87cf7">
								<tr>
									<th style="width: 1%;">No.</th>
									<th style="width: 4%;">Tanggal</th>
									<th>Nama Molding</th>
									<th>Nama Part</th>
									<th>Permasalahan</th>
									<th>Perbaikan Sementara</th>
									<th>Note</th>
									<th style="width: 1%;">Status</th>
								</tr>
							</thead>
							<tbody id="bodyMasalah"></tbody>

						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ url("js/bootstrap-toggle.min.js") }}"></script>
<script src="{{ url("plugins/timepicker/bootstrap-timepicker.min.js")}}"></script>
<!-- <script src="{{ url("js/dataTables.buttons.min.js")}}"></script> -->
<!-- <script src="{{ url("js/buttons.flash.min.js")}}"></script> -->
<script src="{{ url("js/jszip.min.js")}}"></script>
<script src="{{ url("js/vfs_fonts.js")}}"></script>
<!-- <script src="{{ url("js/buttons.html5.min.js")}}"></script> -->
<!-- <script src="{{ url("js/buttons.print.min.js")}}"></script> -->
<!-- <script src="{{ url("js/popper.min.js")}}"></script> -->
<script src="{{ url("js/jquery.gritter.min.js") }}"></script>
<script src="{{ url("ckeditor/ckeditor.js") }}"></script>

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var check_point = <?php echo json_encode($check_points); ?>;
	var moldings = <?php echo json_encode($moldings); ?>;
	var part_status = [];
	var part_err = [];

	CKEDITOR.replace('permasalahan', {
		filebrowserImageBrowseUrl: '{{ url("kcfinder_master") }}',
		toolbar: [
			['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
			{
				name: 'basicstyles',
				items: ['Bold', 'Italic']
			},
			{
				name: 'document',
				items: ['Source']
			},
			{
				name: 'tools',
				items: ['Maximize']
			}
		],
		height: 100
	});

	CKEDITOR.replace('perbaikan_sementara', {
		filebrowserImageBrowseUrl: '{{ url("kcfinder_master") }}',
		toolbar: [
			['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
			{
				name: 'basicstyles',
				items: ['Bold', 'Italic']
			},
			{
				name: 'document',
				items: ['Source']
			},
			{
				name: 'tools',
				items: ['Maximize']
			}
		],
		height: 100
	});

	CKEDITOR.replace('note', {
		filebrowserImageBrowseUrl: '{{ url("kcfinder_master") }}',
		toolbar: [
			['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
			{
				name: 'basicstyles',
				items: ['Bold', 'Italic']
			},
			{
				name: 'document',
				items: ['Source']
			},
			{
				name: 'tools',
				items: ['Maximize']
			}
		],
		height: 100
	});

	jQuery(document).ready(function() {
		$("#wrapper").toggleClass("toggled");
		$('#molding_select').modal('show');
		$('.select2').select2({
			dropdownAutoWidth: true,
			allowClear: true,
			dropdownParent: $('#molding_select')
		});

		$('.select3').select2({
			minimumResultsForSearch: -1,
			dropdownAutoWidth: true,
			allowClear: true
		});

		$('.select4').select2({
			dropdownAutoWidth: true,
			dropdownParent: $('#modal_history')
		});

		$('.select5').select2({
			dropdownAutoWidth: true,
			dropdownParent: $('#status_div')
		});

		$('.datepicker2').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
		});
	})

	function selectMolding() {
		if ($("#moldings").val() == '' || $("#pic").val() == '') {
			openErrorGritter('Gagal', 'Pilih PIC dan Molding');
			return false;
		}

		$("#molding_select").modal('hide');
		$("#molding_name").text($("#moldings").val());
		$("#employee_name").text($("#pic").val() + ' - ' + $("#pic option:selected").text());
		var type = '';

		$.each(moldings, function(index, value) {
			if (value.molding_name == $("#moldings").val()) {
				type = value.molding_type;
			}
		})

		$("#type_molding").val(type);
	}

	function add_point() {
		var body = '';

		body += '<tr>';
		body += '<td>';
		body += '<select class="form-control select3 part" data-placeholder="Pilih Part" style="width: 100%;">';
		body += '<option value=""></option>';
		body += '<option value="tes">tes</option>';
		body += '<option value="tes2">tes2</option>';
		body += '</select>';
		body += '</td>';
		body += '<td>';
		body += '<select class="form-control select3 cek_poin" data-placeholder="Pilih Poin Cek" style="width: 100%;" onchange="changeCek(this)">';
		body += '<option></option>';
		$.each(check_point, function(index, value) {
			body += '<option value="' + value.check_point + '">' + value.poin_cek + '</option>';
		})
		body += '</select>';
		body += '</td>';
		body += '<td class="standar">';
		body += '</td>';
		body += '<td class="cara_cek">';
		body += '</td>';
		body += '<td class="penanganan">';
		body += '</td>';
		body += '<td style="font-weight: bold">';

		body += '<span class="text-red">*</span> Foto Before : <br>';
		body += '<input type="file" class="before1" onchange="readURL(this,\'img_before1\');" accept="image/*" style="display: none"> <input type="file" class="before2" onchange="readURL(this,\'img_before2\');" accept="image/*" style="display: none">';
		body += '<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,\'before1\')"><i class="fa fa-camera"></i> Photo 1</button>&nbsp;<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,\'before2\')"><i class="fa fa-camera"></i> Photo 2</button> <br>';
		body += '<img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_before1">&nbsp; <img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_before2"><hr>';

		body += '<span class="text-red">*</span> Foto After : <br>';
		body += '<input type="file" class="after1" style="display: none" onchange="readURL(this,\'img_after1\');" accept="image/*"> <input type="file" class="after2" style="display: none" onchange="readURL(this,\'img_after2\');" accept="image/*">';
		body += '<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,\'after1\')"><i class="fa fa-camera"></i> Photo 1</button>&nbsp;<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,\'after2\')"><i class="fa fa-camera"></i> Photo 2</button> <br>';
		body += '<img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_after1">&nbsp; <img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_after2"><hr>';

		body += 'Aktifitas Pekerjaan : <br>';
		body += '<input type="file" class="aktifitas1" onchange="readURL(this,\'img_aktifitas1\');" accept="image/*" style="display: none"> <input type="file" class="aktifitas2" onchange="readURL(this,\'img_aktifitas2\');" accept="image/*" style="display: none">';
		body += '<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,\'aktifitas1\')"><i class="fa fa-camera"></i> Photo 1</button>&nbsp;<button class="btn btn-primary" style="width : 49%" onclick="buttonImage(this,\'aktifitas2\')"><i class="fa fa-camera"></i> Photo 2</button> <br>';
		body += '<img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_aktifitas1">&nbsp; <img src="" style="display: none;width: 48%; margin-top: 2px" alt="your image" class="img_aktifitas2">';
		body += '</td>';

		body += '<td>';
		body += '<select class="form-control select3 judgement" data-placeholder="Judgement" style="width: 100%;">';
		body += '<option value=""></option>';
		body += '<option value="OK">OK</option>';
		body += '<option value="NG">NG</option>';
		body += '</select>';
		body += '</td>';
		body += '<td>';
		body += '<button class="btn btn-danger" onclick="delete_cek(this)" style="margin-bottom: 3px"><i class="fa fa-trash"></i></button>';
		body += '<button class="btn btn-warning btn_problem" onclick="modal_problem(this)"><i class="fa fa-exclamation-triangle"></i></button>';
		body += '</td>';
		body += '</tr>';

		$("#body_cek").append(body);

		$('.select3').select2({
			minimumResultsForSearch: -1,
			dropdownAutoWidth: true,
			allowClear: true
		});

	}

	function buttonImage(elem, cls) {
		$(elem).parent().find("." + cls).click();
	}

	function changeCek(elem) {
		$.each(check_point, function(index, value) {
			if ($(elem).val() == value.check_point) {
				$(elem).parent().parent().children(".standar").text(value.std);
				$(elem).parent().parent().children(".cara_cek").text(value.how);
				$(elem).parent().parent().children(".penanganan").text(value.handle2);
			}
		})
	}

	function cek() {
		$("#loading").show();

		var formData = new FormData();

		var part = [];
		var cek_poin = [];
		var judgement = [];

		var status = true;
		var status2 = true;
		$('.part').each(function(i, obj) {
			if ($(obj).val() == '') {
				status = false;
			}
			part.push($(obj).val());
		});

		if (!status) {
			openErrorGritter('Gagal', 'Lengkapi Semua Kolom Part');
			$("#loading").hide();
			return false;
		}

		$('.cek_poin').each(function(i, obj) {
			if ($(obj).val() == '') {
				status = false;
			}

			cek_poin.push($(obj).val());
		});

		if (!status) {
			openErrorGritter('Gagal', 'Lengkapi Semua Kolom Cek Poin');
			$("#loading").hide();
			return false;
		}

		$('.before1').each(function(i, obj) {
			if (typeof $(obj).prop('files')[0] === 'undefined') {
				status = false;
			}

			formData.append('before1_' + i, $(obj).prop('files')[0]);
		});

		$('.before2').each(function(i, obj) {
			if (typeof $(obj).prop('files')[0] === 'undefined') {
				status = false;
			}

			formData.append('before2_' + i, $(obj).prop('files')[0]);
		});

		if (!status) {
			openErrorGritter('Gagal', 'Lengkapi Semua Foto Before');
			$("#loading").hide();
			return false;
		}

		$('.after1').each(function(i, obj) {
			if (typeof $(obj).prop('files')[0] === 'undefined') {
				status = false;
			}

			formData.append('after1_' + i, $(obj).prop('files')[0]);
		});

		$('.after2').each(function(i, obj) {
			if (typeof $(obj).prop('files')[0] === 'undefined') {
				status = false;
			}

			formData.append('after2_' + i, $(obj).prop('files')[0]);
		});

		if (!status) {
			openErrorGritter('Gagal', 'Lengkapi Semua Foto After');
			$("#loading").hide();
			return false;
		}

		$('.aktifitas1').each(function(i, obj) {
			formData.append('aktifitas1_' + i, $(obj).prop('files')[0]);
		});

		$('.aktifitas2').each(function(i, obj) {
			formData.append('aktifitas2_' + i, $(obj).prop('files')[0]);
		});

		$('.judgement').each(function(i, obj) {
			if ($(obj).val() == '') {
				status = false;
			}

			judgement.push($(obj).val());

			if ($(obj).val() == 'NG') {
				// part_status

				var prt = $('.part').eq(i).val();
				if (!findItem(part_status, prt)) {
					part_err.push(prt);
					status2 = false;
				}
			}

		});

		if (!status2) {
			openErrorGritter('Gagal', 'Lengkapi Form Temuan untuk Part berikut : ' + part_err.join(", "));
			$("#loading").hide();
			return false;
		}

		if (!status) {
			openErrorGritter('Gagal', 'Lengkapi Semua Kolom Judgement');
			$("#loading").hide();
			return false;
		}

		formData.append('date', '{{ date("Y-m-d") }}');
		formData.append('molding_name', $('#molding_name').text());
		formData.append('pic', $('#employee_name').text());
		formData.append('location', $('#location').text());
		formData.append('part', part);
		formData.append('cek_poin', cek_poin);
		formData.append('judgement', judgement);
		formData.append('molding_type', $("#type_molding").val());

		$.ajax({
			url: "{{ url('post/workshop/check_molding_vendor') }}",
			method: "POST",
			data: formData,
			dataType: 'JSON',
			contentType: false,
			cache: false,
			processData: false,
			success: function(response) {
				$("#loading").hide();

				openSuccessGritter('Success', 'Pengecekan Berhasil Tersimpan');

				$("#body_cek").empty();
			},
			error: function(response) {
				$("#loading").hide();

				openErrorGritter('Error!', response.message);
			},
		})

	}

	function fetchDetailRecord() {
		$('#loading').show();
		var date_from = $('#date_from').val();
		var date_to = $('#date_to').val();
		var moldings = $('#molding_select').val();
		var pics = $('#molding_select').val();

		var data = {
			date_from: date_from,
			date_to: date_to,
			moldings: moldings
		}
		$.get('{{ url("fetch/workshop/check_molding_vendor/record") }}', data, function(result, status, xhr) {
			if (result.status) {
				$('#bodyTableDetail').empty();
				var tableData = "";

				$.each(result.datas, function(key, value) {
					tableData += '<tr>';
					tableData += '<td>' + value.id + '</td>';
					tableData += '<td>' + value.check_date + '</td>';
					tableData += '<td>' + value.molding_name + '</td>';

					var nama = value.pic;
					$.each(result.employees, function(key2, value2) {
						if (value.pic == value2.employee_id) {
							nama = value2.name
						}
					})

					tableData += '<td>' + nama + '</td>';
					tableData += '<td>' + value.point_check + '</td>';
					tableData += '<td><img style="max-width: 90px; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/check_att") }}/' + value.photo_before1 + '" alt="">';
					tableData += '<img style="max-width: 90px; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/check_att") }}/' + value.photo_before2 + '" alt=""></td>';

					tableData += '<td><img style="max-width: 90px; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/check_att") }}/' + value.photo_after1 + '" alt="">';
					tableData += '<img style="max-width: 90px; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/check_att") }}/' + value.photo_after2 + '" alt=""></td>';

					tableData += '<td><img style="max-width: 90px; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/check_att") }}/' + value.photo_activity1 + '" alt="">';
					tableData += '<img style="max-width: 90px; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/check_att") }}/' + value.photo_activity2 + '" alt=""></td>';

					tableData += '<td>' + value.judgement + '</td>';
					tableData += '<td>' + value.status + '</td>';
					tableData += '</tr>';
				});

				$('#bodyTableDetail').append(tableData);
				$('#loading').hide();
			} else {
				$('#loading').hide();
				openErrorGritter('Error', result.message);
			}
		});
	}

	function readURL(input, idfile) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				var img = $(input).closest("td").find("." + idfile);
				$(img).show();
				$(img).attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

	function readURL2(input, idfile) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				var img = $(input).parent().find("." + idfile);
				$(img).show();
				$(img).attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

	function simpanTemuan() {
		if (CKEDITOR.instances.permasalahan.getData() == '' || CKEDITOR.instances.perbaikan_sementara.getData() == '' || $("#status").val() == '') {
			openErrorGritter('Gagal', 'Mohon lengkapi semua kolom');
			return false;
		}

		$('#loading').show();
		var formData = new FormData();
		formData.append('date', '{{ date("Y-m-d") }}');
		formData.append('pic', $("#employee_name").text());
		formData.append('molding_name', $("#nama_molding").val());
		formData.append('part_name', $("#nama_part").val());
		formData.append('problem', CKEDITOR.instances.permasalahan.getData());
		formData.append('handling_temporary', CKEDITOR.instances.perbaikan_sementara.getData());
		formData.append('notes', CKEDITOR.instances.note.getData());
		formData.append('status', $("#status").val());

		$('#permasalahan1').each(function(i, obj) {
			formData.append('permasalahan1', $(obj).prop('files')[0]);
		});

		$('#permasalahan2').each(function(i, obj) {
			formData.append('permasalahan2', $(obj).prop('files')[0]);
		});

		$('#perbaikan1').each(function(i, obj) {
			formData.append('perbaikan1', $(obj).prop('files')[0]);
		});

		$('#perbaikan2').each(function(i, obj) {
			formData.append('perbaikan2', $(obj).prop('files')[0]);
		});

		$.ajax({
			url: "{{ url('post/workshop/check_molding_vendor/temuan') }}",
			method: "POST",
			data: formData,
			dataType: 'JSON',
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				if (data.status) {
					part_status.push({
						'part': $("#nama_part").val(),
						'status': $("#status").val()
					});
					openSuccessGritter('Success', data.message);
					$('#loading').hide();
					$('#modal_problem').modal('hide');
				} else {
					openErrorGritter('Error!', data.message);
					$('#loading').hide();
				}

			}
		});

	}

	function delete_cek(elem) {
		$(elem).closest('tr').remove();
	}

	function modal_problem(elem) {
		$("#modal_problem").modal('show');
		$("#nama_molding").val($("#molding_name").text());
		$("#nama_part").val($(elem).parent().parent().children(':first-child').find('.part').val());
	}

	function cariTemuan() {
		// tableMasalah
		$("#bodyMasalah").empty();
		body = '';

		var data = {
			date_from: $("#riwayat_dari").val(),
			date_to: $("#riwayat_sampai").val()
		}

		$.get('{{ url("fetch/workshop/check_molding_vendor/temuan") }}', data, function(result, status, xhr) {
			if (result.status) {
				$.each(result.datas, function(index, value) {
					body += "<tr>";
					body += "<td>" + (index + 1) + "</td>";
					body += "<td>" + value.check_date + "</td>";
					body += "<td>" + value.molding_name + "</td>";
					body += "<td>" + value.part_name + "</td>";
					body += "<td>" + value.problem + "<br>";

					var problem_att = value.problem_att.split(",");
					body += '<img style="max-width: 50%; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/problem_att") }}/' + problem_att[0] + '" alt="">';
					body += '<img style="max-width: 50%; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/problem_att") }}/' + problem_att[1] + '" alt="">';
					body += "</td>";
					body += "<td>" + value.handling_temporary + "<br>";

					var handling_att = value.handling_att.split(",");
					body += '<img style="max-width: 50%; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/problem_att") }}/' + handling_att[0] + '" alt="">';
					body += '<img style="max-width: 50%; margin-bottom: 20px" src="{{ url("workshop/Audit_Molding/Check_Molding/problem_att") }}/' + handling_att[1] + '" alt="">';
					body += "</td>";
					body += "<td>" + (value.note_problem || "") + "</td>";

					var label = '';

					if (value.status == "Open")
						label = 'badge-danger';
					else if (value.status == "Temporary Close")
						label = 'badge-warning';
					else
						label = 'badge-success';

					body += "<td><center><span class='badge " + label + "'>" + value.status + "</span></center></td>";
					body += "</tr>";
				})

				$("#bodyMasalah").append(body);
			} else {
				openErrorGritter('Error', result.message);
			}
		})
	}

	function openModal(nama_modal) {
		$("#" + nama_modal).modal('show');
	}

	function openSuccessGritter(title, message) {
		jQuery.gritter.add({
			title: title,
			text: message,
			class_name: 'growl-success',
			image: '{{ url("images/image-screen.png") }}',
			sticky: false,
			time: '2000'
		});
	}

	function openErrorGritter(title, message) {
		jQuery.gritter.add({
			title: title,
			text: message,
			class_name: 'growl-danger',
			image: '{{ url("images/image-stop.png") }}',
			sticky: false,
			time: '2000'
		});
		audio_error.play();
	}

	function findItem(array, value) {
		var stts = false;
		if (array.length > 0) {
			for (var i = 0; i < array.length; i++) {
				if (array[i].part == value) {
					stts = true;
					return stts;
				}
			}
			return stts;
		} else {
			return stts;
		}
	}

	var audio_error = new Audio('{{ url("sounds/error.mp3") }}');
</script>
@endsection