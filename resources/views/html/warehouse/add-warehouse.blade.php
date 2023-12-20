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
    <section class="content-header">
      <div class="header-icon"> <i class="fa fa-users"></i> </div>
      <div class="header-title">
        <h1>Add Warehouse</h1>
        <small>Warehouse list</small> </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-warehouses') }}"> <i class="fa fa-list"></i> Warehouse List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_warehouse')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label> Name   <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="warehouse_name" id="warehouse_name" placeholder="Enter Name" >
                </div>
                <div class="form-group">
                  <label>Location  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="location" id="location" placeholder="Enter Location" >
                </div>
                <div class="form-group">
                  <label>Capacity  <span style="color:#ff0000;">*</span></label>
                  <input type="number" class="form-control" name="capacity" id="capacity" placeholder="Enter Capacity" >
                </div>
               
				
                <div class="form-group">
                  <label>Supervisor Name  <span style="color:#ff0000;">*</span></label>
                   
				  <select class="form-control" name="supervisor_name" id="supervisor_name">
				  <option value=""> Select Supervisor</option>		
				  <?php foreach($dataU as $row) { ?>
					<option value="<?=$row->id;?>"> <?=$row->name;?></option>					
				  <?php } ?>
				  </select>
				  
                </div>
				
				
				
				
				
                <div class="form-group">
                  <label>Contact Number  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter Contact Number" >
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
				warehouse_name: {
				required: true,
				minlength: 3
			},
			location: 	{
				required: true,
				minlength: 3
			},
			capacity: 	{
				required: true,
				minlength: 2,
				number: true
			},
			supervisor_name: {
				required: true				 
			},
			contact_number: {
				required: true,
				minlength: 10,
				maxlength: 10,
				number: true
			}
					},
			messages: {
				warehouse_name: {
					required: "<span style='color:#ff0000;'>Please enter name</span>",
					minlength:"<span style='color:#ff0000;'>The warehouse name should have at least 3 characters</span>"
				},
				location: {
					required: "<span style='color:#ff0000;'>Please enter location name</span>",
					minlength:"<span style='color:#ff0000;'>The location name should have at least 3 characters</span>"
				},
				capacity: {
					required: "<span style='color:#ff0000;'>Please enter capacity</span>",
					minlength:"<span style='color:#ff0000;'>The capacity should have at least 2 numbers</span>"
				},
				supervisor_name: {
					required: "<span style='color:#ff0000;'>Please Select supervisor name</span>"					 
				},
				contact_number: {
					required: "<span style='color:#ff0000;'>Please enter contact number</span>",
					minlength:"<span style='color:#ff0000;'>The contact number should have at least 10 numbers</span>"
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
