when i am clicking on the first check box then the value is showing but when i am clicking on the second check box then the new value should be added to the  old value and then it should br shown, this is not happening.

 
 
<table class="table table-bordered">
<tbody>
  <tr>                    
	<td> <input type="checkbox" id="wis_id" name="wis_id" onClick="addRequisition(1)"> </td>
	<td> <input type="checkbox" id="wis_id" name="wis_id" onClick="addRequisition(2)"> </td>
	<td> <input type="checkbox" id="wis_id" name="wis_id" onClick="addRequisition(3)"> </td>
	<td> <input type="checkbox" id="wis_id" name="wis_id" onClick="addRequisition(4)"> </td>
  </tr>	 				   
</tbody>
</table> 			  
 			  
<table class="table table-bordered" id="myTable">
<tbody>                  		   
  <tr>                  
	<th>Required Quantity</th>
	<td><input type="number" min="1" id="bal_quantity" name="bal_quantity" required> &nbsp; Meter </td>                    
  </tr>  				  
</tbody>
</table>			  
<script>
var siteUrl = "{{ url('/') }}";
function addRequisition(Id) 
{
	alert(Id);
	jQuery.ajax({
		type: "GET",
		url: siteUrl + '/' + "ajax_script/getSumWarehouseItemStockValue",
		data: {
			"_token": "{{ csrf_token() }}",
			"FId": Id,
		},
		cache: false,
		success: function (response) {
			response = JSON.parse(response);
			console.log(response);
			alert(response);
			 $("#bal_quantity").val(response); 
			 
		}
	});				 
}
</script> 
<?php 		
public function getSumWarehouseItemStockValue(Request $request)
{
$FId = $request->FId;
$dataWIS = WarehouseItemStock::where('wis_id', '=', $FId)->where('status', '=', '1')->first(); 
$inspBalQuanSize   = $dataWIS->insp_bal_quan_size;	 
echo json_encode($inspBalQuanSize); 
}

?>