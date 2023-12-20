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
                <h4>All Pages List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
                <div class="row" style="margin-bottom:5px"> 
                <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-allpage"> <i class="fa fa-plus"></i> Add Page </a> </div>
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Title</th>
                      <th>Name</th>
                      
                      <th>Action</th>
                      <th>Delete </th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataI as $data)
					<?php 
						$id =  base64_encode($data->id);
					?>
                  <tr id="Mid{{ $data->id }}">
                    <td> {{ $data->page_title }} </td>
                    <td> {{ $data->page_name }} </td>
                    
                    <td>
					<a href="edit-allpage/{{ $id }}" class="tooltip-info"><i class="fa fa-pencil"></i></a> &nbsp; 
					 
					</td>
					
                    <td class="center"><a href="javascript:void(0);" onClick="deleteAllPage({{ $data->id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>
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
	function deleteAllPage(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteAllPage",
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
