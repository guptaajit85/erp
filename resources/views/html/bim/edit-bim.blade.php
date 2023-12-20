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
        <h1>Update Beam</h1>
        <small>Beam list</small>
	  </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-bims') }}"> <i class="fa fa-list"></i> Beam List </a> </div>
            </div>
            <div class="panel-body">
            <form class="col-sm-6" role="form" name="productEdit" id="productEdit" method="post" action="{{ url('/update_bim') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >

				<div class="form-group">
				 <label> Beam Name   <span style="color:#ff0000;">*</span></label>
				 <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($data->name) }}"  placeholder="Enter Beam Name">
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
            $("#productEdit").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        letterswithbasicpunc: true
                    }
                },
                messages: {
                    name: {
                        required: "<span style='color: red;'>Please enter a name</span>",
                        minlength: "<span style='color: red;'>The name should have at least 3 characters</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only alphabet characters are allowed</span>"
                    }
                }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed</span>");
       });
    </script>


</body>
</html>
