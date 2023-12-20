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
              <div class="btn-group" id="buttonexport"><a href="javascript:void(0);">
                <h4>Start Requisition Process</h4>
                </a></div>
            </div>
            <div class="panel-body">
			<form method="post" action="{{ route('add_work_requisition_for_weaving') }}" class="form-horizontal" autocomplete="off">
			@csrf
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Required Item</th>                    
                  </tr>
                </tbody>
              </table>
				<?php 				
					$itemId 			= $dataWI->item_id;			 
					$itemTypeId 		= $dataWI->item_type_id;
					$item_name  	   	= CommonController::getItemName($dataWI->item_id);
					$item_type_name  	= CommonController::getItemTypeName($dataWI->item_type_id); 
					// $stock  			= CommonController::getTotalAvalableStockByItem($itemId,$itemTypeId);  
					$pur_item_qty 		= $dataWI->pur_item_qty;
					$item_type_id 		= $dataWI->item_type_id; 
					// $resultArray = CommonController::getTotalAvailableStockByItem($itemId, $itemTypeId); 
					$resultArray = CommonController::getWarehouseAvailableItemStockArray($itemId, $itemTypeId); 
				?>	
				 
				<?php 
				foreach ($resultArray as $result) 
				{
					//  echo "<pre>"; print_r($result);  // exit;
					$totalItemQty 	= $result->insp_bal_quan_size;
					$stockTblId 	= $result->wis_id;

				?>	
				
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Item Name</th>
                    <td> <?=$item_name;?> </td> 
                    <td> <?=$totalItemQty;?> Kg <?=$item_type_name;?></td>
                    
                    <td> <!---<input type="hidden" id="required_item_qty" name="required_item_qty[]" value="<?=$totalItemQty;?>" max="<?//=$totalItemQty;?>"> --->
						<input type="checkbox" id="wis_id" name="wis_id[]" value="<?=$stockTblId;?>">

					 </td>
                  </tr>	

				  
				   <input type="hidden" id="ext_item_type_id" name="ext_item_type_id" value="<?=$item_type_id;?>">
				   
				    
                </tbody>
              </table> 			  
			  <?php } ?>
			  
			  
              <table class="table table-bordered" id="myTable">
                <tbody>
                  <tr>
                    <input type="hidden" id="itemIdReq" name="itemIdReq" value="<?=$itemId;?>">
                    <input type="hidden" id="work_order_id_req" name="work_order_id_req" value="<?=$workOrderId;?>">
                    <th><span id="ReqProduct"></span> Item </th>
                    <th>Quantity</th>
                    <th>Unit</th>
                  </tr>
                  <tr>
                    <td><select  class="form-control" name="req_item_id[]">
                        <option value=""> Select Item</option>
                        <?php foreach($dataIYR as $rowArr) { ?>
							<option value="<?=$rowArr->yarn_id;?>"><?=$rowArr['getyarn']->item_name;?> <?=$rowArr->yarn_id;?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td>
						<input type="number" min="1" class="form-control" id="quantity[]" name="quantity[]" required>
						<button type="button" class="btn btn-success btn-xs" onClick="addRow()">Add Row</button>
					</td>
                    <td>Kg</td>
                  </tr>
				  
                </tbody>
              </table>
				
			  <button type="submit" class="btn btn-success pull-left">Send Requisition </button>
			</form>
			  
			</div> 
			
          </div>
        </div>
      </div>
    </section>
  </div>
  @include('common.footer') </div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script>
	function addRow() 
	{
		var table = document.getElementById("myTable");
		var newRow = table.insertRow(table.rows.length);
		var cell1 = newRow.insertCell(0);
		var cell2 = newRow.insertCell(1); 
		var cell3 = newRow.insertCell(2); 

		cell1.innerHTML = '<select  class="form-control" name="req_item_id[]"><option value=""> Select Item</option><?php foreach($dataIYR as $rowArr) { ?><option value="<?=$rowArr->yarn_id;?>"><?=$rowArr['getyarn']->item_name;?></option><?php } ?></select> ';
		
		cell2.innerHTML = '<input type="number" min="1" class="form-control" id="quantity[]" name="quantity[]" required><button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(this)">Delete</button>';		
		cell3.innerHTML = 'Kg'; 
	}

	function deleteRow(button) {
		var row = button.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}
</script>
</body>
</html>
