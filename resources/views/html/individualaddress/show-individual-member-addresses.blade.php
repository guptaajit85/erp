<?php
	use App\Http\Controllers\CommonController; 
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
{!! CommonController::display_message('message') !!}
<div id="response-message" class="alert alert-info" style="display: none;"></div>
<section class="content">
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-bd lobidrag">
      <div class="panel-heading">
        <div class="btn-group" id="buttonexport">
          <h4> Individual Address</h4>
          </a> </div>
      </div>
      <div class="panel-body">
        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
        <div class="row" style="margin-bottom:5px">
          <form action="{{ route('show-individualaddresses') }}" method="GET" role="search">
            @csrf
            <div class="col-sm-4 col-xs-12">
              <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->query('search') }}" />
            </div>
            <div class="col-sm-2 col-xs-12">
              <select class="form-control" name="ind_type" id="ind_type">
                <option value="none" selected disabled hidden>Select an Option</option>
                <option value="s" @if($ind_type =='s') selected="selected" @endif; >Shipping</option> 
                <option value="b"@if($ind_type =='b') selected="selected" @endif;> Billing</option>
              </select>
            </div>
            <div class="col-sm-1 col-xs-12">
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
          <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="{{ route('add-individual-member-address', base64_encode($indID)) }}"> <i class="fa fa-plus"></i> Add Individual Address </a> </div>
        </div>
        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
        <div class="table-responsive">
          <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
            <thead>
              <tr class="info">
                <th> Individual Name </th>
                <th> Address Type </th>
                <th> Address 1 </th>
                <th> Address 2 </th>
                <th> State Name </th>
                <th> City </th>
                <th> Zip Code </th>
                <th> Default </th>
                <th> Action</th>
                <th> Delete </th>
              </tr>
            </thead>
            <tbody>
            
            @foreach ($dataP as $data)
			<?php 
			$default = $data->default_address;
			
			?>
            <tr id="Mid{{ $data->ind_add_id}}">
              <td> {{ $data->indidetail->name }}    <?=$data->ind_add_id;?></td>
              @if($data->address_type=='s')
              <td> Shipping </td>
              @else($data->address_type=='b')
              <td>Billing</td>
              @endif
              <td> {{ $data->address_1 }} </td>
              <td> {{ $data->address_2 }} </td>
              <td> {{ $data->statedetail->name }} </td>
              <td> {{ $data->city }} </td>
              <td> {{ $data->zip_code }} </td>
			  
              <td> 
			  <?php if($default =='1')  {?>
			  <span id="Msgid{{ $data->ind_add_id}}"><a href="javascript:void(0);"  class="btn btn-success btn-xs"> Default</a> </span>
			  <?php } else { ?> 
			  <a href="javascript:void(0);" onclick="updateDefaultAddress({{ $data->ind_add_id }})" class="btn btn-primary btn-xs">Set as Default</a>
			  <?php } ?>
			  </td>
			  
			  <td><a href="{{ route('edit-individual-member-address', base64_encode($data->ind_add_id)) }}" class="tooltip-info"><i class="fa fa-pencil"></i></a></td>
			  
              <td class="center">
				<a href="javascript:void(0);" onclick="deleteIndividualAddress({{ $data->ind_add_id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> 
			  </td>
            </tr>
            @endforeach
            <tr class="center text-center">
              <td class="center" colspan="10"><div class="pagination">{{ $dataP->links() }}</div></td>
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
	var siteUrl = "{{ url('/') }}";
	function updateDefaultAddress(ind_add_id) {
		jQuery.ajax({
			type: "GET",
			url: siteUrl + '/ajax_script/updateDefaultAddress',
			data: {
				"_token": "{{ csrf_token() }}",
				"FId": ind_add_id,
			},
			cache: false,
			success: function (msg) {
				$("#Msgid" + ind_add_id).html('<a href="javascript:void(0);"  class="btn btn-success btn-xs"> Default</a>');
				$('#response-message').text(msg.message).fadeIn('slow');
				
				 setTimeout(function() {
                    window.location.reload();
                }, 1000); // 100 milliseconds = 1 seconds
			}
		});
	}
</script>




<script type="text/javascript">
var siteUrl = "{{url('/')}}";
        function deleteIndividualAddress(ind_add_id) {
            if (confirm("Do you realy want to delete this record?")) {
                jQuery.ajax({
                    type: "GET",
                    url: siteUrl + '/' +"ajax_script/deleteIndividualAddress",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "FId": ind_add_id,
                    },

                    cache: false,
                    success: function(msg) {
                        $("#Mid" + ind_add_id).hide();
                    }
                });

            }

        }
    </script>
</body>
</html>
