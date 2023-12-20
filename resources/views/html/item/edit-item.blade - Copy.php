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
        <h1>Update Item</h1>
        <small>Item list</small> </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-items') }}"> <i class="fa fa-list"></i> Item List </a> </div>
            </div>
            <div class="panel-body">
              <form  role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_item') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id" value="{{ htmlentities($data->item_id) }}"  >


                <div class="col-sm-6">
                    <div class="form-group">
                    <label> Item Type <span class="required">*</span></label>
                    <select class="form-control" name="item_type_id" id="item_type_id">

                    @foreach($dataIT as $dataV)

                      <option value="{{ $dataV->item_type_id  }}" @if($dataV->item_type_id == $data->item_type_id) selected="selected" @endif; > {{ $dataV->item_type_name }} </option>

                    @endforeach

                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Unit Price <span class="required">*</span></label>
                        <input type="number" class="form-control" name="unit_price" id="unit_price" placeholder="Unit Price" step=".01" value="{{ $data->unit_price }}">
                      </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Unit Type <span class="required">*</span></label>
                        <select class="form-control" name="unit_type_id" id="unit_type_id">

                        @foreach($dataUT as $dataV)

                          <option value="{{ $dataV->unit_type_id  }}" @if($dataV->unit_type_id == $data->unit_type_id) selected="selected" @endif; > {{ $dataV->unit_type_name }} </option>

                        @endforeach

                        </select>
                      </div>
                </div>
                <div class="col-sm-6">
                     <div class="form-group">
                    <label> Purchase Rate </label>
                    <input type="number" class="form-control" name="pur_rate" id="pur_rate" placeholder="Enter Purchase Rate" step=".01" value="{{ $data->pur_rate }}">
                  </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Item Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Enter Name" value="{{ $data->item_name }}">
                      </div>
                </div>
				
                <div class="col-sm-6"> 
				<div class="form-group">
                    <label> IGST Rate</label>
					 <select class="form-control" name="igst" id="igst">
                        @foreach($IgstAr as $key => $val)

                          <option value="{{ $val  }}" @if($val == $data->igst) selected="selected" @endif; > {{ $val }} </option>
                        @endforeach

                        </select>
                  </div>
				 </div>
				  
				 <div class="col-sm-6">
                    <div class="form-group">
                        <label> CGST Rate <span class="required">*</span></label>
                        <select class="form-control" name="cgst" id="cgst">
                        @foreach($CgstAr as $key => $val)

                          <option value="{{ $val  }}" @if($val == $data->cgst) selected="selected" @endif; > {{ $val }} </option>
                        @endforeach

                        </select>
                      </div>
                </div>
				
                <div class="col-sm-6"> <div class="form-group">
                    <label> SGST Rate</label>
					 <select class="form-control" name="sgst" id="sgst">
                        @foreach($SgstAr as $key => $val)

                          <option value="{{ $val  }}" @if($val == $data->sgst) selected="selected" @endif; > {{ $val }} </option>
                        @endforeach

                        </select>
                  </div></div> 

                <div class="col-sm-6">
                    <div class="form-group">
                    <label> Item Code </label>
                    <input type="text" class="form-control" name="item_code" id="item_code" placeholder="Enter Item Code" value="{{ $data->item_code }}">
                  </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Sale Rate</label>
                        <input type="number" class="form-control" name="sale_rate" id="sale_rate" placeholder="Enter Sale Rate" step=".01" value="{{ $data->sale_rate }}">
                      </div>
                </div>

                <div class="col-sm-6">
                <div class="form-group">
                    <label> Internal Item Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="internal_item_name" id="internal_item_name" placeholder="Internal Item Name" value="{{ $data->internal_item_name }}">
                  </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>GSM <small>(Grams per square Metre)</small> </label>
                        <input type="number" class="form-control" name="item_gsm" id="item_gsm" placeholder="Enter GSM Value" step=".01" value="{{ $data->item_gsm }}">
                      </div>
                </div>



                <div class="col-sm-6">
                    <div class="form-group">
                        <label>HSN CODE <span class="required">*</span></label>
                        <input type="text" class="form-control" name="hsncode" id="hsncode" placeholder="HSN CODE" value="{{ $data->hsncode }}">
                      </div>

                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Cut </label>
                        <input type="number" class="form-control" name="cut" id="cut" placeholder="Enter Cut Value" step=".01" value="{{ $data->cut }}">
                      </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Remarks </label>
                        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter Remarks" value="{{ $data->remarks }}">
                      </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Conusmabled </label>
                        <?php
                          $is_conusmable = $data->is_conusmable;

                      ?>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                          <input type="radio" class="form-check-input" id="is_conusmable" name="is_conusmable" <?php echo ($is_conusmable=='1')?'checked':'' ?> value="1">
                          Use For Production
                          <input type="radio" class="form-check-input" id="is_conusmable" name="is_conusmable" <?php echo ($is_conusmable=='0')?'checked':'' ?>  value="0">
                          Use For Non Production </label>
                        </div>
                      </div>
                </div>



                <div class="reset-button">
                  <input type="submit" name="submit" value="Save" class="btn btn-success">
                  <a href="javascript:window.location.href=window.location.href" class="btn btn-warning">Reset</a> </div>
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
<script src="{{ asset('js/jquery-ui-timepicker-addon.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/jquery-ui-timepicker-addon.css') }}">
<script>
	$(function() {
		$( "#dob" ).datepicker({
			changeYear: true ,
			yearRange : 'c-1:c +10',
			changeMonth: true ,
			dateFormat: 'yy-mm-dd',
			todayBtn: 'linked'
		});
	});
</script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
$().ready(function() {
	$("#domainEdit").validate({
			rules: {
				name: "required",
				internal_name: "required",
				external_name: "required",
				dob: "required"
			},
			messages: {
				name: "Please enter name",
				internal_name: "Please enter internal_name",
				external_name: "Please enter external name",
				dob: "Please select date of birth"
			}
		});
});
</script>
</body>
</html>
