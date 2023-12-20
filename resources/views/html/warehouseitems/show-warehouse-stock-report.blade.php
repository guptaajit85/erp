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
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Warehouse Stock Report List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form action="{{ route('show-warehouse-stock-report') }}" method="GET" role="search">
                  @csrf
                  <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="{{ $qsearch }}" placeholder="Search by Item Name">
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
                      <th>Purchase Number</th>
                      <th>Warehouse Name</th>
                      <th>Warehouse Compartment</th>
					  <th>Item Name</th>
                      <th>Item Type</th>                      
                      <th>Quantity</th>
                      <th>Reciving Date</th>
                    </tr>
                  </thead>
                  <tbody>                  
                  @foreach($dataWI as $data)
					<?php 
				   //  echo "<pre>"; print_r($data); 
					$id =  base64_encode($data->id);
					$unitTypeId = $data->unit_type_id;
					if($unitTypeId =='4') $unitType = 'Kg';
					else  $unitType = 'Meter';
					?>
                  <tr id="Mid{{ $data->id }}">
                    <td> {{ $data['Purchase']->purchase_number }} </td>
                    <td> {{ $data['Warehouse']->warehouse_name }} </td>
                    <td> {{ $data['WarehouseCompartment']->warehousename }} </td>
					<td> {{ $data->pur_item_name }} </td>
					<td> {{ CommonController::getItemType($data->item_type_id) }} </td>
					<td> {{ round($data->item_qty) }}  {{ $unitType }}</td>
					<td> {{ date('F jS, Y',strtotime($data->receive_date)) }} </td>                    
                  </tr>
                  @endforeach
                  <tr class="center text-center">
                    <td class="center" colspan="8"><div class="pagination"> {{ $dataWI->links('vendor.pagination.bootstrap-4')}} </div></td>
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
</body>
</html>
