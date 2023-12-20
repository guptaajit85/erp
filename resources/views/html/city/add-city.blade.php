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
<div class="wrapper">
 @include('common.header')
  <div class="content-wrapperd">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-users"></i>
               </div>
               <div class="header-title">
                  <h1>Add City</h1>
                  <small>City list</small>
               </div>
            </section>
            <!-- Main content -->
            
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">{!! CommonController::display_message('message') !!} 
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonlist"> 
                              <a class="btn btn-add " href="{{ route('show-cities') }}"> 
                              <i class="fa fa-list"></i>  City List </a>  
                           </div>
                        </div>
                        <div class="panel-body">
                         
				 
		<form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_city')}}" enctype="multipart/form-data">	
				
		@csrf

		<div class="form-group">
		<label> Name </label>
		<input type="text" class="form-control" name="name" id="name" placeholder="Enter City Name" >
		</div> 
		<div class="form-group">
		<label> State Id </label>
		<input type="number" class="form-control" name="state_id" id="state_id" placeholder="Enter State Id" >
		</div>
		
 
		<div class="reset-button">

		<input type="submit" name="submit" value="Save" class="btn btn-success">
		<a href="#" class="btn btn-warning">Reset</a>
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
  @include('common.footer') 
  </div>
@include('common.footerscript')

<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

<script language="javascript" type="text/javascript">
		$().ready(function() {
			$("#productEdit").validate({ 
					rules: {
						name: 	{
										required: true,
										minlength: 2,
                              //letterswithbasicpunc: true // This is the custom rule for alphabet characters
								   }   
                  state_id: 	{
                     required: true,
                     minlength: 2,
                     maxlength: 2,
                     number: true
                  } 
							},
					messages: {
						name: {
									required: "Please enter name",
									minlength:"The name should have at least 2 characters",
                         //  letterswithbasicpunc: "Only alphabet characters are allowed"
								}
                  state_id: {
                     required: "Please enter state id",
                     minlength:"The state id should have only 2 numbers",
                     maxlength:"The state id should have only 2 numbers"
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
