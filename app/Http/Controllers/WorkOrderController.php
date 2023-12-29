<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\ItemType;
use App\Models\Item;
use App\Models\UnitType;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderItemDetail;
use App\Models\SaleOrder;
use App\Models\ProcessItem;
use App\Models\WarehouseItem;
use App\Models\WarehouseItemStock;
use App\Models\SaleOrderItem;
use App\Models\WorkInspection;
use App\Models\Individual;
use App\Models\Machine;
use App\Models\Company;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\FabricFaultReason;
use App\Models\ProcessRequirement;
use App\Models\WorkProcessRequirement;
use App\Models\ItemYarnRequirement;
use App\Models\GatePass;
use App\Models\WarehouseBalanceItem;
use Validator, Auth, Session, Hash;
use App\Http\Controllers\CommonController;

class WorkOrderController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
	  // echo "<pre>";  print_r($request->all()); exit;
		$cusSearch 		= trim($request->cus_search);
		$individualId 	= trim($request->individual_id);
		$itemSearch 	= trim($request->item_search);
		$ordNumSearch 	= trim($request->ordNumSearch);
    //$qsaleOrderId=$request->qsaleOrderId;
		$priority 		= trim($request->priority);
		$search_process_id = $request->search_process_id;
		//dd($request->all());
		//dd(count($search_process_id));
    //dd($search_process_id);
    $fromDate 		= $request->from_date;
		$toDate 		= $request->to_date;
		if (!empty($search_process_id)) {
			$search_process_filter =  array_filter($search_process_id);
			$arrr = count($search_process_filter);
		}
		//echo "<pre>"; print_r($arrr); exit; 
		//dd($search_process_id);
		// $worSqlRes = WorkOrder::where('status', '=', '1')->with('WorkReqSend')->orderByDesc('work_order_id')->get(); 

		$query = WorkOrder::where('status', '=', '1')->with('WorkOrderItem')->with('ProcessType')->with('GatePass')->with('Item')->with('WorkReqSend')->with('GatepassGenratedByWarehouseUser')->orderByDesc('work_order_id');

		if (!empty($cusSearch)) {
			$workorderids = WorkOrderItem::where('customer_id', '=', $individualId)->where('status', '=', '1')->pluck('work_order_id')->implode(',');
			$query->whereIn('work_order_id', explode(',', $workorderids));
		}

		if (!empty($itemSearch)) {
			// echo "dffdfdf"; exit;
			$query->where(DB::raw("concat(item_name)"), 'LIKE', '%' . $itemSearch . '%');
		}

    if (!empty($ordNumSearch)) {
      $saleOrderId = SaleOrder::where('sale_order_number', '=', $ordNumSearch)->pluck('sale_order_id');
      //dd($saleOrderId);
			$workorderids = WorkOrderItem::whereIn('sale_order_id', $saleOrderId)->where('status', '=', '1')->pluck('work_order_id')->implode(',');
			$query->whereIn('work_order_id', explode(',', $workorderids));
		}

		if (!empty($priority)) {
			$workorderids = WorkOrderItem::where('order_item_priority', 'LIKE', '%' . $priority . '%')->where('status', '=', '1')->pluck('work_order_id')->implode(',');
			$query->whereIn('work_order_id', explode(',', $workorderids));
		}
		if (!empty($arrr)) {
			for ($i = 0; $i < count($search_process_id); $i++) {
				$processItemIds[] = ProcessItem::where('id', '=', $search_process_id[$i])->where('status', '=', '1')->pluck('id');
			}
			//dd($processItemIds);
			$query->whereIn('process_type_id', $processItemIds);
		}
    if (!empty($fromDate) && !empty($toDate)) 
		{
			$fromDate 		= date('Y-m-d', strtotime($request->from_date));
			$toDate 		= date('Y-m-d', strtotime($request->to_date));		
			$query->where('created', '>=',  $fromDate)->where('created', '<=',  $toDate);     			
		} 
		//\DB::enableQueryLog();
		$dataWI = $query->paginate(20);
		//dd(\DB::getQueryLog()); 
		// echo "<pre>"; print_r($dataWI); exit;	


		$dataMas 	= Individual::where('type', '=', 'master')->where('status', '=', '1')->get();
		$machine 	= Machine::where('status', '=', '1')->get();
		// echo "<pre>"; print_r($machine); exit;		
		$processI 	= ProcessItem::where('status', '=', '1')->get();
		//dd($processI);		
		$dataW 		= Warehouse::where('status', '=', '1')->orderBy('id', 'asc')->get();

		$dataF 		= FabricFaultReason::where('status', '=', '1')->orderByDesc('id')->get();
		$dataIT  	= ItemType::where('status', '=', '1')->where('is_work', '=', '1')->get();
		$dataITP  	= ItemType::where('status', '=', '1')->where('is_purchase', '=', '1')->get();
		$dataI  	= Item::where('status', '=', '1')->get();
		$priorityArr = config('global.priorityArr');
		// echo "<pre>"; print_r($search_process_id);   exit;
		return view('html.workorder.show-workorders', compact("dataWI", "cusSearch", "individualId", "itemSearch", "ordNumSearch", "priority", "dataMas", "machine", "processI", "dataW", "dataF", "dataIT", "dataI", "dataITP", "priorityArr", "search_process_id","fromDate","toDate"));
	}

	public function work_order_details($Id)
	{
		$Id  	= base64_decode($Id);
		$dataWI = WorkOrderItem::where('work_order_id', '=', $Id)->get();
		return view('html.workorder.workorder-details', compact("dataWI"));
	}

	public function create()
	{
		error_reporting(0);
		$dataIT  = ItemType::where('status', '=', '1')->get();
		$dataUT  = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		$dataSO  = SaleOrder::where('is_deleted', '=', '0')->get();
		return view('html.workorder.add-workorder', compact("dataIT", "dataUT", "dataSO"));
	}

	public function store(Request $request)
	{
		//  echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
			"chk_sale_order_item_id" => "required",
			"WorkSubmit" => "required",
		], [
			"chk_sale_order_item_id.required" => "Please select work Item.",
			"WorkSubmit.required" => "Please select work process type button.",
		]);
		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$chk_sale_order_item_id_Arr = $request->chk_sale_order_item_id;
		$WorkSubmit 				= $request->WorkSubmit;
		if ($WorkSubmit == 'Weaving') {
			$processType = 2;
			$itemTypeId  = 2;
		} else if ($WorkSubmit == 'Dyeing') {
			$processType = 3;
			$itemTypeId  = 3;
		} else if ($WorkSubmit == 'Coating') {
			$processType = 4;
			$itemTypeId  = 4;
		} else {
			$processType = 1;
			$itemTypeId  = 1;
		}
		if ($WorkSubmit != 'Warping') {
			foreach ($chk_sale_order_item_id_Arr as $soId) {
				$soItem 		= SaleOrderItem::where('sale_order_item_id', '=', $soId)->first();
				$itemId 		= $soItem->item_id;
				$dyeingColor 	= $soItem->dyeing_color;
				if ($WorkSubmit == 'Weaving') {
					$chkitem 	  = CommonController::getWarehouseAvailableItemStockBeam($itemId, $itemTypeId);
				} else if ($WorkSubmit == 'Dyeing') {
					$chkitem	  = CommonController::check_warehouse_greige_type_balance($itemId, $itemTypeId);
				} else if ($WorkSubmit == 'Coating') {
					$chkitem	  = CommonController::check_warehouse_dyeing_type_balance($itemId, $itemTypeId, $dyeingColor);
				}
				$chkBalance  = trim(str_ireplace("meter", "", $chkitem));
				if (empty($chkBalance)) {
					Session::put('message', 'Something went wrong.');
					Session::put("messageClass", "errorClass");
					return redirect()->back()->withInput();
				}
			}
		}

		$proType	= CommonController::getProcessTypeName($processType);
		$shortcode  = $proType['shortcode'];
		$dataPI  	= ProcessItem::where('id', '=', $processType)->first();
		$proSNo 	= $dataPI->process_sl_no_last;

		$ArrayItem = array();
		foreach ($chk_sale_order_item_id_Arr as $soId) {
			$itemId 	 = SaleOrderItem::where('sale_order_item_id', '=', $soId)->value('item_id');
			$ArrayItem[] = $itemId;
		}

		$itemUniqueId 	= array_unique($ArrayItem);
		$totUniqItem 	= count(array_unique($ArrayItem));
		if ($totUniqItem > 1) {
			Session::put('message', 'Please select unique Item for creating ' . $WorkSubmit . ' Work Order.');
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$cut 	= 0;
		$pcs 	= 0;
		$meter 	= 0;
		foreach ($chk_sale_order_item_id_Arr as $soId) {
			$soItem = SaleOrderItem::where('sale_order_item_id', '=', $soId)->first();
			$pcs 	+= $soItem->pcs;
			$cut 	+= $soItem->cut;
			$meter 	+= $soItem->meter;
		}
		$totPcs 		= $pcs;
		$totCut 		= $cut;
		$totMeter 		= $meter;
		$userId 		= Auth::id();
		$userD 			= User::find($userId);
		$IndividualId 	= $userD->individual_id;

		$item_name = Item::where('item_id', '=', $itemId)->value('item_name');
		$obj = new WorkOrder;
		$obj->process_type  			= $shortcode;
		$obj->process_sl_no  			= $proSNo + 1;
		$obj->item_id  					= $itemId;
		$obj->item_name  				= $item_name;
		$obj->pcs  						= $totPcs;
		$obj->cut  						= $totCut;
		$obj->meter  					= $totMeter;
		$obj->process_type_id   		= $processType;
		$obj->item_type_id   			= $itemTypeId;
		$obj->user_id   				= $IndividualId;
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d");
		$is_saved 						= $obj->save();
		$workOrderId 					= $obj->getKey();

		if ($is_saved) {
			foreach ($chk_sale_order_item_id_Arr as $soId) {

				$soItem 		= SaleOrderItem::where('sale_order_item_id', '=', $soId)->first();
				$customerId  	= SaleOrder::where('sale_order_id', '=', $soItem->sale_order_id)->value('individual_id');
				$unit_type_id 	= Item::where('item_id', '=', $soItem->item_id)->value('unit_type_id');
				$obj2 = new WorkOrderItem;

				$obj2->work_order_id  					= $workOrderId;
				$obj2->customer_id  					= $customerId;
				$obj2->sale_order_id  					= $soItem->sale_order_id;
				$obj2->sale_order_item_id  				= $soItem->sale_order_item_id;
				$obj2->item_type_id  					= $soItem->item_type_id;
				$obj2->unit_type_id  					= $unit_type_id;
				$obj2->item_id  						= $soItem->item_id;
				$obj2->grey_quality  					= $soItem->grey_quality;
				$obj2->dyeing_color  					= $soItem->dyeing_color;
				$obj2->coated_pvc  						= $soItem->coated_pvc;
				$obj2->extra_job  						= $soItem->extra_job;
				$obj2->print_job  						= $soItem->print_job;
				$obj2->expect_delivery_date  			= $soItem->expect_delivery_date;
				$obj2->order_item_priority  			= $soItem->order_item_priority;
				$obj2->pcs  							= $soItem->pcs;
				$obj2->cut  							= $soItem->cut;
				$obj2->meter  							= $soItem->meter;
				$obj2->status  							= 1;
				$obj2->created  						= date("Y-m-d");
				$is_saved 								= $obj2->save();

				$obj3  = SaleOrderItem::where('sale_order_item_id', '=', $soId)->update(['is_work_order_created' => '1']);
			}

			Session::put('message', 'Work Order created successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Something went wrong.');
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}
	}

	public function start_addworkorder($id, $ItemTypeId)
	{
		$sale_order_item_id  =  base64_decode($id);
		$ItemTypeId  	=  base64_decode($ItemTypeId); // exit;
		$dataSOI 		= SaleOrderItem::where('sale_order_item_id', '=', $sale_order_item_id)->where('is_deleted', '=', '0')->first();
		$ItemId 		= $dataSOI->item_id;
		$saleordId 		=  $dataSOI->sale_order_id;
		$orderItemPriority = $dataSOI->order_item_priority;
		$dataI  		= Item::where('item_id', '=', $ItemId)->where('status', '=', '1')->orderByDesc('item_type_id')->first();
		//	echo "<pre>"; print_r($dataI); exit;
		$dataIT  		= ItemType::where('status', '=', '1')->orderByDesc('item_type_id')->get();
		$dataUT  		= UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		$dataSO  		= SaleOrder::where('is_deleted', '=', '0')->get();

		return view('html.workorder.add-workorder', compact("dataIT", "dataUT", "dataSO", "ItemTypeId", "ItemId", "saleordId", "dataI", "orderItemPriority"));
	}

	public function start_workorder($id)
	{
		$saleordId = base64_decode($id);
		$dataSO  = SaleOrder::where('sale_order_id', '=', $saleordId)->where('is_deleted', '=', '0')->first();
		$dataSOI = SaleOrderItem::where('sale_order_id', '=', $saleordId)->where('is_deleted', '=', '0')->with('WorkOrder')->get();
		$dataWhI = WarehouseItem::where('status', '=', '1')->where('entry_type', '=', 'IN')->get();
		$dataIT  = ItemType::where('status', '=', '1')->where('is_work', '=', '1')->with('WarehouseItem')->with('WarehouseItemStock')->orderByDesc('item_type_id')->get();
		$dataPI  = ProcessItem::where('status', '=', '1')->orderByDesc('id')->with('WarehouseItem')->get();
		// echo "<pre>"; print_r($dataSOI); exit;
		return view('html.workorder.start-workorder', compact("saleordId", "dataSOI", "dataSO", "dataWhI", "dataPI", "dataIT"));
	}

	public function check_warehouse_item_stock($saleOrdItemId)
	{
		$saleOrdItemId 	= base64_decode($saleOrdItemId);
		$dataSOI 		= SaleOrderItem::where('sale_order_item_id', '=', $saleOrdItemId)->where('is_deleted', '=', '0')->first();
		$saleOrderId 	= $dataSOI->sale_order_id;
		return view('html.workorder.check-warehouse-item-stock', compact("saleOrderId", "dataSOI", "saleOrdItemId"));
	}

	public function checkWarehouseItemStock(Request $request)
	{
		$sale_order_item_id 	= $request->FId;
		$dataSOI = SaleOrderItem::where('sale_order_item_id', '=', $sale_order_item_id)->where('is_deleted', '=', '0')->first();
		$itemId  = $dataSOI->item_id;

		$dataI = Item::where('item_id', '=', $itemId)->where('status', '=', '1')->first();
		$ItemTypeId = $dataI->item_type_id;
		$unitTypeId = $dataI->unit_type_id;
		$ItemName   = $dataI->item_name;
		$dataWhI = WarehouseItem::where('item_type_id', '=', $ItemTypeId)->where('status', '=', '1')->first();
		$dataArr = WarehouseItem::where('item_type_id', '=', $ItemTypeId)->where('status', '=', '1')->get();

		$purItemQtyTotal = $dataArr->sum('pur_item_qty');

		$unit  = $dataSOI->unit;
		$pcs  = $dataSOI->pcs;
		$cut  = $dataSOI->cut;
		$meter  = $dataSOI->meter;
		$str = "<table class='table table-bordered'>
		<tr>
			<th>Unit</th>
			<th>Pcs</th>
			<th>Cut</th>
			<th>Meter</th>
		</tr>
		<tr>";
		$str .= " <td>" . $unit . "</td>
				<td>" . $pcs . "</td>
				<td>" . $cut . "</td>
				<td>" . $meter . "</td>
		</tr></table>";

		$result = [];
		$result['itemId'] = $itemId;
		$result['ItemName'] = $ItemName;
		$result['saleordItemId'] = $sale_order_item_id;
		$result['purItemQtyTotal'] = $str;

		echo json_encode($result);

		// echo $itemId."||".$ItemName."||".$sale_order_item_id;
	}

	public function createWorkOrder(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$ItemTypeId 	= $request->ItemTypeId;
		$SaleOrdItemId  = $request->SaleOrdItemId;
		$procesNum  	= $request->procesNum;
		$dataSOI 		= SaleOrderItem::where('sale_order_item_id', '=', $SaleOrdItemId)->where('is_deleted', '=', '0')->first();
		// echo "<pre>"; print_r($dataSOI); exit;
		$ItemId 		= $dataSOI->item_id;
		$saleordId 		= $dataSOI->sale_order_id;
		$orderItemPriority = $dataSOI->order_item_priority;
		$dataI  		= Item::where('item_id', '=', $ItemId)->where('status', '=', '1')->orderByDesc('item_type_id')->first();
		$itemName 		= $dataI->item_name;

		$dataSO 		= SaleOrder::where('sale_order_id', '=', $saleordId)->where('is_deleted', '=', '0')->first();
		$customerId 	= $dataSO->individual_id;
		$dataInd 		= Individual::where('id', '=', $customerId)->where('status', '=', '1')->first();
		$Cusname		= $dataInd->name;
		// exit;

		$userId = Auth::id();
		$userD = User::find($userId);
		$IndividualId = $userD->individual_id;
		$obj = new WorkOrder;
		$obj->sale_order_id  					= $saleordId;
		$obj->sale_order_item_id  				= $SaleOrdItemId;
		$obj->item_name  						= $itemName;
		$obj->item_id  							= $ItemId;
		$obj->purchase_item_id  				= $ItemId;
		$obj->item_type_id   				    = $ItemTypeId;
		$obj->user_id  					 		= $IndividualId;
		$obj->process_type_id  					= $procesNum;
		$obj->order_priority  					= $orderItemPriority;
		$obj->customer_name  					= $Cusname;
		$obj->customer_id  						= $customerId;
		$obj->process_started_by  				= '0';
		$obj->process_ended_by  				= '0';
		$obj->process_inspected_by  			= '0';
		$obj->gatepass_print_by  				= '0';
		// $obj->gatepass_print_date  			= '0000-00-00';
		// $obj->process_started_date  			= '0000-00-00';
		// $obj->process_ended_date  			= '0000-00-00';
		// $obj->process_inspected_date  		= '0000-00-00';
		$obj->gatepass_genrated_by  			= '0';
		$obj->gatepass_genrated_to  			= '0';
		$obj->process_started_remarks  			= '0';
		$obj->process_ended_remarks  			= '0';
		$obj->process_inspected_remark  		= '0';
		$obj->getapass_to_department  			= '0';
		$obj->getapass_from_department  		= '0';
		$obj->status  							= 1;
		$obj->created  							= date("Y-m-d");
		$is_saved 								= $obj->save();
		if ($is_saved) {
			Session::put('message', 'Work Order Added successfully.');
			Session::put("messageClass", "successClass");
			//return redirect("/show-workorders");
			return $is_saved;
		} else {
			Session::put('message', 'Something went wrong.');
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}
	}

	public function getWorkOrderDetails(Request $request)
	{
		$workOrdId = $request->FId;
		$dataWk = WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
		if ($dataWk) {
			$itemId 		= $dataWk->item_id;
			$ItemNameReq 	= $dataWk->item_name;
			$procesTypeId 	= $dataWk->process_type_id;

			$warehousesSql 	= Warehouse::where('status', '=', '1')->get();
			$warehouses 	= "";
			foreach ($warehousesSql as $warehouse) 
			{				 
				$selected = ($warehouse->process_type_id == $procesTypeId) ? 'selected' : '';
				$warehouses .= "<option value='{$warehouse->id}' $selected>{$warehouse->warehouse_name}</option>";				
			}
			$warehouses .= "";

			$machines 	= Machine::where('status', '=', '1')->where('process_wise', '=', $procesTypeId)->get();
			$options = "";
			foreach ($machines as $machine) {
				$options .= "<option value='{$machine->id}'>{$machine->name}</option>";
			}
			$options .= "";

			$dataPr = ProcessRequirement::where('process_type_id', '=', $procesTypeId)->where('status', '=', '1')->first();
			$dataIT = ItemType::where('item_type_id', '=', $dataPr->item_type_id)->where('status', '=', '1')->first();
			$itemTypeName = $dataIT->item_type_name;

			$processI = ProcessItem::where('id', '=', $procesTypeId)->where('status', '=', '1')->first();
			$wprArr = WorkProcessRequirement::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->get();

			$str = "<table class='table table-bordered'>
					<tr>
						<th>Requested Items</th>
						<th>Item Type</th>
						<th>Quantity</th>
					</tr>";

			foreach($wprArr as $row) 
			{
				$ItemD = DB::table('items')->where('item_id', $row->item_id)->first();
				$ItemName = $ItemD->item_name;
				$item_type_id = $row->item_type_id;
				$unit_type_id = $ItemD->unit_type_id;
				$ItemName = DB::table('items')->where('item_id', $row->item_id)->value('item_name');
				$iTName = CommonController::getItemType($row->item_type_id);
				$unitTName = ($item_type_id == '2') ? 'Kg' : CommonController::getUnitTypeName($unit_type_id);
				$qty = $row->quantity;

				$str .= "<tr>
							<td>$ItemName</td>
							<td>$iTName</td>
							<td>$qty $unitTName</td>
						</tr>";
			}

			$str .= "</table>";


			$dataWI = WorkOrderItem::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->get();
			$strWO = "<table class='table table-bordered'>
					<tr> 
						<th>Cut</th>
						<th>Pcs</th>
						<th>Meter</th> 
						<th>Dyeing Color</th>
						<th>Coated PVC</th>
						<th>Extra Job</th>
						<th>Print Job</th>
					</tr>";

			foreach ($dataWI as $rowArr) {
				$itemTypeNameR = CommonController::getItemType($rowArr->item_type_id);
				$soId 			= $rowArr->sale_order_id;
				$cut 			= $rowArr->cut;
				$pcs 			= $rowArr->pcs;
				$meter 			= $rowArr->meter;
				$grey_quality 	= $rowArr->grey_quality;
				$dyeing_color 	= $rowArr->dyeing_color;
				$coated_pvc 	= $rowArr->coated_pvc;
				$extra_job 		= $rowArr->extra_job;
				$print_job 		= $rowArr->print_job;

				$strWO .= "<tr>
							 
							 
						 
							<td>$cut</td>
							<td>$pcs</td>
							<td>$meter</td> 
							<td>$dyeing_color</td>
							<td>$coated_pvc</td>
							<td>$extra_job</td>
							<td>$print_job</td>
						</tr>";
			}

			$strWO .= "</table>";

			$proNext 	= CommonController::getProcessTypeName($procesTypeId);
			$outputNext = $proNext['output'];
			$outputUnit = $proNext['unit'];
			if ($outputNext == 'Beam') {
				$processtext 		= 'Is Drawing process complete ?';
				$outputUnitType 	=  'Kg';
			} else {
				$processtext 		= 'Is Inspection Process Complete ?';
				$outputUnitType 	= 'Meter';
			}
			$result = [
				'itemId' 			=> $itemId,
				'ItemName' 			=> $ItemNameReq,
				'workOrdId' 		=> $workOrdId,
				'itemTypeName' 		=> $itemTypeName,
				'processName' 		=> $processI->process_name,
				'processNameId' 	=> $processI->id,
				'outputNextPro' 	=> $outputNext,
				'outputUnit' 		=> $outputUnit,
				'RequestedItems' 	=> $str,
				'processtext' 		=> $processtext,
				'outputUnitType' 	=> $outputUnitType,
				'options' 			=> $options,
				'warehouses' 		=> $warehouses,
			];

			if ($procesTypeId > 2) {
				$result['workRequirement'] = $strWO;
			}

			echo json_encode($result);
		} else {
			echo json_encode(['error' => 'WorkOrder not found']);
		}
	}

	public function updateworkorder(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
			"itemId" => "required",
			"work_order_id" => "required",
			"masterId" => "required",
			"machineId" => "required",
			"process_started_remarks" => "required",
		], [
			"itemId.required" => "Item Not Found.",
			"work_order_id.required" => "Work order Not Found.",
			"masterId.required" => "Please select Master.",
			"machineId.required" => "Please select Machine.",
			"process_started_remarks.required" => "Please provide your starting process remarks.",
		]);
		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$user = Auth::user();
		$process_started_by = $user->individual_id;
		WorkOrder::where('work_order_id', $request->work_order_id)->update([
			'master_ind_id' => $request->masterId,
			'process_started_by' => $process_started_by,
			'process_started_date' => now(), //  current date and time
			'process_started_remarks' => $request->process_started_remarks,
			'machine_id' => $request->machineId
		]);

		Session::put('message', 'Updated successfully.');
		Session::put("messageClass", "successClass");
		return redirect("/show-workorders");
	}

	public function updateendworkorder(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
			"end_item_id" => "required",
			"end_work_order_id" => "required",
			"output_quantity" => "required",
			"process_ended_remarks" => "required",
		], [
			"end_item_id.required" => "Item Not Found.",
			"end_work_order_id.required" => "Work order Not Found.",
			"output_quantity.required" => "Please provide us your output quantity.",
			"process_ended_remarks.required" => "Please enter your inspection comment.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}
		$itemId 				= $request->end_item_id;
		$workOrderId 			= $request->end_work_order_id;
		$output_quantity 		= $request->output_quantity;
		$output_process 		= $request->output_process;

		$process_ended_remarks 		= $request->process_ended_remarks;
		$userId = Auth::id();
		$userD  = User::find($userId);
		$IndividualId = $userD->individual_id;
		$obj2  = WorkOrder::where('work_order_id', '=', $workOrderId)->update(
			[
				'end_process_emp_id' => $IndividualId,
				'output_quantity' => $output_quantity,
				'process_ended_remarks' => $process_ended_remarks,
				'process_ended_date' => date("Y-m-d"),
				'output_process' => $output_process
			]
		);
		if ($obj2) {
			Session::put('message', 'End Process Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		}
	}

	public function updateinspectionworkorder(Request $request)
	{
		//	  echo "<pre>"; print_r($request->all()); exit; 
		$validator = Validator::make($request->all(), [
			"ins_item_id" => "required",
			"ins_work_order_id" => "required",
			"output_quan_size" => "required",
			"inspec_comment" => "required",
			"work_status" => "required",
		], [
			"ins_item_id.required" => "Item Not Found.",
			"ins_work_order_id.required" => "Work order Not Found.",
			"output_quan_size.required" => "Please provide us your output quantity.",
			"inspec_comment.required" => "Please enter your inspection comment.",
			"work_status.required" => "Please provide your work status.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$itemId 				= $request->ins_item_id;
		$workOrderId 			= $request->ins_work_order_id;
		$comment 				= $request->inspec_comment;
		$workStatus 			= $request->work_status;
		$workStatusProcess 		= $request->insp_work_status_process;

		$insp_status 			= ($workStatusProcess == 'Yes') ? 'Complete' : 'Pending';
		if ($insp_status == 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
		}

		$warehouseId 		    = $request->insp_work_warehouse_id;
		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;

		$dataOrder  = WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     = ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 	= $dataPT->process_sl_no_last + 1;
		$dataPr 	= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId = $dataPr->item_type_id;
		$proTypeId  = $dataPT->id;
		$proType	= CommonController::getProcessTypeName($proTypeId);
		$shortcode  = $proType['shortcode'];
		$curDate  	= date("Y-m-d");
		$processTypeId = $dataOrder->process_type_id;

		$output_quan_size 		= $request->output_quan_size;
		$quantity 				= count($output_quan_size);
		$outputQuanSize 		= array_sum($output_quan_size);

		$objWI = new WorkInspection;
		$objWI->work_order_id  				= $workOrderId;
		$objWI->insp_quantity  				= '1';
		$objWI->insp_quan_size  			= $outputQuanSize;
		$objWI->insp_comment  				= $comment;
		$objWI->insp_work_status  			= $workStatus;
		$objWI->insp_work_status_process  	= $workStatusProcess;
		$objWI->fabric_fault_reason_id  	= $fabric_fault_reasonId;
		$objWI->insp_work_warehouse_id  	= $warehouseId;
		$objWI->insp_status  				= $insp_status;
		$objWI->inspected_by  				= $IndividualId;

		if ($processTypeId == '1') {
			$objWI->is_warehouse_accepted  	= 'Yes';
			$objWI->warehouse_accepted_by  	= $IndividualId;
			$objWI->warehouse_accept_date  	= $curDate;
		}

		$objWI->status  					= 1;
		$objWI->created  					= date("Y-m-d");
		$is_Insaved							= $objWI->save();

		$processTypeId 	= $dataOrder->process_type_id;
		$curDate  		= date("Y-m-d");
		if ($processTypeId == '1') {
			$obj = WorkOrder::where('work_order_id', '=', $workOrderId)->update(['is_warehouse_accepted' => 'Yes', 'warehouse_accepted_by' => $IndividualId, 'warehouse_accept_date' => $curDate]);
		}

		if ($is_Insaved) {

			// $objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last'=> $lastPsnl]); 	 
			if ($processTypeId == '1') {
				$dataOrder  = WorkOrder::where('work_order_id', '=', $workOrderId)->first();
				$dataPT     = ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
				// echo "svdscsdvsv"; exit;
				$warehouseItem = new WarehouseItem([
					'warehouse_id' 		=> $warehouseId,
					'item_type_id' 		=> $itemTypeId,
					'unit_type_id' 		=> 4,
					'created' 			=> now(),
					'status' 			=> 1,
					'master_id' 		=> $dataOrder->master_ind_id,
					'machine_id' 		=> $dataOrder->machine_id,
					'pur_item_name' 	=> $dataOrder->item_name,
					'item_qty' 			=> $outputQuanSize,
					'item_id' 			=> $itemId,
					'process_type_id' 	=> $dataPT->id,
					'entry_type' 		=> 'IN',
					'receive_date' 		=> now(),
					'receiver_id' 		=> $IndividualId,
				]);
				$isSavedWI 		= $warehouseItem->save();
				$lastInsertId 	= $warehouseItem->getKey();

				$opItemQty  = WarehouseBalanceItem::where('item_id', '=', $warehouseItem->item_id)
					->where('item_type_id', '=', $warehouseItem->item_type_id)
					->where('unit_type_id', '=', $warehouseItem->unit_type_id)
					->where('master_id', '=', $warehouseItem->master_id)
					->where('machine_id', '=', $warehouseItem->machine_id)
					->where('dyeing_color', '=', $warehouseItem->dyeing_color)
					->where('coated_pvc', '=', $warehouseItem->coated_pvc)
					->where('print_job', '=', $warehouseItem->print_job)
					->where('extra_job', '=', $warehouseItem->extra_job)
					->where('balance_status', '=', '1')
					->first();

				if (!empty($opItemQty)) {
					$wbId = $opItemQty->id;
					WarehouseBalanceItem::where('id', $wbId)->update(['balance_status' => '0']);
				}
				WarehouseBalanceItem::create([
					'ware_in_item_id'   => $warehouseItem->id,
					'ware_out_item_id'  => 0,
					'warehouse_id'      => $warehouseItem->warehouse_id,
					'ware_comp_id'      => $warehouseItem->ware_comp_id,
					'receiver_id'       => $warehouseItem->receiver_id,
					'receive_date'      => $warehouseItem->receive_date,
					'item_id'           => $warehouseItem->item_id,
					'item_type_id'      => $warehouseItem->item_type_id,
					'unit_type_id'      => $warehouseItem->unit_type_id,
					'master_id'         => $warehouseItem->master_id,
					'machine_id'        => $warehouseItem->machine_id,
					'op_item_qty'       => $opItemQty ? $opItemQty->item_qty : 0,
					'in_item_qty'       => $warehouseItem->item_qty,
					'out_item_qty'      => 0,
					'item_qty'          => $opItemQty ? ($opItemQty->item_qty + $warehouseItem->item_qty) : $warehouseItem->item_qty,
					'grey_quality'      => $warehouseItem->grey_quality,
					'dyeing_color'      => $warehouseItem->dyeing_color,
					'coated_pvc'        => $warehouseItem->coated_pvc,
					'print_job'         => $warehouseItem->print_job,
					'extra_job'         => $warehouseItem->extra_job,
					'created'           => now(),
					'status'            => '1',
				]);


				$warehouseItemStockData = [];
				foreach ($output_quan_size as $quanSize) {
					$warehouseItemStockData[] = [
						'warehouse_item_id' 	=> $lastInsertId,
						'quantity' 				=> 1,
						'work_order_id' 		=> $workOrderId,
						'insp_quan_size' 		=> $quanSize,
						'insp_allot_quan_size' 	=> 0,
						'insp_bal_quan_size' 	=> $quanSize,
						'quan_size_unit' 		=> 'Kg',
						'entry_type' 			=> 'IN',
						'insp_comment' 			=> $comment,
						'inspected_by' 			=> $IndividualId,
						'receive_date' 			=> date("Y-m-d"),
						'item_id' 				=> $itemId,
						'item_type_id' 			=> $itemTypeId,
						'created' 				=> now(),
						'modified' 				=> now(),
						'status' => 1,
					];
				}
				$flag = count($warehouseItemStockData);
				if ($flag > 0) {
					$is_savedWIS = WarehouseItemStock::insert($warehouseItemStockData);
				}
			}

			$objG = new GatePass;
			$objG->work_order_id 						= $request->ins_work_order_id;
			$objG->item_id 								= $itemId;
			$objG->item_type_id 						= $itemTypeId;
			$objG->unit_type_id 						= 4;
			$objG->qty_size 							= $outputQuanSize;
			$objG->qty 									= $quantity;
			$objG->to_department 						= $processTypeId;
			$objG->to_warehouse 						= $warehouseId;
			$objG->gatepass_number 						= $lastPsnl;
			$objG->genrated_by 							= $IndividualId;
			$objG->print_date 							= null;
			$objG->status 								= 1;
			$objG->created 								= now();
			$is_savedG 									= $objG->save();

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function update_weaving_inspec_process(Request $request)
	{
		//  echo "<pre>"; print_r($request->all()); exit; 
		$validator = Validator::make($request->all(), [
			"ins_item_id"		=> "required",
			"ins_work_order_id"	=> "required",
			"output_quan_size"	=> "required",
			"inspec_comment"	=> "required",
			"work_status"		=> "required",
		], [
			"ins_item_id.required"			=> "Item Not Found.",
			"ins_work_order_id.required"	=> "Work order Not Found.",
			"output_quan_size.required"		=> "Please provide us your output quantity.",
			"inspec_comment.required"		=> "Please enter your inspection comment.",
			"work_status.required"			=> "Please provide your work status.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$itemId 				= $request->ins_item_id;
		$workOrderId 			= $request->ins_work_order_id;
		$comment 				= $request->inspec_comment;
		$workStatus 			= $request->work_status;
		$workStatusProcess 		= $request->insp_work_status_process;
		$output_quan_size 		= $request->output_quan_size;
		$curDate  				= date("Y-m-d");
		$fabric_fault_reasonId 	= $workStatus ? $request->fabric_fault_id : 0;
		$quantity 				= count($output_quan_size);
		$outputQuanSize 		= array_sum($output_quan_size);
		$warehouseId 			= $request->insp_work_warehouseId;
		$insp_status 			= ($workStatusProcess == 'Yes') ? 'Complete' : 'Pending';

		if ($insp_status == 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
			// WorkOrderItem::where('woi_id', '=', $woid)->update(['is_work_completed'=> 1]);  
		}

		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;

		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;

		$objWI = new WorkInspection;
		$objWI->work_order_id  				= $workOrderId;
		$objWI->insp_quantity  				= '1';
		$objWI->insp_quan_size  			= $outputQuanSize;
		$objWI->insp_comment  				= $comment;
		$objWI->insp_work_status  			= $workStatus;
		$objWI->insp_work_status_process  	= $workStatusProcess;
		$objWI->fabric_fault_reason_id 		= $fabric_fault_reasonId ?: null;
		$objWI->insp_work_warehouse_id  	= $warehouseId;
		$objWI->insp_status  				= $insp_status;
		$objWI->inspected_by  				= $IndividualId;
		$objWI->status  					= 1;
		$objWI->created  					= $curDate;
		$is_Insaved							= $objWI->save();
		$lastInsertId 						= $objWI->getKey();
		if ($is_Insaved) {
			// $objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last'=> $lastPsnl]); 				 
			$objG = new GatePass;
			$objG->work_order_id  						= $request->ins_work_order_id;
			$objG->item_id  							= $itemId;
			$objG->item_type_id  						= $itemTypeId;
			$objG->unit_type_id  						= 2;
			$objG->qty_size  							= $outputQuanSize;
			$objG->qty  								= $quantity;
			$objG->to_department  						= $processTypeId;
			$objG->to_warehouse  						= $warehouseId;
			$objG->gatepass_number  					= $lastPsnl;
			$objG->genrated_by  						= '';
			$objG->print_date  							= '';
			$objG->status  								= 1;
			$objG->created  							= date("Y-m-d");
			$is_savedG 									= $objG->save();
			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function update_dyeing_inspec_process(Request $request)
	{
		//   echo "<pre>"; print_r($request->all()); exit; 
		$validator = Validator::make($request->all(), [
			"ins_item_id" => "required",
			"ins_work_order_id" => "required",
			"output_quan_size" => "required",
			"inspec_comment" => "required",
			"work_status" => "required",
		], [
			"ins_item_id.required" => "Item Not Found.",
			"ins_work_order_id.required" => "Work order Not Found.",
			"output_quan_size.required" => "Please provide us your output quantity.",
			"inspec_comment.required" => "Please enter your inspection comment.",
			"work_status.required" => "Please provide your work status.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$itemId 				= $request->ins_item_id;
		$workOrderId 			= $request->ins_work_order_id;
		$comment 				= $request->inspec_comment;
		$workStatus 			= $request->work_status;
		$workStatusProcess 		= $request->insp_work_status_process;
		$output_quan_size 		= $request->output_quan_size;
		$curDate  				= date("Y-m-d");
		$fabric_fault_reasonId 	= $workStatus ? $request->fabric_fault_id : 0;
		$quantity 				= count($output_quan_size);
		$outputQuanSize 		= array_sum($output_quan_size);
		$warehouseId 			= $request->insp_work_warehouseId;
		$insp_status 			= ($workStatusProcess == 'Yes') ? 'Complete' : 'Pending';

		if ($insp_status == 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
		}

		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;
		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;

		$DyingColor 			= WorkOrderItem::where('work_order_id', $workOrderId)->where('status', '=', '1')->value('dyeing_color');

		$objWI = new WorkInspection;
		$objWI->work_order_id  				= $workOrderId;
		$objWI->insp_quantity  				= '1';
		$objWI->insp_quan_size  			= $outputQuanSize;
		$objWI->insp_comment  				= $comment;
		$objWI->insp_work_status  			= $workStatus;
		$objWI->insp_work_status_process  	= $workStatusProcess;
		$objWI->fabric_fault_reason_id 		= $fabric_fault_reasonId ?: null;
		$objWI->insp_work_warehouse_id  	= $warehouseId;
		$objWI->insp_status  				= $insp_status;
		$objWI->inspected_by  				= $IndividualId;
		$objWI->dyeing_color  				= $DyingColor;
		// $objWI->coated_pvc  				= $IndividualId; 
		// $objWI->extra_job  				= $IndividualId; 
		// $objWI->print_job  				= $IndividualId; 		
		$objWI->status  					= 1;
		$objWI->created  					= $curDate;
		$is_Insaved							= $objWI->save();
		$lastInsertId 						= $objWI->getKey();

		if ($is_Insaved) {
			$objG = new GatePass;
			$objG->work_order_id  						= $request->ins_work_order_id;
			$objG->item_id  							= $itemId;
			$objG->item_type_id  						= $itemTypeId;
			$objG->unit_type_id  						= 2;
			$objG->qty_size  							= $outputQuanSize;
			$objG->qty  								= $quantity;
			$objG->to_department  						= $processTypeId;
			$objG->to_warehouse  						= $warehouseId;
			$objG->gatepass_number  					= $lastPsnl;
			$objG->genrated_by  						= '';
			$objG->dyeing_color  						= $DyingColor;
			$objG->print_date  							= '';
			$objG->status  								= 1;
			$objG->created  							= date("Y-m-d");
			$is_savedG 									= $objG->save();

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function update_coating_inspec_process(Request $request)
	{
		//   echo "<pre>"; print_r($request->all()); exit; 
		$validator = Validator::make($request->all(), [
			"ins_item_id" => "required",
			"ins_work_order_id" => "required",
			"output_quan_size" => "required",
			"inspec_comment" => "required",
			"work_status" => "required",
		], [
			"ins_item_id.required" => "Item Not Found.",
			"ins_work_order_id.required" => "Work order Not Found.",
			"output_quan_size.required" => "Please provide us your output quantity.",
			"inspec_comment.required" => "Please enter your inspection comment.",
			"work_status.required" => "Please provide your work status.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$itemId 				= $request->ins_item_id;
		$workOrderId 			= $request->ins_work_order_id;
		$comment 				= $request->inspec_comment;
		$workStatus 			= $request->work_status;
		$workStatusProcess 		= $request->insp_work_status_process;
		$output_quan_size 		= $request->output_quan_size;
		$curDate  				= date("Y-m-d");
		$fabric_fault_reasonId 	= $workStatus ? $request->fabric_fault_id : 0;
		$quantity 				= count($output_quan_size);
		$outputQuanSize 		= array_sum($output_quan_size);
		$warehouseId 			= $request->insp_work_warehouseId;
		$insp_status 			= ($workStatusProcess == 'Yes') ? 'Complete' : 'Pending';

		if ($insp_status == 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
			WorkOrder::where('work_order_id', $workOrderId)->update(['work_status' => $insp_status]);
		}

		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;
		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;
		$coatedPvc 				= WorkOrderItem::where('work_order_id', $workOrderId)->where('status', '=', '1')->value('coated_pvc');

		$objWI = new WorkInspection;
		$objWI->work_order_id  				= $workOrderId;
		$objWI->insp_quantity  				= '1';
		$objWI->insp_quan_size  			= $outputQuanSize;
		$objWI->insp_comment  				= $comment;
		$objWI->insp_work_status  			= $workStatus;
		$objWI->insp_work_status_process  	= $workStatusProcess;
		$objWI->fabric_fault_reason_id 		= $fabric_fault_reasonId ?: null;
		$objWI->insp_work_warehouse_id  	= $warehouseId;
		$objWI->insp_status  				= $insp_status;
		$objWI->inspected_by  				= $IndividualId;

		// $objWI->dyeing_color  			= $DyingColor; 
		$objWI->coated_pvc  				= $coatedPvc;
		// $objWI->extra_job  				= $IndividualId; 
		// $objWI->print_job  				= $IndividualId; 	

		$objWI->status  					= 1;
		$objWI->created  					= $curDate;
		$is_Insaved							= $objWI->save();
		$lastInsertId 						= $objWI->getKey();

		if ($is_Insaved) {
			$objG = new GatePass;
			$objG->work_order_id  						= $request->ins_work_order_id;
			$objG->item_id  							= $itemId;
			$objG->item_type_id  						= $itemTypeId;
			$objG->unit_type_id  						= 2;
			$objG->qty_size  							= $outputQuanSize;
			$objG->qty  								= $quantity;
			$objG->to_department  						= $processTypeId;
			$objG->to_warehouse  						= $warehouseId;
			$objG->gatepass_number  					= $lastPsnl;
			$objG->genrated_by  						= '';
			$objG->coated_pvc  							= $coatedPvc;
			$objG->print_date  							= '';
			$objG->status  								= 1;
			$objG->created  							= date("Y-m-d");
			$is_savedG 									= $objG->save();

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function print_workorder_gatepass($id)
	{
		$GpId 	= base64_decode($id);
		$userId = Auth::id();
		$userD 	= User::find($userId);
		$IndividualId 	= $userD->individual_id;
		$dataInd 		= Individual::where('id', '=', $IndividualId)->where('status', '=', '1')->first();
		$currentDate 	= date('Y-m-d');
		$compData 		= Company::find(1);
		$dataGp 	  	= GatePass::where('id', $GpId)->first();
		$workOrderId  	= $dataGp->work_order_id;
		$data 			= WorkOrder::where('work_order_id', $workOrderId)->with('WarehouseItem')->first();
		$fromDepartment = @$data->process_type_id;
		if (empty($fromDepartment)) {
			Session::put('message', 'Work Order Not found.');
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$proType 	= CommonController::getProcessTypeName($dataGp->to_department);
		$warehouseName 	= CommonController::getWarehouseName($dataGp->to_warehouse);




		// echo "<pre>"; print_r($proType); exit;		
		$toDepart  	= $proType['process'];

		return view('html.workorder.print-workorder-gatepass', compact("data", "toDepart", "compData", "dataInd", "GpId", "dataGp", "warehouseName"));
	}

	public function print_workorder_report($id)
	{
		$workOrderId = base64_decode($id);
		$userId = Auth::id();
		$userD 	= User::find($userId);
		$IndividualId 	= $userD->individual_id;
		$dataInd 		= Individual::where('id', '=', $IndividualId)->where('status', '=', '1')->first();
		$currentDate 	= date('Y-m-d');
		$compData 		= Company::find(1);
		$data 			= WorkOrder::where('work_order_id', $workOrderId)->with('WarehouseItem')->first();
		$fromDepartment = $data->process_type_id;
		$toDepartment 	= $fromDepartment + 1;
		return view('html.workorder.print-workorder-report', compact("data", "toDepartment", "compData", "dataInd"));
	}

	public function show_workorder_report(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$qsearch 		= trim($request->qsearch);
		$processTypeId 	= $request->process_type_id;
		$receiverName 	= $request->receiver_name;
		$cusSearch 		= $request->cus_search;
		$customerId 	= $request->customer_id;
		$receiverId 	= $request->receiver_id;
		$senderId 		= $request->sender_id;
		$senderName 	= $request->sender_name;
		if (!empty($request->receive_date)) {
			$recvWhDate = date('Y-m-d', strtotime($request->receive_date));
		} else {
			$recvWhDate = '';
		}
		$query = WorkInspection::where('status', '=', '1')->with('WorkOrder', 'WorkOrder.WorkOrderItem')->orderByDesc('id');
		if (!empty($customerId)) {
			$workorderids = WorkOrderItem::where('customer_id', '=', $customerId)->where('status', '=', '1')->pluck('work_order_id')->implode(',');
			$query->whereIn('work_order_id', explode(',', $workorderids));
		}
		if (!empty($qsearch)) {
			$query->where(DB::raw("concat(item_name)"), 'LIKE', '%' . $qsearch . '%');
		}
		if (!empty($processTypeId)) {
			$workorderids = WorkOrder::where('process_type_id', '=', $processTypeId)->where('status', '=', '1')->pluck('work_order_id')->implode(',');
			$query->whereIn('work_order_id', explode(',', $workorderids));
		}
		if (!empty($receiverId)) {
			$query->where('item_received_in_warehouse_by', '=', $receiverId)->where('status', '=', '1');
		}
		if (!empty($senderId)) {
			$query->where('inspected_by', '=', $senderId)->where('status', '=', '1');
		}
		if (!empty($recvWhDate)) {
			$query->where('item_received_in_warehouse_date', '>=', $recvWhDate)->where('status', '=', '1');
		}
		$dataWI = $query->paginate(20);

		$dataPI = ProcessItem::where('status', '=', '1')->get();
		return view('html.workorder.show-workorder-report', compact("dataWI", "qsearch", "dataPI", "receiverName", "recvWhDate", "cusSearch", "processTypeId"));
	}

	public function accept_work_item_in_warehouse(Request $request)
	{
		$userId = Auth::id();
		$userD 	= User::find($userId);
		$IndId = $userD->individual_id;
		$curDate  = date("Y-m-d");
		$FId = $request->FId;
		$obj = WorkInspection::where('id', '=', $FId)->update(['is_warehouse_accepted' => 'Yes', 'warehouse_accepted_by' => $IndId, 'warehouse_accept_date' => $curDate]);
		if ($obj) {
			Session::put('message', 'Accepted successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorder-report");
		} else {
			Session::put('message', 'Sorry, we encountered an error processing your request. Please try again later.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorder-report");
		}
	}

	public function acceptWorkOrderInWarehouse(Request $request)
	{
		$userId = Auth::id();
		$userD 	= User::find($userId);
		$IndividualId = $userD->individual_id;
		$FId = $request->FId;
		$obj  = WorkOrder::where('work_order_id', '=', $FId)->update(['is_warehouse_accepted' => 'Yes', 'warehouse_accepted_by' => $IndividualId]);
		return $obj;
	}

	public function receive_work_item($id)
	{
		$inspId = base64_decode($id);
		$dataWI = WorkInspection::where('id', $inspId)->first();
		//  echo "<pre>"; print_r(); exit; 		 
		$wId = $dataWI->work_order_id;
		$dataWO = WorkOrder::where('work_order_id', $wId)->where('status', '1')->first();

		$dataWOI = WorkOrderItem::where('work_order_id', $wId)->where('status', '1')->first();
		$ItemTypeId = $dataWOI->item_type_id;

		$ProcessTypeId = $dataWO->process_type_id;
		$dataPI 	= ProcessItem::where('status', '1')->get();
		$dataIT 	= ItemType::where('status', '1')->where('is_work', '1')->get();
		$dataUT 	= UnitType::where('status', '1')->orderByDesc('unit_type_id')->get(); 
		$dataW 		= Warehouse::where('status', '1')->orderBy('id', 'asc')->get();

		return view('html.workorder.receive-work-item', compact('dataW', 'dataWI', 'dataPI', 'dataIT', 'dataWO', 'ItemTypeId', 'ProcessTypeId', 'inspId'));
		
	}

	public function receive_work_item_in_warehouse(Request $request)
	{
		 echo "<pre>"; print_r($request->all());   exit;
		$dataW   = Warehouse::where('status', '=', '1')->orderByDesc('id')->get();
		$dataPI  = ProcessItem::where('status', '=', '1')->get();
		$dataIT  = ItemType::where('status', '=', '1')->get();
		$dataUT  = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		$inspId  = $request->insp_id;

		$validator = Validator::make($request->all(), [
			"warehouseId" => "required",
			"warehouseCompId" => "required",
			"emp_name" => "required",
			"ind_emp_id" => "required",
			"work_order_id" => "required",
		], [
			"warehouseId.required" => "Please select Warehouse.",
			"warehouseCompId.required" => "Please select Warehouse Compartment.",
			"emp_name.required" => "Please Select Employee Name.",
			"ind_emp_id.required" => "Something Error, Employee Id Not found.",
			"work_order_id.required" => "Your Work Order Id Not Found.",

		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}


		$quan_size			= $request->quan_size;
		$workOrdId 			= $request->work_order_id;
		$userId 			= Auth::id();
		$userD 				= User::find($userId);
		$IndividualId 		= $userD->individual_id;
		$receiving_date 	= date('Y-m-d', strtotime($request->receiving_date));
		$itemTypeId 		= $request->item_type_id;
		$receiverId 		= $request->receiver_id;
		$QuanSize  			= array_sum($quan_size);
		$gate_pass_noArr 	= $request->gate_pass_no;
		$quan_sizeArr 	 	= $request->quan_size;
		$itemTypeId 	 	= $request->item_type_id;


		/*if ($request->hasFile('report_document'))
		{
            $reportDocument = $request->file('report_document');
            $reportName 	= uniqid('document_', true) . '.' . $reportDocument->getClientOriginalExtension();
            $reportDocument->move(public_path('warehouse_document'), $reportName);
            $obj->report_document  = $reportName;
        }*/

		$dataOrder  	= WorkOrder::where('work_order_id', '=', $workOrdId)->first();
		$warehouseItem 	= new WarehouseItem([
			'work_order_id' 		=> $workOrdId,
			'insp_id' 				=> $inspId,
			'entry_type' 			=> 'IN',
			'process_type_id' 		=> $request->process_type_id,
			'warehouse_id' 			=> $request->warehouseId,
			'ware_comp_id' 			=> $request->warehouseCompId,
			'receiver_id' 			=> $request->receiver_id,
			'ind_emp_id' 			=> $request->ind_emp_id,
			'emp_name' 				=> $request->emp_name,
			'receive_date' 			=> $receiving_date,
			'item_id' 				=> $request->item_id,
			'item_type_id' 			=> $itemTypeId,
			'unit_type_id' 			=> 2,
			'machine_id' 			=> $dataOrder->machine_id,
			'master_id' 			=> $dataOrder->master_ind_id,
			'pur_item_name' 		=> $request->item_name,
			'dyeing_color' 			=> $request->dyeing_color,
			'coated_pvc' 			=> $request->coated_pvc,
			'extra_job' 			=> $request->extra_job,
			'print_job' 			=> $request->print_job,
			'item_qty' 				=> $QuanSize,
			'individual_id' 		=> $IndividualId,
			'created' 				=> date("Y-m-d H:i:s"),
		]);
		$isSavedWI 					= $warehouseItem->save();
		$warehouseItemId 			= $warehouseItem->getKey();

		$opItemQty  = WarehouseBalanceItem::where('item_id', '=', $warehouseItem->item_id)
			->where('item_type_id', '=', $warehouseItem->item_type_id)
			->where('unit_type_id', '=', $warehouseItem->unit_type_id)
			->where('master_id', '=', $warehouseItem->master_id)
			->where('machine_id', '=', $warehouseItem->machine_id)
			->where('dyeing_color', '=', $warehouseItem->dyeing_color)
			->where('coated_pvc', '=', $warehouseItem->coated_pvc)
			->where('print_job', '=', $warehouseItem->print_job)
			->where('extra_job', '=', $warehouseItem->extra_job)
			->where('balance_status', '=', '1')
			->first();

		if(!empty($opItemQty)) 
		{
			$wbId = $opItemQty->id;
			WarehouseBalanceItem::where('id', $wbId)->update(['balance_status' => '0']);
		}
		WarehouseBalanceItem::create([
			'ware_in_item_id'   => $warehouseItem->id,
			'ware_out_item_id'  => 0,
			'warehouse_id'      => $warehouseItem->warehouse_id,
			'ware_comp_id'      => $warehouseItem->ware_comp_id,
			'receiver_id'       => $warehouseItem->receiver_id,
			'receive_date'      => $warehouseItem->receive_date,
			'item_id'           => $warehouseItem->item_id,
			'item_type_id'      => $warehouseItem->item_type_id,
			'unit_type_id'      => $warehouseItem->unit_type_id,
			'master_id'         => $warehouseItem->master_id,
			'machine_id'        => $warehouseItem->machine_id,
			'op_item_qty'       => $opItemQty ? $opItemQty->item_qty : 0,
			'in_item_qty'       => $warehouseItem->item_qty,
			'out_item_qty'      => 0,
			'item_qty'          => $opItemQty ? ($opItemQty->item_qty + $warehouseItem->item_qty) : $warehouseItem->item_qty,
			'grey_quality'      => $warehouseItem->grey_quality,
			'dyeing_color'      => $warehouseItem->dyeing_color,
			'coated_pvc'        => $warehouseItem->coated_pvc,
			'print_job'         => $warehouseItem->print_job,
			'extra_job'         => $warehouseItem->extra_job,
			'created'           => now(),
			'status'            => '1',
		]);

		foreach ($gate_pass_noArr as $gateId => $rowArr) 
		{
			$quan_size 	= $request->quan_size[$gateId];
			$gateId 	= $request->gate_pass_no[$gateId];
			$objWIS 	= new WarehouseItemStock;
			$objWIS->warehouse_item_id  	= $warehouseItemId;
			$objWIS->work_order_id  		= $workOrdId;
			$objWIS->gate_pass_id  			= $gateId;
			$objWIS->quantity  				= 1;
			$objWIS->insp_quan_size 		= $quan_size;
			$objWIS->insp_allot_quan_size 	= 0;
			$objWIS->insp_bal_quan_size 	= $objWIS->insp_quan_size - $objWIS->insp_allot_quan_size;
			$objWIS->quan_size_unit  		= 'Meter';
			$objWIS->receive_date  			= $receiving_date;
			$objWIS->invoice_number  		= $request->invoice_number;
			$objWIS->purchase_date  		= $request->purchase_date;
			$objWIS->item_type_id  			= $itemTypeId;
			$objWIS->unit_type_id  			= 2;
			$objWIS->item_id  				= $request->item_id;
			$packetNumber 					= CommonController::genrateRandomPacketNumber($itemTypeId, $warehouseItemId);
			$objWIS->packet_number  		= $packetNumber . '/' . $i;
			$objWIS->item_remark  			= 'Greige Product';
			$objWIS->dyeing_color  			= $request->dyeing_color;
			$objWIS->coated_pvc  			= $request->coated_pvc;
			$objWIS->print_job  			= $request->print_job;
			$objWIS->extra_job  			= $request->extra_job;
			$objWIS->created  				= now();
			$objWIS->status  				= 1;
			$is_saved 						= $objWIS->save();
		}
		
		if ($is_saved) 
		{
			WorkInspection::where('id', '=', $inspId)->update([
				'item_interred_in_warehouse_by' => Auth::user()->individual_id,
				'item_received_in_warehouse_by' => $request->receiver_id,
				'item_received_in_warehouse_date' => now(),
				'is_item_received_in_warehouse' => 'Yes',
			]);

			Session::put('message', 'Item Received in Warehouse successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorder-report");
		} else {
			Session::put('message', 'Something error to receive items in warehouse.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorder-report");
		}
	}

	public function add_work_requisition(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
			"itemIdReq" => "required",
			"work_order_id_req" => "required",
			"req_item_id" => "required|array|min:1",
			"quantity" => "required|array|min:1",
			"quantity.*" => "required|numeric|min:1",
		], [
			"itemIdReq.required" => "Please select Item Name.",
			"work_order_id_req.required" => "Please select your Work type.",
			"req_item_id.required" => "Please select a item.",
			"quantity.required" => "Please enter your work Quantity.",
			"quantity.*.required" => "Each quantity must not be empty.",
			"quantity.*.numeric" => "Each quantity must be a number.",
			"quantity.*.min" => "Each quantity must be at least 1.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrdId 		= $request->work_order_id_req;
		$dataWk 		= WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
		$ItemName 		= $dataWk->item_name;
		$procesTypeId 	= $dataWk->process_type_id;

		$dataPr 		= ProcessRequirement::where('process_type_id', '=', $procesTypeId)->where('status', '=', '1')->first();
		$dataIT 		= ItemType::where('item_type_id', '=', $dataPr->item_type_id)->where('status', '=', '1')->first();
		$itemTypeName 	= $dataIT->item_type_name;
		$userId 		= Auth::id();
		$userD 			= User::find($userId);
		$IndividualId 	= $userD->individual_id;
		$curDate 		= date("Y-m-d");
		$reqItemIdArr 	= $request->req_item_id;
		$qty_arr 		= $request->quantity;
		$WitemId 		= $request->itemIdReq;

		$data = [];
		foreach ($reqItemIdArr as $index => $itemId) {
			$dataI = Item::where('item_id', '=', $itemId)->where('status', '=', '1')->first();
			$ItemTypeId = $dataI->item_type_id;
			$qty = $qty_arr[$index];
			$data[] = [
				'work_order_id' => $workOrdId,
				'item_id' => $itemId,
				'process_type_id' => $procesTypeId,
				'item_type_id' => $ItemTypeId,
				'work_req_send_by' => $IndividualId,
				'quantity' => $qty,
				'status' => 1,
				'created' => $curDate,
			];
		}
		$res = WorkProcessRequirement::insert($data);

		if ($res) {
			$obj2 = WorkOrder::where('work_order_id', '=', $workOrdId)->update([
				'work_req_send_by' => $IndividualId,
				'is_work_require_request_accepted' => 'Null', // Use 'Null' as a string
				'work_req_send_date' => $curDate,
			]);
			Session::put('message', 'Work Requirement Send to Warehouse successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		}
	}

	public function add_work_requisition_for_weaving(Request $request)
	{
		// echo "<pre>"; print_r($request->all());   exit;		 
		$validator = Validator::make($request->all(), [
			"itemIdReq" => "required",
			"work_order_id_req" => "required",
			'wis_id' => 'required|array|min:1',
			'wis_id.*' => 'numeric',
			"quantity" => "required|array|min:1",
			"quantity.*" => "required|numeric|min:1",
			"ext_item_type_id" => "required|numeric",
			"req_item_id" => "required|array|min:1",
			"req_item_id.*" => "required|numeric|min:1",
		], [
			"itemIdReq.required" => "Please select Item Name.",
			"work_order_id_req.required" => "Please select your Work type.",
			'wis_id.required' => 'Please select at least one item beam.',
			'wis_id.min' => 'Please select at least one item beam.',
			'wis_id.*.numeric' => 'Each selected item should be numeric.',
			"quantity.required" => "Please enter your work Quantity.",
			"quantity.*.required" => "Each quantity must not be empty.",
			"quantity.*.numeric" => "Each quantity must be a number.",
			"quantity.*.min" => "Each quantity must be at least 1.",
			"ext_item_type_id.required" => "Please enter external item type ID.",
			"ext_item_type_id.numeric" => "External item type ID must be a number.",
			"req_item_id.required" => "Please enter required item ID.",
			"req_item_id.*.required" => "Each required item ID must not be empty.",
			"req_item_id.*.numeric" => "Each required item ID must be a number.",
			"req_item_id.*.min" => "Each required item ID must be at least 1.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrdId 		= $request->work_order_id_req;
		$dataWk 		= WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
		$ItemName 		= $dataWk->item_name;
		$procesTypeId 	= $dataWk->process_type_id;
		$dataPr 		= ProcessRequirement::where('process_type_id', '=', $procesTypeId)->where('status', '=', '1')->first();
		$dataIT 		= ItemType::where('item_type_id', '=', $dataPr->item_type_id)->where('status', '=', '1')->first();
		$itemTypeName 	= $dataIT->item_type_name;
		$Quantity 		= $request->quantity;
		$userId 		= Auth::id();
		$userD 			= User::find($userId);
		$IndividualId 	= $userD->individual_id;
		$curDate 		= date("Y-m-d");
		$reqItemIdArr 	= $request->req_item_id;
		$reqItemQty 	= $request->required_item_qty;
		$qty_arr 		= $request->quantity;
		$WitemId 		= $request->itemIdReq;

		$wisIdArr 		= $request->wis_id;

		$dataWPR = [];
		foreach ($wisIdArr as $stockId => $wisId) {
			$result = WarehouseItemStock::where('wis_id', $wisId)->where('is_allotted_stock', '=', 'No')->first();
			$itemIdQty = $result ? $result->insp_bal_quan_size : null;
			$dataWPR[] = [
				'work_order_id' 	=> $workOrdId,
				'wis_id' 			=> $wisId,
				'item_id' 			=> $WitemId,
				'process_type_id' 	=> $procesTypeId,
				'item_type_id' 		=> $request->ext_item_type_id,
				'work_req_send_by' 	=> $IndividualId,
				'quantity' 			=> $itemIdQty,
				'status' 			=> 1,
				'created' 			=> $curDate,
			];
		}
		$resWPR = WorkProcessRequirement::insert($dataWPR);

		$data = [];
		foreach ($reqItemIdArr as $index => $itemId) {
			$dataI 		= Item::where('item_id', '=', $itemId)->where('status', '=', '1')->first();
			$ItemTypeId = $dataI->item_type_id;
			$qty 		= $qty_arr[$index];
			$data[] = [
				'work_order_id' => $workOrdId,
				'item_id' => $itemId,
				'process_type_id' => $procesTypeId,
				'item_type_id' => $ItemTypeId,
				'work_req_send_by' => $IndividualId,
				'quantity' => $qty,
				'status' => 1,
				'created' => $curDate,
			];
		}
		$res = WorkProcessRequirement::insert($data);



		if ($res) {
			$obj2 = WorkOrder::where('work_order_id', '=', $workOrdId)->update([
				'work_req_send_by' => $IndividualId,
				'is_work_require_request_accepted' => 'Null', // Use 'Null' as a string
				'work_req_send_date' => $curDate,
			]);
			Session::put('message', 'Work Requirement Send to Warehouse successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		}
	}

	public function add_work_requisition_for_dyeing(Request $request)
	{
		//  echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
			"itemIdReq" => "required",
			"work_order_id_req" => "required",
			"tot_req_quantity" => "required",
			"wis_id" => "required",
		], [
			"itemIdReq.required" => "Please select Item Name.",
			"work_order_id_req.required" => "Please select your Work type.",
			"tot_req_quantity.required" => "Please enter your work Quantity.",
			"wis_id.required" => "Please select stock Id.",
		]);
		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}
		$wisIdArr = $request->wis_id;

		$workOrdId  	= $request->work_order_id_req;
		$dataWk 		= WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();

		$ItemName   	= $dataWk->item_name;
		$procesTypeId   = $dataWk->process_type_id;
		$dataPr 		= ProcessRequirement::where('process_type_id', '=', $procesTypeId)->where('status', '=', '1')->first();

		$dataIT 		= ItemType::where('item_type_id', '=', $dataPr->item_type_id)->where('status', '=', '1')->first();
		$itemTypeName 	= $dataIT->item_type_name;


		$ItemTypeId     = $dataPr->item_type_id;
		$userId 		= Auth::id();
		$userD 			= User::find($userId);
		$IndividualId 	= $userD->individual_id;
		$curDate 		= date("Y-m-d");
		$reqItemIdArr 	= $request->req_item_id;

		$WitemId 		= $request->itemIdReq;
		$qty_arr 		= $request->req_quantity;

		$req_grey_qty   = $request->input('req_grey_qty');
		$filteredArray 	= array_filter($req_grey_qty);
		$filtGreyArray 	= array_values($filteredArray);



		$data = [];
		foreach ($reqItemIdArr as $index => $itemId) {
			$dataI = Item::where('item_id', '=', $itemId)->where('status', '=', '1')->first();
			$ItemTypeId = $dataI->item_type_id;
			$qnty = $qty_arr[$index];
			$data[] = [
				'work_order_id' => $workOrdId,
				'item_id' => $itemId,
				'process_type_id' => $procesTypeId,
				'item_type_id' => $ItemTypeId,
				'work_req_send_by' => $IndividualId,
				'quantity' => $qnty,
				'status' => 1,
				'created' => $curDate,
			];
		}
		$res = WorkProcessRequirement::insert($data);

		if (!empty($request->work_order_id_req)) {
			$dataWPR = [];
			foreach ($filtGreyArray as $gindex => $itemqty) {
				$wisId = $wisIdArr[$gindex];
				$dataWPR[] = [
					'work_order_id' 	=> $workOrdId,
					'wis_id' 			=> $wisId,
					'item_id' 			=> $WitemId,
					'process_type_id' 	=> $procesTypeId,
					'item_type_id' 		=> $request->ext_item_type_id,
					'work_req_send_by' 	=> $IndividualId,
					'quantity' 			=> $itemqty,
					'status' 			=> 1,
					'created' 			=> $curDate,
				];
			}
			$resWPR = WorkProcessRequirement::insert($dataWPR);
		}

		if ($resWPR) {
			$obj2  = WorkOrder::where('work_order_id', '=', $workOrdId)->update(
				[
					'work_req_send_by' => $IndividualId,
					'is_work_require_request_accepted' => 'Null',
					'work_req_send_date' => $curDate
				]
			);

			Session::put('message', 'Work Requirement Send to Warehouse successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		}
	}

	public function deleteWorkOrder(Request $request)
	{
		$workId = $request->FId;
		$is_update = WorkOrder::where('work_order_id', '=', $workId)->update(['status' => 0]);
		return $is_update;
	}

	public function checkIteminWarehouse(Request $request)
	{
		//  echo "<pre>"; print_r($request->->all());		
		$FId = explode(',', $request->input('FId'));
		$flag  = 0;
		$Gflag = 0;
		$Dflag = 0;
		foreach ($FId as $soId) {
			$soItem 		= SaleOrderItem::where('sale_order_item_id', '=', $soId)->first();
			$itemId 		= $soItem->item_id;
			$itemTypeId 	= $soItem->item_type_id;
			$dyeingColor 	= $soItem->dyeing_color;

			$chkitemBeam 	= CommonController::getWarehouseAvailableItemStockBeam($itemId, 2);
			$chkBeam  = trim(str_ireplace("meter", "", $chkitemBeam));
			if (!empty($chkBeam)) {
				$flag = 1;
			}
			$chkitemGrig	= CommonController::check_warehouse_greige_type_balance($itemId, 3);
			$chkGrig  		= trim(str_ireplace("meter", "", $chkitemGrig));
			if (!empty($chkGrig)) {
				$Gflag = 1;
			}

			$chkitemDying	  = CommonController::check_warehouse_dyeing_type_balance($itemId, 4, $dyeingColor);
			$chkDying  		  = trim(str_ireplace("meter", "", $chkitemDying));
			if (!empty($chkDying)) {
				$Dflag = 1;
			}
		}

		$result = [
			'weavingwrk' 			=> $flag,
			'dyeingwrk' 			=> $Gflag,
			'coatingwrk' 			=> $Dflag,
		];

		echo json_encode($result);
	}

	public function start_requisition_process($id)
	{
		error_reporting(0);
		$workOrderId 	= base64_decode($id);
		$data 			= WorkOrder::where('work_order_id', $workOrderId)->with('WorkOrderItem')->first();
		$itemId 		= $data->item_id;
		$processId 		= $data->process_type_id ?? 1;
		$dataWI 		= WarehouseItem::where('item_id', $itemId)
			->where('process_type_id', $processId)
			->where('item_qty', '!=', '0')
			->first();
		$itemTypeId = $processId;
		$dataIYR = ItemYarnRequirement::where('item_id', $itemId)
			->where('process_id', $processId)
			->where('status', '1')
			->with('getyarn')
			->get();
		$dataI 		= Item::where('status', '1')->where('item_type_id', '8')->get();
		$dataIC 	= Item::where('status', '1')->where('item_type_id', '9')->get();
		$dataICH 	= Item::where('status', '1')->where('item_type_id', '7')->get();


		$dataIG 	= Item::where('status', '1')->where(function ($query) {
			$query->where('item_type_id', '6')->orWhere('item_type_id', '10');
		})->get();



		// echo $processId; exit;

		$viewName = $this->getViewName($processId);
		return view($viewName, compact("data", "dataI", "dataIC", "dataICH", "dataIG", "dataIYR", "itemId", "itemTypeId", "workOrderId", "dataWI"));
	}

	private function getViewName($processId)
	{
		switch ($processId) {
			case '5':
				return 'html.workorder.start-coating-requisition-process-for-packaging';
			case '4':
				return 'html.workorder.start-dyeing-requisition-process-for-coating';
			case '3':
				return 'html.workorder.start-greige-requisition-process-for-dyeing';
			case '2':
				return 'html.workorder.start-beam-requisition-process-for-weaving';
			default:
				return 'html.workorder.start-requisition-process';
		}
	}

	public function create_work_order_for_weaving(Request $request)
	{
		$validator = Validator::make($request->all(), [
			"work_order_Id" => "required",
		], [
			"work_order_Id.required" => "Work order Not Found.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrderId = $request->work_order_Id;
		$insp_status = 'Complete';

		if ($insp_status === 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
			WorkOrder::where('work_order_id', $workOrderId)->update(['work_status' => $insp_status]);
		}

		$userId = Auth::id();
		$user = User::find($userId);
		$individualId = $user->individual_id;

		$dataOrder 	= WorkOrder::where('work_order_id', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT 	= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 	= $dataPT->process_sl_no_last + 1;
		$dataPr 	= ProcessRequirement::where('process_type_id', $dataPT->id)->where('status', '1')->first();
		$itemTypeId = $dataPr->item_type_id;
		$proType 	= CommonController::getProcessTypeName($dataPT->id);
		$shortcode 	= $proType['shortcode'];
		$curDate 	= date("Y-m-d");

		if ($workOrderId) {
			$objW = new WorkOrder;
			$objW->child_work_order_id 		= $workOrderId;
			$objW->process_type 			= $shortcode;
			$objW->process_sl_no 			= $lastPsnl;
			$objW->user_id 					= $dataOrder->user_id;
			$objW->item_type_id 			= $itemTypeId;
			$objW->process_type_id 			= $dataPT->id;
			$objW->item_id 					= $dataOrder->item_id;
			$objW->item_name 				= $dataOrder->item_name;
			$objW->pcs 						= $dataOrder->pcs;
			$objW->cut 						= $dataOrder->cut;
			$objW->meter 					= $dataOrder->meter;
			$objW->status 					= 1;
			$objW->created 					= date("Y-m-d");
			$is_savedW 						= $objW->save();
			$neworkOrderId 					= $objW->getKey();

			if ($neworkOrderId) {
				foreach ($dataOrder->WorkOrderItem as $soItem) {
					$customerId 	= SaleOrder::where('sale_order_id', $soItem->sale_order_id)->value('individual_id');
					$unit_type_id 	= Item::where('item_id', $soItem->item_id)->value('unit_type_id');

					$obj2 = new WorkOrderItem;
					$obj2->work_order_id 		= $neworkOrderId;
					$obj2->customer_id 			= $customerId;
					$obj2->sale_order_id 		= $soItem->sale_order_id;
					$obj2->sale_order_item_id 	= $soItem->sale_order_item_id;
					$obj2->item_type_id 		= $itemTypeId;
					$obj2->unit_type_id 		= $unit_type_id;
					$obj2->item_id 				= $soItem->item_id;
					$obj2->grey_quality 		= $soItem->grey_quality;
					$obj2->dyeing_color 		= $soItem->dyeing_color;
					$obj2->coated_pvc 			= $soItem->coated_pvc;
					$obj2->extra_job 			= $soItem->extra_job;
					$obj2->print_job 			= $soItem->print_job;
					$obj2->expect_delivery_date = $soItem->expect_delivery_date;
					$obj2->order_item_priority 	= $soItem->order_item_priority;
					$obj2->pcs 					= $soItem->pcs;
					$obj2->cut 					= $soItem->cut;
					$obj2->meter 				= $soItem->meter;
					$obj2->status 				= 1;
					$obj2->created 				= date("Y-m-d");
					$is_saved = $obj2->save();
				}
			}
			$objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last' => $lastPsnl]);

			Session::put('message', 'Work order created successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Something went wrong.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function create_work_order_for_dying(Request $request)
	{
		$validator = Validator::make($request->all(), [
			"work_order_Id" => "required",
		], [
			"work_order_Id.required" => "Work order Not Found.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrderId = $request->work_order_Id;
		$insp_status = 'Complete';

		if ($insp_status === 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
			WorkOrder::where('work_order_id', $workOrderId)->update(['work_status' => $insp_status]);
		}

		$userId 		= Auth::id();
		$user 			= User::find($userId);
		$individualId 	= $user->individual_id;

		$curDate  				= date("Y-m-d");

		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;

		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;

		if ($workOrderId) {
			$woiSql = WorkOrderItem::selectRaw('*, SUM(pcs) AS totPcs, SUM(cut) AS totCut, SUM(meter) AS totMeter')
				->where('work_order_id', '=', $workOrderId)
				->groupBy('dyeing_color')
				->get();

			foreach ($woiSql as $row) {
				$dyValue = strtolower(trim($row->dyeing_color));
				if ($dyValue !== 'no' && $dyValue !== 'not' && $dyValue !== '') {
					$objW = new WorkOrder;
					$objW->child_work_order_id  				= $workOrderId;
					$objW->process_type  						= $shortcode;
					$objW->process_sl_no  						= $lastPsnl;
					$objW->user_id  							= $dataOrder->user_id;
					$objW->item_type_id  						= $itemTypeId;
					$objW->process_type_id  					= $dataPT->id;
					$objW->item_id  							= $row->item_id;
					$objW->item_name  							= $dataOrder->item_name;
					$objW->pcs  								= $row->totPcs;
					$objW->cut  								= $row->totCut;
					$objW->meter  								= $row->totMeter;
					$objW->status  								= 1;
					$objW->created  							= date("Y-m-d");
					$is_savedW 									= $objW->save();
					$neworkOrderId 								= $objW->getKey();

					$woitSql = WorkOrderItem::where('work_order_id', '=', $workOrderId)
						->where('dyeing_color', '=', $dyValue)->get();
					foreach ($woitSql as $rowVal) {
						$objWO = new WorkOrderItem;
						$objWO->work_order_id  					= $neworkOrderId;
						$objWO->item_type_id  					= $itemTypeId;
						$objWO->unit_type_id  					= 2;
						$objWO->customer_id  					= $rowVal->customer_id;
						$objWO->sale_order_id  					= $rowVal->sale_order_id;
						$objWO->sale_order_item_id  			= $rowVal->sale_order_item_id;
						$objWO->item_id  						= $rowVal->item_id;
						$objWO->grey_quality  					= $rowVal->grey_quality;
						$objWO->dyeing_color  					= $rowVal->dyeing_color;
						$objWO->coated_pvc  					= $rowVal->coated_pvc;
						$objWO->extra_job  						= $rowVal->extra_job;
						$objWO->print_job  						= $rowVal->print_job;
						$objWO->expect_delivery_date  			= $rowVal->expect_delivery_date;
						$objWO->order_item_priority  			= $rowVal->order_item_priority;
						$objWO->pcs  							= $rowVal->pcs;
						$objWO->cut  							= $rowVal->cut;
						$objWO->meter  							= $rowVal->meter;
						$objWO->status  						= 1;
						$objWO->created  						= date("Y-m-d");
						$is_saved 								= $objWO->save();
					}
				}
			}


			$objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last' => $lastPsnl]);

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function create_work_order_for_coating(Request $request)
	{

		$validator = Validator::make($request->all(), [
			"work_order_Id" => "required",
		], [
			"work_order_Id.required" => "Work order Not Found.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrderId = $request->work_order_Id;
		$insp_status = 'Complete';

		if ($insp_status === 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
			WorkOrder::where('work_order_id', $workOrderId)->update(['work_status' => $insp_status]);
		}

		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;

		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;


		if ($workOrderId) {
			$woiSql = WorkOrderItem::selectRaw('*, SUM(pcs) AS totPcs, SUM(cut) AS totCut, SUM(meter) AS totMeter')->where('work_order_id', $workOrderId)->groupBy('coated_pvc')->get();

			foreach ($woiSql as $row) {
				$valueC = strtolower(trim($row->coated_pvc));
				if ($valueC !== 'no' && $valueC !== 'not' && $valueC !== '') {
					$objW = new WorkOrder;
					$objW->child_work_order_id  				= $workOrderId;
					$objW->process_type  						= $shortcode;
					$objW->process_sl_no  						= $lastPsnl;
					$objW->user_id  							= $dataOrder->user_id;
					$objW->item_type_id  						= $itemTypeId;
					$objW->process_type_id  					= $dataPT->id;
					$objW->item_id  							= $row->item_id;
					$objW->item_name  							= $dataOrder->item_name;
					$objW->pcs  								= $row->totPcs;
					$objW->cut  								= $row->totCut;
					$objW->meter  								= $row->totMeter;
					$objW->status  								= 1;
					$objW->created  							= date("Y-m-d");
					$is_savedW 									= $objW->save();
					$neworkOrderId 								= $objW->getKey();

					$woitSql = WorkOrderItem::where('work_order_id', '=', $workOrderId)
						->where('coated_pvc', '=', $valueC)->get();
					foreach ($woitSql as $rowVal) {
						$objWO = new WorkOrderItem;
						$objWO->work_order_id  					= $neworkOrderId;
						$objWO->item_type_id  					= $itemTypeId;
						$objWO->unit_type_id  					= 2;
						$objWO->customer_id  					= $rowVal->customer_id;
						$objWO->sale_order_id  					= $rowVal->sale_order_id;
						$objWO->sale_order_item_id  			= $rowVal->sale_order_item_id;
						$objWO->item_id  						= $rowVal->item_id;
						$objWO->grey_quality  					= $rowVal->grey_quality;
						$objWO->dyeing_color  					= $rowVal->dyeing_color;
						$objWO->coated_pvc  					= $rowVal->coated_pvc;
						$objWO->extra_job  						= $rowVal->extra_job;
						$objWO->print_job  						= $rowVal->print_job;
						$objWO->expect_delivery_date  			= $rowVal->expect_delivery_date;
						$objWO->order_item_priority  			= $rowVal->order_item_priority;
						$objWO->pcs  							= $rowVal->pcs;
						$objWO->cut  							= $rowVal->cut;
						$objWO->meter  							= $rowVal->meter;
						$objWO->status  						= 1;
						$objWO->created  						= date("Y-m-d");
						$is_saved 								= $objWO->save();
					}
				}
			}



			$objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last' => $lastPsnl]);

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function create_work_order_for_printing(Request $request)
	{

		$validator = Validator::make($request->all(), [
			"work_order_Id" => "required",
		], [
			"work_order_Id.required" => "Work order Not Found.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrderId = $request->work_order_Id;
		$insp_status = 'Complete';
		if ($insp_status === 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update(['insp_status' => $insp_status]);
			WorkOrder::where('work_order_id', $workOrderId)->update(['work_status' => $insp_status]);
		}

		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;

		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;


		if ($workOrderId) {
			$woiSql = WorkOrderItem::selectRaw('*, SUM(pcs) AS totPcs, SUM(cut) AS totCut, SUM(meter) AS totMeter')->where('work_order_id', $workOrderId)->groupBy('print_job')->get();

			foreach ($woiSql as $row) {
				$valueC = strtolower(trim($row->print_job));
				if ($valueC !== 'no' && $valueC !== 'not' && $valueC !== '') {
					$objW = new WorkOrder;
					$objW->child_work_order_id  				= $workOrderId;
					$objW->process_type  						= $shortcode;
					$objW->process_sl_no  						= $lastPsnl;
					$objW->user_id  							= $dataOrder->user_id;
					$objW->item_type_id  						= $itemTypeId;
					$objW->process_type_id  					= $dataPT->id;
					$objW->item_id  							= $row->item_id;
					$objW->item_name  							= $dataOrder->item_name;
					$objW->pcs  								= $row->totPcs;
					$objW->cut  								= $row->totCut;
					$objW->meter  								= $row->totMeter;
					$objW->status  								= 1;
					$objW->created  							= date("Y-m-d");
					$is_savedW 									= $objW->save();
					$neworkOrderId 								= $objW->getKey();

					$woitSql = WorkOrderItem::where('work_order_id', '=', $workOrderId)
						->where('print_job', '=', $valueC)->get();
					foreach ($woitSql as $rowVal) {
						$objWO = new WorkOrderItem;
						$objWO->work_order_id  					= $neworkOrderId;
						$objWO->item_type_id  					= $itemTypeId;
						$objWO->unit_type_id  					= 2;
						$objWO->customer_id  					= $rowVal->customer_id;
						$objWO->sale_order_id  					= $rowVal->sale_order_id;
						$objWO->sale_order_item_id  			= $rowVal->sale_order_item_id;
						$objWO->item_id  						= $rowVal->item_id;
						$objWO->grey_quality  					= $rowVal->grey_quality;
						$objWO->dyeing_color  					= $rowVal->dyeing_color;
						$objWO->coated_pvc  					= $rowVal->coated_pvc;
						$objWO->extra_job  						= $rowVal->extra_job;
						$objWO->print_job  						= $rowVal->print_job;
						$objWO->expect_delivery_date  			= $rowVal->expect_delivery_date;
						$objWO->order_item_priority  			= $rowVal->order_item_priority;
						$objWO->pcs  							= $rowVal->pcs;
						$objWO->cut  							= $rowVal->cut;
						$objWO->meter  							= $rowVal->meter;
						$objWO->status  						= 1;
						$objWO->created  						= date("Y-m-d");
						$is_saved 								= $objWO->save();
					}
				}
			}



			$objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last' => $lastPsnl]);

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}

	public function accept_item_for_work(Request $request)
	{
		$validator = Validator::make($request->all(), [
			"work_order_Id" => "required",
		], [
			"work_order_Id.required" => "Work order Not Found.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrderId 	= $request->work_order_Id;
		$insp_status 	= 'Complete';
		$userId 		= Auth::id();
		$user 			= User::find($userId);
		$individualId 	= $user->individual_id;
		if ($insp_status === 'Complete') {
			WorkOrder::where('work_order_id', $workOrderId)->update([
				'is_item_received_from_warehouse' => 'Yes',
				'item_received_in_department_by' => $individualId
			]);
		}
		if ($workOrderId) {
			Session::put('message', 'Work Item Accepted successfully.');
			Session::put("messageClass", "successClass");
		} else {
			Session::put('message', 'Something went wrong.');
			Session::put("messageClass", "errorClass");
		}

		return redirect("/show-workorders");
	}

	public function create_work_order_for_packaging(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
			"work_order_Id" => "required",
		], [
			"work_order_Id.required" => "Work order Not Found.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$workOrderId = $request->work_order_Id;
		/*  $insp_status = 'Complete';
		if($workOrderId) 
		{
			WorkOrder::where('work_order_id', $workOrderId)->update([
				'insp_status' => $insp_status,
				'work_status' => $insp_status,
			]);
		}
		*/
		$userId  				= Auth::id();
		$userD   				= User::find($userId);
		$IndividualId 			= $userD->individual_id;

		$dataOrder  			= WorkOrder::where('work_order_id', '=', $workOrderId)->with('WorkOrderItem')->first();
		$dataPT     			= ProcessItem::where('id', '>', $dataOrder->process_type_id)->first();
		$lastPsnl 				= $dataPT->process_sl_no_last + 1;
		$dataPr 				= ProcessRequirement::where('process_type_id', '=', $dataPT->id)->where('status', '=', '1')->first();
		// echo "<pre>"; print_r($dataPr); exit;
		$itemTypeId 			= $dataPr->item_type_id;
		$proTypeId  			= $dataPT->id;
		$proType				= CommonController::getProcessTypeName($proTypeId);
		$shortcode  			= $proType['shortcode'];
		$processTypeId 			= $dataOrder->process_type_id;


		if ($workOrderId) 
		{
			$woiSql = WorkOrderItem::where('work_order_id', $workOrderId)->get();
			foreach ($woiSql as $row) {

				$objW = new WorkOrder;
				$objW->child_work_order_id  				= $workOrderId;
				$objW->process_type  						= $shortcode;
				$objW->process_sl_no  						= $lastPsnl;
				$objW->user_id  							= $dataOrder->user_id;
				$objW->item_type_id  						= $itemTypeId;
				$objW->process_type_id  					= $dataPT->id;
				$objW->item_id  							= $row->item_id;
				$objW->item_name  							= $dataOrder->item_name;
				$objW->pcs  								= $row->pcs;
				$objW->cut  								= $row->cut;
				$objW->meter  								= $row->meter;
				$objW->status  								= 1;
				$objW->created  							= date("Y-m-d");
				$is_savedW 									= $objW->save();
				$neworkOrderId 								= $objW->getKey();

				$objWO = new WorkOrderItem;
				$objWO->work_order_id  					= $neworkOrderId;
				$objWO->item_type_id  					= $itemTypeId;
				$objWO->unit_type_id  					= 2;
				$objWO->customer_id  					= $row->customer_id;
				$objWO->sale_order_id  					= $row->sale_order_id;
				$objWO->sale_order_item_id  			= $row->sale_order_item_id;
				$objWO->item_id  						= $row->item_id;
				$objWO->grey_quality  					= $row->grey_quality;
				$objWO->dyeing_color  					= $row->dyeing_color;
				$objWO->coated_pvc  					= $row->coated_pvc;
				$objWO->extra_job  						= $row->extra_job;
				$objWO->print_job  						= $row->print_job;
				$objWO->expect_delivery_date  			= $row->expect_delivery_date;
				$objWO->order_item_priority  			= $row->order_item_priority;
				$objWO->pcs  							= $row->pcs;
				$objWO->cut  							= $row->cut;
				$objWO->meter  							= $row->meter;
				$objWO->status  						= 1;
				$objWO->created  						= date("Y-m-d");
				$is_saved 								= $objWO->save();
			}

			$objPI = ProcessItem::where('id', '=', $proTypeId)->update(['process_sl_no_last' => $lastPsnl]);

			Session::put('message', 'Work Inspection Updated successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show-workorders");
		} else {
			Session::put('message', 'Somethig error.');
			Session::put("messageClass", "errorClass");
			return redirect("/show-workorders");
		}
	}
}
