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
        <h1>Update Individual</h1>
        <small>Individual list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-individuals') }}"> <i class="fa fa-list"></i> Individual List </a> </div>
            </div>
            <div class="panel-body">
              <form  role="form" name="indvEdit" id="indvEdit" method="post" onSubmit="return validateForm()" action="{{ url('/update_individual') }}">
                @csrf

               <div class="col-sm-6">
                <div class="form-group">
                    <label>Individual type <span class="required">*</span></label>
                    <select class="form-control" name="type" id="type">
                      <option value="customers" @if($data->type =='customers') selected="selected" @endif >Customers</option>
                      <option value="master" @if($data->type =='master') selected="selected" @endif >Master</option>
                      <option value="agents" @if($data->type =='agents') selected="selected" @endif >Agents</option>
                      <option value="labourer" @if($data->type =='labourer') selected="selected" @endif >Labourer</option>
                      <option value="vendors" @if($data->type =='vendors') selected="selected" @endif >Vendors</option>
                      <option value="transport" @if($data->type =='transport') selected="selected" @endif >Transport</option>
                      <option value="employee" @if($data->type =='employee') selected="selected" @endif >Employee</option>
                    </select>
                  </div>
               </div> 
			   
			   
			   <div class="col-sm-6" id="vendor_type" <?php if($data->type !='vendors') { ?>style="display:none"<?php } ?>>
                <div class="form-group">
                    <label>Vendor Type <span class="required">*</span></label>
                    <select class="form-control" required name="vendor_type" id="vendor_type">
						<option value="Yarn" @if($data->vendor_type =='Yarn') selected="selected" @endif>Yarn</option>
						<option value="Greige" @if($data->vendor_type =='Greige') selected="selected" @endif>Greige</option>
						<option value="Chemical" @if($data->vendor_type =='Chemical') selected="selected" @endif>Chemical</option>                      
						<option value="Maintanance" @if($data->vendor_type =='Maintanance') selected="selected" @endif>Maintanance</option>             
						<option value="General" @if($data->vendor_type =='General') selected="selected" @endif>General</option>						 
                    </select>
                  </div>
               </div>
			   
			   
			    <div class="col-sm-6">  
				  <div class="form-group">
					<label>GSTIN  <span id="gstinRe" class="required" style="display:none">*</span></label>
					<input type="text" class="form-control" name="gstin" id="gstin" value="{{ htmlentities($data->gstin) }}" placeholder="Enter GST Number">
				  </div>
				</div>
			    

               <div class="col-sm-6">
                <div class="form-group">
                    <label> Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($data->name) }}" placeholder="Enter Name" required>
                    <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                  </div>
               </div>
               <div class="col-sm-6">
				<div class="form-group">
                    <label> Process Wise </label>
						<select class="form-control" name="process_type_id" id="process_wise">
							<option value="">Select Process</option>
							<?php foreach($dataPI as $row) { ?>
								<option value="<?=$row->id;?>" @if($row->id == $data->process_type_id) selected="selected" @endif;> <?=$row->process_name;?></option>
							<?php } ?>
						</select>
                  </div>
               </div>
			    
               <div class="col-sm-6">

                <div class="form-group">
                    <label> Nick name </label>
                    <input type="text" class="form-control" name="nick_name" id="nick_name" value="{{ htmlentities($data->nick_name) }}" placeholder="Enter Nick Name" >
                  </div>
               </div>

               <div class="col-sm-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ htmlentities($data->email) }}" placeholder="Enter Email">
                  </div>
               </div>
			   
			   	<div class="form-group col-sm-6" id="passwordId" style="display:none">
                  <label> Password <span class="required">*</span> </label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>                
				</div>
				
               <div class="col-sm-6">
                <div class="form-group">
                    <label>Mobile<span class="required">*</span></label>
                    <input type="number" class="form-control" name="phone" id="phone" maxlength="10" value="{{ htmlentities($data->phone) }}" placeholder="Enter Mobile" required>
                  </div>
               </div>

               <div class="col-sm-6">
                <div class="form-group">
                    <label>PAN Number</label>
                    <input type="text" class="form-control" name="pan" id="pan" value="{{ htmlentities($data->pan) }}" placeholder="Enter PAN Number">
                  </div>
               </div>
               <div class="col-sm-6">

                <div class="form-group">
                    <label>TAN Number</label>
                    <input type="text" class="form-control" name="tanno" id="tanno" value="{{ htmlentities($data->tanno) }}" placeholder="Enter TAN Number">
                  </div>
               </div>

               <div class="col-sm-6">
                <div class="form-group">
                    <label>Adhaar</label>
                    <input type="number" class="form-control"  name="adhar" maxlength="12" id="adhar" value="{{ htmlentities($data->adhar) }}" placeholder="Enter Adhaar Number">
                  </div>
               </div>
               <div class="col-sm-6">
                <div class="form-group">
                    <label>WhatsApp</label>
                    <input type="number" class="form-control" name="whatsapp" maxlength="10" id="whatsapp" value="{{ htmlentities($data->whatsapp) }}" placeholder="Enter WhatsApp Number">
                  </div>
               </div>

               <div class="col-sm-6">
                <div class="form-group">
                    <label>Verified Remark</label>
                    <input type="text" class="form-control" name="verified_remark" value="{{ htmlentities($data->verified_remark) }}" id="verified_remark" placeholder="Enter verified Remark">
                  </div>
               </div>
               <div class="col-sm-6">
                <div class="form-group">
                    <label>Is Verified </label>
                    <select class="form-control" name="is_verified" id="is_verified">
                      <option value="yes"  @if($data->type =='yes') selected="selected" @endif; >Yes</option>
                      <option value="no"  @if($data->type =='no') selected="selected" @endif; >No</option>
                    </select>
                  </div>
               </div>

				<div class="col-sm-12">
					<div class="form-group">
						<div class="reset-button">
							<input type="submit" name="submit" value="Save" class="btn btn-success">							 
							<input type="reset" class="btn btn-warning" value="Reset">
						</div>
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
<script language="javascript" type="text/javascript">
    $(document).ready(function () 
	{ 
        var passwordDiv = $('#passwordId');  
        @if($data->type =='master' || $data->type =='employee')
            passwordDiv.show();
        @endif
    });
</script>



<script language="javascript" type="text/javascript">
	document.getElementById('type').addEventListener('change', function () {
		var selectedType = this.value;
		var gstinInput = document.getElementById('gstin'); 		
		if (selectedType === 'vendors') 
		{			 
			$("#vendor_type").show();			
		} else $("#vendor_type").hide(); 	
		
		if (selectedType === 'employee') 
		{			 
			$("#passwordId").show();			
		} 
		if (selectedType === 'master') 
		{			 
			$("#passwordId").show();
			$("#processTypeId").show();			
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

<script type="text/javascript">
function validateForm()
{
	var type 	= document.forms["indvEdit"]["type"].value;
	var gstin 	= $('#gstin').val();
	if (type === "customers" || type === "vendors") 
	{
		if(empty(gstin))
		{
			alert("GSTIN must be filled out");
		}
		return false;
	}
}

</script>
</body>
</html>
