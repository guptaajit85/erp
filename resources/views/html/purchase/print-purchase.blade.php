<?php
// echo "<pre>"; print_r($dataPur); exit;
use \App\Http\Controllers\CommonController;

?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')</head>
<title>
<?php
		  if(trim($dataPur->purchase_number)!='')
		  {
			  ?>
Invoice No:-<?php echo $dataPur->purchase_number;?>-<?php echo date('dS M Y', strtotime($dataPur->purchased_on))?>
<?php
		  }else{
			  ?>
<?php } ?>
</title>
<body class="hold-transition sidebar-mini">
<div class="wrapper"> 
 <div class="content-wrapperd">
    <section class="content">
      <div class="row">
        <div class="col-sm-12"> 
          <div class="panel panel-bd lobidrag">
           
            <div class="panel-body">
			
              <div class="table-responsive">
			 <div class="col-sm-12 phead"><h2>PURCHASE INVOICE</h2></div>
	 
			   <table style="border-collapse:separate; margin-bottom:4px;" class="table table-bordered table-striped table-hover font-size12">
                 <tbody>
				<tr>
                    <td class="font-height" rowspan="4">
					Invoice To<br><b><?php echo $dataI->name;?></b><br>
					<?php echo $dataIA->address_1; ?><BR>
					<?php echo $dataIA->address_2; ?> , <?php echo CommonController::getStateName($dataIA->state_id); ?> , <?php echo $dataIA->city_name; ?>, <?php echo $dataIA->zip_code; ?><br>
					Email : <?php echo $dataI->email; ?> <br>
					Mobile : <?php echo $dataI->phone; ?> <br>
					GSTIN: <?php echo $dataI->gstin;?>
					</td>
                    <td  class="font-height">Voucher No.<br> <b>
					
					<?php
					  if(trim($dataPur->purchase_number)!='')
					  { echo $dataPur->purchase_number;}
					  ?>
					</td>
                    <td>Dated <br> <b>
					<?php
					  if(trim($dataPur->purchase_number)!='')
					  {
						echo date('dS M Y', strtotime($dataPur->purchased_on));
					 }
					 ?>
					</b> </td>
                  </tr>
				  
				  
				  
				  <tr>
                    <th class="font-height">&nbsp;</th>
                    <th class="font-height">Mode/Term of Payment</th>
                  </tr>
				  
				  
				  <tr>
                    <td class="font-height">
					Refference No. & Date.<br><br><b>
					<?php
					  if(trim($dataPur->purchase_number)!='')
					  {
						echo date('dS M Y', strtotime($dataPur->purchased_on));
					 }
					 ?>
					
					</b>
					</td>
                    <td class="font-height">Other Refferences</td>
                
                  </tr>
				  
				   <tr>
                    <td class="font-height">Dispatched through</th>
                    <td class="font-height">Destination</td>
                
                  </tr>
				  
				  
				  <!-- 2nd phase start-->
				  <tr>
                    <td  class="font-height" rowspan="4">
					Consignee(Ship To)<br><b><?php echo $dataCom->name; ?></b><br>
					 <?php echo $dataCom->address_1; ?><BR>
					 <?php echo $dataCom->address_2; ?> , <?php echo CommonController::getStateName($dataCom->state_id); ?> , <?php echo $dataCom->city_name; ?>, <?php echo $dataCom->zip_code; ?> <br>
					 Email : <?php echo $dataCom->email; ?> <br>
                     Mobile : <?php echo $dataCom->phone; ?> <br>
					</td>
                    <td  class="font-height" colspan="4">Terms of Delivery</td>
                  </tr>
				
				
				  
				 </tbody>
			  </table>
               <div class="table-responsive">
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover font-size12 border-hide">
                  <thead> 
                    <tr class="info">
                      <th width="60">S. No.</th>
                      <th>Description of Goods </th>
                      <th>Due on </th>
                      <th>Quantity</th>
                      <th>Rate</th>
                      <th>Per</th>
                      <th>CGST</th>
                      <th>SGST</th>
                      <th>IGST</th>
					  
                      <th>Amount </th>
                    </tr>
                  </thead>
                  <tbody>
	  <?php
		  $salepricewot = 0;
		  $total_price = 0;
		  $tcgst = 0;
		  $tsgst = 0;
		  $tigst = 0;
		  $tcess = 0;
		  $cnt =1;
		  $totQty = 0;
			foreach($dataPI as $rv)
			{


				  $salepricewot = $salepricewot + $rv->saleprice_wot;

				  $tcgst += $rv->cgstrs;
				  $tsgst += $rv->sgstrs;
				  $tigst += $rv->igstrs;
				  $tcess += $rv->cessrs;
	 ?>
				  
                  <tr>
                    <td class="no-border"><?php echo $cnt++; ?>. </td>
                    <td class="no-border"><?php echo CommonController::getItemName($rv->item_id);?> </td>
					 <td  class="no-border">{{date('dS M Y', strtotime($dataPur->purchased_on))}} </td>
					  <td class="no-border"><?php echo $rv->quantity;?> {{CommonController::getUnitTypeName($rv->unit)}}</td>
					  <td class="no-border"><?php echo number_format($rv->mrp,2);?></td>
					  <td class="no-border"><?php echo CommonController::getUnitTypeName($rv->unit);?></td> 
					  <td><?php echo $rv->cgst;?>%</td>
					  <td><?php echo $rv->sgst;?>%</td>
					  <td><?php echo $rv->igst;?>%</td>
					<td class="center no-border">&#8377; <?php echo number_format($rv->total_price,2);?> </td>
                  </tr>
				  
				   <?php
				   
					$totQty = $totQty + $rv->quantity;
				     
				   if($rv->is_return==1)
				   {
					   $total_price = $total_price -  $rv->total_price;
				   }else{
					   $total_price = $total_price +  $rv->total_price;
				   }

				   }
				   
				   $total_price_inword = $total_price;
				   $total_price = number_format($total_price,2);
					
				   
					?>
				  
				  
				 
                 
                  <tr class="center text-center">
				
                    <td colspan="3" align="right"> Total</td>
					 <td align="left"> <?php echo $totQty;?> {{CommonController::getUnitTypeName($rv->unit)}}</td>
					  <td></td>
					<td></td>
					<td></td>
					
					
					<td></td>
					<td></td>
					
					
					<td align="left">&#8377; <?php echo $total_price; ?> </td>
                  </tr>
				  
				  <tr>
					  <td colspan="10">Amount Chargeable (in word) <br> 
					  <b>INR </b><?php  echo CommonController:: convert_number($total_price_inword);?> Only
					  <span style="float:right;"><a href="javascript:window.print()" class="btn btn-success me-1m printbtn"><i class="fa fa-print"></i></a></span>
					  </td>
				  </tr>
                  </tbody>
                  
                </table>
				


              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
 </div>
@include('common.formfooterscript')
</body>
</html>