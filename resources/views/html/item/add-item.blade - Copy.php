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
        <h1>Add Item</h1>
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
              <form  files='true' name="productEdit" id="productEdit" method="post" action="{{ route('store_item')}}">
                @csrf


                <div class="col-sm-6">
                    <div class="form-group">

                        <label for="ItemType">Item Type <span class="required">*</span></label>
                        <select class="form-control" name="item_type_id" required id="item_type_id">
                              <option value=""> Select Type</option>
                            @foreach($dataIT as $data)
                              <option value="{{ $data->item_type_id  }}"> {{ $data->item_type_name }} </option>
                            @endforeach
                        </select>

                      </div>

                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Unit Price <span class="required">*</span></label>
                        <input type="number" class="form-control" name="unit_price" required id="unit_price" placeholder="Unit Price" step=".01">
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
                        <label> Purchase Rate  <span class="required">*</span></label>
                        <input type="number" class="form-control" name="pur_rate" id="pur_rate" required placeholder="Enter Purchase Rate" step=".01">
                      </div>
                </div>
              

			  <div class="col-sm-6">
                    <div class="form-group">
                        <label> Item Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="item_name" id="item_name" required placeholder="Enter Name" >
                      </div>
                </div>



                <div class="col-sm-6">
                    <div class="form-group">
                    <label> IGST Rate  <span class="required">*</span></label>
                  
					 <select class="form-control" name="igst" required id="igst">
                              <option value=""> Select IGST</option>
                            @foreach($IgstAr as $key => $val)
                              <option value="{{ $val  }}"> {{ $val }} </option>
                            @endforeach
                        </select>
					
                  </div>
                </div>
				
				 <div class="col-sm-6">
                    <div class="form-group">
                    <label> SGST Rate  <span class="required">*</span></label>
                  
					 <select class="form-control" name="sgst" required id="igst">
                              <option value=""> Select IGST</option>
                            @foreach($SgstAr as $key => $val)
                              <option value="{{ $val  }}"> {{ $val }} </option>
                            @endforeach
                        </select>
					
                  </div>
                </div>



                <div class="col-sm-6">
                    <div class="form-group">
                    <label> CGST Rate  <span class="required">*</span></label>
                  
					 <select class="form-control" name="cgst" required id="igst">
                              <option value=""> Select IGST</option>
                            @foreach($CgstAr as $key => $val)
                              <option value="{{ $val  }}"> {{ $val }} </option>
                            @endforeach
                        </select>
					
                  </div>
                </div>
				
				
				
				
                <div class="col-sm-6">
                    <div class="form-group">
                    <label> Item Code <span class="required">*</span></label>
                    <input type="text" class="form-control" name="item_code" id="item_code" placeholder="Enter Item Code" >
                  </div>
                </div>



                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Sale Rate</label>
                        <input type="number" class="form-control" name="sale_rate" id="sale_rate" placeholder="Enter Sale Rate" step=".01">
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Internal Item Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="internal_item_name" id="internal_item_name" placeholder="Internal Item Name" >
                      </div>
                </div>


                <div class="col-sm-6">

                    <div class="form-group">
                        <label>GSM <small>(Grams per square Metre)</small> </label>
                        <input type="number" class="form-control" name="item_gsm" id="item_gsm" placeholder="Enter GSM Value" step=".01">
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>HSN CODE <span class="required">*</span></label>
                        <input type="text" class="form-control" name="hsncode" id="hsncode" placeholder="HSN CODE" >
                      </div>
                </div>



                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Cut </label>
                        <input type="number" class="form-control" name="cut" id="cut" placeholder="Enter Cut Value" step=".01">
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" id="hsnval_id222">
                        <label>HSN Value </label>
                        <input type="text" class="form-control" name="hsn_value" id="hsn_value" placeholder="HSN Value" >
                      </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Remarks </label>
                        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter Remarks">
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Conusmable </label>
                        <div class="form-check-inline">
                          <label class="form-check-label">
                          <input type="radio" class="form-check-input" id="is_conusmable" checked name="is_conusmable" value="1">
                          Use For Production
                          <input type="radio" class="form-check-input" id="is_conusmable" name="is_conusmable" value="0">
                          Use For Non Production </label>
                        </div>
                      </div>

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
		$('#hsnval_id').hide();
		$().ready(function() {
			$('#hsncode').on('keyup change', function() {
				 var hsncode = $(this).val();
				 $('#hsn_value').val(hsncode);
				// $('#hsnval_id').show();
				// alert(hsncode);

			});
		});
</script>

</body>
</html>
