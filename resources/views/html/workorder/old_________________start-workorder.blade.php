<?php
	use \App\Http\Controllers\CommonController; 
	// $data = CommonController::searchProcess(4); 
	// echo "<pre>"; print_r($data); exit;	 
?>
 

<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>@include('common.head')
 
</head><body class="hold-transition sidebar-mini">
<!--preloader-->
<div id="preloader">
  <div id="status"></div>
</div>
<!-- Site wrapper -->
<div class="wrapper"> @include('common.header')
  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar"> @include('common.sidebar') </aside>
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="show-workorders"> <i class="fa fa-list"></i> Work Order </a> </div>
            </div>
            <div class="panel-body">
              <form method="post" action="{{ route('store_workorder')}}" onSubmit="return check_form();" autocomplete="off">
                @csrf
                <div class="row">
                  <div class="col-md-12"> </div>
                  <div class="col-md-12">
                    <h2>Sale Order  : {{ $saleordId }}</h2>
                    <h3>Order Type  : {{ CommonController::getItemTypeName($dataSO->sale_order_type) }} </h3>
                    <h4>Priority    : {{ $dataSO->order_priority }}</h4>
                    
					<table class="table table-bordered table-striped table-hover">
                      <tr>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>PCS</th>
                        <th>Cut</th>
                        <th>Meter</th>
                        <th>Priority</th>
                        <th>Remarks</th>
                        <th>Check Stock</th>
                      </tr>
                      <?php foreach($dataSOI as $row) {  //  echo "<pre>"; print_r($row); // exit; ?>
                      <tr>
						<input type="hidden" id="itam_id" name="itam_id"  value="<?=$row->item_id;?>" class="custom-control-input">
                        <td> <?=$row->name;?> </td>
                        <td><?php echo $row->unit; ?></td>
                        <td><?php echo $row->pcs; ?></td>
                        <td><?php echo $row->cut; ?></td>
                        <td><?php echo $row	->meter;?></td>
                        <td><?php echo $row->order_item_priority; ?></td>
                        <td><?php echo $row->remarks; ?></td>
                        <td><a id="chk{{ $row->sale_order_item_id }}" href="javascript:void(0);" onClick="checkWarehouseItemStock({{ $row->sale_order_item_id }})" class="btn btn-primary btn-xs">Check Stock</a> <span id="recordId{{ $row->sale_order_item_id }}"> </span>
                          <select name="strt_process" id="strt_process{{ $row->sale_order_item_id }}" class="custom-control-input" style="display:none">
                            <option>Start Process</option>
                            <option value="new_work_order">Create New Work Order</option>
                          </select>
                        </td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <p>&nbsp; </p>
                  <div class="col-md-12" id="main_div">
                    <div class="row">
                      <div class="col-xs-12">
                        <!--table part start-->
                        <div class="table-responsive table-responsive-custom"> <span id="showPurchaseItems"> </span> </div>
                        <!--table part end-->
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-left">Confirm</button>
                    <button type="button" class="btn btn-danger" ><i class="fa fa-times"></i> Discard</button>
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
  <!-------------------Model Start-------------------->
  <div class="modal fade" id="CreateOrderModelId" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3><i class="fa fa-plus m-r-5"></i> Create Work Order</h3>
			<span id="WorkItemId"></span>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" >
                <fieldset>
                <table class="table table-bordered ">
                  <tr>
                    <th>Item Name</th>
                    <th>Stock</th>
					<th>Unit</th>
					<th>Pcs</th>
					<th>Cut</th>
					<th>Meter</th>
                    <th>Warehouse</th>
                    <th>Process</th>
                    <th>Action</th>
                  </tr>
                  <?php 
						foreach($dataIT as $row) 
						{ 
							//  echo "<pre>"; print_r($row); // exit; 
							/* {!! @$row['WarehouseItem']->pur_item_qty !!} */
							$warehouseItemId 	= @$row['WarehouseItem']->id;
							$warehouseId 	= @$row['WarehouseItem']->warehouse_id;	
							$purItemQty 	= @$row['WarehouseItem']->pur_item_qty;			
							$procesNum 		= @$row['WarehouseItem']->process_type_id;
							$itemId 	    = @$row['WarehouseItem']->item_id;	
							$itemTypeId 	= $row->item_type_id;								
						    $CrprocesNum 	= $procesNum-1;
						   //  $stock = @CommonController::getLastProcessItemStock($CrprocesNum)
						
						?>
                  <tr>
                    <td> {{ $row->item_type_name }} {{ $row->item_type_id }} </td>
					<td> {{ $purItemQty }}  </td>
					<td> {!! @$row['WarehouseItem']->unit !!}   </td>
					<td> {!! @$row['WarehouseItem']->pcs !!}   </td>
					<td> {!! @$row['WarehouseItem']->cut !!}   </td>
					<td> {!! @$row['WarehouseItem']->cut !!}   </td>
                    <td> {{ CommonController::getWarehouseName($warehouseId) }} </td>
                    <td> {{ CommonController::getProcessName($procesNum) }} </td>
					<td>
					
					
					<a href="javascript:void(0);" onClick="addWorkOrder()" class="btn btn-primary btn-xs">Add Work Order</a>
					
					
					<?php if(!empty($procesNum) && !empty($purItemQty)) { ?>
						<p><a class="btn btn-primary btn-xs" href="/start-addworkorder/{{ base64_encode($itemTypeId) }}/{{ base64_encode($itemId) }}/{{ base64_encode($saleordId) }}">Create {{ CommonController::getOutPutName($procesNum) }} order</a></p>
						<p><a class="btn btn-primary btn-xs" href="/start-addworkorder/{{ base64_encode($itemTypeId) }}/{{ base64_encode($itemId) }}/{{ base64_encode($saleordId) }}">Create Purchase Order</a></p> 		 
					<?php } else if(empty($procesNum) && $itemTypeId =='1') { ?>
						<a class="btn btn-primary btn-xs" href="/start-addworkorder/{{ base64_encode($itemTypeId) }}/{{ base64_encode($itemId) }}/{{ base64_encode($saleordId) }}">Create Purchase Order</a>
					<?php } ?>
					</td>
                  </tr>                                                  
                  <?php } ?>
                </table>
				
                <p>&nbsp; 
				<input type="text" id="item_id" name="item_id" value="">
				<input type="text" id="saleordId" name="saleordId" value="<?=$saleordId;?>">
				<input type="text" id="saleordItemId" name="saleordItemId" value="">
				</p>
                <div class="col-md-12 form-group user-form-group" >
                  
                </div>
                </fieldset>
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-------------------Model End-------------------->
  
  
  
  
  @include('common.footer') </div>
@include('common.formfooterscript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
  var siteUrl = "{{url('/')}}";
	function addWorkOrder() 
	{		
		var siteUrl = "{{url('/')}}";	
		var saleordItemId = Base64.encode($("#saleordItemId").val());		 
		window.location.href = siteUrl + '/' +"start-addworkorder/"+saleordItemId;
		 
	}
</script>




<script type="text/javascript">
  var siteUrl = "{{url('/')}}";
	function checkWarehouseItemStock(id) 
	{		
		// alert(id);
		jQuery.ajax({
			type: "GET",  
			url: siteUrl + '/' +"ajax_script/checkWarehouseItemStock", 
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":id,	 			
			},	 	
		
			cache: false,				
			success: function(msg)	
			{ 
				 
				var data = msg.split("||");  
				if(msg === '0')
				{
					$("#recordId"+id).html( 'Not Available' );					
				    					
				}
				// $("#chk"+id).hide();
				// $("#strt_process"+id).show();
				
				$("#item_id").val(''+data[0]+'');
				$("#saleordItemId").val(''+data[2]+'');
				$("#WorkItemId").html(' <strong>Item : </strong>'+data[1]+'');	
				
				$('#CreateOrderModelId').modal({backdrop: 'static', keyboard: false})	

				
			}
		}); 
	}
</script>
</body>
</html>
