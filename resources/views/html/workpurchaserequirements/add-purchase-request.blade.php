<?php 
	use \App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
        <!-- Form controls -->
        <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="javascript:void(0);"> <i class="fa fa-list"></i>Send Purchase Request </a> </div>
            </div>
            <div class="panel-body">
             <form method="post" action="{{ route('store_purchase_request')}}" onSubmit="return check_form();" autocomplete="off">
				@csrf
				<div class="row">				
					<div class="col-md-12" id="main_div">						 
						<div class="row">
							<div class="col-xs-12">
								<!--table part start-->
								<div class="table-responsive table-responsive-custom">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td style="width:15%;">
													<div class="input-group">
														<label for="pur_type">Type</label>
														<select class="form-control" required name="pur_type" id="pur_type">
																<option value="">Select Type</option>
															<?php foreach ($dataIT as $valIT) { ?>
																<option value="<?= $valIT->item_type_id; ?>"><?= $valIT->item_type_name; ?></option>
															<?php } ?>
														</select>
													</div>
												</td>
												<td style="width:15%;">
													<div class="input-group">
														<label for="product_name">Item Name</label>
														<input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product Name">
														<input type="hidden" id="pro_id" name="pro_id">
													</div>
												</td>
												<td style="width:15%;">
													<div class="input-group">
														<label for="hsn">HSN/SAC</label>
														<input type="text" id="hsn" name="hsn" class="form-control" placeholder="HSN/SCN" value="">
													</div>
												</td>
												<td style="width:15%;">
													<div class="input-group">
														<label for="qty">Quantity</label>
														<input type="text" id="qty" name="qty" class="form-control" placeholder="Quantity" value="">
													</div>
												</td>
												<td style="width:15%;">
													<div class="input-group">
														<label for="unit">Unit </label>
														<select id="unit" name="unit" class="form-control" onchange="changeUnit();">
														<option value="">Select Type</option>
															<?php foreach ($dataUT as $utVal) { ?>
																<option value="<?= $utVal->unit_type_id; ?>"><?= $utVal->unit_type_name; ?></option>
															<?php } ?>
														</select>
													</div>
												</td>
												<td style="width:15%;" id="meterId">
													<div class="input-group">
														<label for="meter">Meter</label>
														<input type="text" id="meter" name="meter" class="form-control" value="0">
													</div>
												</td>
												<td style="width:10%;">
													<div class="input-group">
														<label for="remarks">Remark</label>
														<input type="text" id="remarks" class="form-control" name="remarks" value="">
													</div>
												</td>
												<td style="width:30px;">
													<button type="button" id="Add_To_Purchase" class="btn btn-primary">+</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<!--table part end-->
							</div>
						</div>
						<div class="form-group">
							<div class="box-body">
								<table id="example2" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="width:100px;">Type</th>
											<th style="width:100px;">Item Name</th>
											<th style="width:100px;">HSN/SAC</th>
											<th style="width:100px;">Qty</th>
											<th style="width:100px;">Unit</th>
											<th style="width:100px;">Meter</th>
											<th style="width:100px;">Remarks</th>
											<th style="width:30px;">Action</th>
										</tr>
									</thead>
									<tbody id="tbody" style="max-height: 200px;overflow-y: auto;overflow-x: hidden;">
									</tbody>
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<button type="button" class="btn btn-danger" id="confirmBtn" style="display:none"><i class="fa fa-times"></i> Discard</button>
						<button type="submit" class="btn btn-primary pull-left" id="resetBtn" style="display:none">Confirm</button>
					</div>
				</div>
			</form>

			</div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('common.footer') </div>
@include('common.formfooterscript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
<script type="text/javascript">
$("#meterId").hide();			
	function changeUnit()
	{  
		var unit  = $('#unit').val(); 
		if(unit =='4')
		{
			$("#meterId").hide();			
		} 
		else 
		{
			$("#meterId").show();
		}	 
	}
</script>
 
<script type="text/javascript">
function check_form() 
{
    if (!$('#cust_type_raw').is(':checked')) {
        if ($('#individual_id').val() == "") {
            alert("Please select a vendor.");
            $('#cus_name').focus();
            return false;
        }
    }
    if (parseInt($('#count_product').val()) === 0) {
        alert("Please add a product to the purchase list.");
        $('#product_name').focus();
        return false;
    } else {
        return true;
    }
}
</script>
 

<script type="text/javascript">
$(function() {
    var siteUrl = "{{ url('/') }}";

    $("#product_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: siteUrl + '/list_item_type',
                dataType: "json",
                data: {
                    term: request.term,
                    type: $('#pur_type').val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 3,
        focus: function(event, ui) {
            $("#product_name").val(ui.item.item_name);
            return false;
        },
        select: function(event, ui) {
            $("#pro_id").val(ui.item.item_id);
            $("#product_name").val(ui.item.item_name);
            $("#hsn").val(ui.item.hsncode);
            return false;
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        var purType = $('#pur_type').val();
        console.log(purType);
        return $("<li>")
            .append("<div>" + item.item_name + "<br> Item Code: " + item.item_code + "<br> Internal Name:" + item.internal_item_name + " </div>")
            .appendTo(ul);
    };
});
</script>
    

 

 <script type="text/javascript">
$('#Add_To_Purchase').click(function() {
    if ($('#product_name').val() !== '') {
        $("#resetBtn, #confirmBtn").show();
        $('#example2').show();

        if ($('#product_name').val() !== '') {
            var count_product = parseInt($('#count_product').val()) + 1;

            var new_pro = "<tr id='tr_" + count_product + "'>" +
			 "<td><input readonly value='" + $('#pur_type').val() + "' type='text' class='form-control' name='pur_type_arr[]'></td>" +
                "<td><input value='" + $('#pro_id').val() + "' type='hidden' name='pro_id_arr[]' readonly><input readonly value='" + $('#product_name').val() + "' type='text' class='form-control' name='product_name_arr[]'></td>" +
				"<td><input readonly value='"+$('#hsn').val()+"' type='text' class='form-control' name='hsn_arr[]'></td>"+		
                "<td><input readonly value='"+$('#qty').val()+"' type='text' class='form-control' name='qty_arr[]'></td>"+
                "<td><input readonly value='" + $('#unit').val() + "' type='text' class='form-control' name='unit_arr[]'></td>" +
                "<td><input readonly value='" + $('#meter').val() + "' type='text' class='form-control' name='meter_arr[]'></td>" +
                "<td><input readonly value='" + $('#remarks').val() + "' type='text' class='form-control' name='remarks_arr[]'></td>" +
                "<td><a data-toggle='tooltip' href='javascript:void(0);' onclick='removeRows(\"tr_" + count_product + "\");' title='Remove'><span class='glyphicon glyphicon-remove-circle remove' data-trid='tr_" + count_product + "' ></span></a></td>" +
                "</tr>";

            $('#tbody').append(new_pro);
            $('#count_product').val(count_product);
            $('#product_name').val('');
            $('#qty, #pcs, #cut, #meter').val('0');
   
            $('#pro_id').val('0');
            $('#hsn, #taxrs, #remarks').val('');
            $('#grey_quality, #dyeing_color, #coated_pvc, #print_job, #extra_job').val('');
            $('#product_name').focus();
        } else {
            alert("Please Check Discount/Quantity/Tax/Net Price");
            $('#product_name').focus();
        }
    } else {
        $('#product_name').focus();
    }
});
</script>

<script>
function removeRows(rowId) {
    $("#" + rowId).remove();
}
</script>

  
</body>
</html>
