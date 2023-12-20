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
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
		  {!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Warehouse Items List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form action="" method="GET" role="search">
                  @csrf
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="{{ $qsearch }}" placeholder="Search Item Name">
                  </div>
                  <div class="col-sm-2 col-xs-12">
						<select class="form-control" name="item_type" id="item_type">							 
							<?php foreach($dataIT as $row) { ?>
								<option value="<?=$row->item_type_id;?>"><?=$row->item_type_name;?></option>
							<?php } ?>
						</select> 
					</div> 					
					
					<div class="col-sm-2 col-xs-12">
						<select class="form-control" name="warehouseId" id="warehouseId" onChange="selectCompartment(this.value);">
							<option value="">Please Select Warehouse</option>
							<?php foreach($dataW as $val) { ?>
								<option value="<?=$val->id;?>"><?=$val->warehouse_name;?></option>
							<?php } ?>
						</select>
						<span id="warehouseCompIdDiv"></span>
					</div> 
					
					<div class="col-sm-2 col-xs-12">
						<input type="text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="">
					</div> 
					<div class="col-sm-2 col-xs-12">
						<input type="text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="">                
					</div>   
			  
                  <div class="col-sm-2 col-xs-12">
                    <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                  </div>
                </form>
				
				
              <!---  <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add"> <i class="fa fa-plus"></i> Add Warehouse Item </a> </div> ---->
				
              </div>
              <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info"> 
                      <th>Item Name</th>
                      <th>Iternal Name</th>
                      <th>Warehouse</th>
                      <th>Compartment</th>
                      <th>R.Emp. Name</th>
                      <th>Reciving Date</th>
                      <th>Item Type</th>
                      <th>Quantity</th> 
                      
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataWI as $data)
					<?php 
						//   echo "<pre>"; print_r($data); 
						$id 		= base64_encode($data->id);
						$unitTypeId = $data->unit_type_id;
						if($unitTypeId =='4') 	$unitType = 'Kg';
						else  					$unitType = 'Meter';
						$getItemName 			= CommonController::getItemName($data->item_id);
						$getItemInternalName 	= CommonController::getItemInternalName($data->item_id);
						$ReceiverName 			= CommonController::getIndividualName($data->receiver_id);
					?>
                  <tr id="Mid{{ $data->id }}"> 
					<td> {{ $getItemName }} </td>
					<td> {{ $getItemInternalName }} </td>                    
                    <td> {{ $data['Warehouse']->warehouse_name }} </td>
                    <td> {{ $data['WarehouseCompartment']->warehousename }} </td>
                    <td> {{ $ReceiverName }} </td>
                    <td> {{ date('M jS, Y',strtotime($data->created)) }} </td>
                    <td> {{ CommonController::getItemType($data->item_type_id) }} </td>
                    <td> {{ $data->item_qty }} {{ $unitType }}</td> 
                  </tr>
                  @endforeach
                  <tr class="center text-center">
                    <td class="center" colspan="11"><div class="pagination"> {{ $dataWI->links('vendor.pagination.bootstrap-4')}} </div></td>
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

<script type="text/javascript">
var siteUrl = "{{url('/')}}";
	function deleteWarehouseItem(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteWarehouseItem",
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
function selectCompartment(Id) {
    var siteUrl = "{{ url('/') }}";

    $.ajax({
        type: "GET",
        url: siteUrl + "/ajax_script/get_warehouse_compartment",
        data: {
            "_token": "{{ csrf_token() }}",
            "Id": Id,
        },
        cache: false,
        success: function(res) {
            $("#warehouseCompIdDiv").html(res);
        }
    });
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
