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
      <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="btn-group" id="buttonexport">
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
                    <option value="">Filter</option>
                    <option value="customers" @if($ind_type =='customers') selected="selected" @endif;>Customers</option>
                    <option value="master" @if($ind_type =='master') selected="selected" @endif;>Master</option>
                    <option value="agents" @if($ind_type =='agents') selected="selected" @endif;>Agents</option>
                    <option value="labourer" @if($ind_type =='labourer') selected="selected" @endif;>Labourer</option>
                    <option value="vendors" @if($ind_type =='vendors') selected="selected" @endif;>Vendors</option>
                    <option value="transport" @if($ind_type =='transport') selected="selected" @endif;>Transport</option>
                    <option value="employee" @if($ind_type =='employee') selected="selected" @endif;>Employee</option>
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
					<th style="text-align: center;">Name</th>
					<th style="text-align: center;">Email</th>
					<th style="text-align: center;">Type</th>
					<th style="text-align: center;">Phone</th>
				<!---	<th style="text-align: center;">Company Name</th> ----->
					<th style="text-align: center;">GSTN</th>
					<th style="text-align: center;">WhatsApp</th>
					<th style="text-align: center;">Action</th>
				</tr>
              </thead>
              <tbody>
              
              @foreach($dataI as $data)
              <?php 
				$id =  base64_encode($data->id); 
			  // echo "<pre>"; print_r($data['User']);// exit;
			  ?>
              <tr id="Mid{{ $data->id }}">
                <td> {{ $data->name }} </td>
                <td> {{ $data->email }} </td>
                <td> {{ $data->type }} </td>
                <td> {{ $data->phone }} </td>
           <!-----     <td> {{ $data->company_name }} </td> ------>
                <td> {{ $data->gstin }} </td>               
                <td> {{ $data->whatsapp }} </td>
				<td>
				
				<a href="edit-individual/{{ $id }}" class="tooltip-info" title="Edit indivisual"><i class="fa fa-pencil"></i></a> &nbsp; 
				
				<?php if($data->type != 'employee') { 	?>
				<a href="{{ route('show-persons', $id) }}" title="View Person" class="tooltip-info"><i class="glyphicon glyphicon-user"></i></a>				
				<?php } ?>
				
				<?php /* if(empty($data['User']->id)) { ?>
				<a href="{{ route('add-user', $id) }}" title="Create User " class="tooltip-info"><i class="fa fa-user-plus" aria-hidden="true" style='font-size:17px'></i></a>&nbsp; 
				<?php } else if(!empty($data['User']->id)) { ?>

				<a href="{{ route('edit-user', base64_encode($data['User']->id)) }}" title="Edit User " class="tooltip-info"><i class="fa fa-pencil"></i></a> &nbsp; 
				
				<?php } */ ?>
				
				
				<?php 
				if($data->type == 'employee') { 				
					$userId = $data['User']->id;				
					$chk = CommonController::getUserWebPage($userId);				
				?>				
					<?php if($chk) { ?>
						<a href="{{ route('edit-userwebpage', base64_encode($userId)) }}" title="Update Page Permission" class="tooltip-info"><i class="fa fa-lock" aria-hidden="true" style='font-size:20px'></i></a>
					<?php } else { ?>
						<a href="{{ route('indadd-userwebpage', base64_encode($userId)) }}" title="Add Page Permission" class="tooltip-info"><i class="fa fa-lock" aria-hidden="true" style='font-size:20px'></i></a>					
					<?php } ?>
				
				<?php } ?>
				<?php if($data->type == 'customers') { ?>

				<a href="list-sales-order/{{ $id }}" title="Sale Order List"><i class="fa fa-list" aria-hidden="true" style='font-size:20px'></i>SO</a>&nbsp; 				
				<a href="list-sales-entry/{{ $id }}" title="Sale Entry List"><i class="fa fa-list" aria-hidden="true" style='font-size:20px'></i>SE</a>&nbsp; 				
				<a href="show-customers/{{ $id }}" title="View Customers Details"><i class="fa fa-user-circle-o" aria-hidden="true" style='font-size:20px'></i> </a>&nbsp; 			

				<?php } else if($data->type == 'master') { ?> 
				<a href="show-masters/{{ $id }}" title="View Master Details"><i class="fa fa-user-circle-o" aria-hidden="true" style='font-size:20px'></i></a>&nbsp; 			
				
				<?php } else if($data->type == 'agents') { ?> 
				<a href="show-agents/{{ $id }}" title="View Agent Details"><i class="fa fa-user-circle-o" aria-hidden="true" style='font-size:20px'></i></a>&nbsp; 				
				
				<?php } else if($data->type == 'transport') { ?> 
				<a href="show-transports/{{ $id }}" title="View Transport Details"><i class="fa fa-user-circle-o" aria-hidden="true" style='font-size:20px'></i></a>&nbsp; 				
				
				<?php } else if($data->type == 'labourer') { ?> 
				<a href="show-labourers/{{ $id }}" title="View Labourer Details"><i class="fa fa-user-circle-o" aria-hidden="true" style='font-size:20px'></i></a>&nbsp;			
				
				<?php } else if($data->type == 'vendors') { ?>

				<a href="list-purchage-order/{{ $id }}" title="Purchage Order List"><i class="fa fa-file-powerpoint-o" aria-hidden="true" style='font-size:20px'></i></a> &nbsp;				 
				<a href="list-purchage-entry/{{ $id }}" title="Purchage Entry List"><i class="fa fa-shopping-cart" aria-hidden="true" style='font-size:20px'></i></a> &nbsp; 			 
				<a href="show-vendors/{{ $id }}" title="View Vendor Details"><i class="fa fa-user-circle-o" aria-hidden="true" style='font-size:20px'></i></a>&nbsp; 
				
				<?php } ?>	
				
				<a href="show-individual-member-addresses/{{ $id }}" title="View Address Details"><i class="fa fa-truck" aria-hidden="true" style='font-size:20px'></i></a>
				
				&nbsp; <a title="Delete" href="javascript:void(0);" onClick="deleteIndividual({{ $data->id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
				
				</td>
              
             
              </tr>
              @endforeach              
			  
			   <tr class="center text-center">
				<td class="center" colspan="10"> 
					 <div class="pagination"> 
					<span class="pagination-links">
						{{ $dataI->appends(['qsearch' => $qsearch, 'item_type_id' => $item_type_id])->links('vendor.pagination.bootstrap-4') }}
					</span>
					<span class="manual-page-input">
						<label for="manualPageInput">Go to page:</label>
						<input type="number" id="manualPageInput" min="1" max="{{ $dataI->lastPage() }}" value="{{ $dataI->currentPage() }}">
						<button class="btn btn-sm btn-success" id="goToPageButton">Go</button>
					</span>
				</div>
				</td> 
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
@include('common.footer')
</div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script>
    document.getElementById('goToPageButton').addEventListener('click', function() {
        var pageInput = document.getElementById('manualPageInput').value;
        if (pageInput > 0 && pageInput <= {{ $dataI->lastPage() }}) {
            var baseUrl = window.location.href.split('?')[0];
            var params = new URLSearchParams(window.location.search);
            params.set('page', pageInput);
            window.location.href = baseUrl + '?' + params.toString();
        }
    });
</script>
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
