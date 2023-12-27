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
        <h1>Add Individual</h1>
        <small>Individual list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row ">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-individuals') }}"> <i class="fa fa-list"></i> Individual List </a> </div>
            </div>
            <div class="panel-body ">
              <form  role="form" name="indvEdit" id="indvEdit" method="post" onSubmit="return validateForm()" action="{{ url('store_individual') }}">
                @csrf

               <div class="col-sm-6">
                <div class="form-group">
                    <label>Individual Type <span class="required">*</span></label>
                    <select class="form-control" required name="type" id="type">						
						<option value="">Select Individuals</option>
						<option value="agents">Agents</option>
						<option value="customers">Customers</option>
						<option value="master">Master</option>                      
						<option value="labourer">Labourer</option>
						<option value="vendors">Vendors</option>
						<option value="transport">Transports</option>
						<option value="employee">Employee</option>
                    </select>
                  </div>
               </div>
			   
               <div class="col-sm-6" id="vendor_type">
                <div class="form-group">
                    <label>Vendor Type <span class="required">*</span></label>
                    <select class="form-control" required name="vendor_type" id="vendor_type">
						<option value="Yarn">Yarn</option>
						<option value="Greige">Greige</option>
						<option value="Chemical">Chemical</option>                      
						<option value="Maintanance">Maintanance</option>             
						<option value="General">General</option>
						 
                    </select>
                  </div>
               </div>
                
			    <div class="col-sm-6">  
				  <div class="form-group">
					<label>GSTIN  <span id="gstinRe" class="required" style="display:none">*</span></label>
					<input type="text" class="form-control" name="gstin" id="gstin" placeholder="Enter GST Number">
				  </div>
				</div>
				    


               <div class="col-sm-6">
                <div class="form-group">
                    <label> Name  <span class="required">*</span></label>
                    <input type="text" class="form-control" name="name" required id="name" placeholder="Enter Name" >
                  </div>
               </div>
			   
			    <div class="col-sm-6" id="processTypeId">
				    <div class="form-group">
						<label> Department </label>
						<select class="form-control" name="process_type_id" id="process_type_id">
							<option value="">Select Process</option>
							<?php foreach($dataPI as $row) { ?>
								<option value="<?=$row->id;?>"><?=$row->process_name;?></option>
							<?php } ?>
						</select>
                  </div>
               </div>

			   
               <div class="col-sm-6">
                <div class="form-group">
                    <label>Mobile  <span class="required">*</span></label>
                    <input type="number" class="form-control" oninput="limitInputLength(this, 10)" required name="phone" maxlength="10" id="phone" placeholder="Enter Mobile">
                  </div>
               </div>
			   
              
			  
               <div class="col-sm-6">
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" class="form-control" name="email" required id="email" placeholder="Enter Email">
                  </div>
               </div>

				<div class="form-group col-sm-6" id="passwordId" style="display:none">
                  <label> Password <span class="required">*</span> </label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>                
				</div>
				
				 <div class="col-sm-6">
                <div class="form-group">
                    <label> Nick Name </label>
                    <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="Enter Nick Name">
                  </div>
               </div>
			   
               
               <div class="col-sm-6">
                <div class="form-group">
                    <label>PAN</label>
                    <input type="text" class="form-control" oninput="limitInputLength2(this, 10)" name="pan" id="pan" placeholder="Enter Pan">
                  </div>
               </div>


               <div class="col-sm-6">
                <div class="form-group">
                    <label>TAN Number</label>
                    <input type="text" class="form-control" name="tanno" oninput="limitInputLength3(this, 10)" id="tanno" placeholder="Enter Tan Number">
                  </div>
               </div>

               <div class="col-sm-6" id="adharcardId" >
                <div class="form-group">
                    <label>Adhaar </label>
                    <input type="number" class="form-control" oninput="limitInputLength4(this, 12)" name="adhar" id="adhar" placeholder="Enter Adhaar Number">
                  </div>
               </div>


               <div class="col-sm-6">
                <div class="form-group">
                    <label>WhatsApp <span class="required">*</span></label>
                    <input type="number" class="form-control" oninput="limitInputLength5(this, 10)" required maxlength="10" name="whatsapp" id="whatsapp" placeholder="Enter WhatsApp Number">
                  </div>
               </div>
               <div class="col-sm-6">
                <div class="form-group">
                    <label>Verified Remark</label>
                    <input type="text" class="form-control" name="verified_remark" id="verified_remark" placeholder="Enter Verified Remark By">
                  </div>
               </div>


               <div class="col-sm-6">

                <div class="form-group">
                    <label>Is Verified </label>
                    <select class="form-control" name="is_verified" id="is_verified">
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  </div>
               </div>
				<div class="col-sm-6">
					<div class="reset-button">
					  <button type="submit" id="submit" name="submit"  class="btn btn-success"> Save </button>
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
	document.getElementById('type').addEventListener('change', function () {
		var selectedType 	= this.value;
		var gstinInput 		= document.getElementById('gstin'); 	
		
		if (selectedType === 'vendors') 
		{			 
			$("#vendor_type").show();			
		} else $("#vendor_type").hide(); 	
		
		if (selectedType === 'employee') 
		{			 
			$("#passwordId").show();	
			$("#adharcardId").hide(); 				
		}
 		if (selectedType === 'transport') 
		{ 
			$("#processTypeId").hide();
			$("#adharcardId").hide(); 		
		} 	
		if (selectedType === 'vendors' || selectedType === 'customers') {
			gstinInput.setAttribute('required', true);
			$("#gstinRe").show();
			
		} else {
			gstinInput.removeAttribute('required');
			$("#gstinRe").hide();
		}
	});
</script>


<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $("#indvEdit").validate({
        rules: {
            type: {
                required: true,
            },
            name: {
                required: true,
            },
            phone: {
                required: true,
                number: true,
                minlength: 10,
            },
            email: {
                required: true,
                email: true,
            },
            whatsapp: {
                required: true,
                number: true,
                minlength: 10,
            },
        },
        messages: {
            type: {
                required: "<span class='required'>Please Select Individual Type.</span>",
            },
            name: {
                required: "<span class='required'>Please enter your name.</span>",
            },
            phone: {
                required: "<span class='required'>Please enter your mobile number.</span>",
                number: "<span class='required'>Please enter a valid mobile number.</span>",
                minlength: "<span class='required'>Please enter a valid mobile number with at least 10 digits.</span>",
            },
            email: {
                required: "<span class='required'>Please enter your email address.</span>",
                email: "<span class='required'>Please enter a valid email address.</span>",
            },
            whatsapp: {
                required: "<span class='required'>Please enter your WhatsApp number.</span>",
                number: "<span class='required'>Please enter a valid WhatsApp number.</span>",
                minlength: "<span class='required'>Please enter a valid WhatsApp number with at least 10 digits.</span>",
            },
        }
    });
});
</script>



<script>
function limitInputLength(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}

function limitInputLength2(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}

function limitInputLength3(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}
function limitInputLength4(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}

function limitInputLength5(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}
</script>
<script type="text/javascript">
function validateForm()
{
  var type = $("#type").val();
  if (type === "customers" || type === "vendors")
  {
    if($('#gstin').val()=='')
    {

         alert("GSTIN must be filled out");
        $( "#gstin" ).focus();
        return false;
    }
  }
   // $('button[type=submit]').prop('disabled', true);
    return true;
}

</script>
<script type="text/javascript">

</script>
</body>
</html>
