<?php
 // echo "<pre>"; print_r($data); exit;
use \App\Http\Controllers\CommonController;

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>
 Package Order Items
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
      <h1><?=$data['individual']->name;?></h1>
    </div>
    <div class="col-xs-6 text-right">
      <h1>Package Order Items</h1>       
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
          <?php echo $data->billing_address;?> <br>
          </Address>
        </div>
      </div>
    </div>
    <div class="col-xs-5 col-xs-offset-2 text-right">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Shipping Address
           </div> 
        <div class="panel-body">
          <p> <?php echo $data->shiping_address; ?> <br/>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- / end client details section -->
  <table class="table table-bordered">
    <tr>
		<td >S. NO.</td>
		<th>Item Name</th>
		<th>Pack Type</th>
		<th>Required  </th>
		<th>Alloted  </th>
		 
    </tr>
    <?php

		  $total_price = 0;
		  $discountAmt = 0;
		  $cnt =1;
			foreach($data['packagingOrderItems'] as $rv)
			{
				$total_price	+=$rv->net_amount;
				$discountAmt	+=$rv->discount_amount;
				//  echo "<pre>"; print_r($rv['Item']); exit;

			?>
    
	<tr>
		<td>
			<p> AJY No. {{ $rv->sale_order_id }}  </p>
			<p> SO Item No. {{ $rv->sale_order_item_id }}  </p>	
		</td>								
		<td><?=$rv['Item']->item_name;?> <?=$rv->dyeing_color;?> <?=$rv->coated_pvc;?> </td>
		<td>{{ $rv['PackagingType']->name }}</td>
		<td>{{ $rv->meter }} Meter </td>
		<td>{{ $rv->pack_meter }} Meter</td>	
		 					  
	</tr>
	
	
	
	
	
	
    <?php
		   }
			?>
     
    
  </table>
</div>
</body>
</html>
