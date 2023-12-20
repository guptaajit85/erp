<?php
use App\Http\Controllers\CommonController;
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
        <h1>Update User</h1>
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
              <form class="col-sm-12" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_user') }}" enctype="multipart/form-data">
                @csrf
                 
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($dataI->id) }}">
               
				<div class="col-sm-6">
                <div class="form-group">
                    <label>Individual type <span class="required">*</span></label>
                    <select class="form-control" name="type" id="type">
                      <option value="customers" @if($dataI->type =='customers') selected="selected" @endif >Customers</option>
                      <option value="master" @if($dataI->type =='master') selected="selected" @endif >Master</option>
                      <option value="agents" @if($dataI->type =='agents') selected="selected" @endif >Agents</option>
                      <option value="labourer" @if($dataI->type =='labourer') selected="selected" @endif >Labourer</option>
                      <option value="vendors" @if($dataI->type =='vendors') selected="selected" @endif >Vendors</option>
                      <option value="transport" @if($dataI->type =='transport') selected="selected" @endif >Transport</option>
                      <option value="employee" @if($dataI->type =='employee') selected="selected" @endif >Employee</option>
                    </select>
                  </div>
               </div>
               <div class="col-sm-6">

                <div class="form-group">
                    <label>GSTIN <span class="required">*</span></label>
                    <input type="text" class="form-control" name="gstin" id="gstin" value="{{ htmlentities($dataI->gstin) }}" placeholder="Enter GST Number">
                  </div>
               </div>
			   
			   
			   <div class="form-group col-sm-6">
                  <label> Name </label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($dataI->name) }}" placeholder="Enter User Name" required>
                </div>
                <div class="form-group col-sm-6">
                  <label> Email Id </label>
                  <input type="email" class="form-control" name="email" id="email" value="{{ htmlentities($dataI->email) }}" placeholder="Enter Email Id" required>
                </div>
                
                <div class="form-group col-sm-6">
                  <label> Password </label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Change Password">
                  <!--- <small><span style='color: red;'>Note:One Capital letter ,one small letter one special character and one number are required</span></small> --->
				</div>
				  
				  
				  
                <div class="form-group col-sm-6">
                  <label> Phone Number </label>
                  <input type="tel" class="form-control" name="phone_no" id="phone_no" value="{{ htmlentities($dataI->phone_no) }}" placeholder="Enter 10-digit Phone Number" maxlength="10" required>
                </div>
                <div class="form-group col-sm-6">
                  <label> Emergency Phone Number </label>
                  <input type="tel" class="form-control" name="emergency_phone" id="emergency_phone" value="{{ htmlentities($dataI->emergency_phone) }}" placeholder="Enter 10-digit Emergency Phone Number" maxlength="10" required>
                </div>
				   <div class="form-group col-sm-6">
                  <label> Whatsapp Number <span class="required">*</span></label>
                  <input type="tel" class="form-control" name="whatsapp" id="whatsapp" placeholder="Enter 10-digit Whatsapp Number" value="{{ htmlentities($dataI->whatsapp) }}"  maxlength="10" value="{{ htmlentities($dataI->whatsapp) }}" required>
                </div>
                <div class="form-group col-sm-6">
                  <label>Residential Address </label>
                  <input type="text" class="form-control" name="address" id="address" value="{{ htmlentities($dataI->address) }}" placeholder="Enter Address" required>
                </div>
                <div class="form-group col-sm-6">
                  <label>Profile Photo </label>
                  <input type="file" class="form-control" name="photo" id="photo" placeholder="Enter Photo"value="{{ htmlentities($dataI->photo) }}">
                </div>
				<div class="form-group col-sm-6">
					<label> Aadhar Number </label>
					<input type="text" class="form-control" name="aadhar_number" id="aadhar_number" value="{{ htmlentities($dataI->aadhar_number) }}" placeholder="Enter Aadhar Numbe" required>
				</div>
                <div class="form-group col-sm-6">
                  <label> Aadhar Card Photo </label>
                  <input type="file" class="form-control" name="aadhar_photo" id="aadhar_photo" placeholder="Enter Aadhar Card Photo"value="{{ htmlentities($dataI->aadhar_photo) }}">
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Voter Id </label>
                  <input type="text" class="form-control" name="voter_id" id="voter_id" value="{{ htmlentities($dataI->voter_id) }}" placeholder="Enter Voter Id" required>
                </div>
                <div class="form-group col-sm-6">
                  <label> Voter Id Photo </label>
                  <input type="file" class="form-control" name="voter_photo" id="voter_photo" placeholder="Enter Voter Id Photo"value="{{ htmlentities($dataI->voter_photo) }}">
                </div>
                <div class="form-group col-sm-6">
                  <label> Pan Number </label>
                  <input type="text" class="form-control" name="pan_number" id="pan_number" value="{{ htmlentities($dataI->pan_number) }}" placeholder="Enter Pan Number" required>
                </div>
                <div class="form-group col-sm-6">
                  <label> Pan Card Photo </label>
                  <input type="file" class="form-control" name="pan_photo" id="pan_photo" placeholder="Enter Pan Card Photo"value="{{ htmlentities($dataI->pan_photo) }}">
                </div>
                <div class="form-group col-sm-6">
                  <label> Family  Member Name </label>
                  <input type="text" class="form-control" name="fam_name" id="fam_name" value="{{ htmlentities($dataI->fam_name) }}" placeholder="Enter Family  Member Name" required>
                </div>
                <div class="form-group col-sm-6">
                  <label> Family Member Phone Number </label>
                  <input type="tel" class="form-control" name="fam_phone" id="fam_phone" value="{{ htmlentities($dataI->fam_phone) }}" placeholder="Enter 10-digit Family Member Phone Number" maxlength="10" required>
                </div>
				
                <div class="form-group col-sm-6">
                  <label> Reference </label>
                  <input type="text" class="form-control" name="reference" id="reference" value="{{ htmlentities($dataI->reference) }}" placeholder="Enter Reference" required>
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
				
                <div class="reset-button col-sm-12">
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
            $("#domainEdit").validate({
                rules: {
                    user_name: {
                        required: true,
                        // letterswithbasicpunc: true,
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
                    reference: {
                        required: true,
                        minlength: 3,
                        maxlength:200

                    },
                    fam_name: {
                        required: true,
                        letterswithbasicpunccc: true,
                        minlength: 3,
                        maxlength:100

                    },
                    aadhar_number: {
                        required: true,
                        digits: true,
                        minlength: 12,
                        maxlength:12

                    },
                    password: {
                        passwordreg: false,
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
                    reference: {
                        required: "<span style='color: red;'>Please enter a reference</span>",
                        minlength: "<span style='color: red;'>Please enter a reference of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a reference of Minimum Two Hundred letters</span>"

                    },
                    fam_name: {
                        required: "<span style='color: red;'>Please enter a Family Member Name</span>",
                        letterswithbasicpunccc: "<span style='color: red;'>Only alphabet characters are allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Family Member Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Family Member Name of Minimum  Hundred letters</span>"

                    },
                    aadhar_number: {
                        required: "<span style='color: red;'>Please enter an Aadhar Number</span>",
                        digits: "<span style='color: red;'>Only Numbers are allowed</span>",
                        minlength: "<span style='color: red;'>Aadhar Number should have exactly 12  Numbers are allowed</span>",
                        maxlength: "<span style='color: red;'>Aadhar Number should have exactly 12  Numbers are allowed</span>"
                    },

                    password: {
                        passwordreg: "<span style='color: red;'>One Capital letter ,one small letter one special character and one number are required</span>",
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


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed without space</span>");

            jQuery.validator.addMethod("letterswithbasicpuncc", function(value, element) {
                return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed without space</span>");

            jQuery.validator.addMethod("letterswithbasicpunccc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed without space</span>");

            jQuery.validator.addMethod("phoneval", function(value, element) {
                return this.optional(element) || /^[1-9]{1}\d{9}$/i.test(value);
            }, "<span style='color: red;'>Phone Number should be valid</span>");

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
