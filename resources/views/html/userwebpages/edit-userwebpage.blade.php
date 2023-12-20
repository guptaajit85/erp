<?php
	use \App\Http\Controllers\CommonController;
	
	// echo "<pre>"; print_r($data); exit;
	$userId = @$data->user_id;
	
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
        <h1>Update User Web Page</h1>
        <small>All User Web Pages list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-allpages') }}"> <i class="fa fa-list"></i> User Web Page List </a> </div>
            </div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" name="productEdit" id="productEdit" method="post" action="{{ url('/update_userwebpage') }}" novalidate="novalidate">
			    @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                 
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1">User </label>
					<div class="col-sm-4">	
						<?php $subUserSelect = CommonController::subUserSelect($userId); ?>					
						<select id="user_id" name="user_id" class="form-control col-xs-10 col-sm-5"> <?=$subUserSelect;?> </select>
					</div>
				</div>
				   
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Page </label>
					<?php $pagename = CommonController::getAllPages($userId); ?> 
					<div class="col-sm-10"><?=$pagename;?></div>
				</div> 
				
				<div class="clearfix form-actions">
					<div class="col-md-offset-2 col-md-10"> <input type="submit" name="submit" value="Save" class="btn btn-success"> &nbsp; &nbsp; &nbsp; </div>
				</div>
				
				
  
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
		$().ready(function() {
			$("#productEdit").validate({
					rules: {
						page_name: 	{
										required: true,
										minlength: 3,
                               
								   }
							},
					messages: {
						page_name: {
									required: " <span style='color:#ff0000;'>Please enter page name</span>",
									minlength:"<span style='color:#ff0000;'>The name should have at least 3 characters</span>",
                            
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
