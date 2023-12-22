<?php
// echo "<pre>"; print_r($dataSalE); exit;
use \App\Http\Controllers\CommonController;

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>
<?php
if(trim($dataSalE->sale_order_number)!='')
{
?>
Invoice No:-<?php echo $dataSalE->sale_order_number;?>-<?php echo date('dS M Y', strtotime($dataSalE->sale_entry_on))?>
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
      <h1>Sale Entry INVOICE</h1>
      <h1>
        <?php
		  if(trim($dataSalE->sale_order_number)!='')
		  {
			  ?>
        <small>Invoice No:- <?php echo $dataSalE->sale_order_number;?></small><br>
        <small><?php echo date('dS M Y', strtotime($dataSalE->sale_entry_on))?></small>
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
          <h4>Billing Address</h4>
        </div>
        <div class="panel-body">
          <Address>
          <?php echo $dataSalE->billing_address ?> <br>
          </Address>
        </div>
      </div>
    </div>
    <div class="col-xs-5 col-xs-offset-2 text-right">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Shipping Address
            <!-- : <a href="javascript:void(0);">  <?php echo $dataI->
            name;?></a></h4>
          --> </div>
        <div class="panel-body">
          <p> <?php echo $dataSalE->shipping_address; ?> <br/>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- / end client details section -->
  <table class="table table-bordered">
    <tr>
      <td >S. NO.</td>
      <td>PRODUCT</td>
      <td>Unit</td>
      <td>PCs</td>
      <td>Cut</td>
      <td>Meter</td>
      <td>RATE</td>
      <td>Amount</td>
      <td>DISCOUNT</td>
      <td>Discount Amount</td>
      <td>GROSS Amount</td>
    </tr>
    <?php

		  $total_price = 0;
		  $discountAmt = 0;
		  $cnt =1;
			foreach($dataPI as $rv)
			{
				$total_price	+=$rv->net_amount;
				$discountAmt	+=$rv->discount_amount;
				// echo "<pre>"; print_r($rv); exit;

			?>
    <tr>
      <td><?php echo $cnt++; ?>.</td>
      <td><?php echo $rv->name;;?></td>
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
            <td class="bn">: <?php echo number_format($total_price, 2); ?></td>
          </tr>
          <tr>
            <td class="bn">Freight </td>
            <td class="bn">: <?php echo $dataSalE->frieght;?></td>
          </tr>
          <tr>
            <td class="bn">Discount </td>
            <td class="bn">: <?php echo $discountAmt;?></td>
          </tr>
          <tr>
            <td class="bn">Invoice Value</td>
            <td class="bn">: <?php echo $dataSalE->frieght+$total_price-$discountAmt; ?></td>
          </tr>
          <tr>
            <td class="bn" colspan="2" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="right">For AjyTech</td>
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
