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
        <h1>Add Machine</h1>
        <small> Machine list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-machines') }}"> <i class="fa fa-list"></i> Machine  List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('store_machine') }}">
                @csrf
                <div class="form-group">
                  <label> Name <span class="required" style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter  Machine Name" required>
                </div>
                <div class="form-group">
                  <label> Process Wise <span class="required" style="color:#ff0000;">*</span></label>

				  <select class="form-control" name="process_wise"  id="process_wise">
							<option value="">Select Process</option>
					  <?php foreach($dataPI as $row) { ?>
							<option value="<?=$row->id;?>"> <?=$row->process_name;?></option>
					  <?php } ?>
				  </select>
                </div>
				
				<div class="form-group">
					<label for="busy">Is machine busy? <span class="required" style="color:#ff0000;">*</span></label>
					<div>
						<label>
							<input type="radio" id="busy-yes" name="is_busy" value="yes"> Yes
						</label>
						<label>
							<input type="radio" id="busy-no" name="is_busy" value="no"> No
						</label>
					</div>
				</div>

                <div class="reset-button">
                  <input type="submit" name="submit" value="Save" id="disableButton" class="btn btn-success">
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
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100

                    },
                    process_wise:{
                                required:true
                            }
                },
                messages: {
                    name: {
                        required: "<span style='color: red;'>Please enter a Name</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    process_wise:{
                            required:"<span style='color: red;'>Please select proccess wise</span>"
                    }
                }
            });

            $("input").keyup(function(){
                var nameVal =  $('#name').val();
                //alert(nameVal);
                $("#disableButton").removeAttr('disabled');
                if(nameVal.length > 0){
                    //alert(nameVal);
                   $("form").submit(function () {
                        // prevent duplicate form submissions
                        $(this).find(":submit").attr('disabled', 'disabled');
                    });
               } else {
                $("#disableButton").removeAttr('disabled');
               }

            });

            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet  are allowed</span>");
       });
    </script>
</body>
</html>
