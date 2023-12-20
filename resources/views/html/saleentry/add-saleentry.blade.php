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
            <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="javascript:void|(0);"> <i class="fa fa-list"></i> New Sale Entry </a> </div>
          </div>
          <div class="panel-body"  >
            <form method="post" action="{{ route('store_saleentry')}}" onSubmit="return check_form();" autocomplete="off">
            @csrf
            <div class="row">
            <div class="col-md-12">
            <div class="container">
            <form>
              <label class="radio-inline">
              <input type="radio" name="optradio" value="with" />
              With Sale Order </label>
              <label class="radio-inline">
              <input type="radio" name="optradio" value="without" />
              Without Sale Order </label>
            </form>
          </div>
        </div>
        <div class="col-md-12 saleOrder"  id="saleOrderwith" style="display:none">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td style="width:200px;" id="sale_order_numberId"><label for="sale_order_number">Sale Order Number</label>
                  <input type="text" id="sale_order_number" required class="form-control" name="sale_order_number" class="form-control" value="" autofocus="autofocus" >
                </td>
                <td style="width:150px;"><label for="sale_entry_started">Sale Entry Date</label>
                  <input type="text" id="sale_entry_started" required class="form-control" data-date-format="yyyy-mm-dd" name="sale_entry_started" class="form-control" value="" readonly>
                </td>
                <td style="width:300px;"><label for="exampleInputCategory1">Customer Name   <span style="color:#ff0000;">*</span></label>
                  <input type="text" id="cus_name" name="cus_name" class="form-control" placeholder="Customer Name" required  autofocus="autofocus">
                  <label for="exampleInputCategory5">Name : </label>
                  <span id="customer_nameVal"> </span> </br>
                  <input type="hidden" name="customer_name" id="customer_name" class="form-control" placeholder="Customer Name"  >
                  <input type="hidden" id="individual_id" name="individual_id" required >
                  <label for="exampleInputCategory1">Phone : <span id="phone"></span> </label>
                  </br>
                  <input type="hidden" name="mobile" id="mobile" class="form-control" placeholder="Mobile"  >
                  <label for="exampleInputCategory1">Email : <span id="email_spnId"></span> </label>
                  </br>
                  <input type="hidden" name="email" id="email" class="form-control" placeholder="Email"  >
                  <label for="exampleInputCategory1">GSTIN :<span id="gst_label"></span></label>
                  <input type="hidden" name="cst" id="cst" class="form-control" placeholder="GSTIN"  >
                  <input type="hidden" required name="com_state" id="com_state" value="41">
                </td>
                <td><label for="exampleInputCategory1">Billing Address </label>
                  </br>
                  <p><span id="address"></span></p>
                  <label for="exampleInputCategory1">Shipping Address </label>
                  </br>
                  <p><span id="addressShipping"></span></p></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-12" id="main_div" style="display:none">
          <div class="form-group form-inline">
            <div class="hidden">
              <label for="dis_amount1">Bill Based</label>
              <select id="bill_based" name="bill_based" class="form-control" onChange="chkbill_based();">
                <option value="unit">Unit Rate</option>
                <option value="rate">MRP</option>
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
                    <td style="width:10%;display:none"><p>Sr</p>
                      <input type="text" id="sr_number" name="sr_number" class="form-control" placeholder="Serial Number" >
                    </td>
                    <td style="width:10%"><div class="input-group ">
                        <p class="qty_name">Quality Name</p>
                        <input type="text" id="qty_name" name="qty_name"  class="form-control" placeholder="Quality" >
                      </div></td>
                    <td style="width: 10%;"><div class="input-group">
                        <p>Unit</p>
                        <SELECT id="unit" name="unit" class="form-control">
                          <?php foreach($dataUT as $utVal) { ?>
                          <option value=" <?=$utVal->unit_type_name;?>">
                          <?=$utVal->unit_type_name;?>
                          </option>
                          <?php } ?>
                        </select>
                      </div></td>
                    <td style="width:7%"><div class="input-group">
                        <p>PCS</p>
                        <input type="text" id="pcs" name="pcs" class="form-control" onBlur="calculate_price();" placeholder="pcs" value="1">
                      </div></td>
                    <td style="width:7%"><div class="input-group">
                        <p>Cut</p>
                        <input type="text" id="cut" name="cut" class="form-control" placeholder="cut" onBlur="calculate_price();" value="1">
                      </div></td>
                    <td style="width:7%"><div class="input-group">
                        <p>Meter</p>
                        <input type="text" id="meter" name="meter" class="form-control" readonly onBlur="calculate_price();" placeholder="meter" value="1">
                      </div></td>
                    <td style="width:10%"><div class="input-group">
                        <p>Rate</p>
                        <input type="text" id="rate" name="rate" class="form-control" placeholder="rate" value="1" onBlur="calculate_price();">
                      </div></td>
                    <td style="width:10%"><div class="input-group">
                        <input type="hidden" id="pro_id" name="pro_id" >
                        <p>Amount</p>
                        <input type="text" id="amount" name="amount" class="form-control" placeholder="Amount" value="1" onBlur="calculate_price();">
                      </div></td>
                    <td style="width:10%"><div class="input-group">
                        <label for="dis">Dis (%)</label>
                        <input type="text" id="dis" name="dis" class="form-control " placeholder="Discount" value="0" onBlur="calculate_price();">
                      </div>
                </div>

                </td>

                <td style="width:10%"><div class="input-group">
                      <label for="dis_amount">Dis Amount</label>
                      <input type="text" id="dis_amount" name="dis_amount" class="form-control " placeholder="Discount Amount" value="0" onBlur="calculate_price();">
                    </div></td>
                  <td style="width:10%"><div class="input-group">
                      <label for="net_amount">Net Amount</label>
                      <input type="text" id="net_amount" name="net_amount" class="form-control " placeholder="Net Amount" value="0" onBlur="calculate_price();">
                    </div></td>
                  <td style="width:10%"><div class="input-group">
                      <label for="remark">Remark</label>
                      <input type="text" id="remarks" name="remarks" class="form-control " placeholder="Remark" >
                    </div></td>
                  <td style="width:7%;"><button type="button" id="Add_To_Sale_Entry" class="btn btn-primary">+</button></td>
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
                  <!-- <th style="width:10%;">Sr</th> -->
                  <th style="width:10%" class="mrplabel">Quality Name</th>
                  <th style="width:10%">Unit</th>
                  <th style="width:7%">PCS</th>
                  <th style="width:7%">Cut</th>
                  <th style="width:7%">Meter</th>
                  <th style="width:10%">Rate</th>
                  <th style="width:10%">Amount</th>
                  <th style="width:10%">Dis (%)</th>
                  <th style="width:10%">Dis Amount</th>
                  <th style="width:10%">Net Amount</th>
                  <th style="width:10%">Remark</th>
                  <th style="width:7%;">Action</th>
                </tr>
              </thead>
              <tbody id="tbody" style="max-height: 200px;overflow-y: auto;overflow-x: hidden;">
              </tbody>
              <tfoot>
                <tr>
                  <!-- <th></th> -->
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th ></th>
                  <th >Total</th>
                  <th colspan="2"><input type="number" name="total" id="total" min="0" value="0" step="2" class="form-control" readonly></th>
                  <th></th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>Frieght</th>
                  <th colspan="1"><input type="number" name="frieght" id="frieght" value="0" min="0" step="2" class="form-control" ></th>
                  <th>Round Off</th>
                  <th colspan="1"><input type="number" name="discount" id="discount" value="0" min="0" step="2" class="form-control" ></th>
                  <th>G. Total</th>
                  <th colspan="2"><input type="number" name="subtotal" id="subtotal" value="0" min="0" step="2" class="form-control" readonly></th>
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
@include('common.footer')
</div>
@include('common.formfooterscript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
 var siteUrl = "{{url('/')}}";

function calcAddress(stateId)
{
	$('#com_state').val(stateId);
	$('#main_div').show();
}


</script>
<script>
function chkbill_based()
{
	if($('#bill_based').val()=='rate')
	{
		$('.mrplabel').html("MRP");
	}else{
		$('.mrplabel').html("Rate");
	}
}


function check_form()
{
	if( !$('#cust_type_raw').is(':checked'))
	{
		if($('#individual_id').val() == "")
		{
			alert("Please select a customer name.");
			$('#cus_name').focus();
			return false;
		}
	}
	// else{
		// return true;
	// }
	// alert(parseInt($('#count_product').val()));
	if(parseInt($('#count_product').val()) == 0)
	{
		alert("Please Add a product in sale entry List.");
		$('#sr_number').focus();
		return false;
	}
	else{
		// return false;
		return true;
	}
}

function calculate_price()
	{
		var cut = parseFloat($('#cut').val());
		var pcs = parseFloat($('#pcs').val());
		var unit= parseFloat($('#unit').val());
		var rate = parseFloat($('#rate').val());
		console.log("rate "+rate);
		console.log("unit "+unit);
		console.log("pcs " +pcs);
		var dis = $('#dis').val();

		// alert(dis);
		var meter = cut * pcs;
		$('#meter').val(meter.toFixed(2));

		var amount = meter * rate;

		console.log("meter "+meter);
		$('#amount').val(amount.toFixed(2));

			var discountRs = (amount * dis)/100;
		 $('#dis_amount').val(discountRs);

		var final_price = amount-discountRs;
		$('#net_amount').val(final_price);
	}

  $( function() {


	   $(".remove").on('click', 'a', function(event) {
		  // alert( $(this).data('trid') );
	  });

	  $('#saleprice_wot').keyup(function(){
		  // calculatepurchaseprice();
	  });

	  $('#profit,#qty,#cess').blur(function(){

		//   calculateprice();

	  });

	  $('#sgst,#cgst,#igst').change(function(){
		   if( $('#com_state').val() == $('#state').val() )
		  {
			  $('#sgst').val( $('#cgst').val() ).attr('readonly',false);
		  }

		//   calculateprice();
	  });
	  $('#dis_amount').change(function(){
		  $('#profit').trigger('blur');
	  });
	   function getCustomerAddress(individualId)
	   {
			 $.ajax({
				type: "GET",
					url: siteUrl + '/' +"ajax_script/search_customer_addressBilling",
						data: {
							"_token": "{{ csrf_token() }}",
							"individualId":individualId,
						},
					cache: false,
					success: function(res){
							$( "#address" ).html(res);

					}
			})

			$.ajax({
				type: "GET",
					url: siteUrl + '/' +"ajax_script/search_customer_addressShipping",
						data: {
							"_token": "{{ csrf_token() }}",
							"individualId":individualId,
						},
					cache: false,
					success: function(res){
							$( "#addressShipping" ).html(res);

					}
			})
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

	$( "#sale_entry_started" ).datepicker(
	{
	autoclose: true,

	} );

	$( "#cus_name" ).autocomplete({


	 minLength: 0,
	  source: siteUrl + '/' +"list_customer",
	  focus: function( event, ui ) {
		$( "#cus_name" ).val( ui.item.name );
		return false;
	  },
	  select: function( event, ui ) {
		var individualId = ui.item.id;
		getCustomerAddress(individualId);


		$( "#individual_id" ).val( ui.item.id );
		$( "#cus_name" ).val( ui.item.name );
		$( "#mobile" ).val( ui.item.phone );
		$( "#phone" ).val( ui.item.phone );

		$( "#email" ).val( ui.item.email);
		$( "#customer_name" ).html( ui.item.name);
		$( "#vat" ).val( ui.item.vat);
		$( "#cst" ).val( ui.item.gstin);

		$( "#gst_label" ).html( ui.item.gstin);
		$( "#email_spnId" ).html( ui.item.email);
		$( "#phone" ).html( ui.item.phone);
		$( "#customer_nameVal" ).html( ui.item.name);


		if( $('#com_state').val() == ui.item.cus_state )
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

// =====================


$( "#sale_order_number" ).autocomplete({


		minLength: 0,
		 source: siteUrl + '/' +"list_saleOrderNumer",
		 focus: function( event, ui ) {
		   $( "#sale_order_number" ).val( ui.item.sale_order_id);
		   return false;
		 },
		 select: function( event, ui ) {
		   var individualId = ui.item.id;
		   getCustomerAddress(individualId);


		   $( "#individual_id" ).val( ui.item.id );
		   $( "#cus_name" ).val( ui.item.name );
		   $( "#mobile" ).val( ui.item.phone );
		   $( "#phone" ).val( ui.item.phone );

		   $( "#email" ).val( ui.item.email);
		   $( "#customer_name" ).html( ui.item.name);
		   $( "#vat" ).val( ui.item.vat);
		   $( "#cst" ).val( ui.item.gstin);

		   $( "#gst_label" ).html( ui.item.gstin);
		   $( "#email_spnId" ).html( ui.item.email);
		   $( "#phone" ).html( ui.item.phone);
		   $( "#customer_nameVal" ).html( ui.item.name);


		   if( $('#com_state').val() == ui.item.cus_state )
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
		   .append( "<div>" + item.sale_order_id + "</div>" )
		   .appendTo( ul );
	   };

	//====================
	$( "#qty_name" ).autocomplete({
	 minLength: 0,

	  source: siteUrl + '/' +"list_item",
	  focus: function( event, ui ) {
		// if(ui.item.part_number != '')
		// {
		// 	$( "#qty_name" ).val( ui.item.item_name + ' ' + ui.item.item_code );
		// }else{
			$( "#qty_name" ).val( ui.item.item_name );
		// }
		return false;
	  },
	  select: function( event, ui ) {
			// log( "Selected: " + ui.item.value + " aka " + ui.item.id );

		//  alert(ui.item.igst);

		$( "#pro_id" ).val( ui.item.item_id);
		if(ui.item.part_number != '')
		{
			$( "#sr_number" ).val( ui.item.item_name + ' ' + ui.item.item_code);
		}else{
			$( "#sr_number" ).val( ui.item.item_name );
		}
		$( "#rate" ).val( ui.item.unit_price);
		$( "#net_amount" ).val( ui.item.unit_price );
		var com_state = $('#com_state').val();
		var state = $('#com_state').val();


		// alert(ui.item.igst);
		if( $('#com_state').val() == $('#state').val() )
			  {
				var gst = ui.item.igst/2;
				$( '#cgst  option[value="'+gst+'"]' ).prop('selected',true);
				$( '#sgst  option[value="'+gst+'"]' ).prop('selected',true);
			  }else{

				$( '#igst  option[value="'+ui.item.igst+'"]' ).prop('selected',true);

			  }
		// $( "#unit" ).val( ui.item.unit_type_name );
		$( "#saleprice" ).val( ui.item.sale_rate );
	// calculateprice();


		return false;
	  }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
	  return $( "<li>" )
	  .append( "<div>" + item.item_name +' '+ item.item_code + "<br> MRP:" + item.unit_price + " </div>" )
		.appendTo( ul );
	};

	$('#Add_To_Sale_Entry').click(function(){
		if($('#sr_number').val() != '' )
		{
			if( $('#net_amount').val() !=0)
			{
			var count_product = parseInt( $('#count_product').val() ) +1;
			// alert(parseFloat($('#total').val()) +' -- '+ $('#final_price').val());
			var total = parseFloat($('#total').val()) + parseFloat($('#net_amount').val());
			var new_pro = "<tr id='tr_"+count_product+"'>"+
			// "<td>"+count_product+"</td>"+


			"<td><input value='"+$('#pro_id').val()+"' type='hidden' name='pro_id_arr[]' readonly> <input readonly value='"+$('#qty_name').val()+"' type='text' class='form-control' name='qty_name_arr[]'></td>"+
			"<td><input readonly value='"+$('#unit').val()+"' type='text' class='form-control' name='unit_arr[]'></td>"+
			"<td><input readonly value='"+$('#pcs').val()+"' type='text' class='form-control' name='pcs_arr[]'></td>"+
			"<td><input readonly value='"+$('#cut').val()+"' type='text' class='form-control' name='cut_arr[]'></td>"+
			"<td><input readonly value='"+$('#meter').val()+"' type='text' class='form-control' name='meter_arr[]'></td>"+
			"<td><input readonly value='"+$('#rate').val()+"' type='text' class='form-control' name='rate_arr[]'></td>"+
			"<td><input value='"+$('#amount').val()+"' type='text' class='form-control' name='amount_arr[]' readonly></td>"+
			"<td><input value='"+$('#dis').val()+"' type='text' class='form-control' name='discount_arr[]' readonly></td>"+
			"<td><input value='"+$('#dis_amount').val()+"' type='text' class='form-control' name='dis_amount_arr[]' readonly></td>"+
			"<td><input readonly value='"+$('#net_amount').val()+"' type='text' class='form-control total_arr' name='total_arr[]'></td>"+
			"<td><input readonly value='"+$('#remarks').val()+"' type='text' class='form-control' name='remarks_arr[]'></td>"+
			"<td><a data-toggle='tooltip' href='javascript:void(0);' onclick='$(\"#tr_"+count_product+"\").remove();remove_tr("+$('#saleprice').val()+");' title='Remove'><span class='glyphicon glyphicon-remove-circle remove' data-trid='tr_"+count_product+"' ></span></a></td>"+

			"</tr>";

			$('#tbody').append(new_pro);
			$('#count_product').val(count_product);
			$('#sr_number,#rate,#saleprice').val('');
			$('#qty_name').val('');
			$('#total').val(total.toFixed(2)).trigger('change');
			$('#pro_id').val(0);
			$('#saleprice').val('');
			$('#net_amount').val('');
			$('#amount').val('');
			$('#unit').val('');
			$('#rate').val('');
			$('#dis').val('');
			$('#remarks').val('');
			$('#dis_amount').val('');
			$('#saleprice_wot').val('');
			$('#profit').val('');
			$('#sr_number').focus();
			}else{
				alert("Please Check Discount/Quantity/Tax/Net Price");
				$('#profit').focus();

			}
		}else{
			$('#sr_number').focus();
		}
	});

	$('#sale_order_number').blur(function(){
		if($('#sale_order_number').val().length>2){
			var id = $('#sale_order_number').val();
		$.ajax({
			type: "POST",
				url: siteUrl + '/' +"ajax_script/search_sale_order_number",
					data: {
						"_token": "{{ csrf_token() }}",
						"sale_order_number":id,
					},
				cache: false,
				success: function(res){
					if(res!=1)
					{
						alert("You have entereds Duplicate Sale Entry Number");
						$('#sale_order_number').val('').focus();
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
<script>
$(document).ready(function(){
	$('input[type="radio"]').click(function(){
		var demovalue = $(this).val();
		// alert(demovalue);
		if(demovalue =='with')
		{
			$("#saleOrderwith").show();
			// $("#main_div").show();
			$("#sale_order_numberId").show();
		} else if(demovalue =='without')
		{
			$("#saleOrderwith").show();
			//$("#main_div").show();
			$("#sale_order_numberId").hide();
		}
	});
});
</script>
</body>
</html>
