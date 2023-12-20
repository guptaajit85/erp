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
  <div class="content-wrapper"> 
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Transport List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form method="GET" role="search">
                  @csrf
                  <div class="col-sm-4 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="<?=$qsearch;?>" placeholder="Search by Name">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                  </div>
                </form>
                <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="{{ route('add-transport', base64_encode($dataI->id)) }}"> <i class="fa fa-plus"></i> Add Transport </a> </div>
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Company Name </th>
                      <th>Transport From</th>
                      <th>Transport To</th>
                      <th>Action</th>
                      <th>Delete </th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataP as $data)
                  <tr id="Mid{{ $data->id }}">
                    <td> {{ $dataI->company_name }} </td>
                    <td> {{ $data->transport_from }} </td>
                    <td> {{ $data->transport_to }} </td>
                    <td><a href="{{ route('edit-transport', base64_encode($data->id)) }}" class="tooltip-info"><i class="fa fa-pencil"></i></a></td>
                    <td class="center"><a href="javascript:void(0);" onClick="deleteTransport({{ $data->id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>
                  </tr>
                  @endforeach
                  <tr class="center text-center">
                    <td colspan="7">{{ $dataP->links('vendor.pagination.bootstrap-4') }}</td>
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
	function deleteTransport(id) 
	{	
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET", 
				url: siteUrl + '/' +"ajax_script/deleteTransport",
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
