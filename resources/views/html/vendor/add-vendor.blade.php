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
        <h1>Vendor</h1>
        <small>Vendor</small> </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-persons', base64_encode($indID)) }}"> <i class="fa fa-list"></i> Vendor List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_vendor')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <h4>Vendor Name : {{ $data->company_name }}</h4>
                  <input type="hidden" class="form-control" name="individual_id" id="individual_id" value="<?=$indID;?>" >
                </div>
                <div class="form-group">
                  <label>Vendor From</label>
                  <input type="text" class="form-control" name="vendor_from" id="vendor_from" placeholder="Enter Vendor From" >
                </div>
                <div class="form-group">
                  <label>Vendor To</label>
                  <input type="text" class="form-control" name="vendor_to" id="vendor_to" placeholder="Enter Vendor To" >
                </div>
                <div class="reset-button">
                  <input type="submit" name="submit" value="Save" class="btn btn-success">
                  <a href="#" class="btn btn-warning">Reset</a> </div>
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
		$( "#dob,#doa" ).datepicker({
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
