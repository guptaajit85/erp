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
        <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Work Order List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form action="" method="GET" role="search">
                  @csrf
                  <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="{{ $qsearch }}" placeholder="Search By Item Name">
                  </div>
                  <div class="col-sm-4 col-xs-12">
                     <select class="form-control" name="priority" id="priority">
						<option value="">Select Priority</option>
						<?php foreach($priorityArr as $pArr) { ?>
							<option value="<?=$pArr?>" <?php if($pArr =='High') { ?> selected <?php } ?>> <?=$pArr?> </option>
						<?php } ?> 
					 </select>
                  </div>
				   
                  <div class="col-sm-2 col-xs-12">
                    <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                  </div>
                </form>
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Work Order No.</th>
                      <th>Sale Order No.</th>
                      <th>Item</th>
                      <th>Customer Name</th>
                      <th>Process Type</th>
                      <th>Priority</th>
                      <th>Cut</th>
                      <th>Pcs</th>
                      <th>Meter</th>
                      <th>Requirement</th> 
                      <th>Print</th>
                      <th>Action</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($dataWI as $data) {
						 	 // echo "<pre>"; print_r($data); // exit;
						$WOItem = $data['WorkOrderItem'];
						$Id = $data->work_order_id; 
						// base64_encode($data->work_order_id);					  
						$proTypeId 			= $data->process_type_id;			  
						$quantity 			= $data->quantity;
						$masterIndId 		= $data->master_ind_id;
						$machineId 			= $data->machine_id;					  
						$outputQuantity 	= $data->output_quantity;
						$outputProcess 		= $data->output_process;
						$endProcessEmpId 	= $data->machine_id;
						$inspWorkStatusProcess 	= $data->insp_work_status_process;
						$isWarehouseAccepted 	= $data->is_warehouse_accepted;
						$work_req_send_by 		= $data->work_req_send_by;
						$WorkRequireReqAccepted 	= $data->is_work_require_request_accepted;
						$ReqSendBy   				= CommonController::getEmpName($work_req_send_by);
					  ?>
                    <tr id="Mid{{ $Id }}">
                      <td><?=$data->process_type;?><?=$data->process_sl_no;?> </td>
                     <td> 
						<?php foreach($WOItem as $rowArr) { ?>
							<p> {{ $rowArr->sale_order_id }} </p> 				  
						<?php } ?>
					</td>  
                      <td> {{ $data->item_name }}   </td>
                      <td> {{ $data->customer_name }} 
					  <?php foreach($WOItem as $valArr) {   ?>
					  <p> {{ CommonController::getEmpName($valArr->customer_id) }} 	</p> 				  
					  <?php } ?> 
					  </td>
                      <td> {{ CommonController::getProcessName($data->process_type_id) }} </td>
                     
					<td> 
						<?php foreach($WOItem as $rowArr) { ?>
							<p> {{ $rowArr->order_item_priority }} </p> 				  
						<?php } ?>
					</td>  
						<td><?=$data->cut;?> </td> 
						<td><?=$data->pcs;?> </td> 
						<td><?=$data->meter;?> </td> 
					
                      <td>
					     <?php if(!empty($work_req_send_by) && $WorkRequireReqAccepted =='Null') { ?>
                        <p>Work Requirement Send By {{ $ReqSendBy }} </p>
                        <?php } else if($WorkRequireReqAccepted =='Yes') { ?>
                        <span class="btn btn-info btn-xs"> Work Request Accepted By Warehouse</span>
                        <?php } else if($WorkRequireReqAccepted =='No') { ?>
                        <p><span class="btn btn-default btn-xs"> Work Request Denied By Warehouse</span></p>
                        <p> <a href="start-requisition-process/{{ base64_encode($Id) }}" class="btn btn-success btn-xs">Request</a>  </p>
                        <?php } else { ?>    
						<p><a href="start-requisition-process/{{ base64_encode($Id) }}" class="btn btn-success btn-xs">Request</a> </p>
                        <?php } ?>
                      </td>
					  
                      <td class="center"><?php if($isWarehouseAccepted =='Yes' && $WorkRequireReqAccepted =='Yes' && $proTypeId > 1) { ?>
                        <a target="_blank" href="{{ route('print-workorder-gatepass', base64_encode($Id)) }}" class="btn btn-success btn-xs">Gatepass</a>
                        <?php } ?>
                      </td>
					  
                      <td class="center">
					 
					  
					  <a target="_blank" href="workorder-details/{{ base64_encode($Id) }}" class="tooltip-info">
						<label class="label bg-green"><i class="fa fa-eye" aria-hidden="true"></i></label>
                      </a>
					  
					  <?php if($WorkRequireReqAccepted =='Yes') { ?>
                        <?php if(empty($masterIndId) || empty($machineId)) { ?>
                        <a href="javascript:void(0);" onClick="StartProcess({{ $Id }})" class="btn btn-success btn-xs">Start Process</a>
                        <?php } else if(empty($outputQuantity) || empty($outputProcess) || empty($endProcessEmpId)) { ?>
                        <a href="javascript:void(0);" onClick="EndProcess({{ $Id }})" class="btn btn-success btn-xs">End Process</a>
                        <?php } else if(empty($inspWorkStatusProcess)) { ?>
                        <a href="javascript:void(0);" onClick="InspectionProcess({{ $Id }})" class="btn btn-success btn-xs">Inspection</a>
                        <?php } else { ?> 
						<span class="label-custom label label-default">Item Send To Warehouse</span>
                        <?php } ?>
                        <?php } ?>
                      </td>
					  
                      <td class="center"><a href="javascript:void(0);" onClick="deleteWorkOrder({{ $Id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>
					  
                    </tr>
                    <?php } ?>
                    <tr class="center text-center">
                      <td class="center" colspan="13"><div class="pagination"> {{ $dataWI->links('vendor.pagination.bootstrap-4')}}</div></td>
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
  <!-------------------Model Start-------------------->
  <div class="modal fade" id="RequisitionPop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('add_work_requisition')}}" class="form-horizontal" autocomplete="off">
          @csrf
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i> Start Requisition Process </h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <fieldset>
                <table class="table table-bordered">
                  <tbody>
				   <tr>
                      <th>Required Item Name</th>
                      <td> <span id="ItemNameReq"></span></td>
                    
                    </tr>
                  </tbody>   
				  </table>
				  <table class="table table-bordered" id="myTable">
                  
                  <tbody>                   
                    <tr>
                      <input type="hidden" id="itemIdReq" name="itemIdReq">
                      <input type="hidden" id="work_order_id_req" name="work_order_id_req"> 
                      <th><span id="ReqProduct---"></span>  Item </th>
                      <th>Quantity</th>
                      <th>Unit</th>
                    </tr>
					
                    <tr> 
						<td>
							<select  class="form-control" name="req_item_id[]">
							  <option value=""> Select Item</option>
							  <?php foreach($dataI as $rowArr) { ?>
							  <option value="<?=$rowArr->item_id;?>"><?=$rowArr->item_name;?></option>
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
                </fieldset>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Send Requisition </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="InspectionProcessPop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('update_inspec_process')}}" class="form-horizontal" autocomplete="off">
          @csrf
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i> Inspection Process</h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <fieldset>
                <table class="table table-bordered ">
                  <tr>
                    <th>Item Name</th>
                    <td><span id="ItemName"></span></td>
                  </tr>
                  <tr>
                    <input type="hidden" id="ins_item_id" name="ins_item_id" value="">
                    <input type="hidden" id="ins_work_order_id" name="ins_work_order_id" value="">
                    <th>Completed <span id="InsoutputNext"></span></th>
                    <td><input type="number" min="1" id="output_quantity" name="output_quantity" required> <span id="InsoutputUnit"></span></td>
                  </tr>
                  <tr>
                    <td><strong>Comment</strong> </td>
                    <td><textarea class="form-control" id="inspec_comment" required name="inspec_comment"></textarea></td>
                  </tr>
                  <tr>
                    <td><strong>Work Status</strong> </td>
                    <td><select name="work_status" required id="work_status" onChange='selectWorkStatus(this.value)' class="form-control">
                        <option value=""> Select Work Status</option>
                        <option value="Completed"> Completed</option>
                        <option value="Defective"> Defective</option>
                      </select>
                    </td>
                  </tr>
                  <tr id="WorkStatusProcess" style="display:none;">
                    <td><strong>Process</strong></td>
                    <td><div class="i-check">
                        <input tabindex="7" type="radio" id="minimal-radio-1" value="reprocess" onClick="gatePass(this.value)" name="work_status_process">
                        <label for="minimal-radio-1">Re-Processing</label>
                      </div>
                      <div class="i-check">
                        <input tabindex="8" type="radio" id="minimal-radio-2" value="stock" onClick="gatePass(this.value)" name="work_status_process">
                        <label for="minimal-radio-2">Send To Warehouse</label>
                      </div>
                      <!------<div class="i-check"> <span id="ItemGatePass"></span> </div>  ------->
                    </td>
                  </tr>
                  <tr id="WorkStatusProcessReason" style="display:none;">
                    <td><strong>Defect Type Reason</strong></td>
                    <td><select name="fabric_fault_id" id="fabric_fault_id" class="form-control">
                        <?php foreach($dataF as $rowF) { ?>
                        <option value="<?=$rowF->id;?>"> <?=$rowF->reason;?> </option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Warehouse</strong></td>
                    <td><select name="insp_work_warehouse_id" id="insp_work_warehouse_id" required class="form-control">
						<option> Select Warehouse</option>
                        <?php foreach($dataW as $row) { ?>
                        <option value="<?=$row->id;?>"> <?=$row->warehouse_name;?> </option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                </table>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="EndProcessPop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('update_endprocess')}}" class="form-horizontal" autocomplete="off">
          @csrf
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i> End Process</h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <fieldset>
                <table class="table table-bordered ">
                  <tr>
                    <th>Item Name</th>
                    <td><span id="ItemNameE"></span></td>
                  </tr>
                  <tr>
                    <input type="hidden" id="end_item_id" name="end_item_id" value="">
                    <input type="hidden" id="end_work_order_id" name="end_work_order_id" value="">
					
                    <th>Output <span id="outputNext"></span></th>					
                    <td><input type="number" min="1" id="output_quantity" name="output_quantity" required> <span id="outputUnit"></span></td>   		
                    
					
                  </tr>   
				  
				  <tr>                   
                    <th>Output <span id="outputNext"></span> Size</th>					
                    <td><input type="number" min="1" id="output_quantity" name="output_quantity" required>  Meter</td>                  	 
                  </tr>
				  
				  
                  <tr>
                    <td><strong>Process Type</strong> </td>
                    <td><span id="processName"> </span>
                      <input type="hidden" name="output_process" id="output_process">
                    </td>
                  </tr>
                </table>
				<tr>
					<td> 
						<label>End Process Remarks <span class="required">*</span></label>
						<input type="text" name="process_ended_remarks" id="process_ended_remarks" required class="form-control">
					</td>
				</tr>
				  
                </fieldset>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="StartProcessPop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('update_startprocess')}}" class="form-horizontal" autocomplete="off">
          @csrf
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i> Start <span id="processNameId"></span> Process </h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <fieldset>
				<span id="RequestedItems"></span>
                <table class="table table-bordered ">
                  <tr>
                    <th>Item Name</th>
                    <td><span id="ItemNameS"></span> </td>
                  </tr>
                  <tr>
                    <input type="hidden" id="itemId" name="itemId" value="">
                    <input type="hidden" id="work_order_id" name="work_order_id" value="">
                     
                  </tr>
                  <tr>
                    <td><strong>Master</strong> </td>
                    <td><select id="masterId" class="form-control" name="masterId">
                        <?php foreach($dataMas as $row) { ?>
                        <option value="<?=$row->id;?>">
                        <?=$row->name;?>
                        </option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Machine </strong></td>
                    <td><select id="machineId" class="form-control" name="machineId">
                        <?php foreach($machine as $valArr) { ?>
                        <option value="<?=$valArr->id;?>">
                        <?=$valArr->name;?>
                        </option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
				 
                </table>
				 <tr>
				  <td> 
				  <label>Process Remarks <span class="required">*</span></label>
				  <input type="text" name="process_started_remarks" id="process_started_remarks" required class="form-control"></td>
				  </tr>
				
                </fieldset>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Start Process</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-------------------Model End-------------------->
  @include('common.footer') </div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>



<script type="text/javascript">
   var siteUrl = "{{url('/')}}";
	
	function Requisition(Id) 
	{	
		jQuery.ajax({
			type: "GET",  
			url: siteUrl + '/' +"ajax_script/getWorkOrderDetails", 
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":Id,				 
			}, 
			cache: false,				
			success: function(response)	
			{  
			 
				response = JSON.parse(response);
				console.log(response);
			 
				$("#itemIdReq").val(response.itemId); 
				$("#work_order_id_req").val(response.workOrdId); 
				$("#ItemNameReq").html(response.ItemName); 
				$("#ReqProduct").html(response.itemTypeName);

				
			}
		});			
		$('#RequisitionPop').modal({backdrop: 'static', keyboard: false});		 
	}
	
	
	
	function StartProcess(Id) 
	{	
		jQuery.ajax({
			type: "GET",  
			url: siteUrl + '/' +"ajax_script/getWorkOrderDetails", 
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":Id,				 
			},	 
			cache: false,				
			success: function(response)	
			{   
				response = JSON.parse(response);
				console.log(response);	 
				$("#itemId").val(response.itemId); 
				$("#work_order_id").val(response.workOrdId); 
				$("#ItemNameS").html(response.ItemName); 
				$("#processNameId").html(response.processName); 
				$("#RequestedItems").html(response.RequestedItems); 
				  
				// var data = response.split("||");   
				// $("#itemId").val(''+data[0]+'');
				// $("#work_order_id").val(Id);
				// $("#ItemNameS").html(''+data[1]+'');	 
			}
		});			
		$('#StartProcessPop').modal({backdrop: 'static', keyboard: false});		 
	}
	
	function EndProcess(Id) 
	{	
		jQuery.ajax({
			type: "GET",  
			url: siteUrl + '/' +"ajax_script/getWorkOrderDetails", 
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":Id,				 
			},	 
			cache: false,				
			success: function(response)	
			{   
				response = JSON.parse(response);
				console.log(response);	  
				$("#end_item_id").val(response.itemId); 
				$("#end_work_order_id").val(response.workOrdId); 
				$("#ItemNameE").html(response.ItemName); 
				$("#processName").html(response.processName); 
				$("#output_process").val(response.processNameId); 
				$("#outputNext").html(response.outputNextPro); 
				$("#outputUnit").html(response.outputUnit); 
			 
			}
		});			
		$('#EndProcessPop').modal({backdrop: 'static', keyboard: false});		 
	}
	
	function InspectionProcess(Id) 
	{	
		jQuery.ajax({
			type: "GET",  
			url: siteUrl + '/' +"ajax_script/getWorkOrderDetails", 
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":Id,				 
			},	 
			cache: false,				
			success: function(response)	
			{  
				
				response = JSON.parse(response);
				console.log(response);	 
				$("#ins_item_id").val(response.itemId); 
				$("#ins_work_order_id").val(response.workOrdId); 
				$("#ItemName").html(response.ItemName);  
				$("#InsoutputNext").html(response.outputNextPro); 
				$("#InsoutputUnit").html(response.outputUnit); 				
				
				/*
					var data = msg.split("||");   
					$("#ins_item_id").val(''+data[0]+'');
					$("#ins_work_order_id").val(Id);
					$("#ItemName").html(''+data[1]+'');			
				*/
				
			}
		});			
		$('#InspectionProcessPop').modal({backdrop: 'static', keyboard: false});		 
	}
</script>
<script type="text/javascript">
	function deleteWorkOrder(id)
	{
		var siteUrl = "{{url('/')}}";
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteWorkOrder", 
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

<script type="text/javascript">
 function selectWorkStatus(value)
 { 
	if(value === 'Defective')
	{ 
		$('#WorkStatusProcess').show();
		$('#WorkStatusProcessReason').show();
	}
	else if(value === 'Completed')
	{ 
		$('#WorkStatusProcess').hide();
		$('#WorkStatusProcessReason').hide();
	}
	
 } 
 
 function gatePass(value)
 { 	  
	if(value ==='stock')
	{
		var siteUrl = "{{url('/')}}";
		var Id = Base64.encode($("#ins_work_order_id").val()); 
		var pageUrl = siteUrl + '/' +"print-workorder-gatepass"+'/'+Id; 
		$("#ItemGatePass").html('<div class="i-check"> <a target="_blank" href='+pageUrl+' class="btn btn-success btn-xs">Gatepass</a></div>');	
		$("#ItemGatePass").show();		
	}else if(value ==='reprocess')
	{
		 $("#ItemGatePass").hide();		
	}
	
 }
</script>

<script>
	function addRow() 
	{
		var table = document.getElementById("myTable");
		var newRow = table.insertRow(table.rows.length);
		var cell1 = newRow.insertCell(0);
		var cell2 = newRow.insertCell(1); 
		var cell3 = newRow.insertCell(2); 

		cell1.innerHTML = '<select  class="form-control" name="req_item_id[]"><option value=""> Select Item</option><?php foreach($dataI as $rowArr) { ?><option value="<?=$rowArr->item_id;?>"> <?=$rowArr->item_name;?> </option><?php } ?></select> ';
		
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
