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
        <h1>Add New User Web Page</h1>
        <small>All User Web  Page list</small> </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-allpages') }}"> <i class="fa fa-list"></i> All User Web Page List </a> </div>
            </div>
            <div class="panel-body">
              <form class="form-horizontal" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_userwebpage')}}">
                @csrf
				
				
                   <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Employee </label>
                    <div class="col-sm-10">	
						<?php $subUserSelect = CommonController::subUserSelect(); ?>					
						<select id="user_id" name="user_id" class="col-xs-10 col-sm-5">
							<?=$subUserSelect;?>
						</select>
                    </div>
                  </div>
				  
				  
				  
				  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Page </label>
					
					<?php $pagename = CommonController::getAllPages(); ?>
					
						<div class="col-sm-10"><?=$pagename;?></div>
					 
                  </div>
				  
				<div class="clearfix form-actions">
					<div class="col-md-offset-2 col-md-10">
						<input type="submit" name="submit" value="Save" class="btn btn-success">
						<input type="reset" name="Reset" value="Reset" class="btn btn-warning"> 
						&nbsp; &nbsp; &nbsp; 
					</div>
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
		$().ready(function() {
			$("#productEdit").validate({
					rules: {
						name: 	{
										required: true,
										minlength: 3,
                              letterswithbasicpunc: true // This is the custom rule for alphabet characters
								   }
							},
					messages: {
						name: {
									required: " <span style='color:#ff0000;'>Please enter name</span>",
									minlength:"<span style='color:#ff0000;'>The name should have at least 3 characters</span>",
                           letterswithbasicpunc: "<span style='color:#ff0000;'>Only alphabet characters are allowed</span>"
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
