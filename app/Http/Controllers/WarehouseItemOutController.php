<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase; 
use App\Models\ItemType; 
use App\Models\UnitType;
use App\Models\Individual;
use App\Models\IndividualAddress;
use App\Models\Item; 
use App\Models\PurchaseItem; 
use App\Models\Warehouse; 
use App\Models\WarehouseItem; 
use App\Models\WareHouseCompartment; 
use Validator, Auth, Session, Hash;
use App\Http\Controllers\CommonController;

class WarehouseItemOutController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(Request $request)
    { 		
	     error_reporting(0);
		 // ->where('entry_type', '=', 'OUT')
		$qsearch =  trim($request->qsearch); 
		$dataWI = WarehouseItem::where(DB::raw("concat(emp_name, invoice_number, pur_item_name)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->with('Purchase')->with('Warehouse')->with('WarehouseCompartment')->with('User')->with('Individual')->orderByDesc('id')->paginate(20);
			
		// echo "<pre>"; print_r($dataWI); exit;
		return view('html.warehouseitems.show-warehouse-item-out', compact("dataWI","qsearch"));
    }
    
    public function create()
    {
        $dataW = Warehouse::where('status', '=', '1')->orderByDesc('id')->get();
		 	
		return view('html.warehouseitems.add-warehouse-item-out', compact("dataW"));
    }

    
    public function store_item_out(Request $request)
    {
		// echo "wddwdw"; exit;
		
		 $validator = Validator::make($request->all(), [
            "warehouseId"=>"required",
            "warehouseCompId"=>"required",
            "emp_name"=>"required",
            "ind_emp_id"=>"required",
            "invoice_number"=>"required",
            "purchaseId"=>"required",
          ], [
            "warehouseId.required"=>"Please select Warehouse.",
            "warehouseCompId.required"=>"Please select Warehouse Compartmentdddddds .",
            "emp_name.required"=>"Please Select Employee Name.",
            "ind_emp_id.required"=>"Something Error, Employee Id Not found.",
            "invoice_number.required"=>"Please Select invoice Number.",
            "purchaseId.required"=>"Your Item Purchase Details Not Found.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}	   
	  //  echo "<pre>"; print_r($request->all()); exit; 
		$purchaseId  		= $request->purchaseId;
		$entry_type  		= 'Out';  
		$warehouseId  		= $request->warehouseId;
		$warehouseCompId  	= $request->warehouseCompId;
		$receiver_id  		= $request->receiver_id;
		$ind_emp_id  		= $request->ind_emp_id;
		$emp_name  			= $request->emp_name;		 	
		$invoice_number  	= $request->invoice_number;
		$pur_item_id_arr 	= $request->pur_item_id;		
		$pur_item_name_arr 	= $request->pur_item_name; 
		$pur_item_qty  		= $request->comp_quantity;
		$bal_quantity  		= $request->bal_quantity;
		$individual_id  	= $request->individual_id;		 
		$receiving_date 	= date('Y-m-d', strtotime($request->receiving_date));		 
		$dataP = Purchase::where('id', '=', $purchaseId)->where('status', '=', '1')->orderByDesc('id')->first();		
		$purchase_date  	= date('Y-m-d', strtotime($dataP->purchased_on));		
		$userId         	= Auth::id();		
		foreach($pur_item_name_arr as $proidk=>$pro_name)
		{ 
			// echo $proid = $pur_item_id_arr[$proidk]; exit; 
			
			// echo $entry_type;  exit; 
			
			$data[] = array(
				'purchase_id' => $purchaseId,
				'entry_type' => $entry_type,
				'warehouse_id' => $warehouseId,
				'ware_comp_id' => $warehouseCompId,
				'ind_emp_id' => $ind_emp_id,
				'individual_id' => $ind_emp_id,
				'purchase_date' => $purchase_date,
				'emp_name' => $emp_name,
				'receiver_id' => $userId,
				'receive_date' => $receiving_date,
				'created' => date("Y-m-d"),
				'status' => 1,
				'invoice_number' => $invoice_number, 
				'pur_item_name' => $pur_item_name_arr[$proidk],
				'pur_item_id' 	=> $pur_item_id_arr[$proidk],
				'pur_item_name' => $pur_item_name_arr[$proidk],
				'pur_item_qty' => $pur_item_qty[$proidk] 
			); 
		
			PurchaseItem::where(['id'=>$pur_item_id_arr[$proidk]])
			->update([
				'receive_qty'=>$pur_item_qty[$proidk],
				'left_qty'=>$bal_quantity[$proidk],
			]);
		
		}			 
		$is_saved =  WarehouseItem::insert($data); 	
		 
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-warehouse-item-out");
		}
		  
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