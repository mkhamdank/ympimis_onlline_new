@extends('layouts.master')
@section('header')
<section class="content-header">
  <h1>
    Create {{ $page }}
  </h1>
</section>
@endsection
@section('content')
<section class="content">


  @if ($errors->has('password'))
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    {{ $errors->first() }}
  </div>   
  @endif
  @if (session('error'))
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Error!</h4>
    {{ session('error') }}
  </div>   
  @endif


  <!-- SELECT2 EXAMPLE -->
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">Create New User</h3> --}}
    </div>  
    <form role="form" method="post" action="{{url('create/user')}}">
      <div class="box-body">
      	<input type="hidden" value="{{csrf_token()}}" name="_token" />
        <div class="form-group row">
          <label class="col-sm-3">Name<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="name" placeholder="Enter Full Name" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3">Username<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="username" placeholder="Enter Username" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3">E-mail<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter E-mail" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3">Password<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3">Confirm Password<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirm Password" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3">User Role<span class="text-red">*</span></label>
          <div class="col-sm-4" align="left">
            <select class="form-control select2" name="role_code" style="width: 100%;" data-placeholder="Choose a Role..." required>
              <option value=""></option>
              @foreach($roles as $role)
              <option value="{{ $role->role_code }}">{{ $role->role_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-sm-4 col-sm-offset-6">
          <div class="btn-group">
            <a class="btn btn-danger" href="{{ url('index/user') }}">Cancel</a>
          </div>
          <div class="btn-group">
            <button type="submit" class="btn btn-primary col-sm-14">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  @endsection

  @section('scripts')
  <script>
    $(function () {
      $('.select2').select2()
    });

    jQuery(document).ready(function() {
      $('#email').val('');
      $('#password').val('');
    });

  </script>
  @stop

