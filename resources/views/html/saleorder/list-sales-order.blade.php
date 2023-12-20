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
	
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Sale Order List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form method="GET" role="search">
                  @csrf
                  <div class="col-sm-2 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="" placeholder="Search by Customer Name etc.. ">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <input type="date" data-date-format="DD MMMM YYYY" class="form-control" name="from_date" placeholder="From Date" value="">
                  </div>
                  <div class="col-sm-2 col-xs-12">
                    <input type="date" data-date-format="DD MMMM YYYY" class="form-control" name="to_date" placeholder="To Date" value="">
                  </div>
                  <div class="col-sm-1 col-xs-12">
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
               <!-- <div class="col-sm-2 col-xs-12"><a class="btn btn-add" href="jvascript:void(0);"> <i class="fa fa-plus"></i> Add Sale Order</a></div>-->
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>Order Number</th>
                      <th>Sale Order Priority</th>
                      
                      <th>Sale Order Date </th>
                      <th>Customer Name </th>
                      
                      <th>Action</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($dataP as $data)
				  
				  <?php 
				   // echo "<pre>"; print_r($data['SaleOrderItem']); 
				  //  echo "<pre>"; print_r($data['WorkOrder']->count());  // exit;
				   
				   // $totordItem = $data['SaleOrderItem']->count();
				   // $totusedItem = $data['WorkOrder']->count();
				  // $totBal = $totordItem-$totusedItem;
				   
				  ?>
                  <tr id="Mid{{ $data->sale_order_id }}">
                    <td> <center> {{ $data->sale_order_id }} </center> </td>
                    <td> {{ $data->order_priority }}  <!---- {{ $data->sale_order_id }} ----></td>
                     
                    <td> <?=date('F jS, Y',strtotime($data->sale_order_date));?>  </td>
                    <td> {{ $data['Individual']->name }} </td>
                   
					<td>
					
					<a target="_blank" href="{{ route('print-saleorder', base64_encode($data->sale_order_id)) }}" title="Print sales order" class="tooltip-info">
						<label class="label bg-green"><i class="fa fa-print" aria-hidden="true"></i></label>
					</a> 
					
					
					<?php /* if(!empty($totBal)) { ?>
						<a href="start-workorder/{{ base64_encode($data->sale_order_id) }}" class="btn btn-xs btn-success">Create Work Order</a> 
					<p>	  <?=$totBal; ?> item is pending to create the work order. </p>
					<?php } else if(empty($totBal)) { ?>
						<p> <?=$totBal; ?> All items have been sent to create the work order.</p>
					<?php } */ ?>
					
					</td>
                  

				 <!-- <td class="center"><a href="javascript:void(0);" onClick="deleteSaleOrder({{ $data->sale_order_id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> </td>-->
                  </tr>
                  @endforeach
                   <tr class="center text-center">
                    <td class="center" colspan="6"><div class="pagination">{{ $dataP->links('vendor.pagination.bootstrap-4')}} </div></td>
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
	function deleteSaleOrder(id) 
	{	
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET", 
				url: siteUrl + '/' +"ajax_script/deleteSaleOrder",
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
