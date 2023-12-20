<?php
use App\Http\Controllers\CommonController;

  // echo "<pre>"; print_r($dataW);  exit;

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
        <h1>Update Warehouse Compartment</h1>
        <small> Warehouse Compartment list</small> </div>
    </section>
    {!! CommonController::display_message('message') !!}
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-warehousecompartment') }}"> <i class="fa fa-list"></i> Ware House  Compartment List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_warehousecompartment') }}">
                @csrf
                <div class="form-group">
                  <label> Warehouse Compartment Name   <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="warehouseCompartmentname" value="{{ htmlentities($data->warehousename) }}" id="warehouseCompartmentname" placeholder="Enter Warehouse Compartment Name" required>
                  <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                </div>
                <div class="form-group">
                  <label>Warehouse Name  <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="warehouseid" id="warehouseid">
					<?php foreach($dataW as $val) {   ?>
					<option value="<?=$val->id;?>"<?php if($data->warehouseid == $val->id) { ?> selected <?php } ?>> {{ $val->warehouse_name }}</option>
					<?php } ?>
                  </select>

                </div>
                <div class="form-group">
                  <label>Employee Name  <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="ind_emp_id" id="ind_emp_id">

						@foreach ($dataI as $row)

                    <option value="{{ $row->id }}" @if($row->id == $data->ind_emp_id) selected="selected" @endif > {{ $row->name }} </option>

						@endforeach

                  </select>
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
                  warehouseCompartmentname: {
                        required: true,
                       // letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    }
                },
                messages: {
                  warehouseCompartmentname: {
                        required: "<span style='color: red;'>Please enter a Name</span>",
                       // letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Warehouse Compartment Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a  Warehouse Compartment Name of Minimum Hundred letters</span>"

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
