<?php
	use \App\Http\Controllers\CommonController;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
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
      <h1>PURCHASE ORDER</h1>
      <h1>
        <?php
		  if(trim($dataPur->purchase_number)!='')
		  {
			  ?>
        <small>PURCHASE ORDER No:- <?php echo $dataPur->purchase_number;?></small><br>
        <small><?php echo date('dS M Y', strtotime($dataPur->purchased_on))?></small>
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
          <h4>Buyer: <a href="#"><?php echo $dataCom->name; ?></a></h4>
        </div>
        <div class="panel-body">
          <p> <?php echo $dataCom->address_1; ?> <br>
            <?php echo $dataCom->address_2; ?> , <?php echo CommonController::getStateName($dataCom->state_id); ?> , <?php echo $dataCom->city_name; ?>, <?php echo $dataCom->zip_code; ?><br>
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
          <p> <?php echo $dataIA->address_1; ?> <br>
            <?php echo $dataIA->address_2; ?> , <?php echo CommonController::getStateName($dataIA->state_id); ?> , <?php echo $dataIA->city_name; ?>, <?php echo $dataIA->zip_code; ?><br>
            Email : <?php echo $dataI->email; ?> <br>
            Mobile : <?php echo $dataI->phone; ?> <br>
            GSTIN: <?php echo $dataI->gstin;?>
            <?php /* if($rc[0]->vat != '') { ?>GSTIN: <?php echo $rc[0]->cst;?><br><?php } */ ?>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- / end client details section -->
  <table class="table table-bordered">
    <tr>
      <td>S. NO.</td>
      <td>TYPE</td>
      <td>PRODUCT</td>
      <td>HSN/SAC</td>
      <td>QTY</td>
      <td>UOM</td>
      <td>RATE</td>
      <td>TOTAL</td>
      <td>DISCOUNT</td>
      <td>GROSS</td>
      <td colspan="2"><table>
          <tr>
            <td>CGST</td>
          </tr>
          <tr>
            <td>Rate</td>
            <td>Amount</td>
          </tr>
        </table></td>
      <td colspan="2"><table>
          <tr>
            <td>SGST</td>
          </tr>
          <tr>
            <td>Rate</td>
            <td>Amount</td>
          </tr>
        </table></td>
      <td colspan="2"><table>
          <tr>
            <td>IGST</td>
          </tr>
          <tr>
            <td>Rate</td>
            <td>Amount</td>
          </tr>
        </table></td>
      <td colspan="2"><table>
          <tr>
            <td>CESS</td>
          </tr>
          <tr>
            <td>Rate</td>
            <td>Amount</td>
          </tr>
        </table></td>
    </tr>
    <?php
		  $salepricewot = 0;
		  $total_price = 0;
		  $tcgst = 0;
		  $tsgst = 0;
		  $tigst = 0;
		  $tcess = 0;
		  $cnt =1;
			foreach($dataPI as $rv)
			{
			  // echo "<pre>"; print_r($rv->item_type_id);

				$salepricewot = $salepricewot + $rv->saleprice_wot;

		  $tcgst += $rv->cgstrs;
		  $tsgst += $rv->sgstrs;
		  $tigst += $rv->igstrs;
		  $tcess += $rv->cessrs;
			?>
    <tr>
	  <td><?php echo $cnt++; ?>.</td>
	  <td><?php echo CommonController::getItemTypeName($rv->item_type_id);?></td>
	  <td><?php echo CommonController::getItemName($rv->item_id);?></td>     
      <td><?php echo $rv->hsn;?></td>
      <td><?php echo $rv->quantity;?></td>
      <td><?php echo $rv->unit;?></td>
      <td><?php echo $rv->mrp;?></td>
      <td><?php echo $rv->saleprice_wot;?></td>
      <td><?php echo $rv->discount;?><?php echo $rv->dis_type;?></td>
      <td><?php echo $rv->total_price;?></td>
      <td><?php echo $rv->cgst;?></td>
      <td><?php echo $rv->cgstrs;?></td>
      <td><?php echo $rv->sgst;?></td>
      <td><?php echo $rv->sgstrs;?></td>
      <td><?php echo $rv->igst;?></td>
      <td><?php echo $rv->igstrs;?></td>
      <td><?php echo $rv->cess;?></td>
      <td><?php echo $rv->cessrs;?></td>
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
      <td colspan="6" align="left">Total</td>
      <td align="left"><?php echo $salepricewot; ?></td>
      <td align="left"></td>
      <td align="left"><?php echo $total_price; ?></td>
      <td align="left"></td>
      <td align="left"><?php echo $tcgst;?></td>
      <td align="left"></td>
      <td align="left"><?php echo $tsgst;?></td>
      <td align="left"></td>
      <td align="left"><?php echo $tigst;?></td>
      <td align="left"></td>
      <td align="left"><?php echo $tcess;?></td>
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
            <td class="bn">: <?php echo $salepricewot; ?></td>
          </tr>
          <tr>
            <td class="bn">Tax </td>
            <td class="bn">: <?php echo $tcgst+$tsgst+$tigst+$tcess;?></td>
          </tr>
          <tr>
            <td class="bn">Freight </td>
            <td class="bn">: <?php echo $dataPur->frieght;?></td>
          </tr>
          <tr>
            <td class="bn">Discount </td>
            <td class="bn">: <?php echo $dataPur->coupon_discount;?></td>
          </tr>
          <tr>
            <td class="bn">Invoice Value</td>
            <td class="bn">: <?php echo $dataPur->frieght+$total_price-$dataPur->coupon_discount; ?></td>
          </tr>
          <tr>
            <td class="bn" colspan="2" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="right">For Universal</td>
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
