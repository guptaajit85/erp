<?php
	use \App\Http\Controllers\CommonController;
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
        <h1>Update Dyed Febric</h1>
        <small>Dyed Febric list</small>
	  </div>
    </section>
    <!-- Main content -->
	{!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-dyedfabrics') }}"> <i class="fa fa-list"></i> Dyed Febric List </a> </div>
            </div>
            <div class="panel-body">
            <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_dyedfabric') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >

				<div class="form-group">
				 <label> Name   <span style="color:#ff0000;">*</span></label>
				 <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($data->name) }}"  placeholder="Enter Name">
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

<script>
	$(function() {
		$( "#dob" ).datepicker({
			changeYear: true ,
			yearRange : 'c-1:c +10',
			changeMonth: true ,
			dateFormat: 'yy-mm-dd',
			todayBtn: 'linked'
		});
	});
</script>

<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

<script language="javascript" type="text/javascript">
$().ready(function() {
	$("#domainEdit").validate({
			rules: {
				name: "required",
				email: "required",
				mobile: "required",
				dob: "required"
			},
			messages: {
				name: "<span style='color:#ff0000;'>Please enter name</span>",
				email: "Please enter email",
				mobile: "Please enter mobile",
				dob: "Please select date of birth"
			}
		});
});
</script>

</body>
</html>
