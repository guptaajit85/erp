<?php
// echo $indID; exit;
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
        <h1>Add Individual Address</h1>
        <small>Individual Address list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-individualaddresses') }}"> <i class="fa fa-list"></i> Individual Address List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" name="productEdit" id="productEdit" method="post" action="{{ route('store_individual_member_address') }}">
                @csrf
                <div class="form-group">
						<input type="hidden" class="form-control" name="individual_id" id="individual_id" value="<?=$indID;?>">
					<label> Individual Name <span style="color:#ff0000;">: </span>  </label> 
					<p class="form-control"> <?=$dataM->name;?> </p> 
                </div>
                <div class="form-group">
                  <label> Address Type <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="address_type" id="address_type">
                    <option value="none" selected disabled hidden>Select an Option</option>
                    <option value="s"> Shipping</option>
                    <option value="b"> Billing</option>
                  </select>
                </div>
                <div class="form-group">
                  <label> Address 1 <span style="color:#ff0000;">*</span> </label>
                  <input type="text" class="form-control" name="address_1" id="address_1" placeholder="Enter Address 1 " value="{{ old('address_1') }}" required>
                </div>
                <div class="form-group">
                  <label> Address 2 <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="address_2" id="address_2"
                                            placeholder="Enter Address 2 " value="{{ old('address_2') }}" >
                </div>
                <div class="form-group">
                  <label> State Name <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="state_id" id="state_id">
                    <option value="none" selected disabled hidden>Select an Option</option>
                    

                                            @foreach ($dataI as $data)

                    
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                    

                                            @endforeach


                  
                  </select>
                </div>
                <div class="form-group">
                  <label> City <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="city" id="city"
                                            placeholder="Enter City " value="{{ old('city') }}" required>
                </div>
                <div class="form-group">
                  <label> Zip Code <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="zip_code" id="zip_code"
                                            placeholder="Enter Zip Code " value="{{ old('zip_code') }}" required>
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js')}}"></script>
<script language="javascript" type="text/javascript">
        $().ready(function() {
            $("#productEdit").validate({
                rules: {
                    address_type: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 1

                    },
                    city: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 1,
                        maxlength: 100

                    },
                    zip_code: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength:6

                    }
                },
                messages: {
                    address_type: {
                        required: "<span style='color: red;'>Please enter a Address Type</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum One letters</span>"

                    },
                    city: {
                        required: "<span style='color: red;'>Please enter a City Name</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum One letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    zip_code: {
                        required: "<span style='color: red;'>Please enter an Zip Code</span>",
                        digits: "<span style='color: red;'>Only Numbers are allowed</span>",
                        minlength: "<span style='color: red;'>Zip Code should have exactly 6 Numbers</span>",
                        maxlength: "<span style='color: red;'>Zip Code should have exactly 6 Numbers</span>"

                    }
                }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet  are allowed</span>");
       });
    </script>
</body>
</html>
