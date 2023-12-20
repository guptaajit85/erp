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
    {!! CommonController::display_message('message') !!}
    <section class="content-header">
      <div class="header-icon"> <i class="fa fa-users"></i> </div>
      <div class="header-title">
        <h1>Update Vendor</h1>
        <small>Vendor list</small> </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-vendors', base64_encode($data->id)) }}"> <i class="fa fa-list"></i> Vendor List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_vendor') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <h4>Vendor Name : {{ $dataI->company_name }}</h4>
                  <input type="hidden" class="form-control" name="individual_id" id="individual_id" value="<?=$data->individual_id;?>" >
                  <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                </div>
                <div class="form-group">
                  <label>Vendor From</label>
                  <input type="text" class="form-control" name="vendor_from" id="vendor_from" value="{{ htmlentities($data->vendor_from) }}"  placeholder="Enter Vendor From" required>
                </div>
                <div class="form-group">
                  <label>Vendor to</label>
                  <input type="text" class="form-control" name="vendor_to" id="vendor_to" value="{{ htmlentities($data->vendor_to) }}"  placeholder="Enter Vendor To" required>
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
			yearRange : 'c-50:c +1',
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
				
			},
			messages: {
				name: "Please enter name",
				
			}
		});
});
</script>
</body>
</html>
