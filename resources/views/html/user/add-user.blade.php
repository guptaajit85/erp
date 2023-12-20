<?php
use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
<style>
        .page1 {
            -moz-column-count: 4;
            -moz-column-gap: 20px; /* Adjust this value as needed */
            -webkit-column-count: 4;
            -webkit-column-gap: 20px; /* Adjust this value as needed */
            column-count: 4;
            column-gap: 20px; /* Adjust this value as needed */
            max-width: 100%; /* Ensure content stays within the available width */
        }

        .page1 ol {
            display: block; 
            margin-bottom: 10px;  
        }
    </style>
</head><body class="hold-transition sidebar-mini">
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
        <h1>Add User</h1>
        <small>User list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-users') }}"> <i class="fa fa-list"></i> User List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-12" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_user') }}" enctype="multipart/form-data">
                @csrf
				
				<div class="col-sm-6">
                <div class="form-group">
                    <label>Individual Type <span class="required">*</span></label>
                    <select class="form-control" name="type" id="type">
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
			   
			   <div class="col-sm-6">  
				  <div class="form-group">
					<label>GSTIN  <span id="gstinRe" class="required" style="display:none">*</span></label>
					<input type="text" class="form-control" name="gstin" id="gstin" value="{{ old('gstin') }}" placeholder="Enter GST Number">
				  </div>
				</div>
				    
                <div class="form-group col-sm-6">
                  <label> Name <span class="required">*</span> </label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Name" required value="{{ htmlentities($dataI->name) }}">                   
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Email Id <span class="required">*</span></label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Id" value="{{ htmlentities($dataI->email) }}" required>
                </div>
				
               
                <div class="form-group col-sm-6">
                  <label> Password <span class="required">*</span> </label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}" required>
                <!---- <small><span style='color: red;'>Note:One Capital letter ,one small letter one special character and one number are required</span></small>  ---->
				</div>
				
                <div class="form-group col-sm-6">
                  <label> Phone Number <span class="required">*</span></label>
                  <input type="tel" class="form-control" name="phone_no" id="phone_no" placeholder="Enter 10-digit Phone Number" maxlength="10" value="{{ htmlentities($dataI->phone) }}" required>
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Whatsapp Number <span class="required">*</span></label>
                  <input type="tel" class="form-control" name="whatsapp" id="whatsapp" placeholder="Enter 10-digit Whatsapp Number" maxlength="10" value="{{ htmlentities($dataI->whatsapp) }}" required>
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Emergency Phone Number </label>
                  <input type="tel" class="form-control" name="emergency_phone" id="emergency_phone" placeholder="Enter 10-digit Emergency Phone Number" maxlength="10" value="{{ old('emergency_phone') }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label>Residential Address </label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="{{ old('address') }}" >
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Profile Photo </label>
                  <input type="file" class="form-control" name="photo" id="photo" placeholder="Enter Photo" value="{{ old('photo') }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Aadhar Number </label>
                  <input type="text" class="form-control" name="aadhar_number" id="aadhar_number" placeholder="Enter Aadhar Number" value="{{ htmlentities($dataI->adhar) }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Aadhar Card Photo </label>
                  <input type="file" class="form-control" name="aadhar_photo" id="aadhar_photo" placeholder="Enter Aadhar Photo" value="{{ old('aadhar_photo') }}" >
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Voter Id </label>
                  <input type="text" class="form-control" name="voter_id" id="voter_id" placeholder="Enter Voter Id" value="{{ old('voter_id') }}" >
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Voter Card Photo </label>
                  <input type="file" class="form-control" name="voter_photo" id="voter_photo" placeholder="Enter Voter Photo" value="{{ old('voter_photo') }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Pan Number <span class="required">*</span> </label>
                  <input type="text" class="form-control" name="pan_number" id="pan_number" required placeholder="Enter Pan Number" value="{{ htmlentities($dataI->pan) }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Pan Card Photo </label>
                  <input type="file" class="form-control" name="pan_photo" id="pan_photo"  placeholder="Enter Pan Card Photo" value="{{ old('pan_photo') }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Family  Member Name </label>
                  <input type="text" class="form-control" name="fam_name" id="fam_name" placeholder="Enter Family Member Name" value="{{ old('fam_name') }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Family Member Phone Number  <span class="required">*</span></label>
                  <input type="tel" class="form-control" name="fam_phone" id="fam_phone" placeholder="Enter 10-digit Family Member Phone Number" maxlength="10" value="{{ old('fam_phone') }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Reference </label>
                  <input type="text" class="form-control" value="{{ old('reference') }}" name="reference" id="reference" placeholder="Enter Reference">
                </div>

				
			   <div class="col-sm-6">
                  <div class="form-group">
                    <label>Verified Remark</label>
                    <input type="text" class="form-control" value="{{ old('verified_remark') }}" name="verified_remark" id="verified_remark" placeholder="Enter Verified Remark By">
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
            <!---
				<div class="form-group col-sm-12"> <br/>
					<label class="control-label no-padding-right" for="form-field-1"> Page </label>
					<?php // $pagename = CommonController::getAllPages(); ?>					
					<div class="col-sm-12"><? // =$pagename;?></div>
				</div>
			----->	  
                <div class="reset-button col-sm-12">
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
document.getElementById('type').addEventListener('change', function () {
    var selectedType = this.value;
    var gstinInput = document.getElementById('gstin'); 
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
        $().ready(function() {
            $("#productEdit").validate({
                rules: {
                    user_name: {
                        required: true,
                    //    letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    },
                    name: {
                        required: true,
                        letterswithbasicpunccc: true,
                        minlength: 3,
                        maxlength: 100

                    },
                    phone_no: {
                        required: true,
                        phoneval: true
                    },
                    emergency_phone: {
                        required: true,
                        phoneval: true
                    },
                    fam_phone: {
                        required: true,
                        phoneval: true
                    },

                    address: {
                        required: true,
                        minlength: 3,
                        maxlength:200

                    },
                    pan_number: {
                        required: true,
                        letterswithbasicpuncc: true,
                        minlength: 10,
                        maxlength: 10

                    },                    
                    fam_name: {
                        required: true,
                        letterswithbasicpunccc: true,
                        minlength: 3,
                        maxlength:100

                    }, 
                    password: {
                        required: true,
                      //   passwordreg: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    page_name: {
                        required: true,
                        minlength: 3,
                    },
                    voter_id: {
                        required: true,
                        alphanumeric: true,
                        minlength: 10,
                        maxlength:10
                    }
                },
                messages: {
                    user_name: {
                        required: "<span style='color: red;'>Please enter a User Name</span>",
                       // letterswithbasicpunc: "<span style='color: red;'>Only alphabet characters are allowed without space</span>",
                        minlength: "<span style='color: red;'>Please enter a User Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a User Name of Minimum Hundred letters</span>"

                    },
                    name: {
                        required: "<span style='color: red;'>Please enter a Name</span>",
                        letterswithbasicpunccc: "<span style='color: red;'>Only alphabet characters are allowed </span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    phone_no: {
                        required: "<span style='color: red;'>Please enter a Phone Number</span>",
                        phoneval: "<span style='color: red;'>Only numbers are allowed </span>"
                    },

                    emergency_phone: {
                        required: "<span style='color: red;'>Please enter a Phone Number</span>",
                        phoneval: "<span style='color: red;'>Only numbers are allowed </span>"
                    },
                    fam_phone: {
                        required: "<span style='color: red;'>Please enter a Phone Number</span>",
                        phoneval: "<span style='color: red;'>Only numbers are allowed </span>"
                    },

                    address: {
                        required: "<span style='color: red;'>Please enter a Address</span>",
                        minlength: "<span style='color: red;'>Please enter a Address of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Address of Minimum Two Hundred letters</span>"

                    },
                    pan_number: {
                        required: "<span style='color: red;'>Please enter a Pan Number</span>",
                        letterswithbasicpuncc: "<span style='color: red;'>Only valid Pan Number allowed without space</span>",
                        minlength: "<span style='color: red;'>Please enter a Pan Number of exactly 10  Number</span>",
                        maxlength: "<span style='color: red;'>>Please enter a Pan Number of exactly 10  Number</span>"

                    }, 
                    fam_name: {
                        required: "<span style='color: red;'>Please enter a Family Member Name</span>",
                        letterswithbasicpunccc: "<span style='color: red;'>Only alphabet characters are allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Family Member Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Family Member Name of Minimum  Hundred letters</span>"

                    },
                   

                    password: {
                        required: "<span style='color: red;'>Please enter Password</span>",
                     //   passwordreg: "<span style='color: red;'>One Capital letter ,one small letter one special character and one number are required</span>",
                        minlength: "<span style='color: red;'>Please enter a Password of Minimum Eight Characters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Password of Maximum Twenty Characters</span>"
                        },

                    page_name: {
                        required: "<span style='color: red;'>Please enter a Page</span>",
                        minlength: "<span style='color: red;'>Please enter a Page of Minimum Three letters</span>",

                    },

                    voter_id: {
                    required: "<span style='color: red;'>Please enter an Voter Number</span>",
                    alphanumeric: "<span style='color: red;'>Only alphanumeric characters are allowed</span>",
                    minlength: "<span style='color: red;'>Voter Number should have exactly 10 characters</span>",
                    maxlength: "<span style='color: red;'>Voter Number should have exactly 10 characters</span>"
                    }
            }
            });


        /*    jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed without space</span>");
*/
            jQuery.validator.addMethod("letterswithbasicpuncc", function(value, element) {
                return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed without space</span>");

            jQuery.validator.addMethod("phoneval", function(value, element) {
                return this.optional(element) || /^[1-9]{1}\d{9}$/i.test(value);
            }, "<span style='color: red;'>Phone Number should be valid</span>");

            jQuery.validator.addMethod("letterswithbasicpunccc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed without space</span>");

            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                console.log("Validating alphanumeric:", value); // Check if this message appears in the console
                return this.optional(element) || /^[A-Za-z0-9]*$/i.test(value);
            }, "<span style='color: red;'>Only alphanumeric characters are allowed</span>");

            jQuery.validator.addMethod("passwordreg", function(value, element) {
                console.log("Validating alphanumeric:", value); // Check if this message appears in the console
                return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
            }, "<span style='color: red;'>Only alphanumeric characters are allowed</span>");

        });
    </script>
</body>
</html>
