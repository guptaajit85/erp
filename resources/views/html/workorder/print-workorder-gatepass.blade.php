 <?php
use \App\Http\Controllers\CommonController; 
 
 
$unitTypeId 	= $dataGp->unit_type_id; 
$itemTypeId 	= $dataGp->item_type_id; 
$unitTypeName   = CommonController::getUnitTypeName($unitTypeId); 
$itemTypeName   = CommonController::getItemTypeName($itemTypeId); 
//barcode generator
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

// echo "<pre>"; print_r($data); exit; 

$process_type  	 	= $data->process_type;
$process_sl_no  	= $data->process_sl_no;
$proTypeOrdNumber  	= $process_type.$process_sl_no;  


$dyeing_color 		= $dataGp->dyeing_color;
$coated_pvc 		= $dataGp->coated_pvc;
$extra_job 			= $dataGp->extra_job;
$print_job 			= $dataGp->print_job;

if(!empty($dyeing_color)) 		$readyItem = "Dyeing Color : ".$dyeing_color;
else if(!empty($coated_pvc)) 	$readyItem = "Coated : ".$coated_pvc;
else if(!empty($extra_job)) 	$readyItem = "Extra Job : ".$extra_job;
else if(!empty($print_job)) 	$readyItem = "Print Job : ".$extra_job;

?>
<!doctype html>
<html lang="en">
<head>
<body>
<meta charset="UTF-8">
<title>
<?php if(trim($data->work_order_id)!='') { ?>
Gatepass No:-<?php echo (1000+$data->work_order_id);?>
<?php  } ?>
</title>
<link href="{{ asset('css/gatepass.css') }}" rel="stylesheet" type="text/css"/>
    <!--Loop Item Start-->

    <div class="divLoop ">

        <!-- Road challan start-->
        <div class="bxOne bgwp">
            <table class="table table-bordered roadChallan" width="100%">
                <tr>
                    <td style="padding:0;" align="center" width="100%" colspan="2">
                        <table class="head" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="2" align="center" style="padding-top:5px;">
                                    <b style="font-size:18px;"><? // =$proTypeOrdNumber;?> <?=(1000+$GpId);?></b><br />
                                    <strong>Gatepass</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                <h1><?php echo $compData->name; ?> (Gatepass)</h1><br>
                                <h5><?php echo $compData->phone; ?>/<?php echo $compData->another_phone; ?></h5><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

        <tr>
            <td align="center" colspan="2">
                 {!! $generator->getBarcode($proTypeOrdNumber, $generator::TYPE_CODE_128) !!}
             </td>
        </tr>

                <tr>
                    <td align="left" colspan="2">
                        <ul>
                            <li>Work Order : #<?=$proTypeOrdNumber;?></li>
                            <li><b>Sale Order Item : #<?php echo ($data->sale_order_item_id);?></b></li>
                            <li>Item : <?php echo $data->item_name;?> </li>
                            <li><i><b>QTY : </b></i>  <?=$dataGp->qty_size;?>  <?=$unitTypeName;?>  <?=$itemTypeName;?> (<?=$dataGp->qty;?> Pcs) </li>
							
                            <?php if(!empty($readyItem)) { ?>
							<li>  <b> <?=$readyItem;?></b> </li>	
                            <?php } ?>
							<li><b>From Department : <?=$toDepart;?></b></li>							
							<li>To Department : <?=$warehouseName;?></li>   
                            <li>Generated Date : <?=date('d/m/Y');?> </li> 
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sender Signature </td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receiver Signature</td>
                    </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
            </table>
        </div>
        <!--Road challan end-->

        <!--Road challan start-->
        <div class="bxTwo bgwp">
            <table class="table table-bordered roadChallan">
                <tr>
                    <td style="padding:0;" align="center" width="100%" colspan="2">
                        <table class="head" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="2" align="center" style="padding-top:5px;">
                                    <b style="font-size:18px;"><? //=$proTypeOrdNumber;?><?=(1000+$GpId);?></b><br />
                                    <strong>P O D</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                <h1><?php echo $compData->name; ?>  (Challan)</h1><br>
                                <h5><?php echo $compData->phone; ?>/<?php echo $compData->another_phone; ?></h5><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                         {!! $generator->getBarcode($proTypeOrdNumber, $generator::TYPE_CODE_128) !!}
                     </td>
                </tr>
                <tr>
                    <td align="left"  colspan="2">
                        <ul>
                            <li>Work Order : #<?=$proTypeOrdNumber;?></li>
                            <li><b>Sale Order Item : #<?php echo ($data->sale_order_item_id);?></b></li>
                            <li>Item : <?php echo $data->item_name;?> </li>
                            <li><i><b>QTY : </b></i>  <?=$dataGp->qty_size;?>  <?=$unitTypeName;?>  <?=$itemTypeName;?> (<?=$dataGp->qty;?> Pcs) </li>
                            </li>
                           <li><b>From Department : <?=$toDepart;?></b></li> 
							<li>To Department : <?=$warehouseName;?></li>
                            <li> Generated Date : <?=date('d/m/Y');?> </li> 
                        </ul>

                    </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sender Signature </td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receiver Signature</td>
                    </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
            </table>
        </div>
        <!--Road challan end-->


        <!--Road challan start-->
        <div class="bxTwo bgwp">
            <table class="table table-bordered roadChallan">
                <tr>
                    <td style="padding:0;" align="center" width="100%" colspan="2">
                        <table class="head" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="2" align="center" style="padding-top:5px;">
                                    <b style="font-size:18px;"><? //=$proTypeOrdNumber;?> <?=(1000+$GpId);?></b><br />
                                    <strong>P O D</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                <h1><?php echo $compData->name; ?>  (Challan)</h1><br>
                                <h5><?php echo $compData->phone; ?>/<?php echo $compData->another_phone; ?></h5><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr> 
                <tr>
                    <td align="center" colspan="2">
                         {!! $generator->getBarcode($proTypeOrdNumber, $generator::TYPE_CODE_128) !!}
                     </td>
                </tr>
                <tr>
                    <td align="left"  colspan="2">
                        <ul>
                            <li>Work Order : #<?=$proTypeOrdNumber;?></li>
                            <li><b>Sale Order Item : #<?php echo ($data->sale_order_item_id);?></b></li>
                            <li>Item : <?php echo $data->item_name;?> </li>
                            <li><i><b>QTY : </b></i>  <?=$dataGp->qty_size;?>  <?=$unitTypeName;?>  <?=$itemTypeName;?> (<?=$dataGp->qty;?> Pcs) </li>
                            </li>
                           <li><b>From Department : <?=$toDepart;?></b></li> 
							<li>To Department : <?=$warehouseName;?></li>
                            <li> Generated Date : <?=date('d/m/Y');?> </li> 
                        </ul> 
                    </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sender Signature </td>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receiver Signature</td>
                    </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
            </table>
        </div>
        <!--Road challan end-->
        <div style="clear:both;"></div>
    </div>
    <span style="margin-left:50px;"><button class="hidden-print" onClick="window.print()"> Print</button></span>
        <div style="clear:both;"></div>
    </div>
    <div class="pagebreak"> </div>
</body>
</html>
