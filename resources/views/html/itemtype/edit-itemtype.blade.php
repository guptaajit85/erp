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
        <h1>Update Item Type</h1>
        <small>Item Type list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-itemtypes') }}"> <i class="fa fa-list"></i> Item Type List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_itemtype') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label> Item Type  <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="item_type_name" id="item_type_name" value="{{ htmlentities($data->item_type_name) }}" placeholder="Enter Item Type Name" required>
                  <input type="hidden" class="form-control" name="item_type_id" id="item_type_id" value="{{ htmlentities($data->item_type_id) }}"  >
                </div>

				 <div class="form-group">
                  <label>Select Unit  <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="unit_type_id" id="unit_type_id">

                                       @foreach ($unitTypeData as $data1)

                    <option value="{{ $data1->unit_type_id }}" @if($data1->unit_type_id==$data->unit_type_id) selected="selected" @endif;>{{ $data1->unit_type_name }}</option>

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
                    item_type_name: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    },
					 unit_name: {
                     required: true,
                  }
                },
                messages: {
                    item_type_name: {
                        required: "<span style='color: red;'>Please enter a Item Type Name</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },

				 unit_name: {
                     required: "<span style='color: red;'>Please enter Unit name</span>",
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
