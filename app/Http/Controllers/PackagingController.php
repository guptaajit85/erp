<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Packaging;
use App\Models\SaleOrder;
use App\Models\Individual;
use App\Models\PackagingType;
use App\Models\SaleOrderItem;
use App\Models\IndividualAddress;
use App\Models\PackagingOrder;
use App\Models\PackagingOrderItem; 
use App\Models\SaleEntry;
use App\Models\SaleEntryItem;
use App\Models\Item; 
use App\Models\Company; 

use Validator, Session, Hash;

class PackagingController extends Controller
{
    
    public function __construct()
    {
         $this->middleware('auth');
	}
	
    public function index(Request $request)
	{
		$search  = $request->search; 
		 
		$dataP = PackagingOrder::where('status', '=', '1')
		->with(['packagingOrderItems.PackagingType', 'packagingOrderItems.Item', 'individual'])
		->orderByDesc('id')
		->paginate(20); 
		
		 // echo "<pre>";  print_r($dataP); exit;
		return view('html.packaging.show-packagings', compact('dataP'));
	}

   
    public function create_packaging(Request $request)
	{ 
		$individualId 	= $request->input('individual_id'); 
	    $cusName 		= $request->input('cus_name');
		if(!empty($individualId) && !empty($cusName)) 
		{
			$dataInd = Individual::where('id', $individualId)->first(); 
			$query   = SaleOrder::where('individual_id', '=', $individualId)
				->where('is_deleted', '=', '0')
				->with(['SaleOrderItem' => function ($query) {					 
					$query->where('is_work_completed', '=', '1');
				}, 'Individual', 'ItemType']);

			$dataP = $query->paginate(20);
			$dataIAS  	= IndividualAddress::where('individual_id', $individualId)->where('address_type', 's')->where('status', '1')->get();
			$dataIAB  	= IndividualAddress::where('individual_id', $individualId)->where('address_type', 'b')->where('status', '1')->get();			
		} 
		else 
		{
			$dataP 	 = null;
			$dataInd = null;
			$dataIAS = null;
			$dataIAB = null;
		}
		$dataPT 	= PackagingType::where('status', 1)->get();		
		
		
		 
		return view('html.packaging.add-packaging', compact("dataP", "dataPT", "dataIAS", "dataIAB", "cusName", "individualId", "dataInd"));
	}
 
    
    public function store_packaging(Request $request)
    {
	  
		$validator = Validator::make($request->all(), [
			"sale_order_item_id.*" => "required",
			"pack_type.*" => "required",
			"pack_meter.*" => "required|numeric|min:1",
		], [
			"sale_order_item_id.*.required" => "Please select item.",
			"pack_type.*.required" => "Pack type is required.",
			"pack_meter.*.required" => "Pack meter is required.",
			"pack_meter.*.numeric" => "Pack meter must be a number.",
			"pack_meter.*.min" => "Pack meter must be at least :min.",
		]);

		if ($validator->fails()) 
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}
 
		
		$individual_id 			= $request->individual_id;
		$shiping_address 		= $request->shiping_address;
		$billing_address 		= $request->address;
		$ind_add_id_ship 		= $request->ind_add_id_ship;
		$cus_bill_add_id 	 	= $request->ind_add_id;
		
		
		$soiIdArr 		= $request->sale_order_item_id;
		$pacTypeArr 	= $request->pack_type;
		$packMeterArr 	= $request->pack_meter;
		 
		 
		$newPackagingOrder = new PackagingOrder();		
		$newPackagingOrder->customer_id 		= $individual_id;
		$newPackagingOrder->cus_bill_add_id 	= $cus_bill_add_id;
		$newPackagingOrder->cus_ship_add_id 	= $ind_add_id_ship;
		$newPackagingOrder->shiping_address 	= $shiping_address;
		$newPackagingOrder->billing_address 	= $billing_address;
		$newPackagingOrder->created 			= now();
		$newPackagingOrder->status 				= 1;
		$isSaved = $newPackagingOrder->save();
		 
		if($isSaved)
		{
			$lastInsertedId = $newPackagingOrder->id;
			$pacTypeArr 	= $request->pack_type;
			$packMeterArr 	= $request->pack_meter;
		 
			foreach ($soiIdArr as $proidk => $soiId) {
				$packType   = $pacTypeArr[$proidk];
				$packMeter  = $packMeterArr[$proidk];
				$soiData    = SaleOrderItem::where('sale_order_item_id', '=', $soiId)->first();                
				
				$poiArr     = new PackagingOrderItem();    
				
				$poiArr->packaging_ord_id       = $lastInsertedId;               
				$poiArr->sale_order_id          = $soiData->sale_order_id;
				$poiArr->sale_order_item_id     = $soiId;
				$poiArr->pack_type              = $packType;
				$poiArr->pack_meter             = $packMeter;  
				$poiArr->item_id                = $soiData->item_id;
				$poiArr->pcs                    = $soiData->pcs;
				$poiArr->cut                    = $soiData->cut;
				$poiArr->meter                  = $packMeter;  
				$poiArr->rate                   = $soiData->rate;
				$poiArr->amount                 = $soiData->amount;
				$poiArr->discount               = $soiData->discount;
				$poiArr->discount_amount        = $soiData->discount_amount;
				$poiArr->net_amount             = $soiData->net_amount;
				$poiArr->coated_pvc             = $soiData->coated_pvc;
				$poiArr->extra_job              = $soiData->extra_job;
				$poiArr->print_job              = $soiData->print_job;				 
				$poiArr->created                = now();
				$poiArr->status                 = 1;
				$isSaved = $poiArr->save(); 
			}
			
		}	 
		
		 
		if($isSaved)
		{
			Session::put('message', 'E-Way Bill Genrated Successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-packagings");
		}
    }
	
	public function genrate_package_invoice(Request $request)
	{
		$validator = Validator::make($request->all(), [
			"package_order_id" => "required",
		], [
			"package_order_id.required" => "Please select an item.",
		]);

		if ($validator->fails()) {
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass", "errorClass");
			return redirect()->back()->withInput();
		}

		$user 		= auth()->user();
		$userId 	= $user->individual_id;
		$packOrdId 	= $request->package_order_id;

		$dataPO 	= PackagingOrder::where('id', $packOrdId)->where('status', '1')->with(['packagingOrderItems.PackagingType', 'packagingOrderItems.Item', 'individual'])->orderByDesc('id')->first();

		$total 				= 0;
		$subtotal 			= 0;
		$couponDiscount 	= 0;
		foreach ($dataPO->packagingOrderItems as $poiRow) 
		{
			$subtotal 		+= $poiRow->amount;
			$total 			+= $poiRow->net_amount;
			$couponDiscount += $poiRow->discount_amount;
		}
		$saleEntry = new SaleEntry([
			'packaging_ord_id' 		=> $dataPO->id,
			'individual_id' 		=> $dataPO->customer_id,
			'billing_address' 		=> $dataPO->billing_address,
			'shipping_address' 		=> $dataPO->shiping_address,
			'sale_entry_on' 		=> now(),
			'total'				 	=> $total,
			'subtotal' 				=> $subtotal,
			'coupon_discount' 		=> $couponDiscount,
			'is_deleted' 			=> 0,
			'created_by' 			=> $userId,
		]);
		$isSaved = $saleEntry->save();
		if($isSaved) 
		{  
			$lastInsertedId = $saleEntry->sale_entry_id;
			$saleEntryItems = [];
			foreach ($dataPO->packagingOrderItems as $poiArr) {
				$item = Item::find($poiArr->item_id);
				$saleEntryItems[] = [
					'sale_entry_id' 			=> $lastInsertedId,
					'packaging_ord_id' 			=> $poiArr->packaging_ord_id,
					'packaging_ord_item_id' 	=> $poiArr->id,
					'sale_order_id' 			=> $poiArr->sale_order_id,
					'sale_order_item_id' 		=> $poiArr->sale_order_item_id,
					'pack_type' 				=> $poiArr->pack_type,
					'item_id' 					=> $poiArr->item_id,
					'name' 						=> $item->item_name,
					'total_price' 				=> $poiArr->net_amount,
					'unit' 						=> 'Meter',
					'pcs' 						=> $poiArr->pcs,
					'cut' 						=> $poiArr->cut,
					'meter' 					=> $poiArr->meter,
					'rate' 						=> $poiArr->rate,
					'amount' 					=> $poiArr->amount,
					'discount' 					=> $poiArr->discount,
					'discount_amount' 			=> $poiArr->discount_amount,
					'net_amount' 				=> $poiArr->net_amount,
					'dyeing_color' 				=> $poiArr->dyeing_color,
					'coated_pvc' 				=> $poiArr->coated_pvc,
					'extra_job' 				=> $poiArr->extra_job,
					'print_job' 				=> $poiArr->print_job,
					'created_by' 				=> $userId,
					'created' 					=> now(),
					'modified' 					=> now(),
				];
			}
			SaleEntryItem::insert($saleEntryItems);
			
			PackagingOrder::where('id', $packOrdId)->update([
				'is_invoice_generated' => 'Yes',
				'sale_entry_id' => $lastInsertedId,
			]); 
			 
		}
		
		Session::put('message', 'Invoice Generated Successfully.');
		Session::put("messageClass", "successClass");
		return redirect("/show-packagings");
	
	}
     
	 
    public function show(Packaging $qualityType)
    {
        //
    }
    
    
	
	
    public function print_packaging_items($packaging_id)
    {         
		$packagingId = base64_decode($packaging_id);			
		$data  		 = PackagingOrder::where('id', $packagingId)->with(['packagingOrderItems.PackagingType', 'packagingOrderItems.Item', 'individual'])->first();
		
		return view('html.packaging.print-package-items',compact("data"));         
    }

     
    public function update_packaging(Request $request, Packaging $qualityType)
    {
        $validator = Validator::make($request->all(), [
            "packaging_name"=>"required|string|max:100",
            "packaging_des"=>"required|string|max:100",

          ], [
            "packaging_name.required"=>"Please enter name.",
            "packaging_des.required"=>"Please enter Description.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		 

		$obj = Packaging::find($request->packaging_id);
		$obj->packaging_name  					= $request->packaging_name;
        $obj->packaging_des  					= $request->packaging_des;
		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-packagings");
		}

    }
    
	public function deletePackaging(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Packaging::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }


     
}