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
              <div class="btn-group" id="buttonexport"> <a href="add-warehouse">
                <h4>Warehouse Requirement List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
              <div class="row" style="margin-bottom:5px">
                <form action="{{ route('show-warehouses') }}" method="GET" role="search">
                  @csrf
                  <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="" placeholder="Search by Name">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                  </div>
                </form>
              </div>
              <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Request Id</th>
                      <th>Work Order Id</th>
                      <th>Process Type</th>
                      <th>Item Type </th>
                     <!-- <th>Item</th> --->
                      <th>Work Request Send By</th>
                      <th>Status </th>
                      <th>Allotment </th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataWPR as $data)
				<?php
				
					// echo "<pre>"; print_r($data); 
					  $wprData   = CommonController::WorkProcessRequirementData($data->work_order_id);
					  // echo "<pre>"; print_r($wprData); 
					  $wprId 			   	= $data->id;
					  $woId 			   	= $data->work_order_id;
					  $process_accepted_by 	= $data->process_accepted_by;
					  $process_deny_by 	  	= $data->process_deny_by;
					  $isProAccByWarehouse 	= $data->is_pro_acc_by_warehouse;
					  $processAcceptedBy   	= CommonController::getEmpName($process_accepted_by);
					  $processDenyBy   		= CommonController::getEmpName($process_deny_by);
					  
					  
				  ?>
                  <tr id="Mid{{ $data->id }}">
                    <td> {{ $wprId }}  </td>
                    <td> {{ $data['WorkOrder']->process_type }}{{ $data['WorkOrder']->process_sl_no }} </td>
                    <td> {{ CommonController::getProcessName($data->process_type_id) }} </td>
                    <td> {{ CommonController::getItemType($data->item_type_id) }} </br> 
					<a href="javascript:void(0);" onClick="getProcessRequirementItems({{ $woId }})" class="btn btn-info btn-xs">View</a></td>
                 <!---   <td> {{ $data->count }} </td> --->
                    <td> {{ CommonController::getEmpName($data->work_req_send_by) }} </td>
                    <td class="center" id="Waccepted{{ $data->id }}">
					  <?php if(empty($isProAccByWarehouse)) { ?>
                     <!--- <a href="javascript:void(0);" onClick="AcceptWarehouseReq({{ $data->id }})" class="btn btn-success btn-xs">Accept</a> ---->   
					  <a href="{{ route('accept-warehouse-item-requirement', base64_encode($woId)) }}" target="_blank" class="btn btn-success btn-xs">Accept</a>  
					  <a href="javascript:void(0);" onClick="DenyWarehouseReq({{ $woId }})" class="btn btn-danger btn-xs">Deny</a>
                      <?php } else if($isProAccByWarehouse == 'Yes') { ?>
                      <a href="javascript:void(0);" class="btn btn-success btn-xs">Accepted</a>
                      <p> Accepted By <?=$processAcceptedBy;?> </p>
                      <?php } else if($isProAccByWarehouse == 'No') { ?>
                      <a href="javascript:void(0);" class="btn btn-success btn-xs">Denied</a>
                      <p> Denied By <?=$processDenyBy;?> </p>
                      <?php } ?>
                    </td>
					<td>
					 <?php if($isProAccByWarehouse == 'Yes') { ?>
					<a href="javascript:void(0);" onClick="ViewWarehouseReq({{ $wprId }})" class="btn btn-info btn-xs">View</a>
					
					 <a target="_blank" href="{{ route('print-warehouse-item-requirement-gatepass', base64_encode($wprId)) }}" class="btn btn-success btn-xs">Gatepass</a>
					
					 <?php } ?>
					</td>
                  </tr>
                  @endforeach
                  <tr class="center text-center">
                    <td class="center" colspan="8"><div class="pagination">{{ $dataWPR->links() }}</div></td>
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
  
  <!-----------------Model Popup ---------------------->
  <div class="modal fade" id="getProcessRequirementItems" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content"> 
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i>Required Stock List, for <span id="req_work_item_name"> </span>  </h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12"> 
                <table class="table table-bordered">
				<tbody> 
					<tr> 
						<span id="req_stock_allot_arr"> </span> 
					</tr>
				  </tbody>
                </table> 
              </div>
            </div>
          </div>
          <div class="modal-footer"></div> 
      </div>
    </div>
  </div>  
  
  <div class="modal fade" id="StockAllotmentPop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content"> 
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i> Stock Allotment Report, for <span id="stock_ItemName_arr"> </span> </h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12"> 
                <table class="table table-bordered">
				<tbody> 
					<tr> 
						<span id="stock_allot_arr"> </span> 
					</tr>
				  </tbody>
                </table> 
              </div>
            </div>
          </div>
          <div class="modal-footer"></div> 
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="PurchaseReqPop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('add_work_purchase_requisition')}}" class="form-horizontal" autocomplete="off">
          @csrf
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><i class="fa fa-plus m-r-5"></i> Purchase Request</h3>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <fieldset>
                <table class="table table-bordered">
                  <tr>
                    <th>Work Item Name</th>
                    <th> <span id="ItemNameReq"></span></th>
                  </tr>
                   
                  <tr>

				  <td>Purchase Remark </td>
				  <td> 	<input type="text" name="pur_remark" id="pur_remark" required class="form-control"> </td>

				  </tr>
                </table>
				<span id="wprDetails"></span>
				
				
                </fieldset>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success pull-left">Send Purchase Request</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  
  
  
 @include('common.footer') </div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>


<script type="text/javascript">
var siteUrl = "{{url('/')}}"; 
function DenyWarehouseReq(id) 
{ 
	if(confirm("Are You Sure want to Deny this Requirement?"))
	{
		jQuery.ajax({
			type: "GET", 
			url: siteUrl + '/' +"ajax_script/getWorkProcessRequirement",
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":id,	 			
			},			
			cache: false,				
			success: function(response)	
			{	 
				response = JSON.parse(response);
				console.log(response);
				
				// alert(response.quanTity);
				$("#ItemNameReq").html(response.WorkItemName); 
				$("#wprDetails").html(response.wprDetails); 
				 
			}
		});	
			
		$('#PurchaseReqPop').modal({backdrop: 'static', keyboard: false});	
		
	}	
		
}

function DenyWarehouseReq_Old(id) 
{ 
	if(confirm("Are You Sure want to Deny this Requirement?"))
	{
		jQuery.ajax({
			type: "GET", 
			url: siteUrl + '/' +"ajax_script/DenyWarehouseReq",
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":id,	 			
			},			
			cache: false,				
			success: function(msg)	
			{	 
				// $("#Mid"+id).hide();	
				$("#Waccepted"+id).html('<a href="javascript:void(0);"  class="btn btn-success btn-xs">Denied</a>');				
			}
		});
		 
	}	
		
}
</script>

<script type="text/javascript">
var siteUrl = "{{url('/')}}";

function ViewWarehouseReq(id) {
    jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkProcessAllotmentView",
        data: {
            "_token": "{{ csrf_token() }}",
            "FId": id,
        },
        cache: false,
        dataType: 'json', // Specify the expected data type
        success: function(response) {
            console.log(response);
            $("#stock_ItemName_arr").html(response.ItemName);
            $("#stock_allot_arr").html(response.stock_allot_arr);
        }
    });

    $('#StockAllotmentPop').modal({ backdrop: 'static', keyboard: false });
}
	

function getProcessRequirementItems(id) 
{    
    jQuery.ajax({
        type: "GET",
        url: siteUrl + '/ajax_script/getProcessRequirementItems',
        data: {
            "_token": "{{ csrf_token() }}",
            "FId": id,
        },
        cache: false,
        dataType: 'json',  
        success: function(response) {
            console.log(response);
            $("#req_work_item_name").html(response.WorkItemName);
            $("#req_stock_allot_arr").html(response.wprDetails);             
        },
        error: function(xhr, status, error) {
            // Handle errors here, e.g., console.log("Error:", error);
        }
    });
    $('#getProcessRequirementItems').modal({ backdrop: 'static', keyboard: false });
}




function AcceptWarehouseReq_Old(id) 
{ 
	if(confirm("Are You Sure want to Accept this Requirement?"))
	{
		jQuery.ajax({
			type: "GET", 
			url: siteUrl + '/' +"ajax_script/AcceptWarehouseReq",
			data: {
				"_token": "{{ csrf_token() }}",
				"FId":id,	 			
			},			
			cache: false,				
			success: function(msg)	
			{	 
				// $("#Mid"+id).hide();	
				  $("#Waccepted"+id).html('<a href="javascript:void(0);"  class="btn btn-success btn-xs">Accepted</a>');	
				
			}
		});
		 
	}	
		
}
</script>
</body>
</html>
