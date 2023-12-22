<?php
use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
<style>
.address-container {
    display: flex;
    flex-direction: column;
}

.address-label {
    font-weight: bold;
    margin-bottom: 5px;
}

.address-value {
    margin-bottom: 15px;
}
</style>

</head>
<body class="hold-transition sidebar-mini">
 
<!-- Site wrapper -->
<div class="wrapper">
@include('common.header')
<div class="content-wrapperd"> 
{!! CommonController::display_message('message') !!}
<section class="content">
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-bd lobidrag">
      <div class="panel-heading">
        <div class="btn-group" id="buttonexport">
          <h4> Packaging</h4>
          </a> </div>
      </div>
      <div class="panel-body">
      
        <div class="row" style="margin-bottom:5px">
          <form action="{{ route('show-packagings') }}" method="GET" role="search">
            @csrf
            <div class="col-sm-4 col-xs-12">
              <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->query('search') }}" />
            </div>
            <div class="col-sm-2 col-xs-12">
              <button class="btn btn-add">Search</button>
            </div>
          </form>          
          <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-packaging"> <i class="fa fa-plus"></i> Add Packaging </a> </div>
        </div>
         
        <div class="table-responsive">
			<table id="dataTableExample1" class="table table-bordered table-striped table-hover">
			   <thead>
				  <tr class="info">
					 <th>Packing Id </th>
					 <th>Customer Name </th>
					 <th>Shipping Address </th>
					 <th>Billing Address</th>
					 <th>Action </th>
				  </tr>
			   </thead>
			   <tbody>
				  <?php 
					 foreach ($dataP as $data) 
					 {  			
						$customerName 	 	= $data['Individual']->name;
						$shiping_address 	= $data->shiping_address;
						$billing_address 	= $data->billing_address;
						$isInvGenerated 	= $data->is_invoice_generated;	
						$poId 				= $data->id;				
					 ?>
				  <tr>
					 <td> <?=(1000+$data->id);?> </td>
					 <td> <?=$customerName;?> </td>
					 <td>
						<div class="address-container">
						    
						   <div class="address-value">{{ $data->shiping_address }}</div>
						   
						</div>
					 </td>	
					 <td>
						<div class="address-container">
						   
						 
						   <div class="address-value">{{ $data->billing_address }}</div>
						</div>
					 </td>
					  
					 
					 <td>   

					<?php if($isInvGenerated == 'No') { ?> 				 
					<form method="post" action="{{ route('genrate_package_invoice') }}" class="form-horizontal">
						@csrf
						<input type="hidden" name="package_order_id" id="package_order_id" value="<?=$poId;?>">
						<div class="modal-footer">
							<button type="submit" class="btn btn-success pull-left">Genrate Invoice</button>
						</div>
					</form>					 
					<?php } else {  ?>
					
					<p> <a target="_blank" href="print-saleentry/{{ base64_encode($data->sale_entry_id) }}" class="tooltip-info">
                      <label class="label bg-green"><i class="fa fa-print" aria-hidden="true"></i> Invoice Generated</label>
                      </a> 
					  </p>
					<p>  <a target="_blank" href="print-package-items/{{ base64_encode($data->id) }}" class="tooltip-info">
                      <label class="label bg-green"><i class="fa fa-print" aria-hidden="true"></i> Print Package Items</label>
                      </a> 
					   </p>
					 
					<?php } ?>
					 
					 </td>
				  </tr>
				  <?php } ?>
				  <tr class="center text-center">
					 <td class="center" colspan="5">
						<div class="pagination">{{ $dataP->links() }}</div>
					 </td>
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
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript">
var siteUrl = "{{url('/')}}";
        
</script>
</body>
</html>
