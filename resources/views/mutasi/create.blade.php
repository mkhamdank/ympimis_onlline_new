@extends('layouts.master')
@section('stylesheets')
<link href="{{ url("css/jquery.gritter.css") }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url("plugins/timepicker/bootstrap-timepicker.min.css")}}">
<link rel="stylesheet" href="{{ url("css/bootstrap-datetimepicker.min.css")}}">
<style type="text/css">
    input {
        line-height: 22px;
    }
    thead>tr>th{
        text-align:center;
    }
    tbody>tr>td{
        text-align:center;
    }
    tfoot>tr>th{
        text-align:center;
    }
    td:hover {
        overflow: visible;
    }
    table.table-bordered{
        border:1px solid black;
    }
    table.table-bordered > thead > tr > th{
        border:1px solid black;
    }
    table.table-bordered > tbody > tr > td{
        border:1px solid rgb(211,211,211);
    }
    table.table-bordered > tfoot > tr > th{
        border:1px solid rgb(211,211,211);
    }
    #loadingscreen { display: none; }
</style>
@stop

@section('header')
<section class="content-header">
  <h1>
    Pengajuan Form Mutasi <span class="text-purple">突然変異フォームの提出</span>
  </h1>
  <ol class="breadcrumb">
  </ol>
</section>
@stop

@section('content')
<meta name="csrf-token">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="col-md-2">
        </div>
        <form class="form-horizontal" role="form" method="post" action="{{url('create/mutasi')}}">
            {{ csrf_field() }}
          <div class="box-body">
            <div class="col-md-12 col-md-offset-3">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">NIK</label>
                      <div class="col-sm-10">
                        <select class="form-control select2" id="employee_id" name="employee_id" data-placeholder='Pilih NIK' style="width: 100%" required onchange="checkEmp(this.value)">
                          <option value="">&nbsp;</option>
                          @foreach($user as $row)
                          <option value="{{$row->employee_id}}">{{$row->employee_id}} - {{$row->name}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>
                <div class="form-group" hidden="hidden">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label" id="labelnama">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" readonly>
                      </div>
                  </div>
                </div> 
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label" id="labeldept">Bagian</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="department" name="department" readonly>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label" id="labeldept">Section</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="section" name="section" readonly>
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label" id="labelposition">Jabatan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="position" name="position" readonly>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">Rekomendasi Atasan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="rekom" name="rekom" value="MUTASI INTERN DALAM SATU SEKSI" readonly>
                      </div> 
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">Ke Bagian</label>
                      <div class="col-sm-10">
                        <select class="form-control select2" id="ke_bagian" name="ke_bagian" data-placeholder='Pilih Bagian' style="width: 100%" required="">
                          <option value="">&nbsp;</option>
                          @foreach($dept as $row)
                          <option value="{{$row->department}}">{{$row->department}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">Section</label>
                      <div class="col-sm-10">
                        <select class="form-control select2" id="ke_section" name="ke_section" data-placeholder='Pilih Bagian' style="width: 100%" required="">
                          <option value="">&nbsp;</option>
                          @foreach($sect as $row)
                          <option value="{{$row->section}}">{{$row->section}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">Jabatan</label>
                      <div class="col-sm-10">
                        <select class="form-control select2" id="jabatan_bagian" name="jabatan_bagian" data-placeholder='Pilih Bagian' style="width: 100%" required="">
                          <option value="">&nbsp;</option>
                          @foreach($post as $row)
                          <option value="{{$row->position}}">{{$row->position}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">Tanggal Mutasi</label>
                      <div class="col-sm-10">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="tanggal" name="tanggal">
                        </div>                        
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row mb-3">
                  <label for="colFormLabel" class="col-sm-2 col-form-label">Alasan Mutasi</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                      </div>
                  </div>
                </div>
                <div class="form-group pull-right">
                  <br>
                  <a href="javascript:void(0)" onClick="clearConfirmation()" class="btn btn-danger">Clear</a>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function() {
        $('.select2').select2();
        $('body').toggleClass("sidebar-collapse");
        $('#labelnama').show();
        $('#name').show();
        $('#labeldept').show();
        $('#department').show();
        $('#labelposition').show();
        $('#position').show();
    });
    function checkEmp(value) {
        if (value.length == 9) {
            var data = {
                employee_id:$('#employee_id').val()
              }

              $.get('{{ url("dashboard/mutasi/get_employee") }}',data, function(result, status, xhr){
                  if(result.status){
                    $('#labelnama').show();
                    $('#name').show();
                    $('#labeldept').show();
                    $('#department').show();
                    $('#labelposition').show();
                    $('#position').show();
                    $.each(result.employee, function(key, value) {
                        $('#name').val(value.name);
                        $('#department').val(value.department);
                        $('#section').val(value.section);
                        $('#position').val(value.position);
                    });
                  }
                  else{
                    alert('NIK Tidak ditemukan');
                  }

              });
        }else{
            $('#labelnama').show();
            $('#name').show();
            $('#labeldept').show();
            $('#department').show();
            $('#labelposition').show();
            $('#position').show();
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('.select3').select2({
            dropdownParent: $('#modalDetail')
        });
    })

    $(function () {
        $('.select4').select2({
            dropdownParent: $('#modalCreate')
        });
    })

    var audio_error = new Audio('{{ url("sounds/error.mp3") }}');

    function openErrorGritter(title, message) {
        jQuery.gritter.add({
            title: title,
            text: message,
            class_name: 'growl-danger',
            image: '{{ url("images/image-stop.png") }}',
            sticky: false,
            time: '2000'
        });
    }

    function openSuccessGritter(title, message){
        jQuery.gritter.add({
            title: title,
            text: message,
            class_name: 'growl-success',
            image: '{{ url("images/image-screen.png") }}',
            sticky: false,
            time: '2000'
        });
    }

    var participants = [];

    function addGroup(id){
        var data = {
            id:id
        }
        $.get('{{ url("fetch/meeting/group") }}', data, function(result, status, xhr){
            if(result.status){
                $('#createSubject').val(result.groups[0].subject);
                $('#createDescription').val(result.groups[0].description);
                tableData = "";
                $.each(result.groups, function(key, value){
                    tableData += "<tr>";
                    tableData += "<tr id='rowParticipant"+value.employee_id+"'>";
                    tableData += "<td>"+value.employee_id+"</td>";
                    tableData += "<td>"+value.name+"</td>";
                    tableData += "<td>"+value.assignment+"</td>";
                    tableData += "<td>"+value.position+"</td>";
                    tableData += "<td>"+value.department+"</td>";
                    tableData += "<td>";
                    tableData += "<a href='javascript:void(0)' onclick='remParticipant(id)' id='"+value.employee_id+"' class='btn btn-danger btn-sm' style='margin-right:5px;'><i class='fa fa-trash'></i></a>";
                    tableData += "</td>";
                    tableData += "</tr>";
                    participants.push(value.employee_id);   
                });

                $('#tableParticipantBody').append(tableData);
                openSuccessGritter('Success!', result.message);
            }
            else{
                openErrorGritter('Error!', result.message);
            }
        });
    }

    function addParticipant(id){
        $('#loadingscreen').show();
        var assignment = $('#addAssignment').val();
        var position = $('#addPosition').val();
        var department = $('#addDepartment').val();
        var employee_id = $('#addEmployee').val();
        var data = {
            id:id,
            assignment:assignment,
            position:position,
            department:department,
            employee_id:employee_id
        }
        $.get('{{ url("fetch/meeting/add_participant") }}', data, function(result, status, xhr){
            if(result.status){
                $("#addAssignment").prop('selectedIndex', 0).change();
                $("#addPosition").prop('selectedIndex', 0).change();
                $("#addDepartment").prop('selectedIndex', 0).change();
                $("#addEmployee").prop('selectedIndex', 0).change();

                tableData = "";
                $.each(result.participants, function(key, value) {
                    tableData += "<tr id='rowParticipant"+value.employee_id+"'>";
                    tableData += "<td>"+value.employee_id+"</td>";
                    tableData += "<td>"+value.name+"</td>";
                    tableData += "<td>"+value.assignment+"</td>";
                    tableData += "<td>"+value.position+"</td>";
                    tableData += "<td>"+value.department+"</td>";
                    tableData += "<td>";
                    tableData += "<a href='javascript:void(0)' onclick='remParticipant(id)' id='"+value.employee_id+"' class='btn btn-danger btn-sm' style='margin-right:5px;'><i class='fa fa-trash'></i></a>";
                    tableData += "</td>";
                    tableData += "</tr>";
                    participants.push(value.employee_id);
                });

                $('#tableParticipantBody').append(tableData);
                $('#loadingscreen').hide();

                openSuccessGritter('Success!', 'Participant added');
            }
            else{
                $('#loadingscreen').hide();
                audio_error.play();
                openErrorGritter('Error!', result.message);
            }
        });
    }

    function remParticipant(id){
        $('#loadingscreen').show();
        var assignment = $('#addAssignment').val();
        var position = $('#addPosition').val();
        var department = $('#addDepartment').val();
        var employee_id = $('#addEmployee').val();
        var data = {
            id:id,
            assignment:assignment,
            position:position,
            department:department,
            employee_id:employee_id
        }
        $.get('{{ url("fetch/meeting/add_participant") }}', data, function(result, status, xhr){
            if(result.status){
                $.each(result.participants, function(key, value) {
                    $('#rowParticipant'+value.employee_id).remove();
                    participants.splice( $.inArray(value.employee_id, participants), 1 );
                });
                $('#loadingscreen').hide();
                openSuccessGritter('Success!', 'Participant removed');
            }
            else{
                $('#loadingscreen').hide();
                audio_error.play();
                openErrorGritter('Error!', result.message);
            }
        });
    }

    function deleteMeeting(){
        $('#loadingscreen').show();
        var id = $('#meetingId').val();
        var data = {
            id:id,
            cat:'meeting'
        }
        if(confirm("Are you sure you want to delete this meeting?")){
            $.post('{{ url("delete/meeting") }}', data, function(result, status, xhr) {
                if(result.status){
                    $('#loadingscreen').hide();
                    $('#rowMeeting'+id).remove();
                    $('#modalDetail').modal('hide');
                    openSuccessGritter('Success!', result.message);
                }
                else{
                    $('#loadingscreen').hide();
                    audio_error.play();
                    openErrorGritter('Error!', result.message);
                }
            });
        }
        else{
            $('#loadingscreen').hide();
            return false;
        }
    }

    function createMeeting(){
        $('#loadingscreen').show();
        var attendances = participants;
        var subject = $('#createSubject').val();
        var description = $('#createDescription').val();
        var location = $('#createLocation').val();
        var start_time = $('#createStart').val()+' '+$('#createStartTime').val();
        var end_time = $('#createEnd').val()+' '+$('#createEndTime').val();
        // alert(subject+' '+location+' '+start_time+' '+end_time);
        if(subject == "" || location == "" || start_time == "" || end_time == ""){
            openErrorGritter('Error!', 'All field must be filled')
            return false;
        }
        var data = {
            subject:subject,
            description:description,
            location:location,
            start_time:start_time,
            end_time:end_time,
            status:status,
            attendances:attendances
        }
        $.post('{{ url("create/meeting") }}', data, function(result, status, xhr){
            if(result.status){
                $('#loadingscreen').hide();
                $('#modalCreate').modal('hide');
                $('#createSubject').val("");
                $('#createDescription').val("");
                $('#createStart').val("");
                $('#createEnd').val("");
                $('#tableParticipant').html("");
                participants = [];
                fetchTable();
                openSuccessGritter('Success!', result.message)
            }
            else{
                $('#loadingscreen').hide();
                audio_error.play();
                openErrorGritter('Error!', result.message)
            }
        });
    }

    function editMeeting(){
        $('#loadingscreen').show();
        var id = $('#meetingId').val();
        var subject = $('#editSubject').val();
        var description = $('#editDescription').val();
        var location = $('#editLocation').val();
        var start_time = $('#editStart').val()+' '+$('#editStartTime').val();
        var end_time = $('#editEnd').val()+' '+$('#editEndTime').val();
        var status = $('#editStatus').val();
        if(subject == "" || location == "" || start_time == "" || end_time == "" || status == ""){
            audio_error.play();
            openErrorGritter('Error!', 'All field must be filled')
            return false;
        }
        var data = {
            id:id,
            subject:subject,
            description:description,
            location:location,
            start_time:start_time,
            end_time:end_time,
            status:status
        }
        $.post('{{ url("edit/meeting") }}', data, function(result, status, xhr) {
            if(result.status){
                $('#loadingscreen').hide();
                $('#modalDetail').modal('hide');
                fetchTable();
                openSuccessGritter('Success!', result.message);
            }
            else{
                $('#loadingscreen').hide();
                audio_error.play();
                openErrorGritter('Error!', result.message);
            }
        })
    }
    
    function clearConfirmation(){
        location.reload(true);
    }

    function deleteAudience(id, cat){
        $('#loadingscreen').show();
        var data = {
            id:id,
            cat:'audience'
        }
        if(confirm("Are you sure you want to delete this audience?")){
            $.post('{{ url("delete/meeting") }}', data, function(result, status, xhr) {
                if(result.status){
                    $('#loadingscreen').hide();
                    openSuccessGritter('Success!', result.message);
                    $('#rowAudience'+id).remove();
                }
                else{
                    $('#loadingscreen').hide();
                    audio_error.play();
                    openErrorGritter('Error!', result.message);
                }
            });
        }
        else{
            $('#loadingscreen').hide();
            return false;
        }
    }

    function download_files(files) {
        function download_next(i) {
            if (i >= files.length) {
                return;
            }
            var a = document.createElement('a');
            a.href = files[i].download;
            a.target = '_parent';
            if ('download' in a) {
                a.download = files[i].filename;
            }
            (document.body || document.documentElement).appendChild(a);
            if (a.click) {
                a.click();
            } else {
                $(a).click();
            }
            a.parentNode.removeChild(a);
            setTimeout(function() {
                download_next(i + 1);
            }, 500);
        }
        download_next(0);
    }

    function downloadPDF(id){
        $('#loadingscreen').show();
        var data = {
            id:id,
            cat:'pdf'
        }
        $.get('{{ url("download/meeting") }}', data, function(result, status, xhr) {
            if(result.status){
                openSuccessGritter('Success!', result.message);
                download_files(result.paths);
                $('#loadingscreen').hide();
            }
            else{
                openErrorGritter('Error!', result.message);
                $('#loadingscreen').hide();
            }
        });
    }

    function downloadExcel(id){
        $('#loadingscreen').show();
        var data = {
            id:id,
            cat:'xls'
        }
        $.get('{{ url("download/meeting") }}', data, function(result, status, xhr) {
            if(result.status){
                openSuccessGritter('Success!', result.message);
                download_files(result.paths);
                $('#loadingscreen').hide();
            }
            else{
                openErrorGritter('Error!', result.message);
                $('#loadingscreen').hide();
            }
        });     
    }

    function listAttendance(id){
        var url = "{{ url('index/meeting/attendance?id=') }}";
        window.open(url+id);
    }

    function fetchTable(){
        $('#loading2').show();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var location = $('#location').val();
        var status = $('#status').val();

        var data = {
            dateFrom:dateFrom,
            dateTo:dateTo,
            location:location,
            status:status
        }

        $.get('{{ url("fetch/meeting") }}', data, function(result, status, xhr) {
            if(result.status){
                var tableData = "";
                $('#tableBody').html("");

                if(result.meetings.length == 0){
                    audio_error.play();
                    openErrorGritter('Error!', 'No meeting found');
                    $('#loading2').hide();
                    return false;
                }

                $.each(result.meetings, function(key, value) {
                    tableData += "<tr id='rowMeeting"+value.id+"'>";
                    tableData += "<td>"+value.id+"</td>";
                    tableData += "<td>"+value.date+"</td>";
                    tableData += "<td>"+value.subject+"</td>";
                    tableData += "<td>"+value.location+"</td>";
                    tableData += "<td>"+value.name+"</td>";
                    tableData += "<td>"+value.duration+"</td>";
                    if(value.status == 'open'){
                        tableData += "<td style='background-color: RGB(204,255,255);'>"+value.status+"</td>";
                    }
                    else{
                        tableData += "<td style='background-color: RGB(255,204,255);'>"+value.status+"</td>";                       
                    }
                    tableData += "<td>";
                    tableData += "<button onclick='fetchDetail(id)' id='"+value.id+"' class='btn btn-warning btn-sm' style='margin-right:5px;'><i class='fa fa-pencil'></i></buton>";
                    tableData += "<button onclick='downloadPDF(id)' id='"+value.id+"' class='btn btn-danger btn-sm' style='margin-right:5px;' data-toggle='tooltip' title='Download PDF'><i class='fa fa-file-pdf-o'></i></buton>";
                    tableData += "<button onclick='downloadExcel(id)' id='"+value.id+"' class='btn btn-success btn-sm' style='margin-right:5px;' data-toggle='tooltip' title='Download Excel'><i class='fa fa-file-excel-o'></i></buton>";
                    tableData += "<button onclick='listAttendance(id)' id='"+value.id+"' class='btn btn-info btn-sm' style='margin-right:5px;'><i class='fa fa-users'></i></buton>";
                    tableData += "<button onclick='chartAttencance(id)' id='"+value.id+"' class='btn btn-primary btn-sm' style='margin-right:5px;'><i class='fa fa-bar-chart'></i></buton>";
                    tableData += "</td>";
                    tableData += "</tr>";
                });

                $('#loading2').hide();
                $('#tableBody').append(tableData);              
            }
            else{
                $('#loading2').hide();
                audio_error.play();
                openErrorGritter('Error!', 'Attempt to retrieve data failed');
            }   
        });
    }

    function listAudience(id){

    }

    function fetchDetail(id){
        var data = {
            id:id
        }

        $.get('{{ url("fetch/meeting/detail") }}', data, function(result, status, xhr) {
            $('#modalDetail').modal('show');
            $('#loading').show();
            if(result.status){
                $('#loading').hide();
                $('#editSubject').val(result.meeting.subject);
                $('#meetingId').val(result.meeting.id);
                $('#editDescription').val(result.meeting.description);
                
                var start_time = result.meeting.start_time.split(" ");
                var end_time = result.meeting.end_time.split(" ");

                $("#editStart").datepicker('setDate', start_time[0]);
                $('#editStartTime').val(start_time[1]);

                $("#editEnd").datepicker('setDate', end_time[0]);
                $('#editEndTime').val(end_time[1]);

                $('#editLocation').val(result.meeting.location).trigger('change.select2');
                $('#editStatus').val(result.meeting.status).trigger('change.select2');

                var tableData = "";
                var count = 1;
                $('#tableDetailBody').html("");

                $.each(result.meeting_details, function(key, value) {
                    tableData += "<tr id='rowAudience"+value.id+"''>";
                    tableData += "<td>"+count+"</td>";
                    tableData += "<td>"+value.employee_id+"</td>";
                    tableData += "<td>"+value.name+"</td>";
                    tableData += "<td>"+value.department+"</td>";
                    if(value.status == 0){
                        tableData += "<td style='background-color: RGB(255,204,255);'>"+value.status+" - Belum Hadir</td>";
                    }
                    if(value.status == 1){
                        tableData += "<td style='background-color: RGB(204,255,255);'>"+value.status+" - Hadir</td>";
                    }
                    if(value.status == 2){
                        tableData += "<td style='background-color: RGB(204,255,255);'>"+value.status+" - Hadir</td>";
                    }
                    tableData += "<td><button class='btn btn-danger btn-sm' id='"+value.id+"' onclick='deleteAudience(id)'><i class='fa fa-trash'></i></button></td>";
                    tableData += "</tr>";
                    count += 1;
                });
                $('#tableDetailBody').append(tableData);
            }
            else{
                audio_error.play();
                $('#loading').hide();
                $('#modalDetail').modal('hide');
                openErrorGritter('Error!', 'Attempt to retrieve data failed');
            }

        });
    }

    function chartAttencance(id) {
        $('#modalChartTitle').html('');
        $('#container1').html('');
        $('#container2').html('');
        $('#loadingChart').show();
        $('#modalDetailTitleChart').html('');
        $('#tableDetailChart').hide();
        $('#tableDetailChart').DataTable().clear();
        $('#tableDetailChart').DataTable().destroy();
        $('#tableDetailChartBody').html('');
        var data = {
            id:id
        }

        $.get('{{ url("fetch/meeting/chart") }}', data,function(result, status, xhr) {
            if(xhr.status == 200){
                if(result.status){

                    var dept = [];
                    var jml_hadir = [];
                    var jml_tidak = [];
                    var jml_tanpa_undangan = [];
                    var hadir = 0;
                    var tidak = 0;
                    var tanpa_undangan = 0;
                    var series = []
                    var series2 = [];
                    var series3 = [];

                    for (var i = 0; i < result.chart.length; i++) {
                        dept.push(result.chart[i].department_shortname);
                        jml_hadir.push(parseInt(result.chart[i].hadir));
                        hadir = hadir+parseInt(result.chart[i].hadir);
                        tidak = tidak+parseInt(result.chart[i].tidak);
                        tanpa_undangan = tanpa_undangan+parseInt(result.chart[i].tanpa_undangan);
                        jml_tidak.push(parseInt(result.chart[i].tidak));
                        jml_tanpa_undangan.push(parseInt(result.chart[i].tanpa_undangan));
                        series.push([dept[i], jml_hadir[i]]);
                        series2.push([dept[i], jml_tidak[i]]);
                        series3.push([dept[i], jml_tanpa_undangan[i]]);
                    }

                    $('#modalChartTitle').html('Meeting Resume<br>'+result.meeting.subject+' || '+result.meeting.date+' ('+result.meeting.start+'-'+result.meeting.end+')');


                    Highcharts.chart('container1', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'TOTAL AUDIENCE BY DEPT',
                            style: {
                                fontSize: '20px',
                                fontWeight: 'bold'
                            }
                        },
                        xAxis: {
                            categories: dept,
                            type: 'category',
                            gridLineWidth: 1,
                            gridLineColor: 'RGB(204,255,255)',
                            lineWidth:2,
                            lineColor:'#9e9e9e',
                            labels: {
                                style: {
                                    fontSize: '13px'
                                }
                            },
                        },
                        yAxis: [{
                            title: {
                                text: 'Total Audience',
                                style: {
                                    color: '#eee',
                                    fontSize: '15px',
                                    fontWeight: 'bold',
                                    fill: '#6d869f'
                                }
                            },
                            labels:{
                                style:{
                                    fontSize:"15px"
                                }
                            },
                            type: 'linear',
                        },
                        ],
                        tooltip: {
                            headerFormat: '<span>{series.name}</span><br/>',
                            pointFormat: '<span style="color:{point.color};font-weight: bold;">{point.name} </span>: <b>{point.y}</b><br/>',
                        },
                        legend: {
                            layout: 'horizontal',
                            backgroundColor:
                            Highcharts.defaultOptions.legend.backgroundColor || '#2a2a2b',
                            itemStyle: {
                                fontSize:'12px',
                            },
                        },  
                        plotOptions: {
                            series:{
                                cursor: 'pointer',
                                point: {
                                  events: {
                                    click: function () {
                                      ShowModalDetailChart(this.category,this.series.name,id);
                                    }
                                  }
                                },
                                animation: false,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y}',
                                    style:{
                                        fontSize: '1vw'
                                    }
                                },
                                animation: false,
                                pointPadding: 0.93,
                                groupPadding: 0.93,
                                borderWidth: 0.93,
                                cursor: 'pointer'
                            },
                        },credits: {
                            enabled: false
                        },
                        series: [{
                            type: 'column',
                            data: series,
                            name: 'Hadir',
                            colorByPoint: false,
                            color: "#78c718"
                        },{
                            type: 'column',
                            data: series2,
                            name: 'Tidak Hadir',
                            colorByPoint: false,
                            color:'#c71818'
                        }
                        ,{
                            type: 'column',
                            data: series3,
                            name: 'Tanpa Undangan',
                            colorByPoint: false,
                            color:'#fff954'
                        },
                        ]
                    });

                    Highcharts.chart('container2', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Total Audience',
                            style: {
                                fontSize: '20px',
                                fontWeight: 'bold'
                            }
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        accessibility: {
                            point: {
                                valueSuffix: '%'
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                },
                                animation: false,
                            }
                        },credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'Audience',
                            colorByPoint: true,
                            data: [{
                                name: 'Hadir',
                                y: hadir,
                                sliced: true,
                                selected: true,
                                colorByPoint: false,
                                color: "#78c718"
                            }, {
                                name: 'Tidak Hadir',
                                y: tidak,
                                colorByPoint: false,
                                color:'#c71818'
                            }, {
                                name: 'Tanpa Undangan',
                                y: tanpa_undangan,
                                colorByPoint: false,
                                color:'#fff954'
                            }, ]
                        }]
                    });
                    $('#loadingChart').hide();
                }
            }
        });
        $('#modalChart').modal('show');
    }

    function ShowModalDetailChart(dept,attendance,id) {
        $('#tableDetailChart').hide();
        var data = {
            dept:dept,
            attendance:attendance,
            id:id,
        }

        $.get('{{ url("fetch/meeting/chart_detail") }}', data, function(result, status, xhr) {
            if(result.status){
                $('#tableDetailChartBody').html('');

                $('#tableDetailChart').DataTable().clear();
                $('#tableDetailChart').DataTable().destroy();

                var index = 1;
                var resultData = "";
                var total = 0;

                $.each(result.details, function(key, value) {
                    resultData += '<tr>';
                    resultData += '<td>'+ index +'</td>';
                    resultData += '<td>'+ value.employee_id +'</td>';
                    resultData += '<td>'+ value.name +'</td>';
                    resultData += '<td>'+ value.department +'</td>';
                    resultData += '<td>'+ value.section +'</td>';
                    resultData += '<td>'+ attendance +'</td>';
                    resultData += '<td>'+ value.attend_time +'</td>';
                    resultData += '</tr>';
                    index += 1;
                });
                $('#tableDetailChartBody').append(resultData);
                $('#modalDetailTitleChart').html("<center><span style='font-size: 20px; font-weight: bold;'>Detail Employees With Attendance '"+attendance+"'</span></center>");

                $('#tableDetailChart').show();
                var table = $('#tableDetailChart').DataTable({
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
            }
            else{
                alert('Attempt to retrieve data failed');
            }
        });
    }
</script>
@endsection