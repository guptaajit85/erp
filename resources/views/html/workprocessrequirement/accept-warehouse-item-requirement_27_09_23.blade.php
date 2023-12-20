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
	  {!! CommonController::display_message('message') !!}
        <div class="col-sm-6">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"><h4><i class="fa fa-plus m-r-5"></i> Stock Allotment</h4></div>
            </div>
            <div class="panel-body"> 
              <div class="table-responsive">
			   <form method="post" action="{{ route('StoreWarehouseStockAllotment')}}" class="form-horizontal" autocomplete="off">
				@csrf
                 <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item Name</th>
                      <th>{{ $result['ItemName'] }}</th> 
                    </tr>
                  </thead>
				 <tbody>
					<tr>
						<td>{{ $result['itemTypeName'] }}</td>
						<td><input type="text" id="allot_quantity" name="allot_quantity" value="{{ $result['quanTity'] }}" class="form-control"></td> 
					</tr>
					<tr>
						<td>Remark Comment</td>
						<td><input type="text" name="allotment_remark" id="allotment_remark" required class="form-control"></td>
					</tr> 
					<input type="hidden" name="work_process_req_id" id="work_process_req_id" value="<?=$result['work_process_req_id'];?>" class="form-control"> 
					<input type="hidden" name="work_order_id" id="work_order_id" value="<?=$result['workOrdId'];?>" class="form-control"> 
				  </tbody>
				</table>
				<table class="table table-bordered">
				 <tbody> 
					<?php foreach($dataWIS as $row) {  ?>
					<tr>
						<td> 1
							<input type="checkbox" id="used_item[]" name="used_item[]" value="1" checked> &nbsp;  Receiving Date : <span> <?=$row->receive_date;?></span>  
							<input type="hidden" name="wis_id[]" id="wis_id[]" value="<?=$row->wis_id;?>" class="form-control">
							<input type="hidden" name="warehouse_item_id[]" id="warehouse_item_id[]" value="<?=$row->warehouse_item_id;?>" class="form-control"> 
						</td> 
					</tr>
					<?php } ?> 
				  </tbody> 
                 </table>
				  <button type="submit" class="btn btn-success pull-left">Update</button>
				</form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 
@include('common.footer') 
</div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
 
</body>
</html>
