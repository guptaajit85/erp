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
	 <style>
    
    .invoice {
        border: 1px solid #ddd;
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

     
    /* Center the header text */
    .header h2, .header h3, .header p {
        text-align: center;
    }   
    .invoice-info {
        width: 50%;
        float: right;
    }
    </style>

	
	
</head>
<body>
<div class="container">
	<div class="header">
		<h2><?=$dataCom->name;?></h2>
		<p><?=$dataCom->address_1;?> <?=$dataCom->address_2;?></p>
		<p>Phone: <?=$dataCom->phone;?> | Mobile: <?=$dataCom->mobile;?></p>
		<p>GSTIN: <?=$dataCom->gstin;?></p>
		<h3>TAX INVOICE</h3>
	</div>
  
  <div class="row">
    <div class="col-xs-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>LOHIA ENTERPRISES (CAL) PVT.LTD.</h4>
        </div>
        <div class="panel-body"> 
            <table>
                <tr><td>Address:</td><td>166, MAHATMA GANDHI ROAD, 2ND FLOOR, KOLKATTA</td></tr>                
                <tr><td>GSTIN Number:</td><td>19AAACL5183A1ZQ</td></tr>
				  <tr><td>State:</td><td>WEST BENGAL</td></tr>
            </table>
        </div>
      </div>
    </div>
    <div class="col-xs-5 col-xs-offset-2 text-right">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>LOHIA ENTERPRISES (CAL) PVT.LTD.</h4>
        </div>
        <div class="panel-body">
            <table>
                <tr><td>Invoice No:</td> <td><?php echo $dataSalE->sale_order_number;?></td></tr>
                <tr><td>Invoice Date:</td><td style="padding-left: 10px;"><?php echo date('dS M Y', strtotime($dataSalE->sale_entry_on))?></td></tr>
				<tr><td>Party Mo. number:</td><td>9331014144</td></tr>
                <tr><td>Parcel:</td><td>1.00</td></tr>
				 <tr><td>State Code :</td><td>19</td></tr>
            </table>
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
      <td>Taxable Amount</td>
      <td>CGST</td>
      <td>CGST Amount</td>
      <td>SGST</td>
      <td>SGST Amount</td>
      <td>IGST</td>
      <td>IGST Amount</td>
      <td>Tax Amount</td>	      
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
      <td><?php echo $rv->taxable_amount;?></td>	  
      <td><?php echo $rv->cgst;?> %</td>
      <td><?php echo $rv->cgstrs;?></td>	  
      <td><?php echo $rv->sgst;?>%</td>
      <td><?php echo $rv->sgstrs;?></td>
      <td><?php echo $rv->igst;?>%</td>
      <td><?php echo $rv->igstrs;?></td>
	  
      <td><?php echo $rv->tax_amount;?></td>
      <td><?php echo $rv->net_amount;?></td>
    </tr>
    <?php
		   }
			?>
    <tr>
      <td colspan="18" align="right">Total</td>
      <td align="left"><?php echo number_format($total_price, 2); ?></td>
    </tr>
    
   
    <tr>
      <td colspan="10">
	    
	   <div class="transport">
            <h3>Transport Details</h3>
            <table>
                <tr><td>Transport:</td><td>UNIVERSALS EXPRESS</td></tr>
                <tr><td>Disc Amt:</td><td>0% | Transport Id: TSAAVPO0332J1ZB</td></tr>
                <tr><td>Add Amt:</td><td>0.00 | Station: KOLKATTA</td></tr>
                <tr><td>Taxable Value:</td><td>13,218.77</td></tr>
            </table>
        </div> <hr>
	  <div class="bank-details">
            <h3>Bank Details</h3>
            <table>
                <tr><td>Bank Name:</td><td>ICICI BANK</td></tr>
                <tr><td>Bank Account No:</td><td>655705501051 | IFSC Code: IcIc0006557</td></tr> 
            </table>
        </div>
		 <hr>
	  <div class="bank-details">            
            <table>               
                <tr><td>CGST Total:</td><td>0.00% 0.00 | SGST Total: 0.00% 0.00 | IGST Total: 660.94</td></tr>
                <tr><td>IRN No:</td><td>7a3dS08ba4b15866488ab4h9bdccOf3a205/d017191101ficcOOdeds644</td></tr>
                <tr><td>ACK No:</td><td>162315696282904 | ACKDT: 2023-12-09 13:25:00</td></tr>
                <tr><td>Total Amount After Tax:</td><td>13,880.00</td></tr>
            </table>
        </div>
	   
	  
	 
      </td>
      <td colspan="15"><table  class="table ">
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
