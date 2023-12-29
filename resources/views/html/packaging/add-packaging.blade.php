<?php
use App\Http\Controllers\CommonController;
?>

<!DOCTYPE html>
<html lang="en">
   <head>@include('common.head')
   <style>
    .shipping-address-heading p {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333; /* Adjust color as needed */
    }
</style>
   </head>
   <body class="hold-transition sidebar-mini"> 
      <div class="wrapper">
      @include('common.header') 
      <div class="content-wrapperd">
      {!! CommonController::display_message('message') !!} 
      <section class="content">
         <div class="row">
            <div class="col-sm-12">
               <div class="panel panel-bd lobidrag">
                  <div class="panel-heading">
                     <div class="btn-group" id="buttonexport">
                        <h4>Add Packaging</h4>
                        </a>
                     </div>
                  </div> 
				  
                  <div class="panel-body">
                     <div class="row" style="margin-bottom:5px">                        
						<form action="{{ route('add-packaging') }}" method="GET" role="search">
							@csrf 
							<div class="col-sm-4 col-xs-12">
								<input type="text" id="cus_name" name="cus_name" class="form-control" value="<?=$cusName;?>" placeholder="Customer Name" required autofocus="autofocus">
								<input type="hidden" id="individual_id" value="<?=$individualId;?>" name="individual_id">
								<label>Phone : <span id="phone"> <?=$dataInd->phone ?? ''; ?></span> </label>
								</br>
								<label>Email : <span id="email_spnId"><?=$dataInd->email ?? ''; ?></span> </label>
								</br>
								<label>GSTIN : <span id="gst_label"><?=$dataInd->gstin ?? ''; ?></span> </label>
							</div>
							 
							<div class="col-sm-2 col-xs-12">
								<button class="btn btn-add">Search</button>
							</div>
							
							
							
						</form> 
                     </div>
                     <div class="table-responsive">
					  @if ($dataP)
						<form  name="packingStore" id="packingStore" method="post" action="{{ url('/store_packaging') }}">
						@csrf  
						 <input type="hidden" id="individual_id" value="<?=$individualId;?>" name="individual_id">
						<div class="col-sm-4 col-xs-12">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td colspan="2" class="shipping-address-heading">
											<p>Shipping Address</p>
										</td>
									</tr>

									@foreach($dataIAS as $dataV)
										<tr>
											<td>
												<input type="radio" {{ $dataV->default_address ? 'checked' : '' }} required name="ind_add_id_ship" value="{{ $dataV->ind_add_id }}">
												{{ $dataV->address_1 }} {{ $dataV->address_2 }} {{ 'scscdsc' }} {{ $dataV->city }} {{ $dataV->zip_code }}<br>
												<input type="hidden" required name="shiping_address" value="{{ $dataV->address_1 }} {{ $dataV->address_2 }} {{ 'scscdsc' }} {{ $dataV->city }} {{ $dataV->zip_code }}">
											</td>
										</tr>
									@endforeach								 
 
								</tbody>
							</table>
						</div>	
						<div class="col-sm-4 col-xs-12">
							<table class="table table-bordered">
								<tbody> 
									<tr>
										<td colspan="2" class="shipping-address-heading">
											<p>Billing Address</p>
										</td>
									</tr>
									@foreach($dataIAB as $dataB)
										<tr>
											<td>
												<input type="radio" {{ $dataB->default_address ? 'checked' : '' }} required name="ind_add_id" value="{{ $dataB->ind_add_id }}">
												{{ $dataB->address_1 }} {{ $dataB->address_2 }} {{ 'scscdsc' }} {{ $dataB->city }} {{ $dataB->zip_code }}<br>
												<input type="hidden" required name="address" value="{{ $dataB->address_1 }} {{ $dataB->address_2 }} {{ 'scscdsc' }} {{ $dataB->city }} {{ $dataB->zip_code }}">
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
  
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
						 
                           <tbody> 
						   @foreach ($dataP as $saleOrder) 
                           <thead>
                              <tr>
                                 <th>AJY No. : {{ $saleOrder->sale_order_id }} </th>                                 
                              </tr>							  
							  <tr>                                 
                                 <th>Sale Order Number : {{ $saleOrder->sale_order_number }} </th>
                              </tr>
                           </thead>
                           <tr>
                              <td>
                                 @if ($saleOrder->SaleOrderItem->isNotEmpty()) 
                                 <table class="table">
                                    <thead>
                                       <tr>
                                          <th> &nbsp;</th>	
                                          <th> Pack Type</th>	
                                          <th>Item Name</th>										  
                                          <th>Pcs</th>
                                          <th>Cut</th>
                                          <th>Required Meter</th> 
                                          <th>Package Meter</th>                                         
                                          <th>Priority</th>
                                          <th>Dyeing</th>
                                          <th>Coated</th>
                                          <th>Delivery Date</th>
										  <th>Remarks</th>										  
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($saleOrder->SaleOrderItem as $item) 
                                       <tr>
                                          <td><input type="checkbox" name="sale_order_item_id[]" id="sale_order_item_id" value="{{ $item->sale_order_item_id }}"> </td>	
                                          <td> 
											<select name="pack_type[]" id="pack_type"> 
												<?php   foreach ($dataPT as $packagingType) { ?>
													<option value="{{ $packagingType->id }}">{{ $packagingType->name }}</option>
												<?php } ?>
											</select>
										  </td>			 
                                          <td> {{ $item->name }} </td>
                                          <td> {{ $item->pcs }} </td>
                                          <td> {{ $item->cut }} </td>
                                          <td> {{ $item->meter }} </td>  
                                          <td> <input type="number" name="pack_meter[]" id="pack_meter" min="0" max="{{ $item->meter }}" value="{{ $item->meter }}"></td> 
										  <td> {{ $item->order_item_priority }}  </td>
                                          <td> {{ $item->dyeing_color }}  </td>
                                          <td> {{ $item->coated_pvc }}  </td>
                                          <td> {{ $item->expect_delivery_date }}  </td>
										  <td> {{ $item->remarks }}  </td>
                                       </tr>									   
                                       @endforeach 
                                    </tbody>
                                 </table>
                                 @else 
                                 <p>No Sale Order Items</p>
                                 @endif 
                              </td>							  
                           </tr>					   
                           @endforeach
                           </tbody>						 
                        </table>
							<div class="reset-button">
								<input type="submit" name="submit" value="Save" class="btn btn-success">
								<button type="button" class="btn btn-warning" onclick="resetForm()">Reset</button>
							</div>
					    </form>
                     @else
						<p>No data available.</p>
					@endif
					 </div>
                  </div>
               </div>
			</div>
		 </div>
	  </section>
      
      </div>
      <!-- /.content-wrapper --> 
	  @include('common.footer') 
	  </div>
	  @include('common.formfooterscript') 
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>    
<script language="javascript" type="text/javascript">
    $().ready(function() {
        $("#packingStore").validate({
            rules: {
                'sale_order_item_id[]': {
                    required: true
                }
            },
            messages: {
                'sale_order_item_id[]': {
                    required: "<span style='color: red;'>Please select at least one item</span>"
                }
            }
        });
    });
</script>
<script>
    function resetForm() {
        var siteUrl = "{{url('/')}}"; 
        document.getElementById("cus_name").value = "";
        document.getElementById("individual_id").value = ""; 
		
        window.location.href = siteUrl + '/add-packaging';
    }
</script>

  
<script type="text/javascript">
function getCustomerShipAddress(individualId)
{
	var siteUrl = "{{url('/')}}";
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
function getCustomerBillAddress(individualId)
{
	var siteUrl = "{{url('/')}}";
	$.ajax({
		type: "GET",
			url: siteUrl + '/' +"ajax_script/search_customer_bill_address",
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
  
<script type="text/javascript">
  $(function () {
	var siteUrl = "{{url('/')}}";

	$("#cus_name").autocomplete({
	  minLength: 0,
	  source: siteUrl + "/list_customer",
	  focus: function (event, ui) {
		$("#cus_name").val(ui.item.name);
		return false;
	  },
	  select: function (event, ui) {
		var individualId = ui.item.id;
		 
		var individualId = ui.item.id;

		// getCustomerShipAddress(individualId);
		// getCustomerBillAddress(individualId); 
		 
		$("#individual_id").val(ui.item.id);
		$("#cus_name").val(ui.item.name);
		$("#mobile").val(ui.item.phone); 
		$("#email_spnId").html(ui.item.email);
		$("#gst_label").html(ui.item.gstin);
		$("#phone").html(ui.item.phone);
		 
		return false;
	  },
	}).autocomplete("instance")._renderItem = function (ul, item) {
	  return $("<li>").append("<div>" + item.name + "<br> GSTIN - " + item.gstin + "</div>").appendTo(ul);
	};
  });
</script>   
	   
   </body>
</html>
