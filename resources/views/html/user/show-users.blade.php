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
<div class="wrapper">
@include('common.header')
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
          <h4> User</h4>
          </a> </div>
      </div>
      <div class="panel-body">
        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
        <div class="row" style="margin-bottom:5px">
          <form action="{{ route('show-users') }}" method="GET" role="search">
            @csrf
                <div class="col-sm-4 col-xs-12">
                  <input type="text" class="form-control" name="qsearch" id="qsearch" value="<?=$qsearch;?>" placeholder="Search by Name, Email, Company Name, GSTIN, Nick Name, ">
                </div>
                <div class="col-sm-2 col-xs-12">
                  <select class="form-control" name="ind_type" id="ind_type">
                    <option value="">All</option>
                    <option value="customers" @if($ind_type =='customers') selected="selected" @endif;>Customers</option>
                    <option value="master" @if($ind_type =='master') selected="selected" @endif;>Master</option>
                    <option value="agents" @if($ind_type =='agents') selected="selected" @endif;>Agents</option>
                    <option value="labourer" @if($ind_type =='labourer') selected="selected" @endif;>Labourer</option>
                    <option value="vendors" @if($ind_type =='vendors') selected="selected" @endif;>Vendors</option>
                    <option value="transport" @if($ind_type =='transport') selected="selected" @endif;>Transport</option>
                  </select>
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
        </div>
        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
        <div class="table-responsive">
          <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
            <thead>
              <tr class="info">
                <tr class="info">
					<th style="text-align: center;">Name</th>
					<th style="text-align: center;">Email</th>
					<th style="text-align: center;">Type</th>
					<th style="text-align: center;">Phone</th>
					 
					<th style="text-align: center;">GSTN</th>
					<th style="text-align: center;">WhatsApp</th>
					<th style="text-align: center;">Action</th>
				</tr>
               
              </tr>
            </thead>
            <tbody>
            
            @foreach ($dataU as $data)
            <tr id="Mid{{ $data->id }}">
			
				<td> {{ $data->name }} </td>
				<td> {{ $data->email }} </td>
				<td> {{ $data->type }} </td>
				<td> {{ $data->phone_no }} </td> 
				<td> {{ $data->gstin }} </td> 
				<td> {{ $data->whatsapp }} </td> 
				<td><a href="edit-user/{{ base64_encode($data->id) }}" class="tooltip-info"><i class="fa fa-pencil"></i></a></td>

            </tr>
            @endforeach
            <tr class="center text-center">
              <td class="center" colspan="10"><div class="pagination">{{ $dataU->links() }}</div></td>
            </tr>
            </tbody>
            
          </table>
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
</body>
</html>
