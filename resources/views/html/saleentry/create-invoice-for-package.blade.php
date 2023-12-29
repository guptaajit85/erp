<?php
	use \App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>@include('common.head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper"> @include('common.header')
  <div class="content-wrapperd">
    <section class="content">
    <div class="row">
      <!-- Form controls -->
      <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="javascript:void|(0);"> <i class="fa fa-list"></i> New Sale Entry </a> </div>
          </div>
          <div class="panel-body"  >
          <form method="post" action="{{ route('genrateInvoiceForPackage')}}" onSubmit="return check_form();" autocomplete="off">
            @csrf
            <div class="row">
              <div class="col-md-12"  id="saleOrderwith">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
					<input type="hidden" name="packaging_ord_id" value="<?=$dataPO->id;?>">
					 
                      <td style="width:200px;" id="sale_order_numberId"><label for="sale_order_number">S.O Invoice Number</label>
                        <input type="text" id="sale_order_number" readonly required name="sale_order_number" value="<?=$totalRecords;?>" class="form-control">
                      </td>
					  
                      <td style="width:150px;"><label for="sale_entry_started">Sale Entry Date</label>
                        <input type="text" id="sale_entry_started" required name="sale_entry_started" class="form-control" value="<?=date('d-m-Y');?>" readonly>
                      </td>
                      <td style="width:300px;"><label for="exampleInputCategory1">Customer Name <span style="color:#ff0000;">*</span></label>
                        <input type="text" id="cus_name" name="cus_name" class="form-control" readonly placeholder="Customer Name" value="<?=$dataPO['Individual']->name;?>" required>
                        <label for="exampleInputCategory5">Name :
                        <?=$dataPO['Individual']->name;?>
                        </label>
                        <input type="hidden" id="individual_id" name="individual_id" required value="<?=$dataPO->customer_id;?>" >
                        </br>
                        <label for="exampleInputCategory1">Phone :
                        <?=$dataPO['Individual']->phone;?>
                        </label>
                        </br>
                        <input type="hidden" name="mobile" id="mobile" class="form-control" placeholder="Mobile" value="<?=$dataPO['Individual']->phone;?>">
                        <label for="exampleInputCategory1">Email : <?=$dataPO['Individual']->email;?> </label>
                        </br>
                        <input type="hidden" name="email" id="email" class="form-control" placeholder="Email" value="<?=$dataPO['Individual']->email;?>" >
                        <label for="exampleInputCategory1">GSTIN : <?=$dataPO['Individual']->gstin;?> </label>
                        <input type="hidden" name="gstin" id="gstin" class="form-control" placeholder="GSTIN" value="<?=$dataPO['Individual']->gstin;?>">
                        <input type="hidden" required name="com_state" id="com_state" value="<?=$dataIAB->state_id;?>">
                      </td>
                      <td><label for="exampleInputCategory1">Billing Address </label>
                        </br>
                        <p><?=$dataPO->billing_address;?></p>
                        <label for="exampleInputCategory1">Shipping Address </label>
                        </br>
                        <p><?=$dataPO->shiping_address;?></p>
					  </td>
					  <input type="hidden" name="billing_address" id="billing_address"  value="<?=$dataPO->billing_address;?>">
					  <input type="hidden" name="shiping_address" id="shiping_address"  value="<?=$dataPO->shiping_address;?>">
					  
                    </tr>
                  </tbody>
                </table>
               
			  
              <table id="example1" class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width:1%;">Sr</th>
                    <th style="width:10%" class="mrplabel">Quality Name</th>
                    <th style="width:5%">Unit</th>
                    <th style="width:5%">PCS</th>
                    <th style="width:5%">Cut</th>
                    <th style="width:6%">Meter</th>
                    <th style="width:7%">Rate</th>
                    <th style="width:7%">Amount</th>
                    <th style="width:6%">Dis (%)</th>
                    <th style="width:6%">Dis Amount</th>
                    <th style="width:6%">Taxable Amt</th>
                    <th style="width:4%">CGST %</th>
                    <th style="width:4%">SGST %</th>
                    <th style="width:4%">IGST %</th>
                    <th style="width:8%">Tax Amt</th>
                    <th style="width:10%">Net Amount</th>
                  </tr>
                </thead>
				
                <tbody>
					<?php 
						$totNetAmount = 0;
						$i = 1;
						foreach($dataPO['packagingOrderItems'] as $rowArr) { // echo ""; print_r($rowArr);
						$selectedIGST = $rowArr['Item']->igst;						 
						$selectedCGST = $selectedIGST/2; 
						$saleprice  = round($rowArr->amount-$rowArr->discount_amount);					 
						$igstAmount = ($selectedIGST / 100) * $saleprice;				 
						$cgstAmount = ($selectedCGST / 100) * $saleprice;
						$totNetAmount  += $saleprice+$igstAmount;
						$compItemName = $rowArr['Item']->item_name.' '.$rowArr->dyeing_color.' '.$rowArr->coated_pvc;
					?>
                  <tr id="tr_<?=$i;?>">
                    <td><?=$i;?>					
						<input type="hidden" name="packaging_ord_item_id[]" readonly="" value="<?=$rowArr->id;?>">
						<input type="hidden" name="sale_order_id[]" readonly="" value="<?=$rowArr->sale_order_id;?>">
						<input type="hidden" name="sale_order_item_id[]" readonly="" value="<?=$rowArr->sale_order_item_id;?>">
						<input type="hidden" name="pack_type_arr[]" readonly="" value="<?=$rowArr->pack_type;?>">
					</td>
                    <td><input type="hidden" name="item_id_arr[]" readonly="" value="<?=$rowArr->item_id;?>">
                      <input readonly="" value="<?=$compItemName;?>" type="text" class="form-control" name="qty_name_arr[]"></td>
                    <td><input readonly="" value="Meter" type="text" class="form-control" name="unit_arr[]"></td>
                    <td><input readonly="" value="<?=$rowArr->pcs;?>" type="text" class="form-control" name="pcs_arr[]"></td>
                    <td><input readonly="" value="<?=$rowArr->cut;?>" type="text" class="form-control" name="cut_arr[]"></td>
                    <td><input readonly="" value="<?=$rowArr->pack_meter;?>" type="text" class="form-control" name="meter_arr[]"></td>
                    <td><input value="<?=$rowArr->rate;?>" type="text" class="form-control" name="rate_arr[]"></td>
                    <td><input readonly="" value="<?=$rowArr->amount;?>" type="text" class="form-control" name="amount_wot_arr[]"></td>
                    <td><input value="<?=$rowArr->discount;?>" type="text" class="form-control" name="discount_arr[]"></td>
                    <td><input readonly="" value="<?=round($rowArr->discount_amount);?>" type="text" class="form-control" name="dis_amount_arr[]"></td>
                    <td><input readonly="" value="<?=round($rowArr->amount-$rowArr->discount_amount);?>" type="text" class="form-control" name="taxable_amount_arr[]">
                    </td>
                    <td><select readonly id="cgst_<?=$i;?>" name="cgst[]" class="form-control" style="width:75px;">                        
							@foreach($CgstAr as $key => $cval)								
                        		<option value="{{ round($cval) }}" {{ ($cval == $selectedCGST) ? 'selected' : '' }}>{{$cval}}</option>                        
							@endforeach						
                      </select>
                      <input type="hidden" id="cgstrs_<?=$i;?>" name="cgstrs[]" value="<?=$cgstAmount;?>">
                    </td>
                    <td><select readonly id="sgst_<?=$i;?>" name="sgst[]" class="form-control" style="width:75px;">                        
							@foreach($SgstAr as $key => $sval)								
                        		<option value="{{ round($sval) }}" {{ ($sval == $selectedCGST) ? 'selected' : '' }}>{{$sval}}</option>                        
							@endforeach						
                      </select>
                      <input type="hidden" id="sgstrs_<?=$i;?>" name="sgstrs[]" value="<?=$cgstAmount;?>">
                    </td>
                    <td><select readonly id="igst_<?=$i;?>" name="igst[]" class="form-control" style="width:75px;">                        
							@foreach($IgstAr as $key => $val)								
                        		<option value="{{ round($val) }}" {{ ($val == $selectedIGST) ? 'selected' : '' }}>{{$val}}</option>                        
							@endforeach						
                      </select>
                      <input type="hidden" id="igstrs_<?=$i;?>" name="igstrs[]" value="<?=$igstAmount;?>">
                    </td>
                     
					<td><input readonly="" value="<?=$igstAmount;?>" type="text" class="form-control" name="tax_amount_arr[]"></td>
                    <td><input readonly="" value="<?=($saleprice+$igstAmount);?>" type="text" class="form-control" name="net_amount_arr[]">
                    </td>
                  </tr>
                  <?php $i++;} ?>
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
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Sub Total</th>
                    <th colspan="1"><input type="number" name="subtotal" id="subtotal" min="0" value="<?=$totNetAmount;?>" step="2" class="form-control" readonly=""></th>
                    <th></th>
                  </tr>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Frieght</th>
                    <th colspan="1"><input type="number" name="frieght" id="frieght" value="0" min="0" step="2" class="form-control"></th>
                    <th>Round Off</th>
                    <th colspan="1"><input type="number" name="discount" id="discount" value="0" min="0" step="2" class="form-control"></th>
                    <th>G. Total</th>
                    <th colspan="2"><input type="number" name="total" id="total" value="<?=$totNetAmount;?>" min="0" step="2" class="form-control" readonly=""></th>
                  </tr>
                </tfoot>
              
			  </table>
              
			  
			  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
              <button type="submit" class="btn btn-primary pull-left">Confirm</button>
            
			</div>
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
@include('common.footer')
</div>
@include('common.formfooterscript')
 
<script>
  function calculateSalePrice(index) {
    var meterValue = parseFloat(document.getElementsByName("meter_arr[]")[index].value);
	var rateValue = parseFloat(document.getElementsByName("rate_arr[]")[index].value);
	var discountPercentage = parseFloat(document.getElementsByName("discount_arr[]")[index].value);
	var igstPercentage = parseFloat(document.getElementsByName("igst[]")[index].value);

	if (discountPercentage > 90) {
      alert("Discount cannot be more than 90%.");
      document.getElementsByName("discount_arr[]")[index].value = 0; // Reset discount to 0
      return;
    }

	// Calculate sale price without tax
	var salePriceWithoutTax = meterValue * rateValue;

	// Update amount_wot_arr[] field
	document.getElementsByName("amount_wot_arr[]")[index].value = salePriceWithoutTax.toFixed(2);

	// Calculate discount amount
	var discountAmount = (discountPercentage / 100) * salePriceWithoutTax;

	// Update dis_amount_arr[] field
	document.getElementsByName("dis_amount_arr[]")[index].value = discountAmount.toFixed(2);

	// Calculate sale price after discount
	var salePriceAfterDiscount = salePriceWithoutTax - discountAmount;

	// Update taxable_amount_arr[] field
	document.getElementsByName("taxable_amount_arr[]")[index].value = salePriceAfterDiscount.toFixed(2);
    // Calculate IGST amount
    var igstAmount = (igstPercentage / 100) * salePriceAfterDiscount;

    // Update tax_amount_arr[] field
    document.getElementsByName("tax_amount_arr[]")[index].value = igstAmount.toFixed(2);
    document.getElementsByName("igstrs[]")[index].value = igstAmount.toFixed(2);

    // Calculate final amount after IGST
    var finalAmount = salePriceAfterDiscount + igstAmount;

    // Update net_amount_arr[] field
    document.getElementsByName("net_amount_arr[]")[index].value = finalAmount.toFixed(2);

    // Update subtotal field by summing up all net_amount_arr[] values
    updateSubtotal();
  }

  // Function to update subtotal, total, and other related fields
  function updateSubtotal() {
    var amountFields = document.getElementsByName("net_amount_arr[]");
    var subtotal = 0;

    for (var i = 0; i < amountFields.length; i++) {
      subtotal += parseFloat(amountFields[i].value) || 0;
    }

    // Get values from frieght and discount fields
    var frieght = parseFloat(document.getElementById("frieght").value) || 0;
    var discount = parseFloat(document.getElementById("discount").value) || 0;

    // Calculate total amount
    var total = subtotal + frieght - discount;

    // Update the subtotal, total, and other related fields
    document.getElementById("subtotal").value = subtotal.toFixed(2);
    document.getElementById("total").value = total.toFixed(2);
  }

  // Attach onchange event to meter_arr[], rate_arr[], discount_arr[], igst[], frieght, and discount fields
  document.addEventListener("DOMContentLoaded", function() {
    <?php for ($j = 1; $j < $i; $j++) { ?>
      var meterField = document.getElementsByName("meter_arr[]")[<?=$j-1;?>];
      var rateField = document.getElementsByName("rate_arr[]")[<?=$j-1;?>];
      var discountField = document.getElementsByName("discount_arr[]")[<?=$j-1;?>];
      var igstField = document.getElementsByName("igst[]")[<?=$j-1;?>];

      meterField.addEventListener("change", function() {
        calculateSalePrice(<?=$j-1;?>);
      });

      rateField.addEventListener("change", function() {
        calculateSalePrice(<?=$j-1;?>);
      });

      discountField.addEventListener("change", function() {
        calculateSalePrice(<?=$j-1;?>);
      });

      igstField.addEventListener("change", function() {
        calculateSalePrice(<?=$j-1;?>);
      });
    <?php } ?>

    // Attach onchange event to frieght and discount fields
    document.getElementById("frieght").addEventListener("change", updateSubtotal);
    document.getElementById("discount").addEventListener("change", updateSubtotal);
  });
</script>





</body>
</html>
