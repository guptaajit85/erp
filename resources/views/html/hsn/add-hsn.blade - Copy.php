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
        <h1>HSN</h1>
        <small>HSN list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-hsns') }}"> <i class="fa fa-list"></i> HSN List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('store_hsn') }}">
                @csrf
                <div class="form-group">
                  <label> HSN Code <span style='color: #f50808;'>*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter HSN Code" required>
                </div>
                <div class="form-group">
                    <label>Select GST Rate  <span style='color: #f50808;'>*</span></label>
                    <select class="form-control" name="gst_rate_id" id="gst_rate_id">

                                         @foreach ($gstRateData as $data)

                      <option value="{{ $data->gst_rate_id }}">{{ $data->gst_rate }}</option>

                                         @endforeach

                    </select>
                  </div>




                <div class="form-group">
                  <label> HSN Description</label>
                  <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js')}}"></script>
<script language="javascript" type="text/javascript">
        $().ready(function() {
            $("#domainEdit").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100

                    },
					 hsn_value: 	{
                     required: true,
                  }
                },
                messages: {
                    name: {
                        required: "<span style='color: red;'>Please enter HSN Code</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
					hsn_value: {
                     required: "<span style='color: red;'>Please enter HSN Value</span>",
                  }
                }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet  are allowed</span>");
       });
    </script>
</body>
</html>
