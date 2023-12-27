<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\User;
use App\Models\Notification;
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\GstRate;
use App\Models\Individual;
use App\Models\SaleOrder;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use App\Models\IndividualAddress;
use App\Models\WarehouseCompartment;
use App\Models\Warehouse;
use App\Models\State;
use App\Models\ProcessItem;
use App\Models\WarehouseItem;
use App\Models\WarehouseItemStock;
use App\Models\FabricFaultReason;
use App\Models\WorkProcessRequirement;
use App\Models\WarehouseBalanceItem;
use App\Models\UserWebPage;
use App\Models\AllPage;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderItemDetail;
use App\Models\WorkInspection;
use App\Models\Machine;
use Auth;
use Validator;
use Illuminate\Support\Facades\Session;
use DateTime;
use DateInterval;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class CommonController extends Controller
{
  // For sending email
  /*
	public static function sendMail($to="", $subject="", $body="",$fromname="",$type="",$replyto="",$bcc="",$cc="")
	{
		if(empty($type))
		{
			$type="html";
		}
		if($type=="plain")
		{
			$body = strip_tags($body);
		}
		if($type=="html")
		{
			$body = "<font face='Verdana, Arial, Helvetica, sans-serif'>".$body."</font>";
		}
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth 	= true;
		$mail->SMTPSecure 	= 'tls';
		$mail->Host        	= 'smtp.mailgun.org';
		$mail->Port        	= 587;
		$mail->isHTML(true);
		$mail->Username 	= 'postmaster@www.adhasher.com';
		$mail->Password 	= '764f096c64de5eabbd1dd46e0e94d0a3-f2340574-2c4b6881';
		$mail->SetFrom('info@adhasher.com', $fromname);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to);
		if(!empty($bcc))
		{
			$mail->addBcc($bcc);
		}
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo;
			return $error;
		} else {
			$error = 'Message sent!';
			return $error;
		}

	}
	*/
  public static function sendMail($to = "", $subject = "", $body = "", $fromname = "", $type = "", $replyto = "", $bcc = "", $cc = "")
  {
    if (empty($type)) {
      $type = "html";
    }
    if ($type == "plain") {
      $body = strip_tags($body);
    }
    if ($type == "html") {
      $body = "<font face='Verdana, Arial, Helvetica, sans-serif'>" . $body . "</font>";
    }
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure   = 'tls';
    $mail->Host          = 'smtp.mailgun.org';
    $mail->Port          = 587;
    $mail->isHTML(true);
    $mail->Username   = 'postmaster@procogs.com';
    $mail->Password   = '888e62b807581d99278fbb96a45425b7-fe066263-95604b51';
    $mail->SetFrom('pcadspace@gmail.com', $fromname);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if (!empty($bcc)) {
      $mail->addBcc($bcc);
    }
    if (!$mail->Send()) {
      $error = 'Mail error: ' . $mail->ErrorInfo;
      return $error;
    } else {
      $error = 'Message sent!';
      return $error;
    }
  }

  // Uses for email body
  public static function mailBody($bodypart)
  {
    $data = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Adhasher</title>
		</head>
		<body>
		<table width="600" border="0" cellspacing="1" cellpadding="3" align="center" style="border:1px solid #d6d6d6; font:normal 12px/16px Arial, Helvetica, sans-serif; color:#818181;">
		  <tr>
			<td align="left" valign="top" style="height:50px; border-bottom:3px solid #eeefef;background-color:#f9f9f9; text-align: center"><img width="100" src="https://www.adhasher.com/dist/images/logo.png"/>
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top" style="padding:10px 20px 20px 20px; color:#4b4b4b;"><table width="100%" border="0" cellspacing="2" cellpadding="0">
			  <tr>
				<td align="left" valign="top">' . $bodypart . '</td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" style="height:50px; background-color:#4F595B; color:#fff">Copyright &copy;' . date("Y") . ' Adhasher, All Rights Reserved.</td>
		  </tr>
		</table>
		</body>
		</html>';
    return $data;
  }

  // For getting current ip address
  public static function getIp()
  {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          $ip = trim($ip); // just to be safe
          if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
          }
        }
      }
    }
    return request()->ip(); // it will return server ip when no client ip found
  }

  // For removing session message
  public static function remove_message($msgvar)
  {
    Session::forget($msgvar);
    Session::forget('messageClass');
  }
  // For display session message
  public static function display_message($msgvar)
  {
    $message = '';
    if (Session::has($msgvar)) {
      if (Session::get('messageClass') == 'successClass') {
        $message = '<div class="alert alert-block alert-success">
			  <button type="button" class="close" data-dismiss="alert"> <i class="glyphicon glyphicon-remove"></i> </button>
			  <i class="glyphicon glyphicon-ok"></i> ' . Session::get($msgvar) . '</div>';
      } elseif (Session::get('messageClass') == 'infoClass') {
        $message = '<div class="alert alert-block alert-info">
			  <i class="fa fa-comment"></i> <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
			  <i class="ace-icon fa fa-cross "></i> ' . Session::get($msgvar) . '</div>';
      } else {
        $message = '<div class="alert alert-block alert-danger">
			  <button type="button" class="close" data-dismiss="alert"> <i class="ace-icon fa fa-times"></i> </button>
			  <i class="ace-icon fa fa-cross "></i> ' . Session::get($msgvar) . '</div>';
      }
    }

    self::remove_message($msgvar);
    return $message;
  }

  public static function userSecure($userId = NULL)
  {
    $userId = Auth::id();
    $userD   = User::where('id', $userId)->first();
    $userType = $userD->user_type;
    if ($userType == 'advertiser') {
      return redirect()->back();
      exit;
    }
  }
  public static function userAdvSecure($userId = NULL)
  {
    $userId = Auth::id();
    $userD   = User::where('id', $userId)->first();
    $userType = $userD->user_type;
    if ($userType == 'earner') {
      // return redirect()->back();
      return redirect("home");
      exit;
    }
  }

  public static function getUser($userId)
  {
    // $userId = Auth::id();
    $userD   = User::where('id', $userId)->first();
    return  $userD;
  }

  public static function getUserName($userId)
  {
    error_reporting(0);
    // $userId = Auth::id();
    $userD   = User::where('id', $userId)->first();
    return  $userD->name;
  }


  public static function getItemType($itemTypeId)
  {
    try {
      $itemType = ItemType::findOrFail($itemTypeId);
      return $itemType->item_type_name;
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      return 'Item Type not found';
    } catch (\Exception $e) {
      return 'Error retrieving Item Type';
    }
  }

  public static function getItemTypeName($itemTypeId)
  {
    error_reporting(0);
    // $userId = Auth::id();
    $itemD   = ItemType::where('item_type_id', $itemTypeId)->first();
    return  $itemD->item_type_name;
  }

  //added by Dinesh on 27-09-2023
  public static function getGstRate($gstRateId)
  {
    // $userId = Auth::id();
    $itemD   = GstRate::where('gst_rate_id', $gstRateId)->first();
    if (!empty($itemD->gst_rate))  return  $itemD->gst_rate;
    else return  '';
  }

  public static function getUnitTypeName($unitTypeId)
  {
    // $userId = Auth::id();
    $itemD   = UnitType::where('unit_type_id', $unitTypeId)->first();
    if (!empty($itemD->unit_type_name))  return  $itemD->unit_type_name;
    else return  '';
  }

  public static function getStateName($stateId)
  {
    // $userId = Auth::id();
    $stateD = State::where('id', $stateId)->first();
    if (!empty($stateD->name))  return $stateD->name;
    else return '';
  }

  public static function getIndividualName($Id)
  {
    $userD = Individual::where('id', $Id)->first();
    if (!empty($userD->name)) return $userD->name;
    else return '';
  }

  public static function getWarehouseName($Id)
  {
    $data = Warehouse::where('id', $Id)->first();
    if (!empty($data->warehouse_name))  return $data->warehouse_name;
    else return '';
  }

  public static function getWarehouseCompartmentName($Id)
  {
    $data = WarehouseCompartment::where('id', $Id)->first();
    if (!empty($data->warehousename)) return $data->warehousename;
    else return '';
  }

  public static function getItemName($id)
  {
    $dataI = Item::where('item_id', '=', $id)->where('status', '=', '1')->first();
    return $dataI->item_name;
  }
  public static function getItemInternalName($id)
  {
    $dataI = Item::where('item_id', '=', $id)->where('status', '=', '1')->first();
    return $dataI->internal_item_name;
  }

  public function list_vendor(Request $request)
  {
    $qsearch  =  $request->term;
    $dataI = Individual::where(function ($query) use ($qsearch) {
      $query->where(DB::raw("CONCAT(name, whatsapp, email)"), 'LIKE', '%' . $qsearch . '%');
    })
      ->where('type', 'vendors')
      ->with('IndividualBillingAddress')
      ->with('IndividualShipingAddress')
      ->where('status', 1)
      ->limit(10)
      ->get();

    echo json_encode($dataI);
  }

  public function list_employee(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $qsearch  = $request->term;
    $dataI    = Individual::where('type', '=', 'employee')->where(DB::raw("concat(name,email)"), 'LIKE', '%' . $qsearch . '%')->with('IndividualBillingAddress')->with('IndividualShipingAddress')->where('status', '=', '1')->limit(10)->get();
    // echo "<pre>";  print_r($dataI['0']->IndividualAddress->address_1); exit;
    echo json_encode($dataI);
  }

  public function list_purchase_items(Request $request)
  {
    $qsearch  =  $request->term;
    // $dataI = Purchase::where(DB::raw("concat(purchase_number)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->limit(10)->get();
    $dataI = Purchase::join('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
      ->where(DB::raw("concat(purchases.purchase_number)"), 'LIKE', '%' . $qsearch . '%')
      ->whereRaw('purchase_items.quantity > purchase_items.receive_qty')
      ->select('purchases.*')
      ->distinct()
      ->limit(10)
      ->get();
    echo json_encode($dataI);
  }

  public function list_item(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $qsearch  =  $request->term;
    $dataI    = Item::where(DB::raw("concat(item_name, hsncode, internal_item_name, item_code)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->with('UnitType')->with('ItemType')->limit(10)->get();
    // echo "<pre>";  print_r($dataI->UnitType); exit;
    echo json_encode($dataI);
  }

  public function list_item_type(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $qsearch  =  $request->term;
    $type      =  $request->type;
    $dataI    = Item::where('item_type_id', '=', $type)->where(DB::raw("concat(item_name, hsncode, internal_item_name, item_code)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->with('UnitType')->with('ItemType')->limit(10)->get();

    // echo "<pre>";  print_r($dataI); exit;

    echo json_encode($dataI);
  }

  public function fabric_list_item(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $qsearch  =  $request->term;
    $dataI    = Item::where('item_type_id', '=', '8')->where(DB::raw("concat(item_name, hsncode, internal_item_name, item_code)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->with('UnitType')->limit(10)->get();

    echo json_encode($dataI);
  }

  public function list_customer(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $qsearch  =  $request->term;
    $dataI = Individual::where(DB::raw("concat(name, email)"), 'LIKE', '%' . $qsearch . '%')->where('type', '=', 'customers')->with('IndividualBillingAddress')->with('IndividualShipingAddress')->where('status', '=', '1')->limit(10)->get();
    // echo "<pre>";  print_r($dataI['0']->IndividualAddress->address_1); exit;
    echo json_encode($dataI);
  }

  public function list_saleOrderNumer(Request $request)
  {
    $qsearch  =  $request->term;
    $dataI = SaleOrder::where(DB::raw("concat(sale_order_id)"), 'LIKE', '%' . $qsearch . '%')->get();
    echo json_encode($dataI);
  }

  public static function getSaleOrd($sonumId)
  {
    $dataI = SaleOrder::where('sale_order_id', '=', $sonumId)->first();
    return $dataI;
  }

  public function search_vendor_address(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;

    $individualId =  $request->individualId;
    $dataI = IndividualAddress::where('individual_id', '=', $individualId)->where('address_type', '=', 'b')->where('status', '=', '1')->get();

    $compData = DB::table('companies')->where('id', '=', '1')->first();
    $compState  = $compData->state_id;
    $str = "";
    $str .= '<input type="hidden" required name="com_state" id="com_state" value="' . $compState . '">';
    foreach ($dataI as $dataV) {
      $ind_add_id = $dataV->ind_add_id;
      $address_1   = $dataV->address_1;
      $address_2   = $dataV->address_2;
      $state_id   = $dataV->state_id;
      $stateName   = static::getStateName($state_id);
      $cityName   = $dataV->city;
      $zipCode   = $dataV->zip_code;


      $str .= '<input type="radio" onClick="calcAddress(' . $state_id . ')" required name="ind_add_id" value="' . $ind_add_id . '"> ' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . "<br/>";
      $str .= '<input type="hidden" required name="address" value="' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . '">';
      // $str.='<input type="text" required name="state" id="state" value="'.$state_id.'">';

    }
    return $str;
  }

  public function search_customer_bill_address(Request $request)
  {
    $individualId = $request->individualId;
    $dataI = IndividualAddress::where('individual_id', $individualId)
      ->where('address_type', 'b')
      ->where('status', '1')
      ->get();

    $compData = DB::table('companies')->find(1);
    $compState = $compData->state_id;
    $str = '<input type="hidden" required name="state" id="state" value="' . $compState . '">';

    foreach ($dataI as $dataV) {
      $ind_add_id  = $dataV->ind_add_id;
      $address_1   = $dataV->address_1;
      $address_2   = $dataV->address_2;
      $state_id    = $dataV->state_id;
      $stateName   = static::getStateName($state_id);
      $cityName    = $dataV->city;
      $zipCode     = $dataV->zip_code;
      $Isdefault   = $dataV->default_address;
      $default     = $Isdefault ? 'checked' : '';
      $str .= '<input type="radio" ' . $default . ' onClick="calcAddress(' . $state_id . ')" required name="ind_add_id" value="' . $ind_add_id . '"> ' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . "<br/>";
      $str .= '<input type="hidden" required name="address" value="' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . '">';
    }

    return $str;
  }


  public function search_item_type(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;



  }

  public function search_customer_ship_address(Request $request)
  {
    $individualId = $request->individualId;
    $dataI = IndividualAddress::where('individual_id', $individualId)
      ->where('address_type', 's')
      ->where('status', '1')
      ->get();
    $compData = DB::table('companies')->find(1);
    $compState = $compData->state_id;
    $str = "";
    foreach ($dataI as $dataV) {
      $ind_add_id = $dataV->ind_add_id;
      $address_1   = $dataV->address_1;
      $address_2   = $dataV->address_2;
      $state_id   = $dataV->state_id;
      $stateName   = static::getStateName($state_id);
      $cityName   = $dataV->city;
      $zipCode   = $dataV->zip_code;
      $Isdefault  = $dataV->default_address;
      $default    = $Isdefault ? 'checked' : '';

      $str .= '<input type="radio" ' . $default . ' onClick="calcAddresss(' . $state_id . ')" required name="ind_add_id_ship" value="' . $ind_add_id . '"> ' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . "<br/>";
      $str .= '<input type="hidden" required name="shiping_address" value="' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . '">';
    }

    return $str;
  }

  public function search_customer_addressBilling(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;

    $individualId =  $request->individualId;
    $dataI = IndividualAddress::where('individual_id', '=', $individualId)->where('address_type', '=', 'b')->where('status', '=', '1')->get();

    $compData = DB::table('companies')->where('id', '<=', '1')->first();
    $compState  = $compData->state_id;
    $str = "";
    $str .= '<input type="hidden" required name="state" id="state" value="' . $compState . '">';
    foreach ($dataI as $dataV) {
      $ind_add_id = $dataV->ind_add_id;
      $address_1   = $dataV->address_1;
      $address_2   = $dataV->address_2;
      $state_id   = $dataV->state_id;
      $stateName   = static::getStateName($state_id);
      $cityName   = $dataV->city;
      $zipCode   = $dataV->zip_code;


      $str .= '<input type="radio" onClick="calcAddress(' . $state_id . ')" required name="ind_add_id" value="' . $ind_add_id . '"> ' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . "<br/>";
      $str .= '<input type="hidden" required name="address" value="' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . '">';
    }
    return $str;
  }

  public function search_customer_addressShipping(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;

    $individualId =  $request->individualId;
    $dataI = IndividualAddress::where('individual_id', '=', $individualId)->where('address_type', '=', 's')->where('status', '=', '1')->get();

    $compData = DB::table('companies')->where('id', '<=', '1')->first();
    $compState  = $compData->state_id;
    $str = "";
    $str .= '<input type="hidden" required name="state" id="state" value="' . $compState . '">';
    foreach ($dataI as $dataV) {
      $ind_add_id = $dataV->ind_add_id;
      $address_1   = $dataV->address_1;
      $address_2   = $dataV->address_2;
      $state_id   = $dataV->state_id;
      $stateName   = static::getStateName($state_id);
      $cityName   = $dataV->city;
      $zipCode   = $dataV->zip_code;


      $str .= '<input type="radio" onClick="calcAddress(' . $state_id . ')" required name="ind_add_id1" value="' . $ind_add_id . '"> ' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . "<br/>";
      $str .= '<input type="hidden" required name="addressShipping" value="' . $address_1 . ' ' . $address_2 . ' ' . $stateName . ' ' . $cityName . ' ' . $zipCode . '">';
    }
    return $str;
  }

  public static function getWCName($WCId)
  {
    error_reporting(0);
    // echo "<pre>";  print_r($request->all()); exit;
    $data = Warehouse::where('id', $WCId)->first();
    return $data->warehouse_name;
  }

  public static function getEmpName($EId)
  {
    error_reporting(0);
    $data = Individual::where('id', $EId)->first();
    return $data->name;
  }

  public static function fabricFaultReason($Id)
  {
    $data = FabricFaultReason::where('id', $Id)->first();
    return $data->reason;
  }

  public static function store_notification($user_id = "", $model_name = "", $page_link = "", $message = "", $page_name = "")
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $Ip               = self::getIp();
    $objN                       = new Notification;
    $objN->user_id          = $user_id;
    $objN->model_name          = $model_name;
    $objN->page_link          = $page_link;
    $objN->message            = $message;
    $objN->page_name          = $page_name;
    $objN->ip_address          = $Ip;
    $objN->server_details        = $_SERVER['HTTP_USER_AGENT'];  // serialize($_SERVER);		
    $objN->status              = 1;
    $objN->created          = date("Y-m-d H:i:s");
    $objN->modified            = date("Y-m-d H:i:s");
    $is_savedN               = $objN->save();
  }

  public function list_warehouse_compartment(Request $request)
  {
    // echo "<pre>";  print_r($request->all()); exit;
    $qsearch  =  $request->term;
    $dataI = WarehouseCompartment::where(DB::raw("concat(warehousename)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->with('Warehouse')->get(); // echo "<pre>";  print_r($dataI['0']->Warehouse->warehouse_name); exit;
    echo json_encode($dataI);
  }


  public static function getProcessTypeName($id)
  {
    error_reporting(0);
    $arrayAProcess = array(
      '1' => array(
        'input'  => array('Yarn'),
        'output' => 'Beam',
        'process' => 'Warping',
        'id' => '1',
        'shortcode' => 'W',
        'unit' => 'Quantity',
      ),
      '2' => array(
        'input'  => array('Beam', 'Water'),
        'output' => 'Greige',
        'process' => 'Weaving',
        'id' => '2',
        'shortcode' => 'V',
        'unit' => 'Meter',
      ),
      '3' => array(
        'input'  => array('Greige', 'Chemical', 'Color'),
        'output' => 'Dyed',
        'process' => 'Dyeing',
        'id' => '3',
        'shortcode' => 'D',
        'unit' => 'Meter',
      ),
      '4' => array(
        'input'  => array('Dyed', 'Chemical'),
        'output' => 'Coated',
        'process' => 'Coating',
        'id' => '4',
        'shortcode' => 'C',
        'unit' => 'Meter',
      ),
      '5' => array(
        'input'  => array('Tape', 'Box'),
        'output' => 'Dispatch',
        'process' => 'Packaging',
        'id' => '4',
        'shortcode' => 'C',
        'unit' => 'Meter',
      ),
    );


    return $arrayAProcess[$id];
  }


  public static function getProcessName($id)
  {
    error_reporting(0);
    $arrayAProcess = array(
      'warping' => array(
        'input'  => array('Yarn'),
        'output' => 'Beam',
        'id' => '1',
        'shortcode' => 'B',
      ),
      'weaving' => array(
        'input'  => array('Beam', 'Water'),
        'output' => 'Greige',
        'id' => '2',
        'shortcode' => 'W',
      ),
      'Dyeing' => array(
        'input'  => array('Greige', 'Chemical', 'Color'),
        'output' => 'Dyed',
        'id' => '3',
        'shortcode' => 'D',
      ),
      'Coating' => array(
        'input'  => array('Dyed', 'Chemical'),
        'output' => 'Coated',
        'id' => '4',
        'shortcode' => 'C',
      ),
    );

    $dataI = ProcessItem::where('id', '=', $id)->where('status', '=', '1')->first();
    $proArr = array();
    $proArr['entry_name']   = $dataI->entry_name;
    $proArr['process_name'] = $dataI->process_name;
    $proArr['output_name']   = $dataI->output_name;

    return $proArr['process_name'];
  }

  public static function WorkProcessRequirementData($id)
  {
    error_reporting(0);
    $dataI = WorkProcessRequirement::where('work_order_id', '=', $id)->where('status', '=', '1')->where('is_accept', '=', '0')->first();

    $proArr = array();
    $proArr['id']             = $dataI->id;
    $proArr['process_type_id']       = $dataI->process_type_id;
    $proArr['item_type_id']       = $dataI->item_type_id;
    $proArr['work_req_send_by']     = $dataI->work_req_send_by;
    $proArr['quantity']         = $dataI->quantity;
    $proArr['is_pro_acc_by_warehouse']   = $dataI->is_pro_acc_by_warehouse;
    $proArr['process_accepted_by']     = $dataI->process_accepted_by;
    $proArr['acc_deny_date']       = $dataI->acc_deny_date;


    return $dataI;
  }
  public static function getProcessOutPutName($id)
  {
    error_reporting(0);
    $dataI = ProcessItem::where('id', '=', $id)->where('status', '=', '1')->first();
    $proArr = array();
    $proArr['entry_name']   = $dataI->entry_name;
    $proArr['process_name'] = $dataI->process_name;
    $proArr['output_name']   = $dataI->output_name;

    return $proArr['output_name'];
  }

  public static function getLastProcessItemStock($processId)
  {
    if (!empty($processId)) {
      $dataI   = WarehouseItem::where('process_type_id', '=', $processId)->where('status', '=', '1')->first();
      $qty = $dataI->item_qty;
    } else $qty = 0;
    return $qty;
    // echo "<pre>";  print_r($dataI); // exit;

  }

  public static function getWarehouseAvailableItemStockArray($itemId, $itemTypeId)
  {
    $query = WarehouseItemStock::where('item_id', $itemId)
      ->where('item_type_id', $itemTypeId)
      ->where('entry_type', 'IN')
      ->where('is_allotted_stock', 'No')
      ->where('status', 1);

    /*
		$sql = $query->toSql();
		$bindings = $query->getBindings();
		$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
		echo $fullSql;
		 */
    $dataWIS = $query->get();
    return $dataWIS;
  }

  public static function getWarehouseAvailableItemStockBeam($itemId, $itemTypeId)
  {
    $query = WarehouseItemStock::select(DB::raw('*'), DB::raw('SUM(insp_bal_quan_size) AS total_item_qty'))
      ->where('item_id', $itemId)
      ->where('item_type_id', $itemTypeId)
      ->where('entry_type', 'IN')
      ->where('is_allotted_stock', 'No')
      ->where('status', 1);

    $dataWIS = $query->first();
    return $dataWIS ? $dataWIS->total_item_qty : 0;
  }









  public static function getWarehouseAvailableDyingItemStockArray($itemId, $itemTypeId, $dyingColor)
  {
    $query = WarehouseItemStock::where('item_id', $itemId)
      ->where('item_type_id', $itemTypeId)
      ->where('dyeing_color', $dyingColor)
      ->where('entry_type', 'IN')
      ->where('is_allotted_stock', 'No')
      ->where('status', 1);

    /*
		$sql = $query->toSql();
		$bindings = $query->getBindings();
		$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
		echo $fullSql;
		 */

    $dataWIS = $query->get();

    return $dataWIS;
  }

  public static function getWarehouseAvailableCoatingItemStockArray($itemId, $itemTypeId, $coating)
  {
    $query = WarehouseItemStock::where('item_id', $itemId)
      ->where('item_type_id', $itemTypeId)
      ->where('coated_pvc', $coating)
      ->where('entry_type', 'IN')
      ->where('is_allotted_stock', 'No')
      ->where('status', 1);

    /*	$sql = $query->toSql();
				$bindings = $query->getBindings();
				$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
				echo $fullSql;
			*/

    $dataWIS = $query->get();
    return $dataWIS;
  }

  public static function WarehouseItemStockArray($itemId, $wisId, $quanTity)
  {
    $query = WarehouseItemStock::where('item_id', '=', $itemId);

    if (!empty($wisId)) {
      $query->where('wis_id', '=', $wisId);
    }

    $query->where('entry_type', '=', 'IN')
      ->where('is_allotted_stock', '=', 'No')
      ->where('status', '=', '1')
      ->limit($quanTity);

    $dataWIS = $query->get();
    return $dataWIS;
  }

  public static function searchProcess($processItemId)
  {
    $dataI   = WarehouseItem::where('process_type_id', '=', $processItemId)->where('status', '=', '1')->with('ItemType')->first();
    echo "<pre>";
    print_r($dataI);
    exit;
  }
  // added by Dinesh on 18-10-2023
  public static function getStockItem($itemId)
  {
    $dataI   = WarehouseItemStock::where('item_id', '=', $itemId)->where('status', '=', '1')->where('is_allotted_stock', '=', 'No')->count();
    if (!empty($dataI))  return   $qty =  $dataI;
    else return  0;
  }


  public static function getWarehouseItemStockById($wisId)
  {
    $dataI = WarehouseItemStock::where('wis_id', $wisId)->where('status', '1')->where('is_allotted_stock', '=', 'No')->first();
    // echo "<pre>"; print_r($dataI); 
    return $dataI ? $dataI->insp_bal_quan_size : 0;
  }


  public static function getBalanceStockById($Id)
  {
    $result = WarehouseBalanceItem::find($Id);
    return $result ? $result->item_qty : null;
  }

  public static function getTotalAvailableStockByItem($itemId, $itemTypeId)
  {
    $result = DB::table('warehouse_balance_items')
      ->select('*')
      ->where('item_type_id', $itemTypeId)
      ->where('item_id', $itemId)
      ->where('status', '1')
      ->where('balance_status', '1')
      ->where('item_qty', '>', '0')
      ->orderByDesc('id')
      ->get();

    return $result ? $result->toArray() : [];
  }

  public static function getTotalAvalableStockItem($itemId, $itemTypeId)
  {

    $result = DB::table('warehouse_balance_items')
      ->select(DB::raw('*'), DB::raw('SUM(item_qty) AS total_item_qty'))
      ->where('item_type_id', $itemTypeId)
      ->where('item_id', $itemId)
      ->where('status', '1')
      ->where('balance_status', '1')
      ->groupBy('item_id', 'item_type_id')
      ->orderByDesc('id')
      ->limit(1)
      ->first();
    // echo "<pre>"; print_r($result); // exit;		

    if ($result) return $totalStock = $result->total_item_qty;
    else return  0;
  }



  public static function getTotalAvailableItemStock($itemId, $itemTypeId)
  {
    $result = WarehouseItemStock::select(DB::raw('SUM(quantity) as totStock'))
      ->where('item_id', '=', $itemId)
      ->where('item_type_id', '=', $itemTypeId)
      ->where('is_allotted_stock', '=', 'No')
      ->where('status', '=', 1)
      ->first();
    if ($result) return $totalStock = $result->totStock;
    else return  0;
  }



  public static function getYarnItem($itemId)
  {
    $dataI   = Item::where('item_id', '=', $itemId)->where('status', '=', '1')->where('item_type_id', '=', '1')->get();
    return $dataI;
  }

  public static function getWareHouseNameByItemStock($itemId, $processId)
  {
    error_reporting(0);
    // $dataI 	= WarehouseItem::where('process_type_id', '=', $processId)->where('item_id', '=', $itemId)->with('Warehouse')->with('WarehouseCompartment')->where('status', '=', '1')->first();
    $dataI   = WarehouseItem::where('item_id', '=', $itemId)->with('Warehouse')->with('WarehouseCompartment')->where('status', '=', '1')->first();
    $warehouseName = $dataI['Warehouse']->warehouse_name;
    $warehouseCompartName = $dataI['WarehouseCompartment']->warehousename;

    $result = [];
    $result['Warehouse']       = $warehouseName;
    $result['WarehouseCompartment'] = $warehouseCompartName;
    return $result;
  }


  public static function getWareHouseNameByItemStockId_old($wisId)
  {
    $warehouseItemId     = WarehouseItemStock::where('wis_id', '=', $wisId)->where('is_allotted_stock', '=', 'No')->value('warehouse_item_id');
    $dataWI          = WarehouseItem::where('id', '=', $warehouseItemId)->where('status', '=', '1')->first();
    $warehouseId         = $dataWI->warehouse_id;
    $warehouseCompId      = $dataWI->ware_comp_id;
    $warehouseName       = Warehouse::where('id', '=', $warehouseId)->value('warehouse_name');
    $warehouseCompartName   = WarehouseCompartment::where('id', '=', $warehouseCompId)->value('warehousename');


    $result = [];
    $result['Warehouse']       = $warehouseName;
    $result['WarehouseCompartment'] = $warehouseCompartName;
    return $result;
  }

  public static function getWareHouseNameByItemStockId($wisId)
  {
    $warehouseItemId = WarehouseItemStock::where('wis_id', '=', $wisId)->where('is_allotted_stock', '=', 'No')->value('warehouse_item_id');
    $dataWI = WarehouseItem::where('id', '=', $warehouseItemId)->where('status', '=', '1')->first();
    if (!$dataWI) {
      return [];
    }
    $warehouseId       = $dataWI->warehouse_id;
    $warehouseCompId     = $dataWI->ware_comp_id;
    $warehouseName       = Warehouse::where('id', '=', $warehouseId)->value('warehouse_name');
    $warehouseCompartName   = WarehouseCompartment::where('id', '=', $warehouseCompId)->value('warehousename');
    if (!$warehouseName || !$warehouseCompartName) {
      return [];
    }
    $result = [
      'Warehouse'       => $warehouseName,
      'WarehouseCompartment'   => $warehouseCompartName,
    ];
    return $result;
  }











  public static function genrateRandomPacketNumber($itemTypeId, $wItemId)
  {
    error_reporting(0);
    $itemD     = ItemType::where('item_type_id', $itemTypeId)->first();
    $myString   = strtolower($itemD->item_type_name);
    $firstTwo   = substr($myString, 0, 2);
    $result = $firstTwo . $wItemId;
    return $result;
  }

  public static function check_warehouse_item_type_balancettt($itemId, $itemTypeId, $unitTypeId)
  {
    $result = WarehouseBalanceItem::select(DB::raw('SUM(item_qty) as tot'))
      ->where('item_type_id', '=', $itemTypeId)
      ->where('unit_type_id', '=', $unitTypeId)
      ->where('item_id', '=', $itemId)
      ->groupBy('item_id', 'item_type_id')
      ->get();

    $sql = $result->toSql();
    $bindings = $result->getBindings();
    $fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings);
    echo $fullSql;

    /*
			if ($result->count() > 0) {
				$total = $result[0]->tot;
				return $total;
			} else {
				return 0;  
			}
		
		*/
  }

  public static function check_warehouse_item_type_balance($itemId, $itemTypeId, $unitTypeId)
  {
    $result = WarehouseBalanceItem::select(DB::raw('SUM(item_qty) as tot'))
      ->where('item_type_id', '=', $itemTypeId)
      ->where('unit_type_id', '=', $unitTypeId)
      ->where('item_id', '=', $itemId)
      ->where('balance_status', '=', 1)
      ->groupBy('item_id', 'item_type_id')
      ->first();

    if ($result) {
      $total = $result->tot;
      return $total;
    } else {
      return 0;
    }


    /*	
			$sql = $query->toSql();
			$bindings = $query->getBindings();
			$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
			echo $fullSql;
		*/
  }





  public static function check_warehouse_greige_type_balance($itemId, $itemtypeId)
  {
    if ($itemtypeId == '8') $itemtypeId = 3;
    $query = WarehouseBalanceItem::select(DB::raw('SUM(item_qty) as tot'))
      ->where('item_type_id', '=', $itemtypeId)
      ->where('item_id', '=', $itemId)
      ->where('dyeing_color', '=', '')
      ->where('coated_pvc', '=', '')
      ->where('balance_status', '=', '1')
      ->groupBy('item_id', 'item_type_id');

    /* 
			$sql = $query->toSql();
			$bindings = $query->getBindings();
			$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
			echo $fullSql; exit;
		*/

    $result = $query->first();
    //  echo "<pre>"; print_r($result); 				

    if (!empty($result['tot'])) return $result['tot'] . ' ' . 'Meter';
    else return '0' . ' ' . 'Meter';
  }

  public static function check_warehouse_dyeing_type_balance($itemId, $itemtypeId, $dyeingColor)
  {
    $itemtypeId = 4;
    $query = WarehouseBalanceItem::select(DB::raw('SUM(item_qty) as tot'))
      ->where('item_type_id', '=', $itemtypeId)
      ->where('item_id', '=', $itemId)
      ->where('dyeing_color', '=', $dyeingColor)
      ->where('balance_status', '=', '1')
      ->groupBy('dyeing_color');

    /* 
			$sql = $query->toSql();
			$bindings = $query->getBindings();
			$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
			echo $fullSql; exit;
		*/

    $result = $query->first();
    if (!empty($result['tot'])) return $result['tot'] . ' ' . 'Meter';
    else return '0' . ' ' . 'Meter';
  }

  public static function check_warehouse_coating_type_balance($itemId, $itemtypeId, $coatingPvc)
  {
    $itemtypeId = 5;
    $query = WarehouseBalanceItem::select(DB::raw('SUM(item_qty) as tot'))
      ->where('item_type_id', '=', $itemtypeId)
      ->where('item_id', '=', $itemId)
      ->where('coated_pvc', '=', $coatingPvc)
      ->where('balance_status', '=', '1')
      ->groupBy('coated_pvc');

    /* 
			$sql = $query->toSql();
			$bindings = $query->getBindings();
			$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings); 
			echo $fullSql; exit;
		*/

    $result = $query->first();
    //  echo "<pre>"; print_r($result); 		

    // $total = $result['tot'];
    if (!empty($result['tot'])) return $result['tot'] . ' ' . 'Meter';
    else return '0' . ' ' . 'Meter';
  }


  public static function subUserSelect($selval = NULL)
  {

    $str = "<option value=''>--Select User --</option>";

    $res = User::get();
    foreach ($res as $row) {
      $userId = $row->id;
      $userName = $row->name;
      $str .= "<option value='" . $row->id . "'";
      if ($userId == $selval) {
        $str .= ' selected';
      }
      $str .= ">" . $userName . "</option>";
    }
    return $str;
  }

  public static function getAllPages($userId = null)
  {
    $pages = AllPage::where('status', 1)->get();
    $html = '';

    foreach ($pages as $page) {
      $pageId = $page->id;
      $model_name = $page->model_name;
      $page_title = $page->page_title;
      $userWebPage = UserWebPage::where('user_id', $userId)->where('page_id', $pageId)->first();
      $isChecked = $userWebPage ? 'checked' : '';

      // Create a separate div for each model_name
      if (!empty($model_name)) {
        $html .= "<div class='col-sm-12'><br><b>{$model_name}</b><br></div>";
      }
      $html .= "<div class='col-sm-3'>
				<input type='checkbox' name='page_id[]' id='page_id' value='{$pageId}' {$isChecked}>
				{$page_title}
			</div>";
    }

    return $html;
  }



  public static function getAllPagesName($userId)
  {
    error_reporting(0);
    $dataI = UserWebPage::where('user_id', '=', $userId)->orderByDesc('id')->get();
    $str = '';
    foreach ($dataI as $row) {
      $pageId = $row->page_id;
      $data   = AllPage::where('id', $pageId)->first();
      $page_title  = $data->page_title;

      $str .= $page_title . " | ";
    }
    return $str;
  }

  public static function getUserWebPage($userId)
  {
    error_reporting(0);
    $dataI = UserWebPage::where('user_id', '=', $userId)->first();
    return $dataI->id;
  }

  public static function machineName($machineId)
  {
    error_reporting(0);
    $dataI =  Machine::where('id', '=', $machineId)->first();
    return $dataI->name;
  }

  public static function checkPagePermission($page_name)
  {
    $dataP     = AllPage::where('page_name', 'LIKE', '%' . $page_name . '%')->where('status', 1)->first();
    $pageId   = $dataP->id;
    $userId     = Auth::id();
    $results   = UserWebPage::where('user_id', $userId)->where('page_id', $pageId)->first();
    if ($userId > 1) {
      if (empty($results->id)) {
        return 0;
      } else {
        return 1;
      }
    } else {
      return 1;
    }
  }

  public static function getPurchaseOrderItemTypeArr($purchaseId)
  {
    return $purchaseOrderItems = PurchaseOrderItem::where('purchase_id', $purchaseId)
      ->groupBy('item_type_id')
      ->get();
  }

  public static function getPurchaseOrderItemTypeCount($purchaseId)
  {
    return $count  = PurchaseOrderItem::where('purchase_id', $purchaseId)->count();
  }



  public static function getPurchaseItemTypeArr($purchaseId)
  {
    return $purchaseItems = PurchaseItem::where('purchase_id', $purchaseId)
      ->groupBy('item_type_id')
      ->get();
  }

  public static function getPurchaseItemTypeCount($purchaseId)
  {
    return $count  = PurchaseItem::where('purchase_id', $purchaseId)->count();
  }

  public static function getWorkOrderIdForSaleOrder($SaleOrditemId)
  {
    $result = [];
    $workOrderItems = WorkOrderItem::where('sale_order_item_id', $SaleOrditemId)->get();
    foreach ($workOrderItems as $workOrderItem) {
      $workOrder     = WorkOrder::where('work_order_id', $workOrderItem->work_order_id)->first();
      $process_type   = $workOrder->process_type;
      $process_sl_no   = $workOrder->process_sl_no;
      $result[] = $process_type . '' . $process_sl_no;
    }
    return implode('<br/>', $result);
  }


	public function list_transport(Request $request)
    {
		// echo "<pre>";  print_r($request->all()); exit;
		$qsearch  =  $request->term;
		$dataI = Individual::where(DB::raw("concat(name, email)"), 'LIKE', '%' . $qsearch . '%')
                  ->where('type', '=', 'transport')
                  ->where('status', '=', '1')
                  ->limit(10)
                  ->get();		 
		// echo "<pre>";  print_r($dataI['0']->IndividualAddress->address_1); exit;
		echo json_encode($dataI);

    }





  public static function getWorkOrderDetailFromSaleOrderItem($SaleOrditemId)
  {

    return $workOrderItems = WorkOrderItem::where('sale_order_item_id', $SaleOrditemId)->get();
  }

  public static function getWorkOrder($work_order_id)
  {

    return $workOrder = WorkOrder::where('work_order_id', $work_order_id)->first();
  }




  public static function getWorkOrderProcessId($workOrdId)
  {
    try {
      $workOrder = WorkOrder::where('work_order_id', $workOrdId)->first();
      if ($workOrder) {
        $process_type = $workOrder->process_type;
        $process_sl_no = $workOrder->process_sl_no;
        return $process_type . '' . $process_sl_no;
      } else {
        return 'WorkOrder not found';
      }
    } catch (\Exception $e) {
      return 'Error retrieving WorkOrder';
    }
  }

  public static function getWorkOrderItemDetails($workOrdId)
  {
    error_reporting(0);
    $res    = WorkOrderItem::where('work_order_id', $workOrdId)->first();

    return $res;
  }


  public static function getPurchaseDetails($purchId)
  {
    $purchaseDetails = Purchase::where('id', $purchId)->first();
    return $purchaseDetails;
  }


  public static function checkWorkInspection($wId)
  {
    $wId = WorkInspection::where('work_order_id', $wId)->first();
    return $wId->id;
  }

  public static function getWorkOrderDyingArray($workOrderId)
  {
    $woiSql = WorkOrderItem::select('dyeing_color')->where('work_order_id', $workOrderId)->groupBy('dyeing_color')->get();
    $wiArr  = [];
    foreach ($woiSql as $row) {
      $value = strtolower(trim($row->dyeing_color));
      if ($value !== 'no' && $value !== 'not' && $value !== '') {
        $wiArr[] = $row->dyeing_color;
      }
    }
    return $wiArr;
  }



  public static function convert_number($number)
  {
    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
      '0' => '', '1' => 'one', '2' => 'two',
      '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
      '7' => 'seven', '8' => 'eight', '9' => 'nine',
      '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
      '13' => 'thirteen', '14' => 'fourteen',
      '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
      '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
      '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
      '60' => 'sixty', '70' => 'seventy',
      '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
      $divider = ($i == 2) ? 10 : 100;
      $number = floor($no % $divider);
      $no = floor($no / $divider);
      $i += ($divider == 10) ? 1 : 2;
      if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str[] = ($number < 21) ? $words[$number] .
          " " . $digits[$counter] . $plural . " " . $hundred
          :
          $words[floor($number / 10) * 10]
          . " " . $words[$number % 10] . " "
          . $digits[$counter] . $plural . " " . $hundred;
      } else $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
      " and " . $words[$point / 10] . " " .
      $words[$point = $point % 10] : '';
    // return $result . "Rupees  " . $points . " Paise";
    return ucwords($result);
  }

  public function find_saleOrderNumer(Request $request)
  {
    $qsearch  =  $request->term;
    //dd($qsearch);
    //\DB::enableQueryLog();
    $dataI = SaleOrder::where('sale_order_number', 'like', '%' .$qsearch. '%')->get();
    //dd(\DB::getQueryLog());
    echo json_encode($dataI);
  }
}
