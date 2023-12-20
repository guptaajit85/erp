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
        <h1>Update Machine</h1>
        <small>Machine list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-machines') }}"> <i class="fa fa-list"></i> Machine List </a> </div>
            </div>
            <div class="panel-body">
              <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_machine') }}">
                @csrf
                <div class="form-group">
                  <label> Machine <span style="color:#ff0000;">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ htmlentities($data->name) }}" placeholder="Enter Machine Name" required>
                  <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->id) }}"  >
                </div>
                <div class="form-group">
                   <label> Process Wise <span style="color:#ff0000;">*</span></label>
					<select class="form-control" name="process_wise"  id="process_wise">
						<option value="">Select Process</option>
						@foreach($dataPI as $row)
							<option value="<?=$row->id;?>" @if($data->process_wise == $row->id) selected="selected" @endif> <?=$row->process_name;?></option>
						@endforeach
					</select>
                </div>
				
				<div class="form-group">
					<label for="busy">Is machine busy? <span class="required" style="color:#ff0000;">*</span></label>
					<div>
						<label>
							<input type="radio" @if($data->is_busy == '1') checked @endif id="busy-yes" name="is_busy" value="1"> Yes
						</label>
						<label>
							<input type="radio" @if($data->is_busy == '0') checked @endif id="busy-no" name="is_busy" value="0"> No
						</label>
					</div>
				</div>


				<div class="reset-button">
					<input type="submit" name="submit" value="Save" id="disableButton" class="btn btn-success">
					<input type="reset" class="btn btn-warning" value="Reset">
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
        $().ready(function() {
            var nameVal =  $('#name').val();
            $("#domainEdit").validate({
                rules: {
                    name: {
                        required: true,
                        letterswithbasicpunc: true,
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
                        letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    process_wise:{
                        required:"<span style='color: red;'>Please select proccess wise</span>"
                }
                }
            });

            $("input").keyup(function(){
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
