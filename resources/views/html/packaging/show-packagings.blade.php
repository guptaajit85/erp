<?php
use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
<style>
.address-container {
    display: flex;
    flex-direction: column;
}

.address-label {
    font-weight: bold;
    margin-bottom: 5px;
}

.address-value {
    margin-bottom: 15px;
}
</style>

</head>
<body class="hold-transition sidebar-mini">
 
<!-- Site wrapper -->
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
          <h4> Packaging</h4>
          </a> </div>
      </div>
      <div class="panel-body">
      
        <div class="row" style="margin-bottom:5px">
          <form action="{{ route('show-packagings') }}" method="GET" role="search">
            @csrf
            <div class="col-sm-4 col-xs-12">
              <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->query('search') }}" />
            </div>
            <div class="col-sm-2 col-xs-12">
              <button class="btn btn-add">Search</button>
            </div>
          </form>          
          <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-packaging"> <i class="fa fa-plus"></i> Add Packaging </a> </div>
        </div>
         
        <div class="table-responsive">
			<table id="dataTableExample1" class="table table-bordered table-striped table-hover">
			   <thead>
				  <tr class="info">
					 <th>Packing Id </th>
					 <th>Customer Name </th>
					 <th>Shipping Address </th>
					 <th>Billing Address</th>
					 <th>Action </th>
				  </tr>
			   </thead>
			   <tbody>
				  <?php 
					 foreach ($dataP as $data) 
					 {  			
						$customerName 	 	= $data['Individual']->name;
						$shiping_address 	= $data->shiping_address;
						$billing_address 	= $data->billing_address;
						$isInvGenerated 	= $data->is_invoice_generated;	
						$isTransportAlloted = $data->is_transport_alloted;	
						$poId 				= $data->id;				
					 ?>
				  <tr>
					 <td> <?=(1000+$data->id);?> </td>
					 <td> <?=$customerName;?> </td>
					 <td>
						<div class="address-container"> 
						   <div class="address-value">{{ $data->shiping_address }}</div> 
						</div>
					 </td>	
					 <td>
						<div class="address-container">					 
						   <div class="address-value">{{ $data->billing_address }}</div>
						</div>
					 </td>
					 
					<td> 
						<?php if($isInvGenerated == 'No') { ?> 
							<p><a target="_blank" href="create-invoice-for-package/{{ base64_encode($poId) }}" class="tooltip-info">
								<label class="label bg-green"><i class="fa fa-file-text-o" aria-hidden="true"></i> Generate Invoice</label>
							</a></p>
						<?php } else { ?>
							<p><a target="_blank" href="print-saleentry/{{ base64_encode($data->sale_entry_id) }}" class="tooltip-info">
								<label class="label bg-green"><i class="fa fa-print" aria-hidden="true"></i> Invoice Generated</label>
							</a></p>

							<p><a target="_blank" href="print-package-items/{{ base64_encode($data->id) }}" class="tooltip-info">
								<label class="label bg-green"><i class="fa fa-print" aria-hidden="true"></i> Print Package Items</label>
							</a></p>

							<p>
								<?php if($isTransportAlloted == 'No') { ?>
									<a href="transport-package-items/{{ base64_encode($data->id) }}" class="tooltip-info">
										<label class="label bg-green"><i class="fa fa-truck" aria-hidden="true"></i> Allot Transport</label>
									</a>
								<?php } else if($isTransportAlloted == 'Yes') { ?>
									 
									
									<a href="javascript:void(0);" onClick="viewAllotedTransport({{ $data->id }})" class="tooltip-info">
									<label class="label bg-green"><i class="fa fa-eye" aria-hidden="true"></i> View Alloted Transport</label>
									</a>
									 
								<?php } ?>
							</p>
						<?php } ?>
					</td>
 
					 
					 
					 
				  </tr>
				  <?php } ?>
				  <tr class="center text-center">
					 <td class="center" colspan="5"> <div class="pagination">{{ $dataP->links() }}</div> </td>
				  </tr>
			   </tbody>
			</table>
			
        </div>
     
	 </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
  @include('common.footer') 
</div>

<!-- Modal -->
<div class="modal fade" id="viewTransportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
             <div class="modal-header modal-header-primary">
                <h5 class="modal-title" id="exampleModalLabel">Transport Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">
				<table class="table table-bordered">
				    <tr>
						<td colspan="2" style="text-align: center; font-weight: bold;">
							<span id="transportName"></span>
						</td>
					</tr>
					<tr>
						<td><strong>Allotment ID:</strong></td>
						<td><span id="allotmentId"></span></td>
					</tr>
					<tr>
						<td><strong>Packaging Order ID:</strong></td>
						<td><span id="packagingOrderId"></span></td>
					</tr>
					<tr>
						<td><strong>Transport ID:</strong></td>
						<td><span id="transportId"></span></td>
					</tr>
					<tr>
						<td><strong>Phone:</strong></td>
						<td><span id="phone"></span></td>
					</tr>
					<tr>
						<td><strong>Mobile:</strong></td>
						<td><span id="mobile"></span></td>
					</tr>
					<tr>
						<td><strong>Email:</strong></td>
						<td><span id="email"></span></td>
					</tr>
					<tr>
						<td><strong>GSTIN:</strong></td>
						<td><span id="gstin"></span></td>
					</tr>
					<tr>
						<td><strong>Features:</strong></td>
						<td><span id="features"></span></td>
					</tr>
					<tr>
						<td><strong>Created:</strong></td>
						<td><span id="created"></span></td>
					</tr>
				</table>
			</div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
 

@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
 
<script type="text/javascript">
var siteUrl = "{{url('/')}}";
function viewAllotedTransport(Id) 
{	
	jQuery.ajax({
		type: "GET",  
		url: siteUrl + '/' +"ajax_script/getTransportDetails", 
		data: {
			"_token": "{{ csrf_token() }}",
			"FId":Id,				 
		},	 
		cache: false,				
		success: function(response)	
		{				
			response = JSON.parse(response);
			console.log(response);	 
			 
			$("#allotmentId").html(response.allotmentId); 
			$("#packagingOrderId").html(response.packagingOrderId);  
			$("#transportId").html(response.transportId);  
			$("#transportName").html(response.transportName); 
			$("#mobile").html(response.mobile);
			$("#phone").html(response.phone); 
			$("#email").html(response.email); 
			$("#gstin").html(response.gstin); 
			$("#features").html(response.features); 
			$("#created").html(response.created);  	
			 
		}
	});			
	
	$('#viewTransportModal').modal({backdrop: 'static', keyboard: false});		 
}
</script> 



</body>
</html>
