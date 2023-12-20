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
              <form method="post" action="{{ route('store')}}" onSubmit="return check_form();" autocomplete="off">
                @csrf
                <div class="row">
                  <div class="col-md-12"> </div>
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <tbody>

                      <tr>
                        <td><label for="purchase_number">Warehouse  <span style="color:#ff0000;">*</span></label>
                          <select class="form-control" name="warehouseId" required id="warehouseId" onChange="selectCompartment(this.value);">
                            <option value="">Please Select Warehouse  <span style="color:#ff0000;">*</span></option>
                            <?php foreach($dataW as $val) { ?>
                            <option value="<?=$val->id;?>">
                            <?=$val->warehouse_name;?>
                            </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td id="warehouseCompIdDiv"></td>
                        <td>
							<label for="emp_name">Receiver Employee Name  <span style="color:#ff0000;">*</span></label>
							<input type="text" id="emp_name" class="form-control" required name="emp_name" value="">
							<input type="hidden" id="ind_emp_id" class="form-control" name="ind_emp_id" value="">
							<table class="table table-bordered">
							<tbody>
								<span id="warehouseEmpDiv"></span>
							</tbody>
							</table>
						</td>
                        <td><label>Reciving Date  <span style="color:#ff0000;">*</span></label>
                          <input type="text" id="receiving_date"  required class="form-control" data-date-format="yyyy-mm-dd" name="receiving_date" class="form-control">
                        </td>
                        <!---
						  <td><label for="receiver_name">Receiver Name</label>
                            <input type="text" id="receiver_name"  class="form-control" name="receiver_name" class="form-control">
                          </td>
						  ------>
                        <td><label for="invoice_number">Invoice Number  <span style="color:#ff0000;">*</span></label>
                          <input type="text" id="invoice_number"  class="form-control" required name="invoice_number" class="form-control" >
                          <table class="table table-bordered">
                            <tbody>
                            <span id="vendorDetailId"></span>
                            </tbody>

                          </table></td>
                      </tr>
                      </tbody>

                    </table>
                  </div>
                  <div class="col-md-12" id="main_div">
                    <div class="row">
                      <div class="col-xs-12">
                        <!--table part start-->
                        <div class="table-responsive table-responsive-custom"> <span id="showPurchaseItems"> </span> </div>
                        <!--table part end-->
                      </div>
                    </div>
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
 $( "#emp_name" ).autocomplete({

	 minLength: 0,
	  source: siteUrl + '/' +"list_employee",
	  focus: function( event, ui ) {

		// alert(ui.item.name);
		$( "#emp_name" ).val( ui.item.name );
		$( "#ind_emp_id" ).val( ui.item.id );

		return false;
	  },
	  select: function( event, ui ) {

		// alert('okkkkkkkkkk');
		// $( "#ind_emp_id" ).val( ui.item.id );

		return false;
	  }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
	  return $( "<li>" )
		.append( "<div>" + item.name + "</div>" )
		.appendTo( ul );
	};


 </script>
<script type="text/javascript">
function selectInvoice()
{
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

}
</script>
<script type="text/javascript">

 var siteUrl = "{{url('/')}}";
 $( "#invoice_number" ).autocomplete({

	 minLength: 0,
	  source: siteUrl + '/' +"list_purchase_items",
	  focus: function( event, ui ) {

		// alert(ui.item.purchase_number);
		$( "#invoice_number" ).val( ui.item.purchase_number );
		selectInvoice();
		return false;
	  },
	  select: function( event, ui ) {

		// alert('okkkkkkkkkk');


		return false;
	  }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
	  return $( "<li>" )
		.append( "<div>" + item.purchase_number + "<br> Bill Based - " + item.bill_based + "</div>" )
		.appendTo( ul );
	};


 </script>
<script type="text/javascript">
function CalQuantity(purItemId,quantity)
{
	// alert(purItemId);
	// alert(quantity);
	var comp_quantity 	=  $('#comp_quantity'+purItemId).val();
	// alert(comp_quantity);
	var total =  quantity-comp_quantity;
	$('#bal_quantity'+purItemId).val(total);
}
</script>
<script type="text/javascript">
function getPurchaseItems(Id)
{
	// alert(Id);
	$.ajax({
		type: "GET",
			url: siteUrl + '/' +"ajax_script/getPurchaseItems",
				data: {
					"_token": "{{ csrf_token() }}",
					"Id":Id,
				},
			cache: false,
			success: function(res)
			{
				$( "#showPurchaseItems" ).html(res);
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
