<?php
use App\Http\Controllers\CommonController;
?>

<!DOCTYPE html>
<html lang="en">
   <head>
   @include('common.head') 
   <style>
   .contact-details label 
   {
		display: block;  
		margin-bottom: 2px;  
	}
   </style>
   </head>
   <body class="hold-transition sidebar-mini">
     
      <div class="wrapper">
      @include('common.header') 
      <div class="content-wrapperd">	 
		<section class="content">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-bd lobidrag">
						<div class="panel-heading">
							<div class="btn-group" id="buttonlist">
								<a class="btn btn-add" href="javascript:void(0);"> <i class="fa fa-list"></i> Transport Allotment </a>
							</div>
						</div>
						<div class="panel-body">
							<form class="col-sm-6" role="form" name="transport_allotment" id="transport_allotment" method="post" action="{{ url('transportAllotment') }}">
								@csrf

								<div class="form-group">
									<label for="transport_name">Transport Name <span style="color:#ff0000;">*</span></label>
									<input type="text" class="form-control" name="transport_name" id="transport_name" placeholder="Enter Transport Name" required>
									<div class="contact-details"> 
										<label>Email : &nbsp;<span id="email_spnId"></span></label> 
										<label>GSTNO : <span id="gst_label"></span></label> 
										<label>Phone : &nbsp;<span id="phone"></span></label>
									</div>
									<input type="hidden" name="individual_id" id="individual_id" value="">
									<input type="hidden" name="pack_ord_Id" id="pack_ord_Id" value="<?=$packOrdId;?>">
								</div>

								<div class="form-group">
									<label for="booking_date">Booking Date</label>
									<input type="text" class="form-control" name="booking_date" id="booking_date" placeholder="Booking Date" required>
								</div>
								
								<div class="form-group">
									<label for="lr_number">LR Number</label>
									<input type="text" class="form-control" name="lr_number" id="lr_number" placeholder="Enter LR Number" required>
								</div>
								
								<div class="form-group">
									<label for="station">Station</label>
									<input type="text" class="form-control" name="station" id="station" placeholder="Enter LR Number" required>
								</div>							
								
								<div class="form-group">
									<label for="features">Features</label>
									<input type="text" class="form-control" name="features" id="features" placeholder="Enter Features" required>
								</div>

								<div class="reset-button">
									<button type="submit" name="submit" class="btn btn-success">Save</button>
									<button class="btn btn-warning" onclick="resetForm()">Reset</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	
      
      </div>
      <!-- /.content-wrapper --> 
	  @include('common.footer') 
	  </div>
	  @include('common.formfooterscript') 
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>    
 
<script>
function resetForm() 
{
	var siteUrl = "{{url('/')}}"; 
	document.getElementById("transport_name").value = "";
	document.getElementById("individual_id").value = "";  		
	window.location.reload();  
}
</script>
 
<script>
$("#booking_date").datepicker(
	{
		dateFormat: "dd-mm-yy",
		 minDate: -15,
        maxDate: 15,
		autoclose: true, 
		 
	});
</script>
 
  
<script type="text/javascript">
  $(function () {
	var siteUrl = "{{url('/')}}";

	$("#transport_name").autocomplete({
	  minLength: 0,
	  source: siteUrl + "/list_transport",
	  focus: function (event, ui) {
		$("#transport_name").val(ui.item.name);
		return false;
	  },
	  select: function (event, ui) {
		var individualId = ui.item.id; 
		 
		$("#individual_id").val(ui.item.id);
		$("#transport_name").val(ui.item.name);
		$("#mobile").val(ui.item.phone); 
		$("#email_spnId").html(ui.item.email);
		$("#gst_label").html(ui.item.gstin);
		$("#phone").html(ui.item.phone);
		 
		return false;
	  },
	}).autocomplete("instance")._renderItem = function (ul, item) {
	  return $("<li>").append("<div>" + item.name + "<br> GSTIN - " + item.gstin + "</div>").appendTo(ul);
	};
  });
</script>   
	   
   </body>
</html>
