<?php
	use \App\Http\Controllers\CommonController; 
	$WorkWarehouseId 	= $dataWO->insp_work_warehouse_id;
	$workOrderId 		= $dataWO->work_order_id; 
?>
<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
        <!-- Form controls -->
        <div class="col-sm-12">
		 {!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add" href="javascript:void(0);"> <i class="fa fa-list"></i> Received Work Item In Warehouse </a> </div>
            </div>
            <div class="panel-body">
              <form method="POST" action="{{ route('receive_work_item_in_warehouse')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-12"> </div>
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <tbody>
                      
                      <tr>
                        <td><label for="work_order_id">Work Order Number</label>
                          <input type="text" id="work_order_id"  class="form-control" required name="work_order_id" value="<?=$workOrderId;?>">
                        </td>
                        <td><label for="receiver_name">Receiver Name</label>
                          <input type="text" id="receiver_name" required class="form-control" name="receiver_name" class="form-control">
                          <input type="hidden" id="receiver_id"  value="" class="form-control" name="receiver_id">
                        </td>
                        <td><label for="report_document">Report Document</label>
                          <input type="file" name="report_document" id="report_document" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td><label for="purchase_number">Warehouse</label>
                          <select class="form-control" name="warehouseId" required id="warehouseId" onChange="selectCompartment(this.value);">
                            <option value="">Please Select Warehouse</option>
                            <?php foreach($dataW as $val) { ?>
                            <option value="<?=$val->id;?>"<?php if($val->id == $WorkWarehouseId) echo"selected"; ?>>
                            <?=$val->warehouse_name;?>
                            </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td id="warehouseCompIdDiv"></td>
                        <td><label for="emp_name">Receiver Employee Name</label>
                          <input type="text" id="emp_name" class="form-control" required name="emp_name">
                          <input type="hidden" id="ind_emp_id" class="form-control" name="ind_emp_id">
                          <table class="table table-bordered">
                            <tbody>
                            <span id="warehouseEmpDiv"></span>
                            </tbody>
                            
                          </table>
						</td>
                        <td><label>Reciving Date</label>
                          <input type="text" id="receiving_date" required class="form-control" data-date-format="yyyy-mm-dd" name="receiving_date" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td><label for="process_type">Process Type</label>
                          <select name="process_type_id" id="process_type_id" required class="form-control">
						  <option value="">Select Process Type</option>
                            <?php foreach($dataPI as $row) { ?>
                            <option value="<?=$row->id;?>">
                            <?=$row->process_name;?>
                            </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td><label for="item_type">Item Type</label>
                          <select name="item_type_id" required id="item_type_id" class="form-control">
							<option value="">Select Item Type</option>
                            <?php foreach($dataIT as $row) { ?>
                            <option value="<?=$row->item_type_id ;?>"<?php if($row->item_type_id == $ItemTypeId) echo"selected"; ?>>
                            <?=$row->item_type_name;?>
                            </option>
                            <?php } ?>
                          </select>
                        </td>
                        <td><label for="item_name">Item Name</label>
                          <input type="text" id="item_name" class="form-control" value="<?=$dataWO->item_name;?>" name="item_name" required>
                          <input type="hidden" id="item_id" value="<?=$dataWO->item_id;?>" class="form-control" name="item_id">
                        </td>
                      </tr>
                      <!--------  
					  <td><label for="item_quantity">Item Quantity</label>
                          <input type="text" name="pur_item_qty" id="pur_item_qty" value="" class="form-control">
                        </td>
                      <tr>
                        <td><label for="unit">Unit</label>
                          <input type="text" name="unit" id="unit" class="form-control">
                        </td>
                        <td><label for="pcs">Pieces</label>
                          <input type="text" name="pcs" id="pcs" class="form-control">
                        </td>
                        <td><label for="cut">Cut</label>
                          <input type="text" name="cut" id="cut" class="form-control">
                        </td>
                        <td><label for="meter">Meter</label>
                          <input type="text" name="meter" id="meter" class="form-control">
                        </td>
                      </tr>
					  
					  ----->
                      </tbody>
                      
                    </table>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Sender Item Details </th>
                          <th>Warehouse Item Details </th>
                          <th>Left Item Details </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Quantity :
                            <?=$dataWO->output_quantity;?></td>
                          <td>Quantity :
                            <input type="number" onChange="QuantityChange()" onBlur="QuantityChange()" min="0" max="1000" name="pur_item_qty" value="<?=$dataWO->output_quantity;?>" id="pur_item_qty"></td>
                          <td>Quantity :
                            <input type="number" readonly min="0" max="1000" name="left_item_qty" value="0" id="left_item_qty"></td>
                        </tr>
                        <tr>
                          <td>Pieces : 0</td>
                          <td>Pieces :
                            <input type="number" min="0" max="1000" value="0" name="pcs" id="pcs"></td>
                          <td>Pieces :
                            <input type="number" readonly min="0" max="1000" value="0" name="left_pcs" id="left_pcs"></td>
                        </tr>
                        <tr>
                          <td>Meter  : 0</td>
                          <td>Meter  :
                            <input type="number" name="meter" min="0" value="0" max="1000" id="meter"></td>
                          <td>Meter  :
                            <input type="number" readonly name="left_meter" value="0" min="0" max="1000" id="left_meter"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12" id="main_div">
                    <div class="row">
                      <div class="col-xs-12"> &nbsp; </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-left">Confirm</button>
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
  @include('common.footer') </div>
@include('common.formfooterscript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript"> 
	function QuantityChange() {
		 
		var SendQuan = {!! $dataWO->output_quantity !!};  
		var recevQuan = $("#pur_item_qty").val();	
		 
		var totQuan =  SendQuan-recevQuan;
		 $( "#left_item_qty" ).val( totQuan );
		 
	}
</script>
<script type="text/javascript"> 
var siteUrl = "{{url('/')}}"; 
$( "#item_name" ).autocomplete({		 
	  minLength: 1,
	  source: siteUrl + '/' +"list_item", 
	  focus: function( event, ui ) {
		  
		// alert(ui.item.item_name); 
		$( "#item_name" ).val( ui.item.item_name );
		$( "#item_id" ).val( ui.item.item_id );
		 
		return false;
	  },
	  select: function( event, ui ) { 
	  
		return false;
	  }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
	  return $( "<li>" )
		.append( "<div>" + item.item_name + "<br> Code - " + item.item_code + "</div>" )
		.appendTo( ul );
	};  
</script>
<script type="text/javascript"> 
var siteUrl = "{{url('/')}}"; 
$( "#receiver_name" ).autocomplete({		 
	minLength: 0,
	source: siteUrl + '/' +"list_employee", 
	focus: function( event, ui ) 
	{ 
		$( "#receiver_name" ).val( ui.item.name );
		$( "#receiver_id" ).val( ui.item.id ); 
		return false;
	},
	select: function( event, ui ) 
	{ 
		// $( "#ind_emp_id" ).val( ui.item.id ); 
		return false;
	}
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
	return $( "<li>" )
	.append( "<div>" + item.name + "</div>" )
	.appendTo( ul );
}; 
</script>
<script type="text/javascript"> 
var siteUrl = "{{url('/')}}"; 
$( "#emp_name" ).autocomplete({		 
	minLength: 0,
	source: siteUrl + '/' +"list_employee", 
	focus: function( event, ui ) 
	{ 
		$( "#emp_name" ).val( ui.item.name );
		$( "#ind_emp_id" ).val( ui.item.id ); 
		return false;
	},
	select: function( event, ui ) 
	{ 
		// $( "#ind_emp_id" ).val( ui.item.id ); 
		return false;
	}
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
	return $( "<li>" )
	.append( "<div>" + item.name + "</div>" )
	.appendTo( ul );
}; 
</script>
<!---------search_warehouse_compartment -- getWarehouseCompEmployee-------------->
<script type="text/javascript"> 
<?php if(!empty($WorkWarehouseId)) { ?>
	var Id = {!! $WorkWarehouseId !!};
	selectCompartment(Id);
<?php } ?>

function selectCompartment(Id)
{ 
	$.ajax({
	type: "GET", 
		url: siteUrl + '/' +"ajax_script/search_warehouse_compartment",
			data: {
				"_token": "{{ csrf_token() }}",
				"Id":Id,
			},	 	
		cache: false, 
		success: function(res){   
			$( "#warehouseCompIdDiv" ).html(res); 
		}					
	})	   
	
}

function selectEmployee(Id)
{ 
	$.ajax({
	type: "GET", 
		url: siteUrl + '/' +"ajax_script/getWarehouseCompEmployee",
			data: {
				"_token": "{{ csrf_token() }}",
				"Id":Id,
			},	 	
		cache: false, 
		success: function(msg){ 
			var data = msg.split("||");  
			$( "#emp_name" ).val(''+data[1]+'');
			$( "#ind_emp_id" ).val(''+data[0]+''); 
		}					
	})		
}


</script>
<script>
$("#purchase_started,#receiving_date").datepicker({ 
	autoclose: true,
});
</script>
</body>
</html>
