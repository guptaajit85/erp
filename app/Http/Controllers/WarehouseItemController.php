<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase; 
use App\Models\ItemType; 
use App\Models\UnitType;
use App\Models\Individual;
use App\Models\IndividualAddress;
use App\Models\User; 
use App\Models\Item; 
use App\Models\PurchaseItem; 
use App\Models\Warehouse; 
use App\Models\WarehouseItem;
use App\Models\WorkOrderItem; 
use App\Models\WarehouseCompartment; 
use App\Models\WarehouseBalanceItem; 
use App\Models\WarehouseItemStock; 
use App\Models\GstRate; 
use Validator, Auth, Session, Hash;
use App\Http\Controllers\CommonController;

class WarehouseItemController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
 
	public function index(Request $request)
    {  		
		error_reporting(0);
		$qsearch 		= trim($request->qsearch); 
		$workSaleOrd  	= trim($request->work_sale_ord);	
		$item_type  	= trim($request->item_type);	
		$warehouseId  	= trim($request->warehouseId);	
		$warehCompId  	= trim($request->warehouseCompId);	
		$fromDate 		= $request->from_date;
		$toDate 		= $request->to_date;		
 		$dataIT 		= ItemType::where('status', '=', '1')->get();		
 		$dataW 			= Warehouse::where('status', '=', '1')->orderByDesc('id')->get();	
		 
		
		$query 			= WarehouseBalanceItem::where('status', '=', '1')->where('balance_status', '=', '1')->where('item_qty', '>', '0')->with('Warehouse')->with('WarehouseCompartment')->with('User')->with('Individual')->orderByDesc('id'); 		 
		if(!empty($qsearch)) 
		{  
			$itemIds = Item::where(DB::raw("CONCAT(item_name, ' ', internal_item_name)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->pluck('item_id')->implode(',');     
			$query->whereIn('item_id', explode(',', $itemIds));				
		}		
		if(!empty($item_type)) 
		{	
			$itemType = explode(',', $item_type);	
			$query->whereIn('item_type_id', $itemType);
		} 
		if(!empty($warehouseId)) 
		{			 
			$query->whereIn('warehouse_id', explode(',', $warehouseId));				
		}
		if(!empty($warehCompId)) 
		{ 		 
			$query->whereIn('ware_comp_id', explode(',', $warehCompId));				
		}

		if (!empty($fromDate) && !empty($toDate)) 
		{			
			$fromDate 		= date('Y-m-d', strtotime($request->from_date));
			$toDate 		= date('Y-m-d', strtotime($request->to_date)); 			
			$query->where('receive_date', '>=',  $fromDate)->where('receive_date', '<=',  $toDate);			
		} 
		 
		
		$dataWI 	= $query->paginate(20); 
		
		return view('html.warehouseitems.show', compact("dataWI","qsearch","dataW","dataIT"));
    }
	
	
	public function stock_details_listing(Request $request)
    {  		
		//   echo "<pre>"; print_r($request->all());  // exit;
		 
		$qsearch 		= trim($request->qsearch); 
		$workSaleOrd  	= trim($request->work_sale_ord);	
		$item_type  	= trim($request->item_type);	
		$warehouseId  	= trim($request->warehouseId);	
		$warehCompId  	= trim($request->warehouseCompId);	
		$fromDate 		= $request->from_date;
		$toDate 		= $request->to_date;
		
		$dataIT 		= ItemType::where('status', '=', '1')->get();		
 		$dataW 			= Warehouse::where('status', '=', '1')->orderByDesc('id')->get();		
		$query 			= WarehouseItemStock::where('status', '=', '1')->where('is_allotted_stock', '=', 'No')->with('WarehouseItem')->orderByDesc('wis_id'); 
		if(!empty($qsearch)) 
		{  
			$itemIds = Item::where(DB::raw("CONCAT(item_name, ' ', internal_item_name)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->pluck('item_id')->implode(',');     
			$query->whereIn('item_id', explode(',', $itemIds));				
		}		 
		if(!empty($workSaleOrd)) 
		{
			$ordNumSearchArray = explode(',', $workSaleOrd);
			$saleOrderIds = WorkOrderItem::whereIn('work_order_id', $ordNumSearchArray)->pluck('work_order_id');
			$query->whereIn('work_order_id', $saleOrderIds);
		} 		 
		if(!empty($item_type)) 
		{	
			$itemType = explode(',', $item_type);	
			$query->whereIn('item_type_id', $itemType);
		} 
		if(!empty($warehouseId)) 
		{  
			$wareIds = WarehouseItem::where('warehouse_id', '=', $warehouseId)->where('status', '=', '1')->pluck('id')->implode(',');     
			$query->whereIn('warehouse_item_id', explode(',', $wareIds));				
		}
		if(!empty($warehCompId)) 
		{  
			$wareIds = WarehouseItem::where('warehouse_id', '=', $warehCompId)->where('status', '=', '1')->pluck('id')->implode(',');     
			$query->whereIn('ware_comp_id', explode(',', $wareIds));				
		}

		if (!empty($fromDate) && !empty($toDate)) 
		{			
			$fromDate 		= date('Y-m-d', strtotime($request->from_date));
			$toDate 		= date('Y-m-d', strtotime($request->to_date)); 			
			$query->where('receive_date', '>=',  $fromDate)->where('receive_date', '<=',  $toDate);			
		} 
  
		$dataWI 	= $query->paginate(20);		
		return view('html.warehouseitems.show_stock_details_listing', compact("dataWI","dataW","qsearch","workSaleOrd","dataIT"));
    }
	 
	public function index_old(Request $request)
    {  
		error_reporting(0);
		$qsearch =  trim($request->qsearch);  		
		if(!empty($qsearch)) 
		{
			$query = WarehouseItem::where(DB::raw("concat(emp_name, invoice_number, pur_item_name)"), 'LIKE', '%' . $qsearch . '%')->with('Purchase')->with('Warehouse')->with('WarehouseCompartment')->with('User')->with('Individual')->where('status', '=', '1')->orderByDesc('id'); 
		}
		else 
		{
			$query = WarehouseItem::where('status', '=', '1')->with('Purchase')->with('Warehouse')->with('WarehouseCompartment')->with('User')->with('Individual')->orderByDesc('id');
		} 
		$dataWI = $query->paginate(20); 	 
		return view('html.warehouseitems.show', compact("dataWI","qsearch"));
    }
	 
	public function add_item_in_warehouse()
    {
		// echo "assasas"; exit;
		$dataIT = ItemType::where('status', '=', '1')->where('is_purchase', '=', '1')->get();
		$dataI  = Individual::where('type', '=', 'agents')->where('status', '=', '1')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
        $dataW 	= Warehouse::where('status', '=', '1')->orderByDesc('id')->get();
		$IgstAr = config('global.IGST_RATES');
		$CgstAr = config('global.CGST_RATES');
		$SgstAr = config('global.SGST_RATES'); 
		$dataGst = GstRate::where('status', '=', '1')->get();		
		return view('html.warehouseitems.add-item-in-warehouse', compact("dataW","dataIT","dataUT","IgstAr","CgstAr","SgstAr","dataGst","dataI"));
    }
  
	public function store_item_in_warehouse(Request $request)
	{
		
		$validator = Validator::make($request->all(), [
			"warehouseId" => "required",
			"warehouseCompId" => "required",
			"emp_name" => "required",
			"ind_emp_id" => "required",
			"invoice_number" => "required",
		], [
			"warehouseId.required" => "Please select Warehouse.",
			"warehouseCompId.required" => "Please select Warehouse Compartment.",
			"emp_name.required" => "Please Select Employee Name.",
			"ind_emp_id.required" => "Something Error, Employee Id Not found.",
			"invoice_number.required" => "Please Select invoice Number.",
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$invoice_number 	= $request->invoice_number;
		$cus_name 			= $request->cus_name;
		$individual_id 		= $request->individual_id;
		$receiving_date 	= date('Y-m-d', strtotime($request->receiving_date));
		$warehouseId 		= $request->warehouseId;
		$warehouseCompId 	= $request->warehouseCompId;
		$emp_name 			= $request->emp_name;
		$ind_emp_id 		= $request->ind_emp_id;
		$pur_type_arr 		= $request->pur_type_arr;
		$pro_id_arr 		= $request->pro_id_arr;
		$product_name_arr 	= $request->product_name_arr;
		$hsn_arr 			= $request->hsn_arr;
		$qty_arr 			= $request->qty_arr;
		$unit_arr 			= $request->unit_arr;
		$meter_arr 			= $request->meter_arr;
		$remarks_arr 		= $request->remarks_arr;
		$flag = false;

		foreach ($product_name_arr as $proidk => $pro_name) 
		{
			$itemId = $pro_id_arr[$proidk];
			$itemVal = Item::where('item_id', '=', $itemId)->where('status', '=', '1')->first();

			if ($itemVal) 
			{
				$unitTypeId = $itemVal->unit_type_id;
				$itemTypeId = $itemVal->item_type_id;
				$ItemQty 	= $qty_arr[$proidk];
				$meterQty 	= $meter_arr[$proidk];
				$userId = Auth::id();
				$userD = User::find($userId);
				$IndId = $userD->individual_id;

				if (!empty($ItemQty)) 
				{					 
					$warehouseItem = new WarehouseItem([
						'warehouse_id' 		=> $warehouseId,
						'ware_comp_id' 		=> $warehouseCompId,
						'ind_emp_id' 		=> $ind_emp_id,
						'individual_id' 	=> $individual_id,
						'emp_name' 			=> $emp_name,
						'receiver_id' 		=> $IndId,
						'item_id' 			=> $itemId,					 
						'receive_date' 		=> $receiving_date,	 
						'invoice_number' 	=> $invoice_number,	 
						'pur_item_name' 	=> $product_name_arr[$proidk],
						'item_remark' 		=> $remarks_arr[$proidk],	
						'item_type_id' 		=> $itemTypeId,	
						'unit_type_id' 		=> $unitTypeId,						 
						'item_qty'          => !empty($meterQty) ? $meterQty : $ItemQty,
						'entry_type' 		=> 'IN',
						'created' 			=> now(),	 
						'status' 			=> '1',					 
					]);
					$is_saved 		= $warehouseItem->save();
					
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
					
					

					for ($i = 1; $i <= $ItemQty; $i++) 
					{
						$obj2 = new WarehouseItemStock;
						$obj2->warehouse_item_id 	= $lastInsertId;
						$obj2->quantity 			= 1;
						$obj2->insp_quan_size 		= $meterQty;
						$obj2->entry_type 			= 'IN';
						$obj2->receive_date 		= $receiving_date;
						$obj2->invoice_number 		= $invoice_number;
						$obj2->item_id 				= $itemId;
						$obj2->item_type_id 		= $itemTypeId;
						$obj2->unit_type_id 		= $unitTypeId;
						$packetNumber 				= CommonController::genrateRandomPacketNumber($itemTypeId, $lastInsertId);
						$obj2->packet_number 		= $packetNumber . '/' . $i;						 
						$obj2->created 				= date("Y-m-d H:i:s");
						$obj2->modified 			= date("Y-m-d");
						$obj2->status 				= 1;
						$is_saved2 					= $obj2->save();
					}
				}
			}
			$flag = true;
		}

		if ($flag) {
			Session::put('message', 'Added successfully.');
			Session::put("messageClass", "successClass");
			return redirect("/show");
		}
		else 
		{
			Session::put('message', 'Something went wrong.');
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}
	}
 
	public function create()
    {
        $dataW = Warehouse::where('status', '=', '1')->orderByDesc('id')->get();		 	
		return view('html.warehouseitems.add', compact("dataW"));
    }
	
	 
	public function search_warehouse_compartment(Request $request)
    {  
		$WareId = $request->Id;
		$dataWC = WarehouseCompartment::where('warehouseid', '=', $WareId)->where('status', '=', '1')->orderByDesc('id')->get();	
		$str  ="<label>Warehouse Compartment</label>";
		$str .=" <select class='form-control' required name='warehouseCompId' id='warehouseCompId' onChange='selectEmployee(this.value)'>";
		$str .="<option value=''>Select Warehouse compartment</option>";
		foreach($dataWC as $row)
		{
			$str.="<option value='".$row->id."'";
			$str.=">".$row->warehousename."</option>";
		}
		$str .="</select>"; 
		return $str; 
    }
	
	public function get_warehouse_compartment(Request $request)
    {  
		$WareId = $request->Id;
		$dataWC = WarehouseCompartment::where('warehouseid', '=', $WareId)->where('status', '=', '1')->orderByDesc('id')->get();	
		$str ="";
		$str .=" <select class='form-control' required name='warehouseCompId' id='warehouseCompId' onChange='selectEmployee(this.value)'>";
		$str .="<option value=''>Select Warehouse compartment</option>";
		foreach($dataWC as $row)
		{
			$str.="<option value='".$row->id."'";
			$str.=">".$row->warehousename."</option>";
		}
		$str .="</select>"; 
		return $str; 
    }
	
	public function getPurchaseItemDetails(Request $request)
    { 		
		$InvoiceNum 	= $request->InvoiceNum;
		// $dataP 			= Purchase::where('purchase_number', '=', $InvoiceNum)->where('status', '=', '1')->orderByDesc('id')->first();
		$dataP = Purchase::join('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
		->where('purchases.purchase_number', $InvoiceNum)
		->whereRaw('purchase_items.quantity > purchase_items.receive_qty')
		->select('purchases.*')
		->distinct()
		->first();
		
		$individualId 	= $dataP->individual_id;		
		$dataInd 		= Individual::where('id', '=', $individualId)->where('status', '=', '1')->orderByDesc('id')->first(); 
		$purchased_on 	= $dataP->purchased_on;
		
		// $dataPur = Purchase::where('purchase_number', '=', $InvoiceNum)->where('status', '=', '1')->orderByDesc('id')->get(); 
		
		$dataPur = Purchase::join('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
		->where('purchases.purchase_number', $InvoiceNum)
		->whereRaw('purchase_items.quantity > purchase_items.receive_qty')
		->select('purchases.*')
		->distinct()
		->get();
			
		$str = "<table class='table table-bordered'><tbody><tr>"; 
		$str .= "<td>		
			<p> Vendor - " . htmlspecialchars(ucfirst($dataInd->name)) . " <br/>
			Phone - " . htmlspecialchars($dataInd->phone) . "<br/>
			Date - " . htmlspecialchars(date('Y-m-d', strtotime($purchased_on))) . "</p>	
		</td>";

		foreach ($dataPur as $row) { 
			$purchaseId = $row->id;
			$indata = Individual::where('id', '=', $row->individual_id)->where('status', '=', '1')->orderByDesc('id')->first();
			$str .= "<td><p><input type='radio' onClick='getPurchaseItems(" . $purchaseId . ")' required name='purchaseId' value='" . $purchaseId . "'> " . htmlspecialchars($indata->gstin) . "</p></td>";
		} 

		$str .= "</tr></tbody></table>"; 
		return $str;

      
		
    }
	
	
	public function getPurchaseItems(Request $request)
    { 		
		// echo "<pre>"; print_r($request->all()); exit;
		
		$purchaseId = $request->Id;   
		// $dataPI 	= PurchaseItem::where('purchase_ids', '=', $purchaseId)->where('quantity', '>', 'receive_qty')->where('is_deleted', '=', '0')->orderByDesc('id')->get();	
		$dataPI 	= PurchaseItem::where('purchase_id', $purchaseId)->where('quantity', '>', DB::raw('receive_qty'))->where('is_deleted', 0)->orderByDesc('id')->get();		
		
		$str =""; 
		$str .="<table class='table table-bordered'> <tr>
		<th>Item</th>
		<th>Quantity</th>
		<th>Recived Qty</th>
		<th>Balance Qty</th>
		</tr> "; 
		
		foreach($dataPI as $row) 
		{ 
			$purchaseId 	= $row->purchase_id;
			$itemId 		= $row->item_id;
			$quantity 		= $row->quantity-$row->receive_qty;
			$purItemId 		= $row->id;
			$purItemName 	= $row->name;
			  
			$str .="<tr><input type='hidden' name='pur_item_id[]' id='pur_item_id".$purItemId."' min='0' value=".$purItemId."><input type='hidden' name='item_id[]' id='item_id".$itemId."' min='0' value=".$itemId.">
			<input type='hidden' name='pur_item_name[]' id='pur_item_name".$purItemId."' min='0' value=".$purItemName.">
			<td>".CommonController::getItemName($itemId)." ".$itemId."</td>
			<td>".$quantity."</td>
			<td><input type='number' required onkeyup='CalQuantity(".$purItemId.','.$quantity.")' onblur='CalQuantity(".$purItemId.','.$quantity.")' name='comp_quantity[]' id='comp_quantity".$purItemId."' min='0' max=".$quantity." value=".$quantity."></td>
			<td><input type='number' name='bal_quantity[]' id='bal_quantity".$purItemId."' min='0' value='0'></td>			 
			</tr>";			 
		}
		 
		$str .=" </table>"; 		 
		return $str; 
    }
	
	
	public function getWarehouseCompEmployee(Request $request)
    { 	 
		$Id  	= $request->Id;		 
		$dataWC = WarehouseCompartment::where('id', '=', $Id)->where('status', '=', '1')->orderByDesc('id')->first();
		// echo "<pre>"; print_r($dataWC); exit;
		$individualId = $dataWC->ind_emp_id;		 
		$dataInd = Individual::where('id', '=', $individualId)->where('status', '=', '1')->orderByDesc('id')->first();		
		$str     = $individualId.'||'.$dataInd->name;
		return $str; 
    } 
	   
	public function warehouse_stock_report(Request $request)
    { 
		error_reporting(0);
		$qsearch 	= trim($request->qsearch);  
		if(!empty($qsearch))
		{
			$dataWI 	= WarehouseItem::where(DB::raw("concat(emp_name, invoice_number, pur_item_name)"), 'LIKE', '%' . $qsearch . '%')		
			->where('status', '=', '1') 
			->where('item_qty', '>', '0') 
			->where('item_type_id', '>', '0') 
			->with('Warehouse')
			->with('WarehouseCompartment') 
			->with('Individual') 
			->orderByDesc('id')->paginate(20); 			
		} 
		else  
		{
			$dataWI = WarehouseItem::where('status', '=', '1') 
			->where('item_qty', '>', '0') 
			->where('item_type_id', '>', '0') 
			->with('Warehouse')
			->with('WarehouseCompartment') 
			->with('Individual') 
			->orderByDesc('id')->paginate(20); 			
		}
		/* $dataWI = DB::table('warehouse_items')
		->select('item_type_id', DB::raw('count(*) as total'))
		->groupBy('item_type_id')
		->get();
		*/

		
		return view('html.warehouseitems.show-warehouse-stock-report', compact("dataWI","qsearch"));
    }
	 
	public function deleteWarehouseItem(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= WarehouseItem::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	
}
