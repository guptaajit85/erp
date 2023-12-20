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
        <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-purchases')}}"> <i class="fa fa-list"></i> New Purchase </a> </div>
            </div>
            <div class="panel-body">
              <form method="post" action="{{ route('store_purchase')}}" onSubmit="return check_form();" autocomplete="off">
                @csrf
                <div class="row">
                  <div class="col-md-12"> </div>
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <tbody>

                        <tr>
                          <td style="width:155px;"><label for="purchase_number">Type  <span style="color:#ff0000;">*</span></label>
                            <select class="form-control" required name="pur_type" id="pur_type">
                             
                              <?php foreach($dataIT as $valIT) { ?>
                              <option value="<?=$valIT->item_type_id;?>">
                              <?=$valIT->item_type_name;?>
                              </option>
                              <?php } ?>
                            </select>
                          </td>
                          <td style="width:150px;"><label for="purchase_number">Invoice Number  <span style="color:#ff0000;">*</span></label>
                            <input type="text" id="purchase_number"  class="form-control" name="purchase_number" class="form-control" value="" >
                          </td>
                          <td style="width:140px;"><label for="purchase_started">Purchase Date   <span style="color:#ff0000;">*</span></label>
                            <input type="text" id="purchase_started" onblur="changedeliveryDate();"  class="form-control" data-date-format="yyyy-mm-dd" name="purchase_started" class="form-control" value="" readonly>
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
                          <td style="width:170px;">
						  <span id="agentId">
							<label for="sale_order_number">Agent Name</label>
                            <select class="form-control" name="ind_agent_id" id="ind_agent_id">
							<option>Select Agent</option>
                              <?php foreach($dataI as $valIT) { ?>
                              <option value="<?=$valIT->id;?>"> <?=$valIT->name;?> </option>
                              <?php } ?>
                            </select>
							</span>
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
                            <p>
                              <input type="hidden" required name="state" id="state">
                            </p></td>
                          <td><label>Billing Address   <span style="color:#ff0000;">*</span></label>
                            </br>
                            <p><span id="billingAddress"></span></p></td>

							<!--</br>
                          <td><label for="exampleInputCategory1">Shiping Address </label>
                            <p><span id="Shipaddress"></span></p></td>-->

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
									<th>Item Name</th>
									<th>Greige/Quality</th>
									<th>Dyeing/Color</th>
									<th>Coated/PVC</th>
									<th>Print Job</th>
									<th>Extra Job</th>
									<th>Expected Delivery Date</th>
								  </tr> 
								  <tr>
									<td>
									<input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name" >
									</td> <input type="hidden" id="pro_id" name="pro_id"  >
									<td><input type="text" id="grey_quality" name="grey_quality" class="form-control" placeholder="Greige or Quality Name"></td>
									<td><input type="text" id="dyeing_color" name="dyeing_color" class="form-control" placeholder="Dyeing or Color Name"></td>
									<td><input type="text" id="coated_pvc" name="coated_pvc" class="form-control" placeholder="Coated or PVC Name"></td>
									<td><input type="text" id="print_job" name="print_job" class="form-control" placeholder="Print Job"></td>
									<td><input type="text" id="extra_job" name="extra_job" class="form-control" placeholder="Extra Job"></td>
									<td><input type="text" id="expect_delivery_date" name="expect_delivery_date" class="form-control" value="<?=$ExpDeliveryDate;?>"></td>
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
                                  </div></td>
                                <td style="width:8%"><div class="input-group ">
                                    <p >Prch. P</p>
                                    <input type="text" min="0" id="price" name="price" style="width:95px;"  class="form-control" placeholder="0"  >
                                  </div></td>
                                <td style="width:110px;"><div class="input-group">
                                    <p>HSN/SAC</p>
                                    <input type="text" id="hsn" name="hsn" class="form-control" placeholder="HSN/SCN" value="">
                                  </div></td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>Quantity</p>
                                    <input type="text" id="qty" name="qty" class="form-control" placeholder="Quantity" value="1">
                                  </div></td>  
                                <td><div class="input-group">
                                    <p>Unit</p>
                                    <SELECT id="unit" name="unit" class="form-control " style="width:84px;">
                                      <?php foreach($dataUT as $utVal) { ?>
										<option value="<?=$utVal->unit_type_id;?>"> <?=$utVal->unit_type_name;?> </option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </td>

                                <td style="width:6%"><div class="input-group">
                                    <p>PCs</p>
                                    <input type="text" id="pcs" name="pcs" onBlur="calculate_price();" class="form-control" value="1">
                                  </div></td>
                                <td style="width:6%"><div class="input-group">
                                    <p>CUT</p>
                                    <input type="text" id="cut" name="cut" onBlur="calculate_price();" class="form-control" value="1">
                                  </div></td>
                                <td style="width:6%"><div class="input-group">
                                    <p>Meter</p>
                                    <input type="text" id="meter" name="meter" readonly onBlur="calculate_price();" class="form-control" value="1">
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
                                  </div></td>
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
								<th>Item Name</th>
								<th>Greige/Quality</th>
								<th>Dyeing/Color</th>
								<th>Coated/PVC</th>
								<th>Print Job</th>
								<th>Extra Job</th>
								<th>Expect Delivery Date </th>
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
                              <th style="width:100px;">PCs</th>
                              <th style="width:100px;">Cut</th>
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                    <button type="submit" class="btn btn-primary pull-left">Confirm</button>
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
	function changePurchaseOrder()
	{  
		var saleOrderDate  = $('#sales_order').val(); 
		if(saleOrderDate =='agent')
		{
			$("#agentId").show();			
		} 
		else 
		{
			$("#agentId").hide();
		}	 
	}
</script>

<script type="text/javascript">
function calculate_price()
	{
		var cut 		= parseFloat($('#cut').val());
		var pcs 		= parseFloat($('#pcs').val());
		var meter 		= parseFloat($('#meter').val());
		var rate 		= parseFloat($('#rate').val());
		var dis_type 	= parseFloat($('#dis_type').val());
		var discount 	= parseFloat($('#discount').val());
		var meterV 		= cut * pcs;

		$('#meter').val(meterV.toFixed(2));

		var amount 		= meterV * rate;
		$('#amount').val(amount.toFixed(2));

		if(dis_type =='1')
		{
			var discountRs = (amount * discount)/100;
		} else if(dis_type =='2')
		{
			var discountRs = discount;
		}
		else
		{
			var discountRs = (amount * discount)/100;
		}

		var final_price = amount-discountRs;
		$('#final_price').val(final_price);
		$('#discount_amount').val(discountRs);
	}

    
</script>


<script type="text/javascript">
var siteUrl = "{{url('/')}}";
function calcAddress(stateId)
{
	$('#state').val(stateId);
	$('#main_div').show();
	$('#final_price').val('');
	$('#profit').val('0');
	$('#profitrs').val('0');
	$('#igst').val('0');
	$('#cgst').val('0');
	$('#sgst').val('0');
	$('#igstrs').val('0');
	$('#cgstrs').val('0');
	$('#sgstrs').val('0');
	$('#cess').val( '0' ) ;
	$('#cessrs').val( '0' ) ;
	$('#taxrs').val( '0' ) ;
	$('#saleprice_wot').val('');
	$('#product_name').val('');



	$('#mrp').val('');
	$('#price').val('');
	// calculateprice();
}


</script>

<script>

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

		return true;
	}
}

$( "#expect_delivery_date" ).datepicker(
	{
		dateFormat: "dd-mm-yy",
	autoclose: true,

	} );


$("#purchase_started2,#expect_delivery_date2").datepicker(
	{
		dateFormat: "dd-mm-yy",
		autoclose: true,
		onSelect: function(date) {
			changedeliveryDate();
		 },
	});



  $( function() {

	   var siteUrl = "{{url('/')}}";
	   $( "#product_name" ).autocomplete({
		 source: function(request, response) {
            $.ajax({
				url: siteUrl + '/' +"list_item_type",
                dataType: "json",
                data: {
                    term : request.term,
                    type : $('#pur_type').val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        min_length: 3,
		focus: function( event, ui ) {
		if(ui.item.part_number != '')
		{
			$( "#product_name" ).val( ui.item.item_name);
			//$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code );
		}else{
			$( "#product_name" ).val( ui.item.item_name );
		}
		return false;
	  },
	  select: function( event, ui ) {

		$( "#pro_id" ).val( ui.item.item_id);
		$( "#unit" ).val( ui.item.unit_type.unit_type_id);
		if(ui.item.part_number != '')
		{
			$( "#product_name" ).val( ui.item.item_name );
			//$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code);
		}else{
			$( "#product_name" ).val( ui.item.item_name );
		}
		$( "#mrp" ).val( ui.item.unit_price );
		$( "#price" ).val( ui.item.pur_rate );
		$( "#hsn" ).val( ui.item.hsncode );
		$( "#grey_quality" ).val( ui.item.internal_item_name );
		$( "#grey_quality" ).val( ui.item.internal_item_name );
		var com_state = $('#com_state').val();
		var state = $('#state').val();

		if( $('#com_state').val() == $('#state').val() )
		{
			var gst = ui.item.igst/2;
			$( '#cgst  option[value="'+gst+'"]' ).prop('selected',true);
			$( '#sgst  option[value="'+gst+'"]' ).prop('selected',true);
		}
		else
		{
		   $( '#igst  option[value="'+ui.item.igst+'"]' ).prop('selected',true);
		}


		$( "#saleprice" ).val( ui.item.sale_rate );
	    calculateprice();


		return false;
	  }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {

	 var purType = $('#pur_type').val();
	 console.log(purType);
	  return $( "<li>" )
		.append( "<div>" + item.item_name + "<br> Item Code: " + item.item_code + "<br> Internal Name:" + item.internal_item_name + " </div>" )
		.appendTo( ul );
	};

///////////////////////////////////////////////////////////////////////////////////

	  $('#profit,#qty,#meter,#cut,#pcs,#cess').blur(function(){
		  calculateprice();
	  });

	  $('#sgst,#cgst,#igst').change(function(){
		  if( $('#com_state').val() == $('#state').val() )
		  {
			  $('#sgst').val( $('#cgst').val() ).attr('readonly',false);
		  }

		  calculateprice();
	  });
	  $('#dis_type').change(function(){
		  $('#profit').trigger('blur');
	  });

	   function calculatepurchaseprice()
	   {
            var cut 		= parseFloat($('#cut').val());
		    var pcs 		= parseFloat($('#pcs').val());
		    var meter 		= parseFloat($('#meter').val());
          var dis_type  = $('#dis_type').val();
		  var price = parseFloat($('#price').val());
		  var profit = $('#profit').val() != '' ? parseFloat($('#profit').val()) : 0 ;
		  var sgst = parseFloat($('#sgst').val());
		  var cgst = parseFloat($('#cgst').val());
		  var igst = parseFloat($('#igst').val());
		  var qty = parseFloat($('#qty').val());
		  var cess = parseFloat($('#cess').val());
		  var taxrs = parseFloat($('#taxrs').val());

		  var taxrs = 0;
		  var tax = 0;
		   alert($('#com_state').val() +"=="+ $('#state').val());

		  if( $('#com_state').val() == $('#state').val() )
		  {
			  taxrs = sgstrs + cgstrs;
			  tax = cgst*2;
		  }else{
			  taxrs = igstrs;
			  tax = igst;
		  }
		 //  alert(sgst +'--'+ cgst);
		  var pp = parseFloat($('#saleprice_wot').val()) - parseFloat($('#profitrs').val());

		  $('#price').val( (pp + (pp*tax)/100).toFixed(2) );

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

							$( "#billingAddress" ).html(res);
							// $( "#address" ).html( ui.item.state_name );

					}
			})
	    }
//below function using for fetching venders shipping address
 function getCustomerShipAddress(individualId)
	   {
			 $.ajax({
				type: "GET",
					url: siteUrl + '/' +"ajax_script/search_customer_ship_address",
						data: {
							"_token": "{{ csrf_token() }}",
							"individualId":individualId,
						},
					cache: false,
					success: function(res){

							$( "#Shipaddress" ).html(res);
							// $( "#Shipaddress" ).html( ui.item.state_name );

					}
			})
	    }


	    function calculateprice()
	    {
			var dis_type = $('#dis_type').val();
			//  alert('Address check');
			var price = parseFloat($('#price').val());
			var profit = $('#profit').val() != '' ? parseFloat($('#profit').val()) : 0 ;
			var sgst = parseFloat($('#sgst').val());
			var cgst = parseFloat($('#cgst').val());
			var igst = parseFloat($('#igst').val());

			var cess = parseFloat($('#cess').val());
			var cut 		= parseFloat($('#cut').val());
			var pcs 		= parseFloat($('#pcs').val());
			var meter 		= parseFloat($('#meter').val());
			var qty         = parseFloat($('#qty').val());
			// var qty = meter;

		  if(price < 0)
		  {
			  alert('Please enter valid amount.');
			  $('#price').val(0);
		  }
		  if($('#profit').val() != '')
		  {
			  if(dis_type=='%')
			  {
				  // alert('1');
				  if(profit < 90)
				  {
					  var profitRs = (price * profit)/100;
				  }else{
					  alert("Given Discount not permitted");
					  $('#profit').val(0);
				  }
			  }else{
				  // alert('2');
				  if(profit < price)
				  {
						var profitRs = profit;
				  }else{
					  alert("Given Discount not permitted");
					  $('#profit').val(0);
				  }
			  }
			  $('#profitrs').val(profitrs);
		  }else{
			  $('#profitrs').val(0);
			  profitRs = 0;
		  }

		var saleprice = price - profitRs;
		var saleprice_wot = saleprice * qty;

		var cessrs = saleprice_wot  * $('#cess').val()/100;
		var saleprice = saleprice + (saleprice_wot * $('#cess').val()/100);
		var final_price = ( saleprice  * qty );

		var taxrs = 0;
		  console.log(price +'--'+final_price);
			if( !isNaN(price) || final_price > 0)
			{
			  if( $('#com_state').val() == $('#state').val() )
			  {
				  var cgstrs = saleprice_wot * cgst/100;
				  $('#cgstrs').val( parseFloat(cgstrs.toFixed(2) )) ;
				  var sgstrs = saleprice_wot  * sgst /100;
				  $('#sgstrs').val( parseFloat(sgstrs.toFixed(2) ) );
				  taxrs = taxrs + cgstrs + sgstrs;

			  }else{
				  var igstrs = saleprice_wot  * igst/100;
				  $('#igstrs').val( parseFloat(igstrs.toFixed(2) ) );
				  taxrs = taxrs + igstrs;
			  }

				$('#cessrs').val( cessrs.toFixed(2) ) ;

				taxrs = parseFloat(taxrs) + parseFloat(cessrs);
				console.log(taxrs);

				$('#taxrs').val( taxrs.toFixed(2) ) ;
				$('#saleprice').val(saleprice.toFixed(2));
				$('#final_price').val((final_price + taxrs).toFixed(2));
				$('#saleprice_wot').val(saleprice_wot.toFixed(2));


		  }else{
			  // alert("Please Select a product");
			  $('#saleprice').val('');

				$('#final_price').val('');
				$('#profit').val('0');
				$('#profitrs').val('0');
				$('#igst').val('0');
				$('#cgst').val('0');
				$('#sgst').val('0');
				$('#igstrs').val('0');
				$('#cgstrs').val('0');
				$('#sgstrs').val('0');
				$('#cess').val( '0' ) ;
				$('#cessrs').val( '0' ) ;
				$('#taxrs').val( '0' ) ;
				$('#saleprice_wot').val('');

			  $('#product_name').focus();
			  return false;
		  }
	   }


	   $('#total,#discount,#frieght').change(function(){

		  var total = parseFloat($('#total').val());

		  var frieght = parseFloat($('#frieght').val());
		  var discount = parseFloat($('#discount').val());

		  var subtotal = frieght+total-discount;
		  $('#subtotal').val(subtotal.toFixed(2));

	  });
		$('[data-toggle="tooltip"]').tooltip();



	function changedeliveryDate()
	{
		var saleOrderDate  = $('#purchase_started').val();
		var ExpDeliveryDate = '<?php echo $ExpDeliveryDate;?>';
		if(saleOrderDate)
		{
			var inputDate = $('#purchase_started').val();
			var daysToAdd = <?php echo $expDeliverydays;?>;

			// alert(daysToAdd);
			var newDate = addDaysToDate(inputDate, daysToAdd);
			$('#expect_delivery_date').val(newDate);
		}
		else
		{
			$('#expect_delivery_date').val(ExpDeliveryDate);

		}
	}

	$( "#purchase_started" ).datepicker(
	{
		autoclose: true,

	} );


	$( "#cus_name" ).autocomplete({


	 minLength: 0,
	  source: siteUrl + '/' +"list_vendor",
	  focus: function( event, ui ) {
		$( "#cus_name" ).val( ui.item.name );
		return false;
	  },
	  select: function( event, ui ) {

		var individualId = ui.item.id;
		getVendorAddress(individualId);
		getCustomerShipAddress(individualId);
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
	  }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
	  return $( "<li>" )
		.append( "<div>" + item.name + "<br> GSTIN - " + item.gstin + "</div>" )
		.appendTo( ul );
	};
 
		$('#purchase_number').blur(function()
		{
			if($('#purchase_number').val().length>2)
			{
				var id = $('#purchase_number').val();
				$.ajax({
					type: "POST",
						url: siteUrl + '/' +"ajax_script/search_purchase_number",
							data: {
								"_token": "{{ csrf_token() }}",
								"purchase_number":id,
							},
						cache: false,
						success: function(res){
							if(res!=1)
							{
								alert("You have entereds Duplicate Purchase Number");
								$('#purchase_number').val('').focus();
							}
						}
				})
			}
		});


	});


   </script>
   
  <script>
  $('#Add_To_Purchase').click(function()
		{
			if($('#product_name').val() != '' )
			{
				$('#example2').show();
				if( $('#final_price').val() !=0)
				{
					var count_product = parseInt( $('#count_product').val() ) +1;
					var total = parseFloat($('#total').val()) + parseFloat($('#final_price').val());

					var new_pro2 = "<tr id='trr_"+count_product+"'>"+
					"<th><input readonly value='"+$('#product_name').val()+"' type='text' class='form-control' name='product_name_arr[]'></th>"+
					"<th><input readonly value='"+$('#grey_quality').val()+"' type='text' class='form-control' name='grey_quality[]'></th>"+
					"<th><input readonly value='"+$('#dyeing_color').val()+"' type='text' class='form-control' name='dyeing_color[]'></th>"+
					"<th><input readonly value='"+$('#coated_pvc').val()+"' type='text' class='form-control' name='coated_pvc[]'></th>"+
					"<th><input readonly value='"+$('#print_job').val()+"' type='text' class='form-control' name='print_job[]'></th>"+
					"<th><input readonly value='"+$('#extra_job').val()+"' type='text' class='form-control' name='extra_job[]'></th>"+
					"<th><input readonly value='"+$('#expect_delivery_date').val()+"' type='text' class='form-control' name='expect_delivery_date[]'></th>"+
					"</tr>";


					var new_pro = "<tr id='tr_"+count_product+"'>"+
					"<input value='"+$('#pro_id').val()+"' type='hidden' name='pro_id_arr[]' readonly><input value='"+$('#dis_type').val()+"' type='hidden' name='dis_type_arr[]' readonly>"+
					"<td><input readonly value='"+$('#mrp').val()+"' type='text' class='form-control' name='mrp_arr[]'></td>"+
					"<td><input readonly value='"+$('#price').val()+"' type='text' class='form-control' name='price_arr[]'></td>"+
					"<td><input readonly value='"+$('#hsn').val()+"' type='text' class='form-control' name='hsn_arr[]'></td>"+
					 
					"<td><input readonly value='"+$('#qty').val()+"' type='text' class='form-control' name='qty_arr[]'></td>"+
					"<td><input readonly value='"+$('#unit').val()+"' type='text' class='form-control' name='unit_arr[]'></td>"+
                    "<td><input readonly value='"+$('#pcs').val()+"' type='text' class='form-control' name='pcs_arr[]'></td>"+
			        "<td><input readonly value='"+$('#cut').val()+"' type='text' class='form-control' name='cut_arr[]'></td>"+
			        "<td><input readonly value='"+$('#meter').val()+"' type='text' class='form-control' name='meter_arr[]'></td>"+
					"<td><input value='"+$('#profit').val()+"' type='text' class='form-control' name='discount_arr[]' readonly></td>"+
					"<td><input readonly value='"+$('#saleprice_wot').val()+"' type='text' class='form-control' name='saleprice_wot_arr[]'></td>"+
					"<td><input readonly value='"+$('#cgstrs').val()+"' type='text' class='form-control' name='cgstrs_arr[]'><input readonly value='"+$('#cgst').val()+"' type='hidden' class='form-control' name='cgst_arr[]'></td>"+
					"<td><input readonly value='"+$('#sgstrs').val()+"' type='text' class='form-control' name='sgstrs_arr[]'><input readonly value='"+$('#sgst').val()+"' type='hidden' class='form-control' name='sgst_arr[]'></td>"+
					"<td><input readonly value='"+$('#igstrs').val()+"' type='text' class='form-control' name='igstrs_arr[]'><input readonly value='"+$('#igst').val()+"' type='hidden' class='form-control' name='igst_arr[]'></td>"+

					"<td style='display:none;'><input readonly value='"+$('#cessrs').val()+"' type='text' class='form-control' name='cessrs_arr[]'><input readonly value='"+$('#cess').val()+"' type='hidden' class='form-control' name='cess_arr[]'></td>"+
					"<td><input readonly value='"+$('#taxrs').val()+"' type='text' class='form-control' name='taxrs_arr[]'><input value='"+$('#saleprice').val()+"' type='hidden' class='form-control' name='saleprice_arr[]'></td>"+
					"<td><input readonly value='"+$('#remarks').val()+"' type='text' class='form-control' name='remarks_arr[]'></td>"+
					"<td><input readonly value='"+$('#final_price').val()+"' type='text' class='form-control total_arr' name='total_arr[]'></td>"+
					 
					
					"<td><a data-toggle='tooltip' href='javascript:void(0);' onclick='removeRows(\"trr_" + count_product + "\", \"tr_" + count_product + "\", " + $('#saleprice').val() + ");' title='Remove'><span class='glyphicon glyphicon-remove-circle remove' data-trid='tr_" + count_product + "' ></span></a></td>" +
					 
					"</tr>";
 
					$('#trExt').append(new_pro2);
					$('#tbody').append(new_pro);
					$('#count_product').val(count_product);
					$('#product_name,#price,#saleprice').val('');
					$('#qty').val('');
                    $('#pcs').val('1');
			        $('#cut').val('1');
			        $('#meter').val('1');
					$('#total').val(total.toFixed(2)).trigger('change');
					$('#pro_id').val(0);
					$('#saleprice').val('');
					$('#final_price').val('');
					$('#saleprice_wot').val('');
					$('#profit').val('');
					$('#mrp').val('');
					$('#hsn').val('');
					$('#taxrs').val('');
					$('#remarks').val('');
					$('#igst').val('');
					$('#sgst').val('');
					$('#cgst').val('');
					$('#grey_quality').val('');
					$('#dyeing_color').val('');
					$('#coated_pvc').val('');
					$('#print_job').val('');
					$('#extra_job').val('');
					$('#product_name').focus();
				}else{
					alert("Please Check Discount/Quantity/Tax/Net Price");
					$('#profit').focus();

				}
			}
			else
			{
				$('#product_name').focus();
			}
		});

  </script> 
   
   
   
 <script>
 function removeRows(rowId1, rowId2, salePrice) {
    $("#" + rowId1).remove();
    $("#" + rowId2).remove();
    remove_tr(salePrice);
}
 </script>  
   
   
   
  <script>
  function remove_tr(saleprice)
  {

	  var  total = 0;
	  $('.total_arr').each(function(){

		  total = total+ parseFloat($(this).val());

	  });

	  if(total.toFixed(2) >0)
	  {
		  $('#total').val(total.toFixed(2)).trigger('change');
	  }else{
			$('#total').val(0).trigger('change');
	  }


  }
  </script>
</body>
</html>
