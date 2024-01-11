@extends('layouts.master')
@section('stylesheets')
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<style type="text/css">

</style>
@stop
@section('header')
<!-- <section class="content-header">
	<h1>
		{{ $title }}
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url("index/workshop/check_molding_vendor/create") }}" class="btn btn-primary" style="color: white"><i class="fa fa-plus"></i>Audit Molding</a>
		</li>
	</ol>
</section> -->
@stop
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<section class="content" style="padding: 10px">
    <div id="loading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(0,191,255); z-index: 30001; opacity: 0.8; display: none">
		<p style="position: absolute; color: white; top: 45%; left: 35%;">
			<span style="font-size: 40px">Loading, Please Wait . . . <i class="fa fa-spin fa-refresh"></i></span>
		</p>
	</div>

	<div class="row">
		<div class="col-md-10">
			<h1>
				{{ $title }}
			</h1>
		</div>
		<div class="col-md-2">
			<a href="{{ url('index/workshop/check_molding_vendor/create') }}" class="btn btn-primary pull-right" style="color: white"><i class="fa fa-plus"></i> Audit Molding</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<span style="font-weight: bold;">Tanggal Dari</span>
			<div class="form-group">
				<input type="text" class="form-control datepicker" id="datefrom" name="datefrom" placeholder="Select Date From" autocomplete="off">
			</div>
		</div>
		<div class="col-md-3">
			<span style="font-weight: bold;">Tanggal Sampai</span>
			<div class="form-group">
				<input type="text" class="form-control datepicker" id="dateto" name="dateto" placeholder="Select Date To" autocomplete="off">
			</div>
		</div>

		<div class="col-md-3">
			<span style="font-weight: bold;">Molding</span>
			<div class="form-group">
				<select class="form-control select2" style="width: 100%;" multiple="multiple" id='status' data-placeholder="Pilih Status">
					<option value="Open">Open</option>
					<option value="Temporary Close">Temporary Close</option>
					<option value="In-Progress">In-Progress</option>
					<option value="Close">Close</option>
				</select>
			</div>
		</div>

		<div class="col-md-3">
			<span>&nbsp;</span>
			<div class="form-group">
				<button class="btn btn-primary" onclick="drawChart()"><i class="fa fa-search"></i> Cari</button>
			</div>
		</div>
		<div class="col-md-3">
			<span>&nbsp;</span>
			<div class="form-group">
				<button class="btn btn-primary" onclick="drawChart()"><i class="fa fa-file-excel-o"></i> Export</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="chart_kategori" style="width: 100%; height: 300px; margin-top: 5px"></div>
		</div>
		<div class="col-md-12">
			<br>
			<h3 style="text-align: center; margin-bottom: 0px; background-color: #9e83a7; padding : 7px 0 7px 0;">
				OUTSTANDING TEMUAN
				<button class="btn btn-info pull-right" onclick="filter_data('','')" style="padding: 2px 12px 2px 12px; margin-right: 7px; color: white"><i class="fa fa-refresh"></i> refresh</button>
			</h3>
			<table class="table table-stripped table-bordered" id="table_penanganan">
				<thead style="background-color: #9e83a7; color: #000; font-size: 16px;font-weight: bold">
					<tr>
						<th>
							<center>No</center>
						</th>
						<th>
							<center>Tanggal</center>
						</th>
						<th>
							<center>Nama Molding</center>
						</th>
						<th>
							<center>Nama Part</center>
						</th>
						<th>
							<center>Permasalahan</center>
						</th>
						<th>
							<center>PIC</center>
						</th>
						<th>
							<center>Status</center>
						</th>
						<th>
							<center>Aksi</center>
						</th>
					</tr>
				</thead>
				<tbody id="body_penanganan"></tbody>
			</table>
		</div>
	</div>
</section>

<div class="modal modal-default fade" id="modal_penanganan">
	<div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					<center>Penanganan Temuan</center>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="col-md-5 control-label">Tanggal</label>
							<div class="col-md-5">
								<input type="hidden" id="ids">
								<input type="text" class="form-control" id="tanggal" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-5 control-label">PIC</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="pic" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-5 control-label">Permasalahan</label>
							<div class="col-md-12">
								<textarea id="permasalahan" class="form-control" readonly></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-5 control-label">Status <span class="text-red">*</span></label>
							<div class="col-md-5">
								<select class="select3" id="status_problem" style="width: 100%" data-placeholder="Pilih Status">
									<option value=""></option>
									<option value="Open">Open</option>
									<option value="Temporary Close">Temporary Close</option>
									<option value="Close">Close</option>
								</select>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="col-md-5 control-label">Nama Molding</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="molding_name" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-5 control-label">Nama Part</label>
							<div class="col-md-9">
								<input type="text" class="form-control" id="part_name" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-5 control-label">Penanganan Sementara</label>
							<div class="col-md-12">
								<textarea id="temp_penanganan" class="form-control" readonly></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="col-md-5 control-label">Perbaikan <span class="text-red">*</span></label>
							<div class="col-md-12">
								<textarea id="perbaikan" class="form-control"></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="col-md-5 control-label">Perbaikan Foto <span class="text-red">*</span></label>
							<div class="col-md-12">	
								<input type="file" accept="image/*" id="perbaikan1"> <br><br>
								<input type="file" accept="image/*" id="perbaikan2">
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<button class="btn btn-success" onclick="simpanPenanganan()"><i class="fa fa-check"></i> Simpan Penanganan</button>
						</div>
						<hr>
					</div>

					<div class="col-md-12">
						<br>
						<h4>Riwayat Perbaikan</h4>
						<table class="table table-bordered" style="width: 100%" id="tableRiwayat">
							<thead style="background-color: #9e83a7; color: #000;">
								<tr>
									<th width='1%'>No</th>
									<th width='8%'>Tanggal Perbaikan</th>
									<th width='10%'>Status</th>
									<th>Perbaikan</th>
									<th width='40'>Foto Perbaikan</th>
								</tr>
							</thead>
							<tbody id="bodyRiwayat"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ url('js/jquery.gritter.min.js') }}"></script>
<script src="{{ url('js/highcharts.js')}}"></script>
<script src="{{ url('ckeditor/ckeditor.js') }}"></script>

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var data_all = [];
	jQuery(document).ready(function() {
		$('body').toggleClass("sidebar-collapse");

		drawChart();

		$('.select2').select2({
			allowClear: true
		});

		$('.select3').select2({
			dropdownAutoWidth: true,
			allowClear: true,
			dropdownParent: $('#modal_penanganan')
		});

		$('.datepicker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
		});
	});

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

	CKEDITOR.replace('temp_penanganan', {
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

	CKEDITOR.replace('perbaikan', {
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


	function drawChart() {
		var datefrom = $('#datefrom').val();
		var dateto = $('#dateto').val();
		var status = $('#status').val();

		var data = {
			datefrom: datefrom,
			dateto: dateto,
			status: status,
		};

		$.get('{{ url("fetch/workshop/check_molding_vendor/monitoring") }}', data, function(result, status, xhr) {
			if (result.status) {

				var kategori = [];
				var open = [];
				var close = [];
				var temp_close = [];
				var inprogress = [];
				var temp_datas = [];

				$.each(result.datas, function(key, value) {
					if (kategori.indexOf(value.check_date) === -1) {
						kategori[kategori.length] = value.check_date;
					}
				});

				$.each(kategori, function(key, value) {
					temp_datas.push({
						'tanggal': value,
						'temp_close': 0,
						'close': 0,
						'open': 0,
						'inprogress': 0
					});
				})

				$.each(result.datas, function(key, value) {
					$.each(temp_datas, function(key2, value2) {
						if (value.check_date == value2.tanggal) {
							if (value.status == 'Close') {
								value2.close = value.jml;
							} else if (value.status == 'Temporary Close') {
								value2.temp_close = value.jml;
							} else if (value.status == 'Open') {
								value2.open = value.jml;
							} else if (value.status == 'In-Progress') {
								value2.inprogress = value.jml;
							}
						}
					})
				});

				$.each(temp_datas, function(key, value) {
					close.push(parseInt(value.close));
					temp_close.push(parseInt(value.temp_close));
					open.push(parseInt(value.open));
					inprogress.push(parseInt(value.inprogress));
				});

				$('#chart_kategori').highcharts({
					chart: {
						type: 'column',
						backgroundColor: "#fff"
					},
					title: {
						text: "Resume Audit Molding",
						style: {
							color: '#000',
							fontWeight: 'Bold'
						}
					},
					xAxis: {
						type: 'category',
						categories: kategori,
						lineWidth: 2,
						lineColor: '#9e9e9e',
						gridLineWidth: 1,
						labels: {
							style: {
								color: '#000',
								fontSize: '14px'
							}
						}
					},
					yAxis: {
						lineWidth: 2,
						lineColor: '#fff',
						type: 'linear',
						title: {
							text: 'Total Temuan',
							style: {
								color: '#000'
							}
						},
						stackLabels: {
							enabled: true,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
							}
						}
					},
					legend: {
						itemStyle: {
							color: "#111",
							fontSize: "12px"
						}
					},
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										filter_data(this.category, this.series.name);
									}
								}
							},
							dataLabels: {
								enabled: false,
								format: '{point.y}',
								style: {
									color: "#000"
								}
							}
						},
						column: {
							color: Highcharts.ColorString,
							stacking: 'percent',
							pointPadding: 0.93,
							groupPadding: 0.93,
							borderWidth: 1,
							dataLabels: {
								enabled: true
							}
						}
					},
					credits: {
						enabled: false
					},

					tooltip: {
						formatter: function() {
							return this.series.name + ' : ' + this.y;
						}
					},
					series: [{
							name: 'Open',
							data: open,
							color: "#dd4b39"
						},
						{
							name: 'In-Progress',
							data: inprogress,
							color: "#3889f2"
						},
						{
							name: 'Temporary Close',
							data: temp_close,
							color: "#f39c12"
						},
						{
							name: 'Close',
							data: close,
							color: "#78e04f"
						}
					]
				})

				$("#body_penanganan").empty();
				body = '';
				data_all = result.data_all;
				$.each(result.data_all, function(key, value) {
					if (status == '') {
						if (value.status == "Open" || value.status == "Temporary Close" || value.status == "In-Progress") {
							body += '<tr>';
							body += '<td>' + (key + 1) + '</td>';
							body += '<td>' + value.check_date + '</td>';
							body += '<td>' + value.molding_name + '</td>';
							body += '<td>' + value.part_name + '</td>';
							body += '<td>' + value.problem + '</td>';
							body += '<td>' + value.pic + '</td>';

							var label = '';

							if (value.status == "Open")
								label = 'badge-danger';
							else if (value.status == "Temporary Close")
								label = 'badge-warning';
							else if (value.status == "In-Progress")
								label = 'badge-primary';
							else
								label = 'badge-success';

							body += "<td><center><span class='badge " + label + "'>" + value.status + "</span></center></td>";
							body += "<td>";
							body += "<button class='btn btn-primary'><i class='fa fa-info'></i> Details</button><br>";

							if (value.status == "Open" || value.status == "Temporary Close" || value.status == "In-Progress") {
								body += "<button class='btn btn-success' style='margin-top : 3px' onclick='penangananModal(" + value.id + ")'><i class='fa fa-edit'></i> Penanganan</button>";
							}
							body += "</td>";
							body += '</tr>';
						}
					} else {
						body += '<tr>';
						body += '<td>' + (key + 1) + '</td>';
						body += '<td>' + value.check_date + '</td>';
						body += '<td>' + value.molding_name + '</td>';
						body += '<td>' + value.part_name + '</td>';
						body += '<td>' + value.problem + '</td>';
						body += '<td>' + value.pic + '</td>';

						var label = '';

						if (value.status == "Open")
							label = 'badge-danger';
						else if (value.status == "Temporary Close")
							label = 'badge-warning';
						else if (value.status == "In-Progress")
							label = 'badge-primary';
						else
							label = 'badge-success';

						body += "<td><center><span class='badge " + label + "'>" + value.status + "</span></center></td>";
						body += "<td>";
						body += "<button class='btn btn-primary'><i class='fa fa-info'></i> Details</button><br>";

						if (value.status == "Open" || value.status == "Temporary Close" || value.status == "In-Progress") {
							body += "<button class='btn btn-success' style='margin-top : 3px' onclick='penangananModal(" + value.id + ")'><i class='fa fa-edit'></i> Penanganan</button>";
						}
						body += "</td>";
						body += '</tr>';
					}

				})

				$("#body_penanganan").append(body);
			} else {
				alert('Attempt to retrieve data failed');
			}
		})
	}

	function filter_data(tanggal, stat) {
		$("#body_penanganan").empty();

		body = '';
		$.each(data_all, function(key, value) {
			if (tanggal != '' && stat != '') {
				if (value.status == stat && value.check_date == tanggal) {
					body += '<tr>';
					body += '<td>' + (key + 1) + '</td>';
					body += '<td>' + value.check_date + '</td>';
					body += '<td>' + value.molding_name + '</td>';
					body += '<td>' + value.part_name + '</td>';
					body += '<td>' + value.problem + '</td>';
					body += '<td>' + value.pic + '</td>';

					var label = '';

					if (value.status == "Open")
						label = 'badge-danger';
					else if (value.status == "Temporary Close")
						label = 'badge-warning';
					else if (value.status == "In-Progress")
						label = 'badge-primary';
					else
						label = 'badge-success';

					body += "<td><center><span class='badge " + label + "'>" + value.status + "</span></center></td>";
					body += "<td>";
					body += "<button class='btn btn-primary'><i class='fa fa-info'></i> Details</button><br>";

					if (value.status == "Open" || value.status == "Temporary Close" || value.status == "In-Progress") {
						body += "<button class='btn btn-success' style='margin-top : 3px' onclick='penangananModal(" + value.id + ")'><i class='fa fa-edit'></i> Penanganan</button>";
					}
					body += "</td>";
					body += '</tr>';
				}
			} else {
				body += '<tr>';
				body += '<td>' + (key + 1) + '</td>';
				body += '<td>' + value.check_date + '</td>';
				body += '<td>' + value.molding_name + '</td>';
				body += '<td>' + value.part_name + '</td>';
				body += '<td>' + value.problem + '</td>';
				body += '<td>' + value.pic + '</td>';

				var label = '';

				if (value.status == "Open")
					label = 'badge-danger';
				else if (value.status == "Temporary Close")
					label = 'badge-warning';
				else if (value.status == "In-Progress")
					label = 'badge-primary';
				else
					label = 'badge-success';

				body += "<td><center><span class='badge " + label + "'>" + value.status + "</span></center></td>";
				body += "<td>";
				body += "<button class='btn btn-primary'><i class='fa fa-info'></i> Details</button><br>";

				if (value.status == "Open" || value.status == "Temporary Close" || value.status == "In-Progress") {
					body += "<button class='btn btn-success' style='margin-top : 3px' onclick='penangananModal(" + value.id + ")'><i class='fa fa-edit'></i> Penanganan</button>";
				}
				body += "</td>";
				body += '</tr>';
			}

		})

		$("#body_penanganan").append(body);
	}

	function simpanPenanganan() {
		$("#loading").show();
		var id = $("#ids").val();

		var formData = new FormData();			
		formData.append('finding_id', id);
		formData.append('check_date', $('#tanggal').val());
		formData.append('pic', $('#pic').val());
		formData.append('molding_name', $('#molding_name').val());
		formData.append('part_name', $('#part_name').val());
		formData.append('status', $('#status_problem').val());
		formData.append('handling_note', CKEDITOR.instances.perbaikan.getData());

		formData.append('perbaikan1', $("#perbaikan1").prop('files')[0]);
		formData.append('perbaikan2', $("#perbaikan2").prop('files')[0]);

		$.ajax({
			url:"{{ url('post/workshop/check_molding_vendor/penanganan') }}",
			method:"POST",
			data:formData,
			dataType:'JSON',
			contentType: false,
			cache: false,
					processData: false,
					success: function (response) {
						$("#loading").hide();
						openSuccessGritter("Success", "Penanganan Berhasil Disimpan");
						$("#modal_penanganan").modal('hide');
					},
					error: function (response) {
						console.log(response.message);
					},
				})
	}

	function penangananModal(ids) {
		$("#modal_penanganan").modal('show');

		$.each(data_all, function(key, value) {
			if (value.id == ids) {
				$("#ids").val(ids);
				$("#tanggal").val(value.check_date);
				$("#pic").val(value.pic);
				$("#permasalahan").val(value.problem);
				$("#status_problem").val(value.status).trigger('change');
				$("#molding_name").val(value.molding_name)
				$("#part_name").val(value.part_name);
				CKEDITOR.instances['permasalahan'].setData(value.problem);
				CKEDITOR.instances['temp_penanganan'].setData(value.handling_temporary);
			}
		})

		$("#bodyRiwayat").empty();
		var body = '';

		var data = {
			id: ids
		};

		$.get('{{ url("fetch/workshop/check_molding_vendor/penanganan/log") }}', data, function(result, status, xhr) {
			$.each(result.datas, function(key, value) {
				body += '<tr>';
				body += '<td>'+(key+1)+'</td>';
				body += '<td>'+value.handling_date+'</td>';
				body += '<td>'+value.status+'</td>';
				body += '<td>'+value.handling_note+'</td>';
				body += '<td><img style="max-width:200px" src="{{ url("workshop/Audit_Molding/Check_Molding/handling_att") }}/'+value.handling_att1+'">&nbsp;<img style="max-width:200px" src="{{ url("workshop/Audit_Molding/Check_Molding/handling_att") }}/'+value.handling_att2+'"></td>';
				body += '</tr>';
			})

			$("#bodyRiwayat").append(body);
		})
	}
</script>
@endsection