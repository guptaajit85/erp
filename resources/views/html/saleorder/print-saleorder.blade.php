<?php 
// echo "<pre>"; print_r($dataPur); exit;
use \App\Http\Controllers\CommonController; 

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>
<?php
		  if(trim($dataPur->sale_order_number)!='')
		  {
			  ?>
Sale Order No:-<?php echo $dataPur->sale_order_number;?>-<?php echo date('dS M Y', strtotime($dataPur->sale_order_date))?>
<?php
		  }else{
			  ?>
<?php } ?>
</title>
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<style>
      @import url(http://fonts.googleapis.com/css?family=Bree+Serif);
      body, h1, h2, h3, h4, h5, h6{
      font-family: 'Bree Serif', serif;
      }
	  body{
		  font-size: 16px;
	  }
    </style>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-xs-6">
      <h1> AJY TECH INDIA PVT. LTD. </h1>
    </div>
    <div class="col-xs-6 text-right">
      <h1>Sale Order Number</h1>
      <h1>
		<?php
		if(trim($dataPur->sale_order_number)!='')
		{
		?>
        <small>Sale Order No:- <?php echo $dataPur->sale_order_number;?></small><br>
        <small><?php echo date('dS M Y', strtotime($dataPur->sale_order_date))?></small>
		<?php
		}else{
		?>
		<?php } ?>
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Buyer: <a href="javascript:void(0);"><?php echo $dataCom->name; ?></a></h4>
        </div>
        <div class="panel-body">
          <p>
            <?php /*echo $dataCom->address_1; ?> <br>
               <?php echo $dataCom->address_2; ?> ,  <?php echo CommonController::getStateName($dataCom->state_id); ?> ,  <?php echo $dataCom->city_name; ?>, <?php echo $dataCom->zip_code; */ ?>
            <br>
            Email : <?php echo $dataCom->email; ?> <br>
            Mobile : <?php echo $dataCom->phone; ?> <br>
          </p>
        </div>
      </div>
    </div>
    <div class="col-xs-5 col-xs-offset-2 text-right">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Seller : <a href="javascript:void(0);"> <?php echo $dataI->name;?></a></h4>
        </div>
        <div class="panel-body">
          <p>
            <?php /* echo $dataIA->address_1; ?> <br>
				<?php echo $dataIA->address_2; ?> ,  <?php echo CommonController::getStateName($dataIA->state_id); ?> ,  <?php echo $dataIA->city_name; ?>, <?php echo $dataIA->zip_code; */ ?>
            <br>
            Email  : 	<?php echo $dataI->email; ?> <br>
            Mobile : 	<?php echo $dataI->phone; ?> <br>
            GSTIN: 		<?php echo $dataI->gstin;?>
            <?php /* if($rc[0]->vat != '') { ?>GSTIN: <?php echo $rc[0]->cst;?><br><?php } */ ?>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- / end client details section -->
  <table class="table table-bordered">
    <tr>
      <td >S. NO.</td>
      <td>Quality Name</td>
      <td>Unit</td>
      <td>Pieces</td>
      <td>CUT</td>
      <td>Meter</td>
      <td>Rate</td>
      <td>Amount</td>
      <td>Discount(%)</td>
      <td>Discount Amount</td>
      <td>Net Amount</td>
    </tr>
    <?php
		  $salepricewot = 0;
		  $total_price = 0;
		  
		  $cnt =1;
			foreach($dataPI as $rv)
			{
			// echo "<pre>"; print_r($rv);  
				
				$salepricewot = $salepricewot + $rv->saleprice_wot;
		   
		  
			?>
    <tr>
      <td><?php echo $cnt++; ?>.</td>
      <td><?php echo CommonController::getItemName($rv->item_id);?></td>
      <td><?php echo $rv->unit;?></td>
      <td><?php echo $rv->pcs;?></td>
      <td><?php echo $rv->cut;?></td>
      <td><?php echo $rv->meter;?></td>
      <td><?php echo $rv->rate;?></td>
      <td><?php echo $rv->amount;?></td>
      <td><?php echo $rv->discount;?></td>
      <td><?php echo $rv->discount_amount;?></td>
      <td><?php echo $rv->net_amount;?></td>
    </tr>
    <?php
		   
		   if($rv->is_return==1)
		   {
			   $total_price = $total_price -  $rv->total_price;
		   }else{
			   $total_price = $total_price +  $rv->total_price;
		   }
		   
		   }
			?>
    <tr>
      <td colspan="10" align="right">Total</td>
      <td align="left"><?php echo number_format($total_price, 2); ?></td>
    </tr>
    <tr>
      <td  colspan="19" class="bn">&nbsp;</td>
    </tr>
    <tr>
      <td  colspan="19" class="bn">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7">Invoice Terms: <br>
        1. No Refunds of money once sold<br>
        2. Warranty provided by company<br>
      </td>
      <td colspan="12"><table  class="table ">
          <tr>
            <td class="bn">Gross Value </td>
            <td class="bn">: <?php echo $rv->amount; ?></td>
          </tr>
          <tr>
            <td class="bn">Freight </td>
            <td class="bn">: <?php echo $dataPur->frieght;?></td>
          </tr>
          <tr>
            <td class="bn">Discount </td>
            <td class="bn">: <?php echo $rv->discount_amount;?></td>
          </tr>
          <tr>
            <td class="bn">Sale Order Value</td>
            <td class="bn">: <?php echo $dataPur->frieght+$rv->amount-$rv->discount_amount; ?></td>
          </tr>
          <tr>
            <td class="bn" colspan="2" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="right">For   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td class="bn" colspan="2" align="right">Authorised signatory</td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>
</body>
</html>
