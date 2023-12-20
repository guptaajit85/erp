<?php

$prtyArr = array();
$prtyArr['0']  = 'Low';
$prtyArr['1']  = 'Normal';
$prtyArr['2']  = 'High';
$prtyArr['3']  = 'Extreme';

$IGST_RATES = array();
$IGST_RATES['0']  = 5;
$IGST_RATES['1']  = 12;
$IGST_RATES['2']  = 18;
$IGST_RATES['3']  = 28;

$CGST_RATES = array();
$CGST_RATES['0']  = '2.5';
$CGST_RATES['1']  = '6';
$CGST_RATES['2']  = '9';
$CGST_RATES['3']  = '14';

$SGST_RATES = array();
$SGST_RATES['0']  = '2.5';
$SGST_RATES['1']  = '6';
$SGST_RATES['2']  = '9';
$SGST_RATES['3']  = '14';

$expDeliverydays = 3;

$expDeliveryDate = date('d-m-Y', strtotime('+'.$expDeliverydays.' days'));

$arrayProcess = array(
			'warping'=>array(
				'input'  =>array('Yarn'),
				'output' =>'Beam',
				'id' =>'1',
			),
			'weaving'=>array(
				'input'  =>array('Beam','Water'),
				'output' =>'Greige',
				'id' =>'2',
			),
			'Dyeing'=>array(
				'input'  =>array('Greige','Chemical','Color'),
				'output' =>'Dyed',
				'id' =>'3',
			),
			'Coating'=>array(
				'input'  =>array('Dyed','Chemical'),
				'output' =>'Coated',
				'id' =>'4',
			),
		);


return [
	'PER_PAGE' => 20,
	'priorityArr' => $prtyArr,
	'arrayProcess' => $arrayProcess,
	'reedPkAr' => ['Wrap', 'Weft'],
	'ExpDeliveryDate' => $expDeliveryDate,
	'expDeliverydays' => $expDeliverydays,
    'IGST_RATES' => $IGST_RATES,
    'CGST_RATES' => $CGST_RATES,
    'SGST_RATES' => $SGST_RATES,
	'SOREFERAL' => ['WhatsApp', 'Email', 'Mobile'],
	'user_type' => ['User', 'Admin'],
]



?>
