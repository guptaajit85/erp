<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\User;
use App\Models\Individual;
use App\Models\PurchaseItem;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Models\WarehouseCompartment;
use App\Models\WorkOrder;
use App\Models\WorkProcessRequirement;
use App\Models\WorkPurchaseRequirement;
use App\Models\Item;
use App\Models\WorkOrderItem;
use Validator, Auth, Session, Hash;
use App\Http\Controllers\CommonController;



class WorkPurchaseRequirementController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }


  public function index(Request $request)
  {
    error_reporting(0);
    $qnamesearch     = trim($request->qnamesearch);
    $item_type    = trim($request->item_type);
    $qworkordersearch     = trim($request->qworkordersearch);
    $qsalesearch     = trim($request->qsalesearch);
    $qworkrequestsearch     = trim($request->qworkrequestsearch);
    //dd($qworkordersearch);
    $first_character = substr($qworkordersearch, 0, 1);
    //dd($first_character);
    $strlen = strlen($qworkordersearch);
    $remaining_character = substr($qworkordersearch, 1, $strlen);
    //dd($remaining_character);
    $dataIT     = ItemType::where('status', '=', '1')->get();
    //$dataWPR = WorkPurchaseRequirement::where('status', '=', '1')->orderByDesc('id')->paginate(20);
    $query = WorkPurchaseRequirement::where('status', '=', '1')->orderByDesc('id');
    if (!empty($qnamesearch)) {
      $itemIds = Item::where(DB::raw("CONCAT(item_name, ' ', internal_item_name)"), 'LIKE', '%' . $qnamesearch . '%')->where('status', '=', '1')->pluck('item_id')->implode(',');
      $query->whereIn('item_id', explode(',', $itemIds));
    }
    if (!empty($item_type)) {
      $itemType = explode(',', $item_type);
      $query->whereIn('item_type_id', $itemType);
    }
    if (!empty($qworkordersearch)) {
      //\DB::enableQueryLog();
      $workOrderIds = WorkOrder::where(DB::raw("process_type"), 'LIKE', '%' . $first_character . '%')->where(DB::raw("process_sl_no"), 'LIKE', '%' . $remaining_character . '%')->where('status', '=', '1')->pluck('work_order_id')->implode(',');
      //dd($workOrderId);
      //dd(\DB::getQueryLog());     
      $query->whereIn('work_order_id', explode(',', $workOrderIds));
    }
    if (!empty($qsalesearch)) {
      $ordNumSearchArray = explode(',', $qsalesearch);
      $workOrderIds = WorkOrderItem::whereIn('sale_order_id', $ordNumSearchArray)->pluck('work_order_id');
      $query->whereIn('work_order_id', $workOrderIds);
      //dd($workOrderIds);
    }
    if (!empty($qworkrequestsearch)) {
      $individualIds = Individual::where(DB::raw("name"), 'LIKE', '%' . $qworkrequestsearch . '%')->where('status', '=', '1')->pluck('id')->implode(',');
      $query->whereIn('purchase_req_send_by', explode(',', $individualIds));
    }
    //dd($itemType);
    //  echo "<pre>"; print_r($dataWPR); exit;
    //\DB::enableQueryLog();
    $dataWPR = $query->paginate(20);
    //dd(\DB::getQueryLog());
    //dd($dataWPR);	
    return view('html.workpurchaserequirements.show-work-purchase-requirement', compact("dataWPR", "qnamesearch", "item_type", "qworkordersearch", "qsalesearch", "qworkrequestsearch", "dataIT"));
  }

  public function create()
  {
    //  error_reporting(0);	 

    //  echo "<pre>"; print_r($dataWPR); exit;

    $dataIT = ItemType::where('status', '=', '1')->where('is_purchase', '=', '1')->get();
    $dataI  = Individual::where('type', '=', 'agents')->where('status', '=', '1')->get();
    $dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();

    return view('html.workpurchaserequirements.add-purchase-request', compact("dataIT", "dataI", "dataUT"));
  }


  public function add_work_purchase_requisition(Request $request)
  {
    $userId = Auth::id();
    $userD = User::find($userId);
    $IndId = $userD->individual_id;

    $request->validate([
      'work_order_id' => 'required|numeric',
      'pur_remark' => 'required|string',
      'wpr_id.*' => 'required|numeric',
      'item_id.*' => 'required|numeric',
      'item_name.*' => 'required|string',
      'item_quan.*' => 'required|numeric',
    ], [
      'work_order_id.required' => 'Work Order ID is required.',
      'work_order_id.numeric' => 'Work Order ID must be a number.',
      'pur_remark.required' => 'Purchase Remark is required.',
      'pur_remark.string' => 'Purchase Remark must be a string.',
      'wpr_id.*.required' => 'WPR ID is required for all items.',
      'wpr_id.*.numeric' => 'WPR ID must be a number for all items.',
      'item_id.*.required' => 'Item ID is required for all items.',
      'item_id.*.numeric' => 'Item ID must be a number for all items.',
      'item_name.*.required' => 'Item Name is required for all items.',
      'item_name.*.string' => 'Item Name must be a string for all items.',
      'item_quan.*.required' => 'Item Quantity is required for all items.',
      'item_quan.*.numeric' => 'Item Quantity must be a number for all items.',
    ]);

    $workOrderId   = $request->work_order_id;
    $pur_remark   = $request->pur_remark;
    $wpr_id_arr   = $request->wpr_id;
    $item_id_arr   = $request->item_id;
    $item_name_arr   = $request->item_name;
    $item_quan_arr   = $request->item_quan;

    $data = [];
    foreach ($wpr_id_arr as $itemidk => $row) {
      $wprId       = $wpr_id_arr[$itemidk];
      $itemId     = $item_id_arr[$itemidk];
      $itemName     = $item_name_arr[$itemidk];
      $itemqty     = $item_quan_arr[$itemidk];
      $dataWPR     = WorkProcessRequirement::find($wprId);
      $procesTypeId   = $dataWPR->process_type_id;
      $itemTypeId   = $dataWPR->item_type_id;
      $workOrderId   = $dataWPR->work_order_id;

      $data[] = [
        'work_order_id' => $workOrderId,
        'item_id' => $itemId,
        'process_type_id' => $procesTypeId,
        'item_type_id' => $itemTypeId,
        'purchase_req_send_by' => $IndId,
        'quantity' => $itemqty,
        'pur_remark' => $pur_remark,
        'status' => 1,
        'created' => now(),
      ];
      $obj2 = WorkProcessRequirement::find($wprId);
      $obj2->is_pro_acc_by_warehouse   = 'No';
      $obj2->process_deny_by       = $IndId;
      $obj2->acc_deny_date       = now();
      $is_saved2             = $obj2->save();
    }

    $res = WorkPurchaseRequirement::insert($data);
    if ($res) {
      $obj3 = WorkOrder::where('work_order_id', '=', $workOrderId)->update(['is_work_require_request_accepted' => 'No']);
      Session::put('message', 'Purchase request sent successfully.');
      Session::put("messageClass", "successClass");
      return redirect()->back()->withInput();
    } else {
      Session::put('message', 'Something went wrong.');
      Session::put("messageClass", "errorClass");
      return redirect()->back()->withInput();
    }
  }



  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'pur_type_arr.*' => 'required|numeric',
      'pro_id_arr.*' => 'required|numeric',
      'product_name_arr.*' => 'required|string',
      'hsn_arr.*' => 'required|numeric',
      'qty_arr.*' => 'required|numeric',
      'unit_arr.*' => 'required|numeric',
    ]);
    if ($validator->fails()) {
      $error = $validator->errors()->first();
      Session::put('message', $validator->messages()->first());
      Session::put("messageClass", "errorClass");
      return redirect()->back()->withInput();
      // return redirect()->back()->withErrors($validator)->withInput();
    }
    $userId   = Auth::id();
    $userD     = User::find($userId);
    $IndId     = $userD->individual_id;
    $dataToInsert = [];
    foreach ($request->pur_type_arr as $key => $value) {
      $dataToInsert[] = [
        'item_type_id'   => $request->pur_type_arr[$key],
        'item_id'   => $request->pro_id_arr[$key],
        'item_name' => $request->product_name_arr[$key],
        //'hsn' 		=> $request->hsn_arr[$key],	
        'quantity'     => $request->qty_arr[$key],
        'unit_type_id'   => $request->unit_arr[$key],
        'meter'   => $request->meter_arr[$key],
        'purchase_req_send_by'   => $IndId,
        'pur_remark'   => $request->remarks_arr[$key],
      ];
    }
    $res = WorkPurchaseRequirement::insert($dataToInsert);
    if ($res) {
      Session::put('message', 'Purchase request sent successfully.');
      Session::put("messageClass", "successClass");
      return redirect()->back()->withInput();
    } else {
      Session::put('message', 'Something went wrong.');
      Session::put("messageClass", "errorClass");
      return redirect()->back()->withInput();
    }
  }



  public function AcceptWarehouseItemReq(Request $request)
  {
    $FId      = $request->FId;
    $userId   = Auth::id();
    $userD     = User::find($userId);
    $IndId    = $userD->individual_id;

    $obj   = WorkPurchaseRequirement::find($FId);
    $obj->is_pro_acc_by_manager  = 'Yes';
    $obj->process_accepted_by     = $IndId;
    $obj->acc_deny_date           = now();
    $obj->save();


    return response()->json([
      'message' => 'Warehouse item request accepted successfully.',
      'processAcceptedBy' => $userD->name,
    ]);
  }
  public function DenyWarehouseItemReq(Request $request)
  {
    $FId      = $request->FId;
    $userId   = Auth::id();
    $userD     = User::find($userId);
    $IndId    = $userD->individual_id;

    $obj   = WorkPurchaseRequirement::find($FId);
    $obj->is_pro_acc_by_manager  = 'No';
    $obj->process_accepted_by     = $IndId;
    $obj->acc_deny_date           = now();
    $obj->save();


    return response()->json([
      'message' => 'Warehouse item request denied successfully.',
      'processAcceptedBy' => $userD->name,
    ]);
  }
}
