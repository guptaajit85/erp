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
                <h4>Individual List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form action="{{ route('show-individuals') }}" method="GET" role="search">
                  @csrf
                  <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="<?=$qsearch;?>" placeholder="Search by Name, Email, Company Name, GSTIN, Nick Name, ">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <select class="form-control" name="ind_type" id="ind_type">
                      <option value="all">All</option>
                      <option value="customers">Customers</option>
                      <option value="master">Master</option>
                      <option value="agents">Agents</option>
                      <option value="labourer">Labourer</option>
                      <option value="vendors">Vendors</option>
                      <option value="transport">Transport</option>
                    </select>
                  </div>
                  <div class="col-sm-2 col-xs-12">
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
                <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-individual"> <i class="fa fa-plus"></i> Add Individual </a> </div>
              </div>
              <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Phone</th>
                      <th>Company Name</th>
                      <th>GSTN</th>
                      <th>TAN</th>
                      <th>PAN</th>
                      <th>Adhaar</th>
                      <th>WhatsApp</th>
                      <th>Action</th>
                      <th>Delete </th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataI as $data)
				<?php  $id =  base64_encode($data->id); ?>
                  <tr id="Mid{{ $data->id }}">
                    <td> {{ $data->name }} </td>
                    <td> {{ $data->email }} </td>
                    <td> {{ $data->type }} </td>
                    <td> {{ $data->phone }} </td>
                    <td> {{ $data->company_name }} </td>
                    <td> {{ $data->gstin }} </td>
                    <td> {{ $data->tanno }} </td>
                    <td> {{ $data->pan }} </td>
                    <td> {{ $data->adhar }} </td>
                    <td> {{ $data->whatsapp }} </td>
                    <td><a href="edit-individual/{{ $id }}" class="tooltip-info"><i class="fa fa-pencil"></i></a> &nbsp; <a href="{{ route('show-persons', $id) }}" title="View Person" class="tooltip-info"><i class="glyphicon glyphicon-user"></i></a> </td>
                    <td class="center"><a href="javascript:void(0);" onClick="deleteIndividual({{ $data->id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>
                  </tr>
                  @endforeach
                  <tr class="center text-center">
                    <td class="center" colspan="12"><div class="pagination"> {{ $dataI->links('vendor.pagination.bootstrap-4')}} </div></td>
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
	function deleteIndividual(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteIndividual",
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
