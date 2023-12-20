<?php
 //echo "<pre>"; print_r($data); exit;
use \App\Http\Controllers\CommonController;
$fromDepart   = CommonController::getProcessName($data->process_type_id);
$toDepart     = CommonController::getProcessName($toDepartment);

$warehouseId = $data['WarehouseItem']->warehouse_id;
$warehouseName  = CommonController::getWarehouseName($warehouseId);

//barcode generator
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();



?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>
<?php if(trim($data->work_order_id)!='') { ?>
Gatepass No:-<?php echo (10000+$data->work_order_id);?>
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
                                    <b style="font-size:18px;">338776</b><br />
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
                 {!! $generator->getBarcode($data->work_order_id, $generator::TYPE_CODE_128) !!}
             </td>
        </tr>

                <tr>
                    <td align="left" colspan="2">
                        <ul>
                            <li>Work Order : #<?php echo ($data->work_order_id);?></li>
                            <li><b>Sale Order Item : #<?php echo ($data->sale_order_item_id);?></b></li>
                            <li>Item : <?php echo $data->item_name;?> </li>
                            <li><i><b>QTY : </b></i></li>
                            <li>From Department : <?=$warehouseName;?></li>

                            <li><b>To Department : <?=$toDepart;?></b></li>
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
                                    <b style="font-size:18px;">338776</b><br />
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
                    <td align="center">
                         {!! $generator->getBarcode($data->work_order_id, $generator::TYPE_CODE_128) !!}
                     </td>
                </tr>
                <tr>
                    <td align="left"  colspan="2">
                        <ul>
                            <li>Work Order : #<?php echo ($data->work_order_id);?></li>
                            <li><b>Sale Order Item : #<?php echo ($data->sale_order_item_id);?></b></li>
                            <li>Item : <?php echo $data->item_name;?> </li>
                            <li><i><b>QTY : &nbsp;</b></i>
                            </li>
                            <li>From Department :<?=$warehouseName;?></li>
                            <li><b>To Department : <?=$toDepart;?></b></li>
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
                                    <b style="font-size:18px;">338776</b><br />
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
                    <td align="center">
                         {!! $generator->getBarcode($data->work_order_id, $generator::TYPE_CODE_128) !!}
                     </td>
                </tr>
                <tr>
                    <td align="left"  colspan="2">
                        <ul>
                            <li>Work Order : #<?php echo ($data->work_order_id);?></li>
                            <li><b>Sale Order Item : #<?php echo ($data->sale_order_item_id);?></b></li>
                            <li>Item : <?php echo $data->item_name;?> </li>
                            <li><i><b>QTY : &nbsp;</b></i>
                            </li>
                            <li>From Department :<?=$warehouseName;?></li>
                            <li><b>To Department : <?=$toDepart;?></b></li>
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
