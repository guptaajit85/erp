<?php
	use \App\Http\Controllers\CommonController; 
	error_reporting(0);
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
						
                          <td style="width:150px;"><label for="purchase_number">Type</label>
						  <select class="form-control" required name="pur_type" id="pur_type">
						  <option value="">Select Type</option>
						  <?php foreach($dataIT as $valIT) { ?>
						  <option value="<?=$valIT->item_type_id;?>"><?=$valIT->item_type_name;?></option>
						  <?php } ?>
						  </select>
                          </td>
						  
                          <td style="width:150px;"><label for="purchase_number">Invoice Number</label>
                            <input type="text" id="purchase_number"  class="form-control" name="purchase_number" class="form-control" value="" >
                          </td>
                          <td style="width:150px;"><label for="purchase_started">Purchase Date</label>
                            <input type="text" id="purchase_started"  class="form-control" data-date-format="yyyy-mm-dd" name="purchase_started" class="form-control" value="" readonly>
                          </td>
                          <td style="width:260px;"><div class="hidden">
                              <label for="exampleInputCategory1">Vendor Type *</label>
                              <br>
                              <input type="radio" name="cust_type" class="" placeholder="" value="1" checked>
                              Existing &nbsp;&nbsp;&nbsp;
                              <input type="radio" id="cust_type_raw" name="cust_type" class="" placeholder="" value="0" >
                              New </div>
                            <label for="exampleInputCategory1">Vendor Name *</label>
                            <input type="text" id="cus_name" name="cus_name" class="form-control" placeholder="Vendor Name" required  autofocus="autofocus">
							<input type="hidden" id="individual_id" name="individual_id" required >
							<label for="exampleInputCategory1">Phone : <span id="phone"></span> </label></br>
                            <input type="hidden" name="mobile" id="mobile" class="form-control" placeholder="Mobile"  >
                            <input type="hidden" name="email" id="email" class="form-control" placeholder="Email"  >
                            <label for="exampleInputCategory1">GSTIN :<span id="gst_label"></span></label>
                            <input type="hidden" name="cst" id="cst" class="form-control" placeholder="GSTIN"  >
							<p>
							<input type="hidden" required name="state" id="state"> 
							</p>
                          </td>

                          
                          
							<td><label>Billing Address </label> </br> 
								<p><span id="billingAddress"></span></p>
							</td>
						  
                        </tr>
                      </tbody>
                    </table>
                  </div>
                 
				 <div class="col-md-12" id="main_div" style="display:none">
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
								<td>
									<p>Product</p>
									<input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name" ></td>

                                <td> 
                                  <input type="hidden" id="pro_id" name="pro_id"  >
                                  <div class="input-group ">
                                    <p class="mrplabel">MRP</p>
                                    <input type="text" id="mrp" name="mrp"  class="form-control" placeholder="0">
                                  </div></td>


                                <td><div class="input-group ">
                                    <p >Prch. P</p>
                                    <input type="text" min="0" id="price" name="price" style="width:70px;"  class="form-control" placeholder="0"  >
                                  </div></td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>HSN/SAC</p>
                                    <input type="text" id="hsn" name="hsn" class="form-control" placeholder="HSN/SCN" value="">
                                  </div></td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>Quantity</p>
                                    <input type="text" id="qty" name="qty" class="form-control" placeholder="Quantity" value="1">
                                  </div></td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>Unit</p>
                                    <SELECT id="unit" name="unit" class="form-control ">
									<?php foreach($dataUT as $utVal) { ?> 
									<option value="<?=$utVal->unit_type_name;?>"><?=$utVal->unit_type_name;?></option>
									<?php } ?>
                                      
                                    </select>
                                  </div></td>
								<td style="width:80px;">
									<div class="input-group">
										<label for="dis_type">Dis Type</label>
										<select id="dis_type" name="dis_type" class="form-control" onChange="calculateprice();">
											<option value="%">%</option>
											<option value="r">Rs.</option>
										</select> 
										<p>Discount </p>
										<input type="text" id="profit" name="profit" class="form-control " placeholder="Discount" value="0" >
										<input type="hidden" id="profitrs" name="profitrs" value="0">
									</div>
								</td>
                                <td style="width:80px;">  
								  <div class="input-group">
                                    <p>Taxable Amt</p>
                                    <input type="text" id="saleprice_wot" name="saleprice_wot" class="form-control" placeholder="Taxable Amount" >
                                  </div>
								</td>
                                <td><div class="input-group">
                                    <p>CGST %</p>
                                    <SELECT id="cgst" name="cgst" class="form-control">
                                      <option value="0">0</option>
                                      <option value="0.125">0.125</option>
                                      <option value="1.5">1.5</option>
                                      <option value="2.5">2.5</option>
                                      <option value="6">6</option>
                                      <option value="9">9</option>
                                      <option value="14">14</option>
                                    </select>
                                    <input type="hidden" id="cgstrs" name="cgstrs" value="0">
                                  </div></td>
                                <td><div class="input-group">
                                    <p>SGST %</p>
                                    <SELECT id="sgst" name="sgst" class="form-control">
                                      <option value="0">0</option>
                                      <option value="0.125">0.125</option>
                                      <option value="1.5">1.5</option>
                                      <option value="2.5">2.5</option>
                                      <option value="6">6</option>
                                      <option value="9">9</option>
                                      <option value="14">14</option>
                                    </select>
                                    <input type="hidden" id="sgstrs" name="sgstrs" value="0"   >
                                  </div></td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>IGST %</p>
                                    <SELECT id="igst" name="igst" class="form-control ">
                                      <option value="0">0</option>
                                      <option value="0.250">0.25</option>
                                      <option value="3">3</option>
                                      <option value="5">5</option>
                                      <option value="12">12</option>
                                      <option value="18">18</option>
                                      <option value="28">28</option>
                                    </select>
                                    <input type="hidden" id="igstrs" name="igstrs" value="0"  >
                                  </div></td>
                                <td style="width:80px;display:none;" >
									<div class="input-group">
                                    <p>CESS</p>
                                    <input type="hidden" id="cess" name="cess" class="form-control" placeholder="CESS" value="0">
                                    <input type="hidden" id="cessrs" name="cessrs"  value="0">
                                  </div></td>
                                <td style="width:80px;"><div class="input-group">
                                    <p>Tax Amt</p>
                                    <input type="text" id="taxrs" name="taxrs" class="form-control" placeholder="Tax Amount" >
                                    <input type="hidden" id="saleprice" name="saleprice" class="form-control" placeholder="Unit Price After Discount" readonly >
                                  </div></td>
                                <td style="width:120px;"><div class="input-group">
                                    <p>Net Price</p>
                                    <input type="text" id="final_price" name="final_price" class="form-control" placeholder="Net Price After Discount" value="" readonly>
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
                              <!--<th>#</th>                                           -->
                              <th style="width:220px;">Product Name</th>
                              <th style="width:80px;" class="mrplabel">MRP</th>
                              <th style="width:80px;">Prch. P</th>
                              <th style="width:80px;">HSN/SAC</th>
                              <th style="width:80px;">Qty</th>
                              <th style="width:80px;">Unit</th>
                              <th style="width:80px;">Discount</th>
                              <th style="width:80px;">Taxable Amt</th>
                              <th style="width:80px;">CGST</th>
                              <th style="width:80px;">SGST</th>
                              <th style="width:80px;">IGST</th>
                              <th style="width:80px; display:none;">CESS</th>
                              <th style="width:80px;">Tax Amt</th>
                              <th style="width:80px;">Net Price</th>
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
                              <th>Total</th>
                              <th colspan="2"><input type="number" name="total" id="total" min="0" value="0" step=".01" class="form-control" readonly></th>
                              <th></th>
                            </tr>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Frieght</th>
                              <th colspan="2"><input type="number" name="frieght" id="frieght" value="0" min="0" step=".01" class="form-control" ></th>
                              <th>Round Off</th>
                              <th colspan="2"><input type="number" name="discount" id="discount" value="0" min="0" step=".01" class="form-control" ></th>
                              <th>G. Total</th>
                              <th colspan="2"><input type="number" name="subtotal" id="subtotal" value="0" min="0" step=".01" class="form-control" readonly></th>
                              <th></th>
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
	calculateprice();
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
		// return false;
		return true;
	}
}

  $( function() {
	 
			
	  
	  $('#profit,#qty,#cess').blur(function(){
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
		  var dis_type = $('#dis_type').val();
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
	   
	    function calculateprice()
	   {
		  var dis_type = $('#dis_type').val();
		   //  alert('Address check');
		  var price = parseFloat($('#price').val());
		  var profit = $('#profit').val() != '' ? parseFloat($('#profit').val()) : 0 ;
		  var sgst = parseFloat($('#sgst').val());
		  var cgst = parseFloat($('#cgst').val());
		  var igst = parseFloat($('#igst').val());
		  var qty = parseFloat($('#qty').val());
		  var cess = parseFloat($('#cess').val());
		 
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
		  // var tax = parseFloat($('#tax').val());
		  var frieght = parseFloat($('#frieght').val());
		  var discount = parseFloat($('#discount').val());
		  // var taxtotal = (total*tax)/100;
		  var subtotal = frieght+total-discount;
		  $('#subtotal').val(subtotal.toFixed(2));
		  // $('#taxrs').val(taxtotal.toFixed(2));
	  });
	$('[data-toggle="tooltip"]').tooltip(); 

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
	//====================
	$( "#product_name" ).autocomplete({
	 minLength: 0,
	 
	  source: siteUrl + '/' +"list_item", 
	  focus: function( event, ui ) {
		if(ui.item.part_number != '')
		{
			$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code );
		}else{
			$( "#product_name" ).val( ui.item.item_name );
		}
		return false;
	  },
	  select: function( event, ui ) {
			// log( "Selected: " + ui.item.value + " aka " + ui.item.id );
		
		//  alert(ui.item.igst);
		
		$( "#pro_id" ).val( ui.item.item_id);
		if(ui.item.part_number != '')
		{
			$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code);
		}else{
			$( "#product_name" ).val( ui.item.item_name );
		}
		$( "#mrp" ).val( ui.item.unit_price );
		$( "#price" ).val( ui.item.pur_rate );
		$( "#hsn" ).val( ui.item.hsncode );
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
	  return $( "<li>" )
		.append( "<div>" + item.item_name +' '+ item.item_code + "</div>" )
		.appendTo( ul );
	};
	
	$('#Add_To_Purchase').click(function(){ 
		if($('#product_name').val() != '' )
		{
			if( $('#final_price').val() !=0)
			{
			var count_product = parseInt( $('#count_product').val() ) +1;
			// alert(parseFloat($('#total').val()) +' -- '+ $('#final_price').val());
			var total = parseFloat($('#total').val()) + parseFloat($('#final_price').val());
			var new_pro = "<tr id='tr_"+count_product+"'>"+
			// "<td>"+count_product+"</td>"+
			"<td><input value='"+$('#pro_id').val()+"' type='hidden' name='pro_id_arr[]' readonly><input value='"+$('#dis_type').val()+"' type='hidden' name='dis_type_arr[]' readonly><input data-toggle='tooltip' value='"+$('#product_name').val()+"' title='"+$('#product_name').val()+"' type='text' class='form-control' name='product_name_arr[]' readonly></td>"+
			"<td><input readonly value='"+$('#mrp').val()+"' type='text' class='form-control' name='mrp_arr[]'></td>"+
			"<td><input readonly value='"+$('#price').val()+"' type='text' class='form-control' name='price_arr[]'></td>"+
			"<td><input readonly value='"+$('#hsn').val()+"' type='text' class='form-control' name='hsn_arr[]'></td>"+
			"<td><input readonly value='"+$('#qty').val()+"' type='text' class='form-control' name='qty_arr[]'></td>"+
			"<td><input readonly value='"+$('#unit').val()+"' type='text' class='form-control' name='unit_arr[]'></td>"+
			"<td><input value='"+$('#profit').val()+"' type='text' class='form-control' name='discount_arr[]' readonly></td>"+
			"<td><input readonly value='"+$('#saleprice_wot').val()+"' type='text' class='form-control' name='saleprice_wot_arr[]'></td>"+
			"<td><input readonly value='"+$('#cgstrs').val()+"' type='text' class='form-control' name='cgstrs_arr[]'><input readonly value='"+$('#cgst').val()+"' type='hidden' class='form-control' name='cgst_arr[]'></td>"+
			"<td><input readonly value='"+$('#sgstrs').val()+"' type='text' class='form-control' name='sgstrs_arr[]'><input readonly value='"+$('#sgst').val()+"' type='hidden' class='form-control' name='sgst_arr[]'></td>"+
			"<td><input readonly value='"+$('#igstrs').val()+"' type='text' class='form-control' name='igstrs_arr[]'><input readonly value='"+$('#igst').val()+"' type='hidden' class='form-control' name='igst_arr[]'></td>"+
			"<td style='display:none;'><input readonly value='"+$('#cessrs').val()+"' type='text' class='form-control' name='cessrs_arr[]'><input readonly value='"+$('#cess').val()+"' type='hidden' class='form-control' name='cess_arr[]'></td>"+
			"<td><input readonly value='"+$('#taxrs').val()+"' type='text' class='form-control' name='taxrs_arr[]'><input value='"+$('#saleprice').val()+"' type='hidden' class='form-control' name='saleprice_arr[]'></td>"+
			"<td><input readonly value='"+$('#final_price').val()+"' type='text' class='form-control total_arr' name='total_arr[]'></td>"+
			"<td><a data-toggle='tooltip' href='javascript:void(0);' onclick='$(\"#tr_"+count_product+"\").remove();remove_tr("+$('#saleprice').val()+");' title='Remove'><span class='glyphicon glyphicon-remove-circle remove' data-trid='tr_"+count_product+"' ></span></a></td>"+
			"</tr>";

			$('#tbody').append(new_pro);
			$('#count_product').val(count_product);
			$('#product_name,#price,#saleprice').val('');
			$('#qty').val('1');
			$('#total').val(total.toFixed(2)).trigger('change');
			$('#pro_id').val(0);
			$('#saleprice').val('');
			$('#final_price').val('');
			$('#saleprice_wot').val('');
			$('#profit').val('');
			$('#mrp').val('');
			$('#hsn').val('');
			$('#taxrs').val('');
			$('#igst').val('');
			$('#sgst').val('');
			$('#cgst').val('');
			$('#product_name').focus();
			}else{
				alert("Please Check Discount/Quantity/Tax/Net Price");
				$('#profit').focus();
					
			}
		}else{
			$('#product_name').focus();
		}
	});
  
	$('#purchase_number').blur(function(){
		if($('#purchase_number').val().length>2){
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
	} );
  } );
  
 
  
  function remove_tr(saleprice)
  {
	   
	  var  total = 0;
	  $('.total_arr').each(function(){
		  // alert($(this).val());
		  total = total+ parseFloat($(this).val());
		  // alert(total);
	  });
	  
	  if(total.toFixed(2) >0)
	  {
		  $('#total').val(total.toFixed(2)).trigger('change');
	  }else{
			$('#total').val(0).trigger('change');
	  }

	  // alert($(this).html());
  }
  </script>
</body>
</html>
