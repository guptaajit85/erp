<?php
	use \App\Http\Controllers\CommonController; 
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
</head>
<body class="hold-transition sidebar-mini">
<!--preloader-->
 
<!-- Site wrapper -->
<div class="wrapper"> @include('common.header')
    <div class="content-wrapperd">
	
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Sale Order Work Order Details </h4>
                </a> </div>
            </div>
            <div class="panel-body">
             
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
					  <th>Sale <br / > Order Num. </th>
					  <th>Customer <br / >Name </th>
                      <th>Order</th> 
                      <th>Order Item Details </th> 
                      <th>Action</th> 
                    </tr>
                  </thead>
                  <tbody>  
                  <tr>
				     <td> {{ $dataPur->sale_order_number }} </td>
				    <td> {{ $dataPur['Individual']->name }} </td>
					<td>  
						Priority : <strong>{{ $dataPur->order_priority }} </strong>
						</br>
						Lot Num. <strong>{{ $dataPur->sale_order_id }} </strong>
						</br>
						<?=date('M jS, Y', strtotime($dataPur->sale_order_date));?>
						<br>
					</td>					
                    <td> <table class="table table-bordered table-striped table-hover">
					  <tr>
						<th>Process No.</th>
						<th>Master</th>
						<th>Machine</th>
						<th>Item Name</th>
						<th>Dyeing Color </th>
						<th>Coated PVC</th>
						<th>Extra Job</th>
						<th>Print Job</th>					 
						<th>Pcs</th>
						<th>Cut</th>
						<th>Meter</th>
						<th>Work Order Start Date</th>
					  </tr>
					<?php 
					foreach($dataPur['SaleOrderItem'] as $row) 
					{ 	
						//  echo "<pre>"; print_r($row); exit;						
						$saleOrdItemId 	= $row->sale_order_item_id;						 
						foreach ($row['WorkOrderItem'] as $workOrderItem) 
						{						   
							$workOrdId 		= $workOrderItem->work_order_id;							 
							$itemName 		= CommonController::getItemName($workOrderItem->item_id);						 
							$machineId 		= $workOrderItem['WorkOrder']->machine_id;
							$masterName     = CommonController::getIndividualName($workOrderItem['WorkOrder']->master_ind_id); 	
							$MachineName    = CommonController::machineName($machineId); 
							$process_type 	= $workOrderItem['WorkOrder']->process_type;
							$process_sl_no 	= $workOrderItem['WorkOrder']->process_sl_no;
							$resultProcess  = $process_type . '' . $process_sl_no;	 
					?>
					    <tr>
							<td> <?=$resultProcess;?> </td>
							<td> <?=$masterName;?> </td>
							<td> <?=$MachineName;?> </td>
							<td> <?=$itemName;?> </td>
							<td> <?=$workOrderItem->dyeing_color;?> </td>
							<td> <?=$workOrderItem->coated_pvc;?> </td>
							<td> <?=$workOrderItem->extra_job;?> </td>
							<td> <?=$workOrderItem->print_job;?>  </td>
							<td> <?=$workOrderItem->pcs;?> </td> 
							<td> <?=$workOrderItem->cut;?>  </td> 
							<td> <?=$workOrderItem->meter;?>  </td> 
							<td> <?=$workOrderItem['WorkOrder']->process_started_date;?>  	</td> 
					    </tr>
					 <?php } ?> 

			  <?php } ?> 
					</table> 
					
					</td> 
					
					
					<td>
					
					 
					 
					</td> 
                  </tr>
                  
                  <tr class="center text-center">
                    <td class="center" colspan="6"><div class="pagination"> </div></td>
                  </tr>
                  </tbody>
                  
                </table>
              </div>
			  
			  <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
					  <th>Sale <br / > Order Num. </th>
					  <th>Customer <br / >Name </th>
                      <th>Order</th> 
                      <th>Packaging Item Details </th> 
                      <th>Action</th> 
                    </tr>
                  </thead>
                  <tbody>                   
				  
                  <tr>
				     <td> {{ $dataPur->sale_order_number }} </td>
				    <td> {{ $dataPur['Individual']->name }} </td>
					<td>  
						Priority : <strong>{{ $dataPur->order_priority }} </strong>
						</br>
						Lot Num. <strong>{{ $dataPur->sale_order_id }} </strong>
						</br>
						<?=date('M jS, Y', strtotime($dataPur->sale_order_date));?>
						<br>
					</td>
					
                    <td> <table class="table table-bordered table-striped table-hover">
					  <tr>
						<th>Packaging Id.</th>
						<th>Sale Order Id</th>
						<th>Sale Order Item Id</th>
						<th>Item Name</th>
						<th>Pack Type</th>						 
						<th>Pcs</th>
						<th>Cut</th>
						<th>Required Meter</th>
						<th>Packed Meter </th>
						<th>Work Status</th>
					  </tr>
					<?php 
					foreach($dataPur['SaleOrderItem'] as $rowArr) 
					{ 	
						//  echo "<pre>"; print_r($rowArr); exit;						
						$saleOrdItemId 	= $rowArr->sale_order_item_id;						 
						foreach ($rowArr['PackagingOrderItem'] as $packOrderItem) 
						{	 
							$itemName 	= 	CommonController::getItemName($packOrderItem->item_id);							 
						 
					?>
					    <tr>
							<td> <?=$packOrderItem->packaging_ord_id;?> </td> 
							<td> <?=$packOrderItem->sale_order_id;?> </td> 
							<td> <?=$packOrderItem->sale_order_item_id;?> </td>
							<td> <?=$itemName;?> </td>			
							<td> <?=$packOrderItem['PackagingType']->name;?> </td> 	 											 
							<td> <?=$packOrderItem->pcs;?> </td> 
							<td> <?=$packOrderItem->cut;?>  </td> 
							<td> <?=$packOrderItem->meter;?>  </td> 
							<td> <?=$packOrderItem->pack_meter;?>  </td> 
						 
					    </tr>
					 <?php } ?> 

			  <?php } ?> 
					</table> 
					
					</td> 
					
					
					<td>
					
					 
					 
					</td> 
                  </tr>
                  
                  <tr class="center text-center">
                    <td class="center" colspan="6"><div class="pagination"> </div></td>
                  </tr>
                  </tbody>
                  
                </table>
              </div>
			  
			  
			  
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
  @include('common.footer') </div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
 
<script>
  $(function() {
    $("#from_date, #to_date").datepicker({
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      autoclose: true,
    });
  });
</script>

<script type="text/javascript">
var siteUrl = "{{url('/')}}";
	function deleteSaleOrder(id) 
	{	
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET", 
				url: siteUrl + '/' +"ajax_script/deleteSaleOrder",
				data: {
					"_token": "{{ csrf_token() }}",
					"FId":id,	 			
				},	 	
			
				cache: false,				
				success: function(msg)	
				{	 
					$("#Mid"+id).hide();				
				}
			});
			 
		}	
			
	}
</script>
</body>
</html>
