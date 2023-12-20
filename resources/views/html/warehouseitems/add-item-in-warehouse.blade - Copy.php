<?php
	use \App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add" href="javascript:void(0);"> <i class="fa fa-list"></i> Warehouse Items </a> </div>
            </div>
            <div class="panel-body">  
              <form method="post" action="{{ route('store_item_in_warehouse')}}" onSubmit="return check_form();" autocomplete="off">
                @csrf
                <div class="row">
                  <div class="col-md-12"> </div>
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>                          
                          
                          <td style="width:150px;"><label for="purchase_number">Invoice Number <span style="color:#ff0000;">*</span></label>
                            <input type="text" id="purchase_number"  class="form-control" required name="purchase_number" class="form-control" value="" >
                          </td>
                          <td style="width:140px;"><label for="purchase_started">Purchase Date   <span style="color:#ff0000;">*</span></label>
                            <input type="text" id="purchase_started" onblur="changedeliveryDate();" placeholder="Select Date" name="purchase_started" class="form-control" required>
                          </td>

						   <td style="width:220px;"><label for="sales_order">Purchase Order</label>
                            <select id="sales_order" name="sales_order" onChange="changePurchaseOrder();"  class="form-control" required>
                              <option value="">Select Purchase Order</option>
                              <option value="direct">Direct</option>
                              <option value="agent">Agent</option>
                              <option value="email">Email</option>
                              <option value="phone">Phone</option>
                              <option value="whatsapp">Whatsapp</option>
                            </select>
                          </td>
                          


                          <td style="width:260px;"><div class="hidden">
                              <label for="exampleInputCategory1">Vendor Type   <span style="color:#ff0000;">*</span></label>
                              <br>
                              <input type="radio" name="cust_type" class="" placeholder="" value="1" checked>
                              Existing &nbsp;&nbsp;&nbsp;
                              <input type="radio" id="cust_type_raw" name="cust_type" class="" placeholder="" value="0" >
                              New </div>
                            <label for="exampleInputCategory1">Vendor Name   <span style="color:#ff0000;">*</span></label>
                            <input type="text" id="cus_name" name="cus_name" class="form-control" placeholder="Vendor Name" required  autofocus="autofocus">
                            <input type="hidden" id="individual_id" name="individual_id" required >
                            <label for="exampleInputCategory1">Phone : <span id="phone"></span> </label>
                            </br>
                            <input type="hidden" name="mobile" id="mobile" class="form-control" placeholder="Mobile"  >
                            <input type="hidden" name="email" id="email" class="form-control" placeholder="Email"  >
                            <label for="exampleInputCategory1">GSTIN :<span id="gst_label"></span></label>
                            <input type="hidden" name="cst" id="cst" class="form-control" placeholder="GSTIN"  >
                            </td>
							<td>
								<label>Billing Address <span style="color:#ff0000;">*</span></label></br>
								<p><span id="billingAddresshghghgh"></span></p>

							</td> 
							
                        </tr>  
						  
                      </tbody>
                    </table>
					
					 <table class="table table-bordered">
                      <tbody>
					  <tr>
                        <td style="width:20%;"><label for="purchase_number">Warehouse  <span style="color:#ff0000;">*</span></label>
                          <select class="form-control" name="warehouseId" required id="warehouseId" onChange="selectCompartment(this.value);">
                            <option value="">Please Select Warehouse  <span style="color:#ff0000;">*</span></option>
                            <?php foreach($dataW as $val) { ?>
                            <option value="<?=$val->id;?>">
                            <?=$val->warehouse_name;?>
                            </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td style="width:20%;" id="warehouseCompIdDiv"></td>
                        <td style="width:20%;">
							<label for="emp_name">Receiver Employee Name  <span style="color:#ff0000;">*</span></label>
							<input type="text" id="emp_name" class="form-control" required name="emp_name" value="">
							<input type="hidden" id="ind_emp_id" class="form-control" name="ind_emp_id" value="">
							<table class="table table-bordered">
							<tbody>
								<span id="warehouseEmpDiv"></span>
							</tbody>
							</table>
						</td>
                        <td style="width:20%;"><label>Reciving Date  <span style="color:#ff0000;">*</span></label>
                          <input type="text" id="receiving_date"  required class="form-control" data-date-format="yyyy-mm-dd" name="receiving_date" class="form-control">
                        </td>
                    
                      </tr>

					  
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12" id="main_div" style="display:nonwe">
                    <div class="form-group form-inline">
                      <div class="hidden">
                        <label for="dis_type">Bill Based</label>
                        <select id="bill_based" name="bill_based" class="form-control" onChange="chkbill_based();">
                          <option value="unit">Unit Rate</option>
                          <option value="price">MRP</option>
                        </select>
                      </div>
                    </div> 

                    <div class="row">
                      <div class="col-xs-12">
                        <!--table part start-->
                        <div class="table-responsive table-responsive-custom">

						 <table class="table table-bordered">
								<tbody>
								 <tr>
									<th>Type</th>
									<th>Item Name</th> 
									<th>Delivery Date</th>								
								  </tr> 
								  <tr>
								  <td>
										<select class="form-control" required name="pur_type" id="pur_type">										 
										  <?php foreach($dataIT as $valIT) { ?>
											<option value="<?=$valIT->item_type_id;?>"> <?=$valIT->item_type_name;?> </option>
										  <?php } ?>
										</select>
									</td>
									<td>
										<input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name" >
										<input type="hidden" id="pro_id" name="pro_id">
									</td> 
									
								  
									<td><input type="text" id="delivery_date" name="delivery_date" class="form-control"></td>
								  </tr> 
								</tbody>
							</table> 
							
							
							
							
                          <table class="table table-bordered">
                            <tbody>
                              <tr>

                                <td style="width:8%">
                                  <div class="input-group ">
                                    <p class="mrplabel">MRP</p>
                                    <input type="text" id="mrp" name="mrp"  class="form-control" placeholder="0">
                                  </div>
								</td>
                                <td style="width:8%"><div class="input-group ">
                                    <p >Prch. P</p>
                                    <input type="text" min="0" id="price" name="price" style="width:95px;"  class="form-control" placeholder="0"  >
                                  </div>
								</td>
                                <td style="width:110px;"><div class="input-group">
                                    <p>HSN/SAC</p>
                                    <input type="text" id="hsn" name="hsn" class="form-control" placeholder="HSN/SCN" value="">
                                  </div>
								</td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>Quantity</p>
                                    <input type="text" id="qty" name="qty" class="form-control" placeholder="Quantity" value="1">
                                  </div>
								</td>  
                                <td><div class="input-group">
                                    <p>Unit</p>
                                    <select id="unit" name="unit" class="form-control" onChange="changeUnit();"  style="width:84px;">
                                      <?php foreach($dataUT as $utVal) { ?>
										<option value="<?=$utVal->unit_type_id;?>"> <?=$utVal->unit_type_name;?> </option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </td>                                
                                <td style="width:6%" id="meterId">								
								  <div class="input-group">
                                    <p>Meter</p>
                                    <input type="text" id="meter" name="meter" class="form-control" value="0">
                                  </div>								  
								</td>
 
                                <td style="width:10%"><div class="input-group">
                                    <label for="dis_type">Dis Type</label>
                                    <select id="dis_type" name="dis_type" class="form-control" onChange="calculateprice();">
                                      <option value="%">%</option>
                                      <option value="r">Rs.</option>
                                    </select>
                                    <p>Discount </p>
                                    <input type="text" id="profit" name="profit" class="form-control" placeholder="Discount" value="0" >
                                    <input type="hidden" id="profitrs" name="profitrs" value="0">
                                  </div>
								</td>
								
                                <td style="width:10%"><div class="input-group">
                                    <p>Taxable Amt</p>
                                    <input type="text" id="saleprice_wot" name="saleprice_wot" onChange="calculateprice();" class="form-control" placeholder="Taxable Amount" >
                                  </div></td>
                                <td style="width:6%"><div class="input-group">
                                    <p>CGST %</p>
                                    <SELECT id="cgst" name="cgst" class="form-control" style="width:75px;">
                                      <option value="0">0</option>
                                      @foreach($CgstAr as $key => $val)
                                        <option value="{{ round($val) }}">{{$val}}</option>
                                      @endforeach
                                    </select>
                                    <input type="hidden" id="cgstrs" name="cgstrs" value="0">
                                  </div></td>

                                  <td style="width:6%"><div class="input-group">
                                    <p>SGST %</p>
                                    <SELECT id="sgst" name="sgst" class="form-control" style="width:75px;">
                                      <option value="0">0</option>
                                      @foreach($SgstAr as $key => $val)
                                        <option value="{{ round($val) }}">{{$val}}</option>
                                      @endforeach
                                    </select>
                                    <input type="hidden" id="sgstrs" name="sgstrs" value="0"   >
                                  </div></td>

                                <td style="width:6%"><div class="input-group">
                                    <p>IGST %</p>
                                    <SELECT id="igst" name="igst" class="form-control " style="width:75px;">
                                      <option value="0">0</option>
                                      @foreach($IgstAr as $key => $val)
                                        <option value="{{ round($val) }}">{{$val}}</option>
                                      @endforeach
                                    </select>
                                    <input type="hidden" id="igstrs" name="igstrs" value="0"  >
                                  </div></td>
                                <td style="width:6%; display:none;" ><div class="input-group">
                                    <p>CESS</p>
                                    <input type="hidden" id="cess" name="cess" class="form-control" placeholder="CESS" value="0">
                                    <input type="hidden" id="cessrs" name="cessrs"  value="0">
                                  </div></td>
                                <td style="width:10%"><div class="input-group">
                                    <p>Tax Amt</p>
                                    <input type="text" id="taxrs" name="taxrs" onChange="calculateprice();" class="form-control" placeholder="Tax Amount" >
                                    <input type="hidden" id="saleprice" name="saleprice" class="form-control" placeholder="Unit Price After Discount" readonly >
                                  </div>
								</td> 
								<td style="width:10%">
								   <label for="remarks">Remark</label>
                                  <input type="text" id="remarks"  class="form-control" name="remarks" value="" >
                                </td>

                                <td style="width:10%"><div class="input-group">
                                    <p>Net Price</p>
                                    <input type="text" id="final_price" name="final_price" class="form-control" placeholder="Net Price After Discount" readonly>
                                  </div></td>
                                <td style="width:30px;"><button type="button" id="Add_To_Purchase" class="btn btn-primary">+</button></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!--table part end-->
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="box-body">

					   <table id="example1" class="table table-bordered table-striped">
                          <thead>
						  <tr>
								<th>Item Type</th>
								<th>Item Name</th> 
								<th>Delivery Date </th>
							</tr>
						   </thead>
						    <tbody id="trExt" style="max-height: 100%;overflow-y: auto;overflow-x: hidden;">
							</tbody>
						  </table>


                        <table id="example2" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <!--<th>#</th>  -->

                              <th style="width:80px;" class="mrplabel">MRP</th>
                              <th style="width:100px;">Prch. P</th>
                              <th style="width:100px;">HSN/SAC</th>
                              <th style="width:100px;">Qty</th> 
                              <th style="width:100px;">Unit</th> 
                              <th style="width:100px;">Meter</th> 
                              <th style="width:100px;">Discount</th>
                              <th style="width:100px;">Taxable Amt</th>
                              <th style="width:100px;">CGST</th>
                              <th style="width:100px;">SGST</th>
                              <th style="width:100px;">IGST</th>
                              <th style="width:100px; display:none;">CESS</th>
                              <th style="width:100px;">Tax Amt</th>
                              <th style="width:100px;">Remarks</th>
                              <th style="width:100px;">Net Price</th>
                              <th style="width:30px;">Action</th>
                            </tr>
                          </thead>
                          <tbody id="tbody" style="max-height: 200px;overflow-y: auto;overflow-x: hidden;">
                          </tbody>
                          <tfoot>
                            <tr>
                              <th></th>
                              <th></th> 
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th> 
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th> 
                              <th>Total</th>
                              <th colspan="2"><input type="number" name="total" id="total" min="0" value="0" step=".01" class="form-control" readonly></th>
                            </tr>
                            <tr>
                              <th></th>
                              <th></th>  
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Frieght</th>
                              <th colspan="2"><input type="number" name="frieght" id="frieght" value="0" min="0" step=".01" class="form-control" ></th>
                              <th style="width:125px;">Round Off</th>
                              <th colspan="2"><input type="number" name="discount" id="discount" value="0" min="0" step=".01" class="form-control" ></th>
                              <th>G. Total</th>
                              <th colspan="2"><input type="number" name="subtotal" id="subtotal" value="0" min="0" step=".01" class="form-control" readonly></th>
                            </tr>
                          </tfoot>
                        </table>
                      
					  
					  </div>
                    </div>
                    <button type="button" class="btn btn-danger" id="confirmBtn" style="display:none"><i class="fa fa-times"></i> Discard</button>
                    <button type="submit" class="btn btn-primary pull-left" id="resetBtn" style="display:none">Confirm</button>
                  </div>
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
@include('common.formfooterscript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function () {
	var siteUrl = "{{url('/')}}";

	$("#emp_name").autocomplete({
		minLength: 0,
		source: siteUrl + '/' + "list_employee",
		focus: function (event, ui) {
			$("#emp_name").val(ui.item.name);
			$("#ind_emp_id").val(ui.item.id);
			return false;
		},
		select: function (event, ui) {
			$("#emp_name").val(ui.item.name); // Optional: Set the name again
			$("#ind_emp_id").val(ui.item.id);
			return false;
		}
	}).autocomplete("instance")._renderItem = function (ul, item) {
		return $("<li>")
			.append("<div>" + item.name + "</div>")
			.appendTo(ul);
	};
	 
});
</script>


<script type="text/javascript">
 
$(document).ready(function () {
	var siteUrl = "{{url('/')}}";

	$("#cus_name").autocomplete({
		minLength: 0,
		source: siteUrl + '/' + "list_vendor",
		focus: function (event, ui) {
			var individualId = ui.item.id;
			getVendorAddress(individualId); 
			$( "#individual_id" ).val( ui.item.id );
			$( "#cus_name" ).val( ui.item.name );
			$( "#mobile" ).val( ui.item.phone );
			$( "#email" ).val( ui.item.email );
			$( "#vat" ).val( ui.item.vat );
			$( "#cst" ).val( ui.item.gstin );
			$( "#phone" ).html( ui.item.phone );
			$( "#gst_label" ).html( ui.item.gstin );
			if( $('#com_state').val() == $('#state').val() )
			{
				$('#cgst').attr('readonly',false);
				$('#sgst').attr('readonly',false);
				$('#igst').attr('readonly',true);
			}else{
				$('#cgst').attr('readonly',true);
				$('#sgst').attr('readonly',true);
				$('#igst').attr('readonly',false);
			}
			return false;
		},
		select: function (event, ui) {
			var individualId = ui.item.id;
			getVendorAddress(individualId); 
			$("#cus_name").val(ui.item.name); // Optional: Set the name again
			$("#individual_id").val(ui.item.id);
			return false;
		}
	}).autocomplete("instance")._renderItem = function (ul, item) {
		return $("<li>")			 
			.append( "<div>" + item.name + "<br> GSTIN - " + item.gstin + "</div>" )
			.appendTo(ul);
	};
	 
});
</script>

<script type="text/javascript">
function getVendorAddress(individualId)
{  alert('dsdsdsdsd');
	$.ajax({
	type: "GET",
		url: siteUrl + '/' +"ajax_script/search_vendor_address",
			data: {
				"_token": "{{ csrf_token() }}",
				"individualId":individualId,
			},
		cache: false,
		success: function(res)
		{
			alert(res);
			$( "#billingAddresshghghgh" ).html(res);
			// $( "#address" ).html( ui.item.state_name );

		}
	})
}

</script>
<script type="text/javascript">

	$("#invoice_number").blur(function(){
		var InvoiceNum = $('#invoice_number').val();
		$.ajax({
		type: "GET",
			url: siteUrl + '/' +"ajax_script/getPurchaseItemDetails",
			data: {
				"_token": "{{ csrf_token() }}",
				"InvoiceNum":InvoiceNum,
			},
			cache: false,
			success: function(res)
			{
				$( "#vendorDetailId" ).html(res);
			}
		})

	});
</script>
<!---------search_warehouse_compartment -- getWarehouseCompEmployee-------------->
<script type="text/javascript">
function selectCompartment(Id)
{
//	alert(Id);

	$.ajax({
		type: "GET",
			url: siteUrl + '/' +"ajax_script/search_warehouse_compartment",
				data: {
					"_token": "{{ csrf_token() }}",
					"Id":Id,
				},
			cache: false,
			success: function(res){

					$( "#warehouseCompIdDiv" ).html(res);


			}
	})

}

function selectEmployee(Id)
{
	// alert(Id);

	$.ajax({
		type: "GET",
			url: siteUrl + '/' +"ajax_script/getWarehouseCompEmployee",
				data: {
					"_token": "{{ csrf_token() }}",
					"Id":Id,
				},
			cache: false,
			success: function(msg){
					var data = msg.split("||");

					// alert(data);
					$( "#emp_name" ).val(''+data[1]+'');
					$( "#ind_emp_id" ).val(''+data[0]+'');




			}
	})

}


</script>
<script type="text/javascript">
	var siteUrl = "{{url('/')}}";
	function calcAddress(stateId)
	{
		$('#com_state').val(stateId);
		$('#main_div').show();
	}
	function getVendorAddress(individualId)
	{
		 $.ajax({
			type: "GET",
				url: siteUrl + '/' +"ajax_script/search_vendor_address",
					data: {
						"_token": "{{ csrf_token() }}",
						"individualId":individualId,
					},
				cache: false,
				success: function(res){

						$( "#address" ).html(res);
						// $( "#address" ).html( ui.item.state_name );

				}
		})
	}

</script>
<script>
$("#purchase_started,#receiving_date").datepicker({
	dateFormat: "dd-mm-yy",
	autoclose: true,
});

function check_form()
{
	if( !$('#cust_type_raw').is(':checked'))
	{
		if($('#individual_id').val() == "")
		{
			alert("Please select a vendor.");
			$('#cus_name').focus();
			return false;
		}
	}

	if(parseInt($('#count_product').val()) == 0)
	{
		alert("Please Add a product in purchase List.");
		$('#product_name').focus();
		return false;
	}
	else{
		// return false;
		return true;
	}
}
</script>

 
</body>
</html>
