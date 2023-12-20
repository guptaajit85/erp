<?php
	use \App\Http\Controllers\CommonController;
?>
<!DOCTYPE html> 
<html lang="en">
<head>@include('common.head') </head>
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
        <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                <h4>Item List</h4>
                </a> </div>
            </div>
            <div class="panel-body">
              <div class="row" style="margin-bottom:5px">
                <form action="{{ route('show-items') }}" method="GET" role="search">
                  @csrf
                  <div class="col-sm-3 col-xs-12">
                    <input type="text" class="form-control" name="qsearch" id="qsearch" value="<?=$qsearch;?>" placeholder="Search by Name, Item Code, Internal Name etc.. ">
                  </div>
                  <div class="col-sm-2 col-xs-12">
					<select class="form-control" name="item_type_id" id="item_type_id">
						<option value=""> Select Item Type</option>
						@foreach($dataIT as $dataV)
							<option value="{{ $dataV->item_type_id  }}" @if($dataV->item_type_id == $item_type_id) selected="selected" @endif; > {{ $dataV->item_type_name }} </option>
						@endforeach
					</select>
                  </div>
				  <?php /* ?>
                  <div class="col-sm-2 col-xs-12">
					<select class="form-control" name="unit_type_id" id="unit_type_id">
						<option value=""> Select Unit Type</option>
						@foreach($dataUT as $dataU)
							<option value="{{ $dataU->unit_type_id  }}" @if($dataU->unit_type_id == $unit_type_id) selected="selected" @endif; > {{ $dataU->unit_type_name }}</option>
						@endforeach
					</select>
                  </div>
				  <?php */ ?>
				  
				  
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
				  
				  <!---  <a href="{{ route('item.export-items') }}" class="btn btn-primary"> Export Data </a>--->
					
                </div>
                <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-item"> <i class="fa fa-plus"></i> Add Item </a> </div>
              </div>
              <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
						<th>Item Name</th>
						<th>Item Code</th>
						<th>Internal Name</th>
						<th>Unit Price</th>
						<th>HSN CODE</th>
						<th>Item Type</th>
						<th>Unit Type</th>
						<th>Total Stock</th>
						<th>Purchase Rate</th>
						<th>Sale Rate</th> 
						<th>Manage</th>
						<th>Action</th>                      
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($dataI as $data)
					<?php
						$itemId 		= $data->item_id;
						$itemTypeId 	= $data->item_type_id;	
						$stockItem 		= CommonController::getTotalAvalableStockItem($itemId,$itemTypeId);
					?>

                  <tr id="Mid{{ $data->item_id }}">
                    <td> {{ $data->item_name }}    </td>
                    <td> {{ $data->item_code }} </td>
                    <td> {{ $data->internal_item_name }} </td>
                    <td> {{ $data->unit_price }} </td>
                    <td> {{ $data->hsncode }} </td>
                    <td> {{ CommonController::getItemTypeName($data->item_type_id) }} </td>
                    <td> {{ CommonController::getUnitTypeName($data->unit_type_id) }} </td>
					<td> {{ $stockItem }} </td>
                    <td> {{ $data->pur_rate }} </td>
                    <td> {{ $data->sale_rate }} </td>   
                    <td>
                        @if($data->item_type_id == '8')
                        <a href="manage-yarn/{{ base64_encode($data->item_id) }}" class="btn btn-add">Manage Yarn</a>
                        @else <span>N/A</span>
						@endif
                    </td>
                    <td class="center"> 
						<a href="edit-item/{{ base64_encode($data->item_id) }}" class="tooltip-info"><i class="fa fa-pencil"></i></a> &nbsp;
						<a href="javascript:void(0);" onClick="deleteItem({{ $data->item_id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> 
					</td>
                  </tr>
                  @endforeach
				  
                  <tr class="center text-center">
                    <td class="center" colspan="14"> 
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
  @include('common.footer') </div>
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
	function deleteItem(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteItem",
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
