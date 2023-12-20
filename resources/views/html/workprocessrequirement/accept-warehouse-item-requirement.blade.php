<?php
	use \App\Http\Controllers\CommonController; 	
	// echo "<pre>"; print_r($dataWPR); exit;	
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
	  {!! CommonController::display_message('message') !!}
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"><h4><i class="fa fa-plus m-r-5"></i> Stock Allotment</h4></div>
            </div>
            <div class="panel-body"> 
              <div class="table-responsive">
			  
			   <form method="post" action="{{ route('StoreWarehouseStockAllotment') }}" class="form-horizontal" autocomplete="off">
				@csrf
				
				<?php
				$flag 	= 0;
				$i 		= 0;
				foreach ($dataWPR as $wprArr) 
				{	
					// echo "<pre>"; print_r($wprArr['Item']); 
					$wbitemId 			= $wprArr->warehouse_balance_item_id;
					$wisId 				= $wprArr->wis_id;
				  	$itemTypeId 		= $wprArr->item_type_id;
					$wprId 				= $wprArr->id;
					$itemId 			= $wprArr->item_id;					 
					$processId 			= $wprArr->process_type_id;
					$Quantity 			= $wprArr->quantity;
					// echo $wprArr['Item']->unit_type_id;
					if(!empty($wisId))
					{
						$warehouseName 	= CommonController::getWareHouseNameByItemStockId($wisId);
					} else 
					{
						$warehouseName 	= CommonController::getWareHouseNameByItemStock($itemId, $processId);
					}					
					$unitType 			= CommonController::getUnitTypeName($wprArr['Item']->unit_type_id);
					$ItemTypeName 		= CommonController::getItemTypeName($itemTypeId);
					$totAvlStock 		= null;
					if (!empty($wbitemId)) {
						$totAvlStock 	= CommonController::getBalanceStockById($wbitemId);
					} elseif (!empty($wisId)) {
						$totAvlStock 	= CommonController::getWarehouseItemStockById($wisId);
					} else {
						$totAvlStock 	= CommonController::getTotalAvailableItemStock($itemId, $itemTypeId);
					}
					$flag 			= !empty($totAvlStock) ? 1 : 0;			 
					$itemName 		= $wprArr['Item']->item_name;
					$itemCode 		= $wprArr['Item']->item_code;
					$itemInterName 	= $wprArr['Item']->internal_item_name;
				?>
					<div class="col-sm-12">
						<table class="table table-bordered">
							<tr>
								<td style="width:20%"> <strong> Item Name </strong> <?=$itemName; ?> </td>
								<td style="width:20%"> <strong> Item Intarnal Name </strong> <?=$itemInterName; ?> </td>
								<td style="width:20%"> <strong> Item Code </strong> <?=$itemCode; ?> </td>								 
								<td style="width:20%"><strong>Available Qty </strong> = <?=$totAvlStock;?> <?=$unitType;?> <?=$ItemTypeName;?> </td>		 
								<td><strong> Needed Qty </strong> = <?=$Quantity;?> <?=$unitType;?> <?=$ItemTypeName;?></td>
							</tr>
							<tr>
								<td> <strong> Warehouse </strong> <?=$warehouseName['Warehouse']; ?> </td>
								<td> <strong> Warehouse Compartment </strong> <?=$warehouseName['WarehouseCompartment']; ?></td>
							</tr>							 
							<?php
								$dataWIS = CommonController::WarehouseItemStockArray($itemId,$wisId, $Quantity);
								foreach ($dataWIS as $row)
								{
							?>
								<tr>
									<td>
										Received Date: <span> <?=date('d M, Y', strtotime($row->receive_date)); ?></span>
										<input type="hidden" name="received_quantities[]" value="<?=$Quantity; ?>" class="form-control">
										<input type="hidden" name="wis_ids[]" value="<?=$row->wis_id; ?>" class="form-control">
										<input type="hidden" name="warehouse_item_ids[]" value="<?= $row->warehouse_item_id; ?>" class="form-control">
										<input type="hidden" name="work_process_req_ids[]" value="<?=$wprId;?>" class="form-control">
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
				<?php $i++;
				} ?>
				<table class="table table-bordered">
					<input type="hidden" name="work_order_id" id="work_order_id" value="<?= $result['workOrdId']; ?>" class="form-control">
					<tr>
						<th>Remark Comment <span class="required" aria-required="true">*</span></th>
						<td><input type="text" name="allotment_remark" id="allotment_remark" required class="form-control"></td>
					</tr>
				</table>
				<?php if (empty($flag)) { ?>
					<p> Note: <b style="color: red;">Some Item Not Available in Warehouse.</b></p>
				<?php } ?>
				<?php if (!empty($flag)) { ?>
					<button type="submit" class="btn btn-success pull-left">Update Allotment</button>
				<?php } ?>
			</form>

			  </div>
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
 
</body>
</html>
