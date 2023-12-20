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
use App\Models\Item;
use App\Models\WorkProcessRequirement;
use App\Models\WarehouseItemStock;
use App\Models\Company;  
use App\Models\WarehouseOutItem;
use App\Models\WarehouseBalanceItem;
use Validator, Auth, Session, Hash;
use App\Http\Controllers\CommonController;

 

class WorkProcessRequirementController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index()
    {
        // error_reporting(0);  
		$dataWPR = WorkProcessRequirement::groupBy('work_order_id')
		->selectRaw('work_order_id, COUNT(*) as count')->with('WorkOrder')
		->orderByDesc('work_order_id')
		->paginate(20); 
	 //  echo "<pre>"; print_r($dataWPR); exit;
		return view('html.workprocessrequirement.show-warehouse-item-requirement', compact("dataWPR"));
    }

	public function accept_warehouse_item_requirement($Id)
    {
		$workOrdId 	 	= base64_decode($Id);
		$dataWPR 		= WorkProcessRequirement::where('work_order_id', '=', $workOrdId)->with('Item')->where('status', '=', '1')->get();
		//  echo "<pre>"; print_r($dataWPR); exit; 
		$result = [];
		$result['workOrdId'] 	= $workOrdId;
	 	return view('html.workprocessrequirement.accept-warehouse-item-requirement', compact("dataWPR","result")); 
    }


	public function StoreWarehouseStockAllotment(Request $request)
    {  
			// error_reporting(0);
		   echo "<pre>"; print_r($request->all());   exit;
		   
			$validator = Validator::make($request->all(), [
				"used_item"=>"required",
				"wis_id"=>"required",
				"warehouse_item_id"=>"required",
				"work_process_req_id"=>"required", 
				"work_order_id"=>"required",	
				"allotment_remark"=>"required",			
			], [
				"used_item.required"=>"Received Quantity not found.",
				"wis_id.required"=>"Warehouse Item Stock Id not Found",
				"warehouse_item_id.required"=>"Warehouse item Id not found",	
				"work_process_req_id.required"=>"Work process request not found",	
				"work_order_id.required"=>"Work order not found", 
				"allotment_remark.required"=>"Stock Allotment remark not found.",			
			]);
			
			if ($validator->fails())
			{
				$error = $validator->errors()->first();
				Session::put('message', $validator->messages()->first());
				Session::put("messageClass","errorClass");
				return redirect()->back()->withInput();
			} 
			
			$workProcessReqIdArr 		= $request->work_process_req_id;
			$workOrderId 				= $request->work_order_id;
			$allotQuantity 				= $request->allot_quantity;
			$allotmentRemark 			= $request->allotment_remark;
			$useQuan 					= $request->used_item;
			$wisIdArr 					= $request->wis_id; 
			$warehouseItemIdArr 		= $request->warehouse_item_id; 
			$userId         			= Auth::id();
			$userD 						= User::find($userId);
			$IndId  					= $userD->individual_id; 
			
			$flag = false;
			foreach($wisIdArr as $wisidk=>$wisId)
			{  
				$used_quan 			= $useQuan[$wisidk];
				$warehouseItemId 	= $warehouseItemIdArr[$wisidk]; 
				$workProcessReqId 	= $workProcessReqIdArr[$wisidk]; 
				
				WarehouseItemStock::where(['wis_id'=>$wisId])
				->update([
					'is_allotted_stock'	=>'Yes',
					'work_order_id'		=>$workOrderId,
					'work_pro_req_id'	=>$workProcessReqId,
					'stock_alloted_by'	=>$IndId,
					'alloted_remark'	=>$allotmentRemark,
				]); 
				 
				$dataWI = WarehouseItem::find($warehouseItemId);				
				// echo "<pre>"; print_r($dataWI); exit;
				if (empty($dataWI))
				{
					$error = $validator->errors()->first();
					Session::put('message', 'Warehouse Item Not Found.');
					Session::put("messageClass","errorClass");
					return redirect()->back()->withInput();
				} 

				$outArr = new WarehouseOutItem;			 
				$outArr->process_type_id  			= $dataWI->process_type_id;
				$outArr->warehouse_id  				= $dataWI->warehouse_id;
				$outArr->ware_comp_id  				= $dataWI->ware_comp_id;
				$outArr->item_id  					= $dataWI->item_id;
				$outArr->item_type_id  				= $dataWI->item_type_id;
				$outArr->unit_type_id  				= $dataWI->unit_type_id;
				$outArr->item_qty  					= '1';
				$outArr->pcs  						= $dataWI->pcs;
				$outArr->cut  						= $dataWI->cut;
				$outArr->meter  					= $dataWI->meter;
				$outArr->individual_id  			= $IndId;
				$outArr->work_order_id  			= $workOrderId;
				$outArr->item_remark  				= $allotmentRemark;
				$outArr->grey_quality  				= $dataWI->grey_quality;
				$outArr->dyeing_color  				= $dataWI->dyeing_color;
				$outArr->coated_pvc  				= $dataWI->coated_pvc;
				$outArr->print_job  				= $dataWI->print_job;
				$outArr->extra_job  				= $dataWI->extra_job;				 
				$outArr->created  					= date("Y-m-d");				
				$is_saved 							= $outArr->save(); 				
				$lastInsertId 						= $outArr->id; 
				 // exit;
				 
				$newItem = WarehouseOutItem::create([
					'process_type_id' => $dataWI->process_type_id,
					'warehouse_id' => $dataWI->warehouse_id,
					'ware_comp_id' => $dataWI->ware_comp_id,
					'item_id' => $dataWI->item_id,
					'item_type_id' => $dataWI->item_type_id,
					'unit_type_id' => $dataWI->unit_type_id,
					'item_qty' => $request->item_qty,
					'pcs' => $request->pcs ?? 0.00,
					'cut' => $request->cut,
					'meter' => $request->meter ?? 0.00,
					'individual_id' => $request->individual_id,
					'work_order_id' => $request->work_order_id,
					'item_remark' => $request->item_remark,
					'grey_quality' => $request->grey_quality,
					'dyeing_color' => $request->dyeing_color,
					'coated_pvc' => $request->coated_pvc,
					'print_job' => $request->print_job,
					'extra_job' => $request->extra_job,
					'created' => now(),
					'status' => 1,
				]); 
						 
				 
				 
				 
				 
				 
				 
				$totItemQty 	= $dataWI->item_qty;
				$totAllotQty 	= $dataWI->allotted_qty;
				$totQty 		= $totItemQty-1;
				$totAltQty 		= $totAllotQty+1;
				
				WarehouseItem::where(['id'=>$warehouseItemId])
				->update([					 
					'item_qty'			=> $totQty,
					'allotted_qty'		=> $totAltQty,					 
				]);
 
				$objWP  = WorkProcessRequirement::where('id', '=', $workProcessReqId)
				->update([
					'is_pro_acc_by_warehouse'=> 'Yes',
					'process_accepted_by'=> $IndId,
					'acc_deny_date'=> date("Y-m-d")
				]); 
				
				$obj2  = WorkOrder::where('work_order_id', '=', $workOrderId)->update(
				['is_work_require_request_accepted'=> 'Yes']); 
				
				$flag = true; 
			}
			if($flag) 
			{
				Session::put('message', 'Stock Alloted successfully.');
				Session::put("messageClass","successClass");
				return redirect("/show-warehouse-item-requirement");
			}
		  
    }


	public function getWorkProcessAllotmentView(Request $request)
	{
		$FId 			= $request->FId;
		$dataWPR 		= WorkProcessRequirement::find($FId);
		$workOrdId 		= $dataWPR->work_order_id;
		$dataWk 		= WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
		$itemId 		= $dataWk->item_id;
		$itemName 		= $dataWk->item_name;
		$procesTypeId 	= $dataWk->process_type_id;

		$dataIT 		= ItemType::where('item_type_id', '=', $dataWPR->item_type_id)->where('status', '=', '1')->first();
		$itemTypeName 	= $dataIT->item_type_name;
		$quanTity 		= $dataWPR->quantity;

		$result = [
			'itemId' => $itemId,
			'ItemName' => $itemName,
			'workOrdId' => $workOrdId,
			'itemTypeName' => $itemTypeName,
			'quanTity' => $quanTity,
			'work_process_req_id' => $dataWPR->id,
		];

		$orderCounts = WarehouseItemStock::select('item_id', 'item_type_id', 'alloted_remark', DB::raw('count(work_pro_req_id) as req_count'))
			->groupBy('item_id')
			->where('work_order_id', '=', $workOrdId)
			->with('Item', 'Item.UnitType') // Eager loading
			->get();

		if (!empty($orderCounts[0]->item_id)) 
		{
			$str = "";
			 
			$str .= '<table class="table table-bordered"><tbody>';
			 
			foreach ($orderCounts as $count) {
				$itemtypeId = $count->item_type_id;
				$itemType = ItemType::where('item_type_id', '=', $itemtypeId)->value('item_type_name');
				$str .= '<tr>
							<td>' . $itemType . '</td>
							<td>Quantity</td>
						</tr>';

				if ($itemtypeId == '2') {
					$unitTypeName = 'Beam';
				} else {
					$unitTypeName = $count->Item->UnitType->unit_type_name;
				}

				$str .= "<tr>";
				$str .= "<td>{$count->Item->item_name} </td>";
				$str .= "<td>{$count->req_count}  {$unitTypeName} </td>";
				$str .= "</tr>";
			}

			$str .= "</tbody></table>";
			$str .= ' <strong> Allotment Remark </strong> =  ' . $orderCounts[0]->alloted_remark . ' ';
		} 
		else 
		{
			$str = "";
			$str .= '<table class="table table-bordered"><tbody>';
			$str .= '<tr> <td>Record Not Found!</td> </tr>';
			$str .= "</tbody></table>";
		}

		$result['stock_allot_arr'] = $str;

		return response()->json($result);
	}
	
	public function getWorkProcessRequirement(Request $request)
    {
		$workOrdId 		= $request->FId;
		$dataWk 		= WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
		$itemId  		= $dataWk->item_id;
		$WorkItemName   = $dataWk->item_name;
		$procesTypeId   = $dataWk->process_type_id;

		$dataWPR 		= WorkProcessRequirement::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->get();

		$str ="";
		$str.='<input type="hidden" name="work_order_id" id="work_order_id" value="'.$workOrdId.'" class="form-control">';
		$str.='<table class="table table-bordered">
				  <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                  </tr>';
		foreach($dataWPR as $row)
		{
			// echo "<pre>"; print_r($row); exit;
			$dataI 		= Item::where('item_id', '=', $row->item_id)->where('status', '=', '1')->first();
			$itemName 		= $dataI->item_name;
			$quantity 		= $row->quantity;


			$str.='<tr>
			<input type="hidden" name="wpr_id[]" id="wpr_id[]" value="'.$row->id.'" class="form-control">
			<input type="hidden" name="item_id[]" id="item_id[]" value="'.$row->item_id.'" class="form-control">
			<input type="hidden" name="item_name[]" id="item_name[]" value="'.$itemName.'" class="form-control">
			<input type="hidden" name="item_quan[]" id="item_quan[]" value="'.$quantity.'" class="form-control">
			<td> '.$itemName.' </td>
			<td> '.$quantity.' </td>';

		}

		$str.='</tr>
		</table>';

		// echo "<pre>"; print_r($request->all()); exit;
		$result = [];
		$result['wprDetails'] = $str;
		$result['WorkItemName'] = $WorkItemName;

		echo json_encode($result);


    }

 
		public function getProcessRequirementItems(Request $request)
		{
			$workOrdId = $request->FId;
			$dataWk = WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
			$itemId 		= $dataWk->item_id;
			$WorkItemName 	= $dataWk->item_name;
			$procesTypeId 	= $dataWk->process_type_id;
			$dataWPR = WorkProcessRequirement::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->get();
			$str = "";			
			if($procesTypeId =='2') { 
				$str .= '<table class="table table-bordered">';
				$str .= '<tr> <th>Beam for Yarn</th> </tr></table>';		
			}		
			$str .= '<table class="table table-bordered">';			 
			$str .= '<tr>
						<th>Item Name</th>
						<th>Quantity</th>
					</tr>';

			foreach ($dataWPR as $row) {
				$dataI = Item::where('item_id', '=', $row->item_id)->where('status', '=', '1')->first();
				$itemName = $dataI->item_name;
				$quantity = $row->quantity;
				$unit_type_id = $dataI->unit_type_id;
				if ($row->item_type_id == '2') {
					$unitTName = 'Beam';
				} else {
					$unitTName = CommonController::getUnitTypeName($unit_type_id);
				}
				$str .= '<tr>
					<td>' . $itemName . '</td>
					<td>' . $quantity . ' ' . $unitTName . '</td>
				</tr>';
			}

			$str .= '</table>';
			$result = [
				'wprDetails' 	=> $str,
				'WorkItemName' 	=> $WorkItemName,
			];
			return response()->json($result);
		}


    public function print_warehouse_item_requirement_gatepass($id)
	{
			$wprId 	 = base64_decode($id);
			$dataWPR = WorkProcessRequirement::where('status', '=', '1')->first();
			$workOrderId 	= $dataWPR->work_order_id;
			$userId 		= Auth::id();
			$userD 			= User::find($userId);
			$IndividualId 	= $userD->individual_id;
			$dataInd 		= Individual::where('id', '=', $IndividualId)->where('status', '=', '1')->first();
			$currentDate 	= date('Y-m-d');
			$compData 		= Company::find(1);
			$data 			= WorkOrder::where('work_order_id', $workOrderId)->with('WarehouseItem')->first();
							//   echo "<pre>"; print_r($data); exit;
			$fromDepartment = $data->process_type_id;
			$toDepartment 	= $fromDepartment+1;

			return view('html.workprocessrequirement.print-warehouse-item-requirement-gatepass',compact("data","toDepartment","compData","dataInd"));
	}




    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

	public function AcceptWarehouseReq(Request $request)
    {
		$userId = Auth::id();
		$userD 	= User::find($userId);
		$IndId  = $userD->individual_id;
		$FId 	= $request->FId;
		$obj 	= WorkProcessRequirement::find($FId);
		$workOrderId  = $obj->work_order_id;
		// echo "<pre>"; print_r($obj); exit;

		$obj->is_pro_acc_by_warehouse  = 'Yes';
		$obj->process_accepted_by  	   = $IndId;
		$obj->acc_deny_date  	   	   = date("Y-m-d");
		$obj->save();

		$obj2  = WorkOrder::where('work_order_id', '=', $workOrderId)->update(
		['is_work_require_request_accepted'=> 'Yes']);

		return $FId;
    }

	public function DenyWarehouseReq(Request $request)
    {
		$userId = Auth::id();
		$userD 	= User::find($userId);
		$IndId  = $userD->individual_id;
		$FId 	= $request->FId;
		$obj 	= WorkProcessRequirement::find($FId);
		$workOrderId  = $obj->work_order_id;
		// echo "<pre>"; print_r($obj); exit;

		$obj->is_pro_acc_by_warehouse  = 'No';
		$obj->process_accepted_by  	   = $IndId;
		$obj->acc_deny_date  	   	   = date("Y-m-d");
		$obj->save();

		$obj2  = WorkOrder::where('work_order_id', '=', $workOrderId)->update(
		['is_work_require_request_accepted'=> 'No']);

		return $FId;
    }

    public function destroy($id)
    {
        //
    }

	public function accept_warehouse_item_requirement_old($Id)
    {
		$FId 	 		= base64_decode($Id);
		$dataWPR 		= WorkProcessRequirement::find($FId);
		$processAcceptedBy = $dataWPR->process_accepted_by;

		if(!empty($processAcceptedBy))
		{
			Session::put('message', 'Your Work Process Requirement Invalid.');
			Session::put("messageClass","errorClass");
			return redirect("/show-warehouse-item-requirement");
		}
		//  echo "<pre>"; print_r($dataWPR); exit;

		$workOrdId 		= $dataWPR->work_order_id;
		$dataWk 		= WorkOrder::where('work_order_id', '=', $workOrdId)->where('status', '=', '1')->first();
		$itemId  		= $dataWk->item_id;
		$ItemName   	= $dataWk->item_name;
		$procesTypeId   = $dataWk->process_type_id;
		$itemTypeId 	= $dataWPR->item_type_id;
		$dataIT 		= ItemType::where('item_type_id', '=', $dataWPR->item_type_id)->where('status', '=', '1')->first();
		$itemTypeName 	= $dataIT->item_type_name;
		$quanTity 		= $dataWPR->quantity;

		$dataWIS 		= WarehouseItemStock::where('item_type_id', '=', $itemTypeId)->where('entry_type', '=', 'IN')->where('is_allotted_stock', '=', 'No')->where('status', '=', '1')->limit($quanTity)->get();

		$result = [];
		$result['itemId'] 		= $itemId;
		$result['ItemName'] 	= $ItemName;
		$result['workOrdId'] 	= $workOrdId;
		$result['itemTypeName'] = $itemTypeName;
		$result['quanTity'] 	= $quanTity;
		$result['work_process_req_id'] 	= $dataWPR->id;


	 	return view('html.workprocessrequirement.accept-warehouse-item-requirement', compact("dataWPR","result","dataWIS"));
    }




}
