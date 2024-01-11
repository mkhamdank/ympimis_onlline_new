@extends('layouts.master')
@section('stylesheets')
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<style type="text/css">
	h5 {
		margin-bottom: 0px;
	}
	td:hover {
		background-color: #ddd;
		cursor: pointer;
	}

	#left {
		height:450px;
		overflow-y: scroll;
	}

	#right {
		height:450px;
		overflow-y: scroll;
	}

</style>
@stop
@section('header')
<section class="content-header">
	{{-- 	 @if (session('status'))
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-thumbs-o-up"></i> Success!</h4>
		{{ session('status') }}
	</div>   
	@endif --}}
	<h1>
		{{$title}}<span class="text-purple"> </span>
		<small><span class="text-purple"> {{$title_jp}}</span></small>
	</h1>
	<ol class="breadcrumb">
	</ol>
</section>
@stop
@section('content')
@php
$avatar = 'images/avatar/'.Auth::user()->avatar;
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="content">
	<div class="box box-solid">
		<div class="box-body">
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-3">
						<input type="text" id="search" class="form-control" placeholder="Search . . .">
					</div>
					<div class="col-xs-2">
						<select class="form-control select2" id="category" style="width: 100%;">
							<option value="">All</option>
							@foreach($all_question as $question)
							<option value="{{ $question->category }}">{{ $question->category }} ({{ $question->unanswer }})</option>
							@endforeach
						</select>
					</div>
					<div class="col-xs-2">
						<select class="form-control select2" id="order" style="width: 100%;">
							<option value="tanggal">Order by Date</option>
							<option value="unanswered">Order by Unanswered</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-xs-12" style="padding-top: 10px;">
				<div class="row">
					<div class="col-xs-3" id="left" style="padding: 0 5px 0 10px;">
						<table class="table table-responsive" id="tabel">
						</table>
					</div>
					<div class="col-xs-9" id="right">
						<div id="chat">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>

@endsection
@section('scripts')
<script src="{{ url("js/jquery.gritter.min.js") }}"></script>
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var emp = "";
	var saringan = "";
	var cat = "";
	var ordering = "tanggal";

	jQuery(document).ready(function() {
		$('.select2').select2();
		$('body').toggleClass("sidebar-collapse");
		getMasterQuestion("","","tanggal");

		$("#search").keypress(function() {
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				if ($('#category').val() != "") {
					cat = $('#category').val();
				}

				saringan = this.value;
				getMasterQuestion(saringan, cat, ordering);
			}
		});

		setInterval(check_chart, 10000);
	});

	$('#category').on('change', function() {
		cat = this.value;
		getMasterQuestion(saringan, cat, ordering);
	});

	$('#order').on('change', function() {
		ordering = this.value;
		getMasterQuestion(saringan, cat, ordering);
	});

	function check_chart() {
		if (!$(".komen").is(':focus')) {
			getMasterQuestion(saringan, cat, ordering);

			if (emp != "") {
				getDetailQuestion(emp);
				$("#"+emp).css("background-color","#ddd");
			}

		}
	}

	function getMasterQuestion(cat, cat2, order2) {
		var data = {
			filter:cat,
			ctg:cat2,
			order:order2
		}

		$.get('{{ url("fetch/hr/hrqa") }}', data,function(result, status, xhr){
			if (result.status) {
				var masterQuestion = "";
				$("#tabel").empty();

				$.each(result.question, function(index, value){
					masterQuestion += '<tr onclick="select(this)" class="chat" id="'+value.created_by+'" style="border-bottom:1px solid black">';
					masterQuestion += '<td>';
					masterQuestion += '<h5>'+value.created_by+' <span class="pull-right">'+value.created_at_new+'</span></h5>';

					var truncated = value.message;

					if (value.message.length > 35) {
						truncated = truncated.substr(0,35) + '...';
					}


					masterQuestion += '<span style="color: #666">'+truncated+'</span>';
					if (value.notif != 0) {
						masterQuestion += '<span class="pull-right badge bg-purple">'+value.notif+'</span>';
					}
					masterQuestion += '</td></tr>';
				})

				$("#tabel").append(masterQuestion);
			}
		})
	}

	function select(elem) {
		$(".chat").css("background-color","white");
		$(elem).css("background-color","#ddd");
		var id = $(elem).attr('id');
		getDetailQuestion(id);
		emp = id;
	}

	function getDetailQuestion(id) {
		var data = {
			employee_id: id
		}

		$.get('{{ url("fetch/chat/hrqa") }}', data, function(result, status, xhr){
			if(result.status){
				$("#chat").html("");
				var xCategories2 = [];

				for(var i = 0; i < result.chats.length; i++){
					ctg = result.chats[i].id+"_"+result.chats[i].message+"_"+result.chats[i].category+"_"+result.chats[i].created_at_new;

					if(xCategories2.indexOf(ctg) === -1){
						xCategories2[xCategories2.length] = ctg;
					}
				}

				$.each(xCategories2, function(index, value){
					var chat_history = "";
					var chats = value.split("_");
					chat_history += '<div class="post">';
					chat_history += '<div class="user-block">'
					chat_history += '<img class="img-circle img-bordered-sm" src="'+result.base_avatar+'/'+id.split("_")[0]+'.jpg" alt="image">';
					chat_history += '<span class="username">'+id+'</span>';
					chat_history += '<span class="description"><b>'+chats[2]+'</b> - '+chats[3]+'</span></div>';
					chat_history += '<p>'+chats[1]+'</p>';

					var stat = 0;
					var rev = 0;

					$.each(result.chats, function(index2, value2){
						if (chats[0] == value2.id) { 
							if (value2.message_detail) {
								if (stat == 0) {
									chat_history += '<div style="margin-left: 30px">';
								} else {
									chat_history += '<div>';
								}

								chat_history += '<div class="post">'
								chat_history += '<div class="user-block">';
								chat_history += '<img class="img-circle img-bordered-sm" src="'+result.base_avatar+'/'+value2.avatar+'.jpg" alt="image">';
								chat_history += '<span class="username">'+value2.dari+' &nbsp; ';
								chat_history += '<span style="color:#999; font-size:13px">'+value2.created_at_new+'</span></span>';

								var msg = value2.message_detail.replace(/\n/g, '<br>');
								chat_history += '<span class="description" style="color:#666; font-size:14px">'+msg+'</span></div>';
								console.log(msg);
								// chat_history += '<p>'+value2.message_detail+'</p>';

								stat = 1;

								if (typeof result.chats[index2+1] === 'undefined') {
									rev = 1;
									// chat_history += '<input class="form-control input-sm komen" type="text" placeholder="Type a comment" id="comment_'+value2.id+'"></div>';

									chat_history += '<textarea class="form-control input-sm komen" type="text" placeholder="Type a comment" id="comment_'+value2.id+'"></textarea></div>';
								} else {
									if (result.chats[index2].id != result.chats[index2+1].id) {
										rev = 1;
										// chat_history += '<input class="form-control input-sm komen" type="text" placeholder="Type a comment" id="comment_'+value2.id+'"></div>';
										chat_history += '<textarea class="form-control input-sm komen" type="text" placeholder="Type a comment" id="comment_'+value2.id+'"></textarea></div>';
									}
								}
							} else {
								if (rev == 0) {
									// chat_history += '<input class="form-control input-sm komen" type="text" placeholder="Type a comment" id="comment_'+value2.id+'">';	
									chat_history += '<textarea class="form-control input-sm komen" type="text" placeholder="Type a comment" id="comment_'+value2.id+'"></textarea>';	
								}
							}
						}

					})
					chat_history += '</div>';

					$("#chat").append(chat_history);
				})


				$( ".komen" ).keypress(function() {
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13'){
						if (event.shiftKey) {
							console.log('shifted');
						} else {
							if (this.value != "") {
								var id2 = this.id.split("_")[1];							
								var data = {
									id:id2,
									message:this.value,
									from:"HR"
								}

								$.post('{{ url("post/chat/comment") }}', data, function(result, status, xhr){
									if (result.status) {
										openSuccessGritter('Success', 'Comment Posted');
										$(this).val("");
										getDetailQuestion(emp);
									} else {
										openErrorGritter('Error', '');
									}
								})
							} else {
								alert('Komentar tidak boleh kosong'); 
							// openErrorGritter('Error', 'Komentar tidak boleh kosong');
						}
					}
				} 

				if (keycode == '13' && event.altKey) {
					this.value = this.value + "\r\n";
					console.log('tes');
				}
			});
			}
		})
}

function openDangerGritter(title, message){
	jQuery.gritter.add({
		title: title,
		text: message,
		class_name: 'growl-danger',
		image: '{{ url("images/image-stop.png") }}',
		sticky: false,
		time: '3000'
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

$('.datepicker').datepicker({
	autoclose: true,
	format: 'yyyy-mm-dd',
	todayHighlight: true
});

</script>
@endsection

