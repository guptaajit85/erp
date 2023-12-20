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
        <h1>Update Individual Address</h1>
        <small>Individual Address List</small> </div>
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
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post"
                                    action="{{ url('/update_individualaddress') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label> Individual Name   <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="individual_id" id="individual_id">
                    <option value="none" selected disabled hidden>Select an Option</option>

                                            @foreach ($dataM as $data2)

                    <option value="{{ $data2->id }}"@if($data2->id==$data->individual_id) selected="selected" @endif;>{{ $data2->name }}</option>

                                            @endforeach


                  </select>
                  <input type="hidden" class="form-control" name="ind_add_id" id="ind_add_id"
                                        value="{{ htmlentities($data->ind_add_id) }}">
                </div>
                <div class="form-group">
                  <label> Address Type   <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="address_type" id="address_type">
                    <option value="s" @if($data->address_type =='s') selected="selected" @endif; > Shipping</option>
                    <option value="b" @if($data->address_type =='b') selected="selected" @endif;>  Billing</option>
                  </select>
                </div>
                <div class="form-group">
                  <label> Address 1   <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="address_1" id="address_1"
                                            value="{{ htmlentities($data->address_1) }}" placeholder="Enter Address 1 "
                                            required>
                </div>
                <div class="form-group">
                  <label> Address 2   <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="address_2" id="address_2"
                                            value="{{ htmlentities($data->address_2) }}" placeholder="Enter Address 2 "
                                            required>
                </div>
                <div class="form-group">
                  <label> State Name  <span style="color:#ff0000;">*</span> </label>
                  <select class="form-control" name="state_id" id="state_id">
                    <option value="none" selected disabled hidden>Select an Option</option>

                                            @foreach ($dataI as $data1)

                    <option value="{{ $data1->id }}"@if($data1->id==$data->state_id) selected="selected" @endif;>{{ $data1->name }}</option>

                                            @endforeach


                  </select>
                </div>
                <div class="form-group">
                  <label> City   <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="city" id="city"
                                            value="{{ htmlentities($data->city) }}" placeholder="Enter City "
                                            required>
                </div>
                <div class="form-group">
                  <label> Zip Code   <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="zip_code" id="zip_code"
                                            value="{{ htmlentities($data->zip_code) }}" placeholder="Enter City "
                                            required>
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
            $("#domainEdit").validate({
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
