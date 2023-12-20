<?php
	use \App\Http\Controllers\CommonController; 
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
<style>
.hrr{}
</style>
</head>
<body class="hold-transition sidebar-mini">
 
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
                <h4>Create WO from SO List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form action="{{ route('show-saleorderitems') }}" method="GET" role="search">
				
                  @csrf
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="<?=$qsearch;?>" placeholder="Search by Customer Name.. ">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="qnamesearch" id="qnamesearch" value="<?=$qnamesearch;?>" placeholder="Search by Item Name.. ">
                  </div>				  
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="ordNumSearch" id="ordNumSearch" value="<?=$ordNumSearch;?>" placeholder="Search by Order Number.. ">
                  </div>				  
                   <div class="col-sm-1 col-xs-12">
						<select class="form-control" name="priority" id="priority">
							<option value="">Priority</option>
							<?php foreach($priorityArr as $pArr) { ?>
							<option value="<?=$pArr?>" <?php if($pArr == $priority) { ?> selected <?php } ?>> <?=$pArr?> </option>
							<?php } ?> 
						</select>
                  </div>				  
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?=$fromDate;?>">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?=$toDate;?>">
                  </div>
                  <div class="col-sm-1 col-xs-12">
                    <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                  </div>
				  
                </form>
				
                <div class="col-sm-2 col-xs-12">
                  <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                  <ul class="dropdown-menu exp-drop" role="menu">
                    <li class="divider"></li>
                    <li> <a href="javascript:void(0);" onClick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});"> <img src="assets/dist/img/xls.png" width="24" alt="logo"> XLS</a> </li>
                  </ul>
                </div>
                 
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
						<th>#</th>
						<th>Lot Number</th> 
						<th>Sale Ord. Number</th> 
						<th>Cus. Name</th> 	
						<th>Internal Name</th>	
						<th>Item Name</th>						
						<th>Dyeing Color</th>
						<th>Coated PVC</th>
						<th>Extra job</th>
						<th>Print job</th> 
						<th>Required </br>PCs</th>
						<th>Required </br>Cut</th>
						<th>Required </br>Meter</th> 
						<th>Priority</th> 
						<th>Sale <br/> Order Date </th>
						<th>Expected <br/> Delivery Date </th>										 
                    </tr>
                  </thead>
                  <tbody>
                <form action="{{ route('store_workorder') }}" method="post" name="creatworkord" id="creatworkord">  
				   @csrf
				    <?php  
					foreach($dataSOI as $data) 
					{ 
					//   echo "<pre>"; print_r($data);   exit;
						$itemId = $data->item_id;
						$saleOrderItemId  		= $data->sale_order_item_id;
						$indvId  				= $data['SaleOrder']->individual_id;
						$workSaleOrderItemId  	= @$data['WorkOrderItem']->sale_order_item_id;
						$cusName 				= CommonController::getIndividualName($indvId);
						$itemtypeId 			= $data->item_type_id;
						$dyeing_color 			= $data->dyeing_color;
						$coatingPvc 			= $data->coated_pvc;
						
					    $totGreige 				= CommonController::check_warehouse_greige_type_balance($itemId,$itemtypeId);						
					    $totDying 				= CommonController::check_warehouse_dyeing_type_balance($itemId,$itemtypeId,$dyeing_color);		
					    $totCoated 				= CommonController::check_warehouse_coating_type_balance($itemId,$itemtypeId,$coatingPvc);
						
						$priority 				= $data->order_item_priority;
						$getItemInternalName = CommonController::getItemInternalName($data->item_id);
					?>
                  <tr id="Mid{{ $data->sale_order_item_id }}" <?php if($priority =='Extreme') { ?> style="background-color:#ffdbdb" <?php } ?>>
                    <td> <input type="checkbox" name="chk_sale_order_item_id[]" data-item-name="{{ $data->name }}" data-sale_order_id="{{ $data->sale_order_id }}" onClick="checkItemStock({{ $itemId }})"  value="<?=$saleOrderItemId;?>" id="sale_order_item_id" class="form-control"></td>
                    <td> <center>{{ $data->sale_order_id }}</center></td>  
					<td> <center>{{ $data['SaleOrder']->sale_order_number }}</center></td>
					<td> <?=$cusName;?> </td> 	
					
                    <td> {{ $getItemInternalName }} <p> Available <br/> <strong> <?=$totGreige;?></strong> </p></td>
                    <td> {{ $data->name }}  </td>
                    <td> {{ $data->dyeing_color }}  <p> Available <br/> <strong> <?=$totDying;?></strong> </p></td>
                    <td> {{ $data->coated_pvc }}    <p> Available <br/> <strong> <?=$totCoated;?></strong> </p></td>
                    <td> {{ $data->extra_job }}  </td>
                    <td> {{ $data->print_job }}  </td>
                    <td> {{ $data->pcs }}  </td>
                    <td> {{ $data->cut }}  </td>
                    <td> {{ $data->meter }}  </td>
                    <td> {{ $data->order_item_priority }}</td> 
                    <td> <?=date('M jS, Y',strtotime($data->created));?>  </td>
                    <td> <?=date('M jS, Y',strtotime($data->expect_delivery_date));?>  </td>
                    		 
                  </tr>
                <?php } ?>
				 
                  <tr class="center text-center">
                    <td class="center" colspan="20">  
						<button type="submit" name="WorkSubmit" value="Warping" class="btn btn-success">Create Warping Work  </button>  
						<button type="submit" name="WorkSubmit" value="Weaving" class="btn btn-success">Create Weaving Work  </button> 
						<button type="submit" name="WorkSubmit" value="Dyeing" class="btn btn-success">Create Dyeing Work  </button> 
						<button type="submit" name="WorkSubmit" value="Coating" class="btn btn-success">Create Coating Work  </button>  
					</td>
                  </tr>		
				  
                  <tr class="center text-center">
                    <td class="center" colspan="20"><div class="pagination">{{ $dataSOI->links('vendor.pagination.bootstrap-4')}} </div></td>
                  </tr>				  
				</form>  
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
  @include('common.footer') 
</div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

  
<script type="text/javascript">
    var siteUrl = "{{ url('/') }}";

    function checkItemStock(id) {
        var selectedItems = document.querySelectorAll('input[name="chk_sale_order_item_id[]"]:checked');
        var selectedValues = [];

        selectedItems.forEach(function (item) {
            selectedValues.push(item.value);
        });

        var ids = selectedValues.join(", ");

        // Send AJAX request 
		 jQuery.ajax({
			type: "GET",
			url: siteUrl + '/' + "ajax_script/checkIteminWarehouse",
			data: {
				"_token": "{{ csrf_token() }}",
				"FId": ids,
			},
			cache: false,
			success: function (response) {
				response = JSON.parse(response);
				console.log(response);

				// Assuming the keys are strings and you want to check if they are empty
				if (!response.weavingwrk || response.weavingwrk === "0") {
					$('button[value="Weaving"]').prop('disabled', true);
				} else {
					$('button[value="Weaving"]').prop('disabled', false);
				}

				if (!response.dyeingwrk || response.dyeingwrk === "0") {
					$('button[value="Dyeing"]').prop('disabled', true);
				} else {
					$('button[value="Dyeing"]').prop('disabled', false);
				}

				if (!response.coatingwrk || response.coatingwrk === "0") {
					$('button[value="Coating"]').prop('disabled', true);
				} else {
					$('button[value="Coating"]').prop('disabled', false);
				}
			}
		});

 
        // Check for duplicates based on data-item-name attribute
        var prevItem = '';
        var isDifferentItems = true;

        selectedItems.forEach(function (item) {
            if ($(item).prop('checked') === true) {
                if (prevItem === $(item).data('item-name') || prevItem === '') {
                    prevItem = $(item).data('item-name');
                } else {
                    alert('You cannot select different items to start any process!');
                    isDifferentItems = false;
                    $(item).prop('checked', false);
                }
            }
        });

        if (!isDifferentItems) {
            return false; // Prevent form submission
        }

        // Check for selected item names
        var selectedNames = new Set();

        selectedItems.forEach(function (item) {
            var itemName = item.getAttribute('data-item-name');
            if (selectedNames.has(itemName)) {
                return true; // Prevent form submission
            }
            selectedNames.add(itemName);
        });

        // Check for unchecked item names
        var uncheckedItems = document.querySelectorAll('input[name="chk_sale_order_item_id[]"]:not(:checked)');

        uncheckedItems.forEach(function (item) {
            var uncheckedItemName = item.getAttribute('data-item-name');
            if (selectedNames.has(uncheckedItemName)) {
                alert(uncheckedItemName + ' similar item is in the list.');
                return false; // Prevent form submission
            }
        });

        if (selectedNames.size === 0) {
            alert('Please select at least one item.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>
  
  
<script>
  $(function() {
    $("#from_date, #to_date").datepicker({
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      autoclose: true,
	  maxDate: 0,
    });
  });
</script>
 
</body>
</html>
