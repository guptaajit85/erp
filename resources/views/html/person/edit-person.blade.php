<?php
use App\Http\Controllers\CommonController;
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
        <h1>Update Person</h1>
        <small>Person list</small> </div>
    </section>
    <!-- Main content -->
	
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!} 
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-persons', $data->individual_id) }}"> <i class="fa fa-list"></i> Person List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_person') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                <input type="hidden" class="form-control" name="individual_id" id="individual_id" value="<?=$indID;?>" >
                <div class="form-group">
                  <label> Name </label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($data->name) }}"  placeholder="Enter Name">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" id="email" value="{{ htmlentities($data->email) }}"  placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                  <label>Mobile</label>
                  <input type="number" class="form-control" name="mobile" id="mobile" value="{{ htmlentities($data->mobile) }}"  placeholder="Enter Mobile" required>
                </div>
                <div class="form-group">
                  <label>Date Of Birth</label>
                  <input type="text" class="form-control" name="dob" id="dob" value="{{ htmlentities($data->dob) }}"  placeholder="Select Date Of Birth" required>
                </div>
                <div class="form-group">
                  <label>Date Of Anniversary</label>
                  <input type="text" class="form-control" name="doa" id="doa" value="{{ htmlentities($data->doa) }}"  placeholder="Select Date Of Anniversary" required>
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" id="pimage1"  class="form-control" name="pimage1"/>
                  <img src="{{ asset('storage/images/'.$data->image) }}" alt="" title="" height="50px" width="50px;"> </div>
                <div class="form-group">
                  <label>Facebook Link</label>
                  <input type="text" class="form-control" name="fb_link" value="{{ htmlentities($data->fb_link) }}"  id="fb_link" placeholder="Select Facebook Link" required>
                </div>
                <div class="form-group">
                  <label>Call Number</label>
                  <input type="number" class="form-control" maxlength="10" name="call_no" value="{{ htmlentities($data->call_no) }}"  id="call_no" placeholder="Select calling Number" required>
                </div>
                <div class="form-group">
                  <label>WhatsApp</label>
                  <input type="number" class="form-control" maxlength="10" name="whatsapp" value="{{ htmlentities($data->whatsapp) }}"  id="whatsapp" placeholder="Enter whatsapp" required>
                </div>
                <?php 
				
				$is_po_genrated   = $data->is_po_genrated;
				
				?>
                <div class="form-group">
                  <label>Assign Notification</label>
                  <p>
                    <input type="checkbox" name="is_po_genrated" id="is_po_genrated" value="1"  @if($data->
                    is_po_genrated =='1') checked @endif; > Po Genrated
                    <input type="checkbox" name="is_work_order_genrated" id="is_work_order_genrated"  value="1" @if($data->
                    is_work_order_genrated =='1') checked @endif; > Work Order Genrated
                    <input type="checkbox" name="is_warp_process" id="is_warp_process" value="1" @if($data->
                    is_warp_process =='1') checked @endif;> Warp process
                    <input type="checkbox" name="is_drawing_process" id="is_drawing_process" value="1" @if($data->
                    is_drawing_process =='1') checked @endif;> Drawing process
                    <input type="checkbox" name="is_weave_process" id="is_weave_process" value="1" @if($data->
                    is_weave_process =='1') checked @endif;> Weave Process
                    <input type="checkbox" name="is_dyeing_process" id="is_dyeing_process" value="1" @if($data->
                    is_dyeing_process =='1') checked @endif;> Dyeing process
                    <input type="checkbox" name="is_coting_process" id="is_coting_process" value="1" @if($data->
                    is_coting_process =='1') checked @endif;> Coting process
                    <input type="checkbox" name="is_work_order_completed" id="is_work_order_completed" value="1" @if($data->
                    is_work_order_completed =='1') checked @endif;> Work Order Completed
                    <input type="checkbox" name="is_invoice_generated" id="is_invoice_generated" value="1" @if($data->
                    is_invoice_generated =='1') checked @endif;> Invoice Generated
                    <input type="checkbox" name="is_packing" id="is_packing" value="1" @if($data->
                    is_packing =='1') checked @endif;> Packing
                    <input type="checkbox" name="is_dispatch" id="is_dispatch" value="1" @if($data->
                    is_dispatch =='1') checked @endif;> Dispatch </p>
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
