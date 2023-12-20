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
        <h1>Person</h1>
        <small>Person</small> </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-persons', base64_encode($indID)) }}"> <i class="fa fa-list"></i> Person List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_person')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label> Name </label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" >
                  <input type="hidden" class="form-control" name="individual_id" id="individual_id" value="<?=$indID;?>" >
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" >
                </div>
                <div class="form-group">
                  <label>Mobile</label>
                  <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile" >
                </div>
                <div class="form-group">
                  <label>Date Of Birth</label>
                  <input type="text" class="form-control" name="dob" id="dob" placeholder="Select Date Of Birth" >
                </div>
                <div class="form-group">
                  <label>Date Of Anniversary</label>
                  <input type="text" class="form-control" name="doa" id="doa" placeholder="Select Date of Anniversary" >
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" id="pimage"  name="pimage"/>
                </div>
                <div class="form-group">
                  <label>Facebook link</label>
                  <input type="text" class="form-control" name="fb_link" id="fb_link" placeholder="Select Facebook Link" >
                </div>
                <div class="form-group">
                  <label>Call Number</label>
                  <input type="number" class="form-control" maxlength="10"  name="call_no" id="call_no" placeholder="Enter Calling Number" >
                </div>
                <div class="form-group">
                  <label>WhatsApp</label>
                  <input type="number" class="form-control" maxlength="10"  name="whatsapp" id="whatsapp" placeholder="Enter WhatsApp" >
                </div>
                <div class="form-group">
                  <label>Assign Notification</label>
                  <p>
                    <input type="checkbox" name="is_po_genrated" id="is_po_genrated" value="1">
                    Po Genrated
                    <input type="checkbox" name="is_work_order_genrated" id="is_work_order_genrated"  value="1">
                    Work Order Genrated
                    <input type="checkbox" name="is_warp_process" id="is_warp_process" value="1">
                    Warp process
                    <input type="checkbox" name="is_drawing_process" id="is_drawing_process" value="1">
                    Drawing process
                    <input type="checkbox" name="is_weave_process" id="is_weave_process" value="1">
                    Weave Process
                    <input type="checkbox" name="is_dyeing_process" id="is_dyeing_process" value="1">
                    Dyeing process
                    <input type="checkbox" name="is_coting_process" id="is_coting_process" value="1">
                    Coting process
                    <input type="checkbox" name="is_work_order_completed" id="is_work_order_completed" value="1">
                    Work Order Completed
                    <input type="checkbox" name="is_invoice_generated" id="is_invoice_generated" value="1">
                    Invoice Generated
                    <input type="checkbox" name="is_packing" id="is_packing" value="1">
                    Packing
                    <input type="checkbox" name="is_dispatch" id="is_dispatch" value="1">
                    Dispatch </p>
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
				email: "required",
				mobile: "required",
				dob: "required"
			},
			messages: {
				name: "Please enter name",
				email: "Please enter email",
				mobile: "Please enter mobile",
				dob: "Please select date of birth"
			}
		});
});
</script>
</body>
</html>
