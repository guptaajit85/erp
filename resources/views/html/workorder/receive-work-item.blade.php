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
				     <table class="table table-bordered" id="myTable">					
                      <thead>
                        <tr>
                          <th>Gate Pass No.</th>
                          <th>Quantity</th>
                          <th>Size (Meter)</th>
                          <th>Report Document</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>					  
                        <tr>
                          <td><input type="number" name="gate_pass_no[]" id="gate_pass_no" value="<?=$dataWI['GatePass']->id;?>"></td>
                          <td>1</td>
                          <td><input type="number" min="0" name="quan_size[]" id="quan_size" value="<?=$dataWI->insp_quan_size;?>"></td>
						  <td><input type="file" name="report_document[]" id="report_document[]"></td>	
						  <?php /* ?> <td><button type="button" class="btn btn-success btn-xs" onClick="addRow()">Add Row</button> </td>	<?php */ ?>		  
                        </tr>  						               
                      </tbody>					  
                    </table>
                    <table class="table table-bordered">
                      <tbody> 
						<input type="hidden" name="insp_id" id="insp_id" value="<?=$inspId;?>">
                      <tr>
                        <td><label for="work_order_id">Work Order Number</label>
                          <input type="text" id="work_order_id"  class="form-control" required name="work_order_id" value="<?=$workOrderId;?>">
                        </td>
                        <td><label for="receiver_name">Receiver Name</label>
                          <input type="text" id="receiver_name" required class="form-control" name="receiver_name" class="form-control" value="<?=$userD->name;?>">
                          <input type="hidden" id="receiver_id"  value="<?=$userD->individual_id;?>" class="form-control" name="receiver_id">
                        </td>                        
						 <td><label>Reciving Date</label>
                          
						  <input type="text" id="receiving_date" required data-date-format="yyyy-mm-dd" value="<?=date('d-m-Y');?>" name="receiving_date" class="form-control">


                        </td>					 
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
                      </tr>
                      <tr>
                        <td><label for="process_type">Process Type</label>
                          <select name="process_type_id" id="process_type_id" required class="form-control">
						  <option value="">Select Process Type</option>
                            <?php foreach($dataPI as $rowp) { ?>
                            <option value="<?=$rowp->id;?>" <?php if($rowp->id == $ProcessTypeId) echo"selected"; ?>> <?=$rowp->process_name;?></option>
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
						
                        <td><label for="dyeing_color">Dyeing Color</label>
                          <input type="text" id="dyeing_color" class="form-control" readonly value="<?=$dataWI->dyeing_color;?>" name="dyeing_color">         
						</td>
						
                        <td><label for="coated_pvc">Coated Pvc</label>
                          <input type="text" id="coated_pvc" class="form-control" readonly value="<?=$dataWI->coated_pvc;?>" name="coated_pvc">         
						</td>
						
                        <td><label for="extra_job">Extra Job</label>
                          <input type="text" id="extra_job" class="form-control" readonly value="<?=$dataWI->extra_job;?>" name="extra_job">         
						</td>
						
                        <td><label for="print_job">Print Job</label>
                          <input type="text" id="print_job" class="form-control" readonly value="<?=$dataWI->print_job;?>" name="print_job">         
						</td>						 
                      </tr>					                   
                      </tbody>                      
                    </table>
                 					
                  </div>
                  <div class="col-md-12" id="main_div">
                    <div class="row">
                      <div class="col-xs-12">&nbsp;</div>
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
	function addRow() 
	{
		var table = document.getElementById("myTable");
		var newRow = table.insertRow(table.rows.length);
		var cell1 = newRow.insertCell(0);
		var cell2 = newRow.insertCell(1); 
		var cell3 = newRow.insertCell(2); 
		var cell4 = newRow.insertCell(3); 
		var cell5 = newRow.insertCell(4);  
		
		cell1.innerHTML = '<input type="number" min="1" id="gate_pass_no" name="gate_pass_no[]" required>';
		cell2.innerHTML = '1';
		cell3.innerHTML = '<input type="number" min="1" id="quan_size" name="quan_size[]" required>';
		cell4.innerHTML = '<input type="file" name="report_document[]" id="report_document[]">';
		cell5.innerHTML = '<button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(this)">Delete</button>';	
		
	}

	function deleteRow(button) {
		var row = button.parentNode.parentNode;
		row.parentNode.removeChild(row);
	} 
</script>

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
