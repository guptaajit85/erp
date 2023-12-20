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
        <h1>Add Station</h1>
        <small>Station list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-stations') }}"> <i class="fa fa-list"></i> Station List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_station')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label>Station Name <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Station Name">
                </div>
                <div class="form-group">
                  <label>State Name</label>
                  <select class="form-control" name="state_id" id="state_id">

                                       @foreach ($dataI as $data)

                    <option value="{{ $data->id }}">{{ $data->name }}</option>

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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
		$().ready(function() {
			$("#productEdit").validate({
					rules: {
						name: 	{
										required: true,
										minlength: 3,
                              letterswithbasicpunc: true // This is the custom rule for alphabet characters
								   },
                        state_id: 	{
                            required: true,
                        }
							},
					messages: {
						name: {
									required: "<span style='color: red;'>Please enter Station name</span>",
									minlength:"<span style='color: red;'>The name should have at least 3 characters</span>",
                           letterswithbasicpunc: "<span style='color: red;'>Only alphabet characters are allowed</span>"
								},
                  state_id: {
                     required: "<span style='color: red;'>Please select  state name</span>",
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
