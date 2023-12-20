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
              <div class="btn-group" id="buttonexport">
                <h4>Add Vehicle</h4>
              </div>
            </div>
            <div class="panel-body">
              <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
              <div class="row" style="margin-bottom:5px">
                <form action="{{ route('show-vehicles') }}" method="GET" role="search">
                  @csrf
                  <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" name="search" placeholder="Search..."
                                value="{{ request()->query('search') }}" />
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-add">Search</button>
                  </div>
                </form>
                <div class="col-sm-2 col-xs-12">
                  <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                  <ul class="dropdown-menu exp-drop" role="menu">
                    <li class="divider"></li>
                    <li> <a href="javascript:void(0);" onClick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});"> <img src="assets/dist/img/xls.png" width="24" alt="logo"> XLS</a> </li>
                  </ul>
                </div>
                <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-vehicle"> <i class="fa fa-plus"></i> Add
                  Vehicle </a> </div>
              </div>
              <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Lorry Type</th>
                      <th> Lorry Owner</th>
                      <th>Vehicle Type</th>
                      <th>Body Type</th>
                      <th>Lorry Number</th>
                      <th>Brand Name</th>
                      <th>GVW</th>
                      <th>Chasis Weight</th>
                      <th>Lorry Owner Id</th>
                      <th> Owner Name</th>
                      <th>Owner Address</th>
                      <th>Owner Phone</th>
                      <th>Pan Number</th>
                      <th>Engine Number</th>
                      <th>Chassis Number</th>
                      <th>Model Type</th>
                      <th>TDS Declare</th>
                      <th>NPNO</th>
                      <th>Policy Number</th>
                      <th>Policy Date</th>
                      <th>Valid Date</th>
                      <th>Colour</th>
                      <th>Action</th>
                      <th>Delete </th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataP as $data)
                  <tr id="Mid{{ $data->id }}">
                    <td> {{ $data->lorry_type }} </td>
                    <td> {{ $data->lorry_owner }} </td>
                    <td> {{ $data->vehicle_type }} </td>
                    <td> {{ $data->body_type }} </td>
                    <td> {{ $data->lorry_number }} </td>
                    <td> {{ $data->vehicledetail->brand_name }} </td>
                    <td> {{ $data->gvw }} </td>
                    <td> {{ $data->chasis_weight }} </td>
                    <td> {{ $data->lorryowner_id }} </td>
                    <td> {{ $data->owner_name }} </td>
                    <td> {{ $data->owner_address }} </td>
                    <td> {{ $data->owner_phone }} </td>
                    <td> {{ $data->pan_number }} </td>
                    <td> {{ $data->engine_no }} </td>
                    <td> {{ $data->chassis_no }} </td>
                    <td> {{ $data->modeltype }} </td>
                    <td> {{ $data->tds_declare }} </td>
                    <td> {{ $data->npno }} </td>
                    <td> {{ $data->policy_no }} </td>
                    <td> {{ $data->policy_date }} </td>
                    <td> {{ $data->valid_date }} </td>
                    <td> {{ $data->colour }} </td>
                    <td><a href="edit-vehicle/{{ base64_encode($data->id) }}" class="tooltip-info"><i class="fa fa-pencil"></i></a></td>
                    <td class="center"><a href="javascript:void(0);" onClick="deleteVehicle({{ $data->id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>
                  </tr>
                  @endforeach
                  <tr class="center text-center">
                    <td class="center" colspan="24"><div class="pagination">{{ $dataP->links() }}</div></td>
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
	function deleteVehicle(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteVehicle",
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
