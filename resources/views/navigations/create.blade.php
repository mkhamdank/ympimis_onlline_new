@extends('layouts.master')
@section('header')
<section class="content-header" style="padding:20px">
  <h1>
    Create {{ $page }}
    <small></small>
  </h1>
  <ol class="breadcrumb">
  </ol>
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

  <div class="box box-primary">
    <div class="box-header with-border">
    </div>  
    <form role="form" method="post" action="{{url('create/navigation')}}">
      <div class="box-body">
      	<input type="hidden" value="{{csrf_token()}}" name="_token" />
        <div class="form-group row">
          <label class="col-sm-3">Navigation Code<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="navigation_code" placeholder="Enter Navigation Code" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-3">Navigation Name<span class="text-red">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="navigation_name" placeholder="Enter Navigation Name" required>
          </div>
        </div>
        <div class="col-sm-4 col-sm-offset-6">
          <div class="btn-group">
            <a class="btn btn-danger" href="{{ url('index/navigation') }}">Cancel</a>
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
    })
  </script>
  @stop

