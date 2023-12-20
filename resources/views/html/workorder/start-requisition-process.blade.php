<?php
	use \App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
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
        <div class="col-sm-12">
		
			{!! CommonController::display_message('message') !!}
			
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"><a href="javascript:void(0);">
                <h4>Start Requisition For Warping Process</h4>
                </a></div>
            </div>
            <div class="panel-body">
			<form method="post" action="{{ route('add_work_requisition') }}" class="form-horizontal" autocomplete="off">
			@csrf
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Required Item</th>                    
                  </tr>
                </tbody>
              </table>
			  <?php $itemId  = $data->item_id; ?>			           
			  
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
                    <td>
						<select  class="form-control" name="req_item_id[]">
							<option value=""> Select Item</option>
							<?php foreach($dataIYR as $rowArr) { ?>
							<option value="<?=$rowArr->yarn_id;?>"><?=$rowArr['getyarn']->item_name;?> </option>
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
