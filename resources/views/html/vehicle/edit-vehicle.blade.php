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
        <h1>Update Vehicle</h1>
        <small>Vehicle List</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-vehicles') }}"> <i class="fa fa-list"></i> Vehicle List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_vehicle') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                <div class="form-group">
                  <label>Lorry Type </label>
                  <select class="form-control" name="lorry_type" id="lorry_type">
                    <option value="I" @if($data->lorry_type =='I') selected="selected" @endif; >  I</option>
                    <option value="L" @if($data->lorry_type =='L') selected="selected" @endif;>  L</option>
                    <option value="B" @if($data->lorry_type =='B') selected="selected" @endif;>  B</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Lorry Owner </label>
                  <select class="form-control" name="lorry_owner" id="lorry_owner">
                    <option value="C"@if($data->lorry_owner =='C') selected="selected" @endif; >  C</option>
                    <option value="H"@if($data->lorry_owner =='B') selected="selected" @endif; >  H</option>
                  </select>
                </div>
                <div class="form-group">
                  <label> Vehicle Type </label>
                  <input type="text" class="form-control" name="vehicle_type" id="vehicle_type" value="{{ $data->vehicle_type }}" placeholder="Enter Vehicle Type">
                </div>
                <div class="form-group">
                  <label> Body Type </label>
                  <input type="text" class="form-control" name="body_type" id="body_type" value="{{ $data->body_type }}" placeholder="Enter Body Type" >
                </div>
                <div class="form-group">
                  <label> Lorry Number  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="lorry_number" id="lorry_number" value="{{ $data->lorry_number }}" placeholder="Enter Lorry Number" >
                </div>
                <div class="form-group">
                  <label> Brand Name </label>
                  <select class="form-control" name="brand_id" id="brand_id">

                       @foreach ($dataI as $data1)

                    <option value="{{ $data1->id }}" @if($data1->id==$data->brand_id) selected="selected" @endif;>{{ $data1->brand_name}}</option>

                       @endforeach


                  </select>
                </div>
                <div class="form-group">
                  <label> GVW </label>
                  <input type="text" class="form-control" name="gvw" id="gvw" value="{{ $data->gvw }}" placeholder="Enter GVW" >
                </div>
                <div class="form-group">
                  <label> Chasis Weight </label>
                  <input type="text" class="form-control" name="chasis_weight" value="{{ $data->chasis_weight }}" id="chasis_weight" placeholder="Enter Chasis  Weight" >
                </div>
                <div class="form-group">
                  <label> Lorry Owner Id </label>
                  <input type="text" class="form-control" name="lorryowner_id" value="{{ $data->lorryowner_id }}" id="lorryowner_id" placeholder="Enter Lorry Owner Id" >
                </div>
                <div class="form-group">
                  <label> Owner Name  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="owner_name" value="{{ $data->owner_name }}" id="owner_name" placeholder="Enter Owner Name" >
                </div>
                <div class="form-group">
                  <label> Owner Address </label>
                  <input type="text" class="form-control" name="owner_address" value="{{ $data->owner_address }}" id="owner_address" placeholder="Enter Owner Address" >
                </div>
                <div class="form-group">
                  <label> Owner Phone  <span style="color:#ff0000;">*</span> </label>
                  <input type="text" class="form-control" name="owner_phone" value="{{ $data->owner_phone }}" id="owner_phone" placeholder="Enter Owner Phone" >
                </div>
                <div class="form-group">
                  <label> Pan Number  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="pan_number" value="{{ $data->pan_number }}" id="pan_number" placeholder="Enter Pan Number" >
                </div>
                <div class="form-group">
                  <label> Engine Number </label>
                  <input type="text" class="form-control" name="engine_no" value="{{ $data->engine_no }}" id="engine_no" placeholder="Enter Engine Number" >
                </div>
                <div class="form-group">
                  <label> Chassis Number </label>
                  <input type="text" class="form-control" name="chassis_no" value="{{ $data->chassis_no }}" id="chassis_no" placeholder="Enter Chassis Number" >
                </div>
                <div class="form-group">
                  <label> Model Type </label>
                  <input type="text" class="form-control" name="modeltype" value="{{ $data->modeltype }}" id="modeltype" placeholder="Enter Model Type" >
                </div>
                <div class="form-group">
                  <label> TDS Declare </label>
                  <input type="text" class="form-control" name="tds_declare" value="{{ $data->tds_declare }}" id="tds_declare" placeholder="Enter TDS Declare" >
                </div>
                <div class="form-group">
                  <label> NPNO </label>
                  <input type="text" class="form-control" name="npno" id="npno" value="{{ $data->npno }}" placeholder="Enter NPNO" >
                </div>
                <div class="form-group">
                  <label> Policy Number </label>
                  <input type="text" class="form-control" name="policy_no" id="policy_no" value="{{ $data->policy_no }}" placeholder="Enter Policy Number" >
                </div>
                <div class="form-group">
                  <label> Policy Date </label>
                  <input type="text" class="form-control" name="policy_date" id="policy_date" value="{{ $data->policy_date }}" placeholder="Enter Policy Date" >
                </div>
                <div class="form-group">
                  <label> Valid Date </label>
                  <input type="text" class="form-control" name="valid_date" id="valid_date" value="{{ $data->valid_date }}" placeholder="Enter Valid Date" >
                </div>
                <div class="form-group">
                  <label> Colour </label>
                  <input type="text" class="form-control" name="colour" id="colour" value="{{ $data->colour }}" placeholder="Enter Colour" >
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
