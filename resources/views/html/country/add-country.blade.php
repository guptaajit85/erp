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
        <h1>Add Country</h1>
        <small>Country list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-countries') }}"> <i class="fa fa-list"></i> Country List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_country')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label> Name </label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" >
                </div>
                <div class="form-group">
                  <label> Sortname </label>
                  <input type="text" class="form-control" name="sortname" id="sortname" placeholder="Enter Sortname Name" >
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
		$().ready(function() {
			$("#productEdit").validate({ 
					rules: {
						name: 	{
										required: true,
										minlength: 3,
                              letterswithbasicpunc: true // This is the custom rule for alphabet characters
								   },   
                  sortname: 	{
                     required: true,
                     maxlength: 2,
                     letterswithbasicpunc: true // This is the custom rule for alphabet characters
                  }   
							},
					messages: {
						name: {
									required: "Please enter name",
									minlength:"The name should have at least 3 characters",
                           letterswithbasicpunc: "Only alphabet characters are allowed"
								},
                        sortname: {
                     required: "Please enter sortname",
                     maxlength:"The sortname should have only 2 characters",
                     letterswithbasicpunc: "Only alphabet characters are allowed"
                  }
					}
				});			
                     jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                     return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
               }, "<span style='color: red;'> Only alphabet characters are allowed </span>"); 
		}); 
</script>
</body>
</html>
