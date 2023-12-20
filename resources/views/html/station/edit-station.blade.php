<?php
use \App\Http\Controllers\CommonController;
// echo "<pre>"; print_r($data);

?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
</head>
<body class="hold-transition sidebar-mini">
<!--preloader-->
<div id="preloader">
  <div id="status"></div>
</div>
<!-- Site wrapper -->
<div class="wrapper"> @include('common.header')
   <div class="content-wrapperd">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="header-icon"> <i class="fa fa-users"></i> </div>
      <div class="header-title">
        <h1>Update Station</h1>
        <small>Station list</small> </div>
    </section>
    <!-- Main content -->

    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-stations') }}"> <i class="fa fa-list"></i> Station List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_station') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                <div class="form-group">
                  <label> Station Name  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($data->name) }}"  >
                </div>
                <div class="form-group">
                  <label>State Name</label>
                  <select class="form-control" name="state_id" id="state_id">

                                       @foreach ($dataI as $data1)

                    <option value="{{ $data1->id }}" @if($data1->id==$data->state_id) selected="selected" @endif;>{{ $data1->name }}</option>

                                       @endforeach

                  </select>
                </div>
                <div class="reset-button">
                  <input type="submit" name="submit" value="Save" class="btn btn-success">
                  <a href="javascript:window.location.href=window.location.href" class="btn btn-warning">Reset</a> </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('common.footer') </div>
@include('common.footerscript')
<script src="{{ asset('js/jquery-ui-timepicker-addon.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/jquery-ui-timepicker-addon.css') }}">
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
$().ready(function() {
	$("#domainEdit").validate({
			rules: {
				name: "required",
			},
			messages: {
				name: "Please enter name",
			}
		});
});
</script>
</body>
</html>
