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
                <h4>User Web Pages List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
                <div class="row" style="margin-bottom:5px"> 
                <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-userwebpage"> <i class="fa fa-plus"></i> Add User Web Pages </a> </div>
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
						<th>User</th>          
						<th style="width:70%">Page</th>  
						<th class="hidden-480">Status</th>
						<th>Action</th>
						<th class="center">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataI as $data)
					<?php 
						$id =  base64_encode($data->id);
						$userId = $data->user_id;
						$pagename = CommonController::getAllPagesName($userId);
						if($data->status =='1') $status = 'Active';
						else if($data->status =='2') $status = 'InActive';
						else if($data->status =='3') $status = 'Deleted';
						
						
						
					?>
                  <tr id="Mid{{ $data->id }}">
                    <td> {!! CommonController::getUserName($userId) !!} </td>
                    <td> {{ $pagename }} </td>
                    <td> {{ $status }} </td>
                    
                    <td>
					<a href="edit-userwebpage/{{ $id }}" class="tooltip-info"><i class="fa fa-pencil"></i></a> &nbsp; 
					 
					</td>
					
                    <td class="center"><a href="javascript:void(0);" onClick="deleteUserWebPage({{ $userId }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>
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
	function deleteUserWebPage(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteUserWebPage",
				data: {
					"_token": "{{ csrf_token() }}",
					"userId":id,
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
