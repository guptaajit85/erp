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
        <h1>Add Vehicle</h1>
        <small>Vehicle list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-vehicles') }}"> <i class="fa fa-list"></i> Person List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_vehicle')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label>Lorry Type </label>
                  <select class="form-control" name="lorry_type" id="lorry_type">
                    <option value="none" selected disabled hidden>Select an Option</option>
                    <option value="I"> I</option>
                    <option value="L"> L</option>
                    <option value="B"> B</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Lorry Owner </label>
                  <select class="form-control" name="lorry_owner" id="lorry_owner">
                    <option value="none" selected disabled hidden>Select an Option</option>
                    <option value="C"> C</option>
                    <option value="H"> H</option>
                  </select>
                </div>
                <div class="form-group">
                  <label> Vehicle Type </label>
                  <input type="text" class="form-control" name="vehicle_type" id="vehicle_type" placeholder="Enter Vehicle Type" value="{{ old('vehicle_type') }}" >
                </div>
                <div class="form-group">
                  <label> Body Type </label>
                  <input type="text" class="form-control" name="body_type" id="body_type" placeholder="Enter Body Type"  value="{{ old('body_type') }}">
                </div>
                <div class="form-group">
                  <label> Lorry Number  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="lorry_number" id="lorry_number" placeholder="Enter Lorry Number"  value="{{ old('lorry_number') }}">
                </div>
                <div class="form-group">
                  <label> Brand Name </label>
                  <select class="form-control" name="brand_id" id="brand_id">
                    <option value="none" selected disabled hidden>Select an Option</option>

                       @foreach ($dataI as $data)

                    <option value="{{ $data->id }}">{{ $data->brand_name }}</option>

                       @endforeach

                  </select>
                </div>
                <div class="form-group">
                  <label> GVW </label>
                  <input type="text" class="form-control" name="gvw" id="gvw" placeholder="Enter Gross Vehicle Weight" value="{{ old('gvw') }}">
                </div>
                <div class="form-group">
                  <label> Chasis Weight </label>
                  <input type="text" class="form-control" name="chasis_weight" id="chasis_weight" placeholder="Enter Chasis Weight" value="{{ old('chasis_weight') }}">
                </div>
                <div class="form-group">
                  <label> Lorry Owner Id </label>
                  <input type="text" class="form-control" name="lorryowner_id" id="lorryowner_id" placeholder="Enter Lorryowner Id" value="{{ old('lorry_id') }}">
                </div>
                <div class="form-group">
                  <label> Owner Name  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="Enter Owner Name" value="{{ old('owner_name') }}">
                </div>
                <div class="form-group">
                  <label> Owner Address </label>
                  <input type="text" class="form-control" name="owner_address" id="owner_address" placeholder="Enter Owner Address" value="{{ old('owner_address') }}">
                </div>
                <div class="form-group">
                  <label> Owner Phone  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="owner_phone" id="owner_phone" placeholder="Enter Owner Phone" value="{{ old('owner_phone') }}">
                </div>
                <div class="form-group">
                  <label> Pan Number  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="pan_number" id="pan_number" placeholder="Enter Pan Number" value="{{ old('pan_number') }}">
                </div>
                <div class="form-group">
                  <label> Engine Number </label>
                  <input type="text" class="form-control" name="engine_no" id="engine_no" placeholder="Enter Engine Number" value="{{ old('engine_no') }}" >
                </div>
                <div class="form-group">
                  <label> Chassis Number </label>
                  <input type="text" class="form-control" name="chassis_no" id="chassis_no" placeholder="Enter Chassis Number" value="{{ old('chassis_no') }}">
                </div>
                <div class="form-group">
                  <label> Model Type </label>
                  <input type="text" class="form-control" name="modeltype" id="modeltype" placeholder="Enter Model Type" value="{{ old('modeltype') }}">
                </div>
                <div class="form-group">
                  <label> TDS Declare </label>
                  <input type="text" class="form-control" name="tds_declare" id="tds_declare" placeholder="Enter TDS Declare" value="{{ old('tds_declare') }}">
                </div>
                <div class="form-group">
                  <label> NPNO </label>
                  <input type="text" class="form-control" name="npno" id="npno" placeholder="Enter NPNO" value="{{ old('npno') }}">
                </div>
                <div class="form-group">
                  <label> Policy Number </label>
                  <input type="text" class="form-control" name="policy_no" id="policy_no" placeholder="Enter Policy Number" value="{{ old('policy_no') }}">
                </div>
                <div class="form-group">
                  <label> Policy Date </label>
                  <input type="text" class="form-control" name="policy_date" id="policy_date" placeholder="Enter Policy Date" value="{{ old('policy_date') }}">
                </div>
                <div class="form-group">
                  <label> Valid Date </label>
                  <input type="text" class="form-control" name="valid_date" id="valid_date" placeholder="Enter Valid Date  " value="{{ old('valid_date') }}">
                </div>
                <div class="form-group">
                  <label> Colour </label>
                  <input type="text" class="form-control" name="colour" id="colour" placeholder="Enter Colour" value="{{ old('colour') }}">
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
		$( "#policy_date,#valid_date" ).datepicker({
			changeYear: true ,
			yearRange : 'c-50:c +1',
			changeMonth: true ,
			dateFormat: 'yy-mm-dd',
			todayBtn: 'linked'
		});
	});
</script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.js')}}"></script>
<script language="javascript" type="text/javascript">
        $().ready(function() {
            $("#productEdit").validate({
                rules: {
                    lorry_number: {
                        required: true,
                        customlorry: true
                    },

                    owner_name: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    },
                    owner_phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength:10

                    },
                    pan_number: {
                        required: true,
                        custompan: true,
                        minlength: 10,
                        maxlength: 10
                    }

                },
                messages: {
                    lorry_number: {
                        required: "<span style='color: red;'>Please enter a Lorry Number</span>",
                        customlorry: "<span style='color: red;'>Please enter a valid Lorry Number (e.g., AB 12 A/AB 1234)</span>"
                    },

                    owner_name: {
                        required: "<span style='color: red;'>Please enter a Name</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    owner_phone: {
                        required: "<span style='color: red;'>Please enter an Phone Number</span>",
                        digits: "<span style='color: red;'>Only Numbers are allowed</span>",
                        minlength: "<span style='color: red;'>Phone Number should have exactly 10 Numbers</span>",
                        maxlength: "<span style='color: red;'>Phone Number should have exactly 10 Numbers</span>"

                    },
                    pan_number: {
                        required: "<span style='color: red;'>Please enter a PAN Number</span>",
                        custompan: "<span style='color: red;'>Please enter a valid PAN Number</span>",
                        minlength: "<span style='color: red;'>PAN Number should have exactly 10 characters</span>",
                        maxlength: "<span style='color: red;'>PAN Number should have exactly 10 characters</span>"
                    }

                }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet  are allowed</span>");

            jQuery.validator.addMethod("custompan", function(value, element) {
                return this.optional(element) || /^[A-Za-z]{5}\d{4}[A-Za-z]{1}$/i.test(value);
            }, "<span style='color: red;'>Please enter a valid PAN Number</span>");

            jQuery.validator.addMethod("customlorry", function(value, element) {
                return this.optional(element) || /^[A-Z]{2}\s\d{2}\s[A-Z]{1,2}\s\d{4}$/i.test(value);
            }, "<span style='color: red;'>Please enter a valid Lorry Number (e.g., AB 12 A/AB 1234)</span>");


       });
    </script>
</body>
</html>
