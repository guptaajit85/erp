<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\Individual;
use App\Models\IndividualAddress;
use App\Models\Item;

use App\Models\Company;
use App\Models\SaleOrder;
use App\Models\GstRate;

use Validator, Auth, Session, Hash;


class PurchaseController extends Controller
{
	public function __construct()
    {
		$this->middleware('auth');
    }

    public function index(Request $request)
    {
		$itemType 	= $request->priority;
	  	$qsearch =  trim($request->qsearch);
		 $dataP = Purchase::where('is_deleted', 0)
		->with('PurchaseItem')
		->where(function ($query) use ($qsearch) {
			$query->where('purchase_number', 'LIKE', '%' . $qsearch . '%')
				->orWhere('billing_address', 'LIKE', '%' . $qsearch . '%')
				->orWhere('shiping_address', 'LIKE', '%' . $qsearch . '%');
		})
		->orWhereHas('PurchaseItem', function ($query) use ($qsearch) {
			$query->where('dis_type', 'LIKE', '%' . $qsearch . '%')
				->orWhere('remarks', 'LIKE', '%' . $qsearch . '%')
				->orWhere('order_item_priority', 'LIKE', '%' . $qsearch . '%')
				->orWhere('grey_quality', 'LIKE', '%' . $qsearch . '%')
				->orWhere('dyeing_color', 'LIKE', '%' . $qsearch . '%')
				->orWhere('coated_pvc', 'LIKE', '%' . $qsearch . '%')
				->orWhere('extra_job', 'LIKE', '%' . $qsearch . '%')
				->orWhere('print_job', 'LIKE', '%' . $qsearch . '%')
				->orWhere('expect_delivery_date', 'LIKE', '%' . $qsearch . '%')
				->orWhere('saleprice', 'LIKE', '%' . $qsearch . '%')
				->orWhere('total_price', 'LIKE', '%' . $qsearch . '%');
		})->orderByDesc('id')
		->paginate(20);
	 
	  //  echo"<pre>"; print_r($dataP); exit;
	   $dataIT = ItemType::where('status', '=', '1')->where('is_purchase', '=', '1')->get();
	  
		return view('html.purchase.show-purchases',compact("dataP","itemType","qsearch","dataIT"));
    }

    public function list_purchage_entry(Request $request,$id = NULL)
    {
        $individual_id = base64_decode($id);
		$qsearch =  trim($request->qsearch);
		$dataP = Purchase::where('individual_id', '=', $individual_id)->where(DB::raw("concat(purchase_number, billing_address, shiping_address)"), 'LIKE', '%' . $qsearch . '%')->where('is_deleted', '=', '0')->paginate(20);
		// echo"<pre>"; print_r($dataP); exit;
		return view('html.purchase.list-purchage-entry',compact("dataP","qsearch"));
    }

    public function create()
    {
		error_reporting(0);
		$priorityArr = config('global.priorityArr');
		$dataIT = ItemType::where('status', '=', '1')->where('is_purchase', '=', '1')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		$dataE  = Individual::where('type', '=', 'employee')->where('status', '=', '1')->get();
		$dataI  = Individual::where('type', '=', 'agents')->where('status', '=', '1')->get();
		$ExpDeliveryDate = config('global.ExpDeliveryDate');
	    $expDeliverydays = config('global.expDeliverydays');
        $dataGst = GstRate::where('status', '=', '1')->get();

		$IgstAr = config('global.IGST_RATES');
		$CgstAr = config('global.CGST_RATES');
		$SgstAr = config('global.SGST_RATES');
		// echo "<pre>"; print_r($CgstAr); exit;
		$dataSO = SaleOrder::where('is_deleted', '=', '0')->count();
		$totSleord = $dataSO+1;
		return view('html.purchase.add-purchase', compact("dataIT","dataUT",'dataE','priorityArr','totSleord','dataI','ExpDeliveryDate','expDeliverydays','IgstAr', 'CgstAr','SgstAr'));
    }

	public function create_new($individual_id = NULL)
	{
		if(!empty($individual_id)){
			$individual_id = $individual_id;
		} else {
			$individual_id = '';
		}

		$priorityArr = config('global.priorityArr');
		$ExpDeliveryDate = config('global.ExpDeliveryDate');
		$expDeliverydays = config('global.expDeliverydays');

		// echo "<pre>"; print_r($expDeliverydays); exit;
		$dataIT = ItemType::where('status', '=', '1')->where('is_purchase', '=', '1')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		$dataI = Individual::where('type', '=', 'agents')->where('status', '=', '1')->get();
		$dataE = Individual::where('type', '=', 'employee')->where('status', '=', '1')->get();
		$dataSO = SaleOrder::where('is_deleted', '=', '0')->count();
		$totSleord = $dataSO+1;
		
		return view('html.purchase.add-purchase', compact("dataIT","dataUT","dataI","dataE","totSleord","priorityArr","ExpDeliveryDate","expDeliverydays"));
	}

    public function store(Request $request)
    {
		error_reporting(0);
	   // echo "<pre>"; print_r($request->all()); // exit;
		$validator = Validator::make($request->all(), [
			"pur_type"=>"required",
			"product_name_arr"=>"required",
			"mrp_arr"=>"required",
			], [
			"pur_type.required"=>"Please item Type",
			"product_name_arr.required"=>"Please select your product",
			"mrp_arr.required"=>"Product price not found",
		]);
		if($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$pur_type 		 = $request->pur_type;
		$individual_id 	 = $request->individual_id;
		$cust_type 		 = $request->cust_type;
		$cus_name 		 = $request->cus_name;
		$mobile 		 = $request->mobile;
		$email 			 = $request->email;
		$ind_add_id 	 = $request->ind_add_id;
		$userId 		 = Auth::id();
		$purchased_on    = date('Y-m-d', strtotime($request->purchase_started)) != '' ? date('Y-m-d', strtotime($request->purchase_started)) : date('Y-m-d H:i:s');
		$purchase_number = $request->purchase_number;

		$order_priority 		= $request->order_priority;
		$sales_order  			= $request->sales_order;
		$bill_based 			= $request->bill_based;
		$billing_address  		= $request->address;
		$shiping_address  		= $request->shiping_address;
		$tax 					= $request->tax;
		$cgst  					= $request->cgst ? $request->cgst : 0;
		$sgst  					= $request->sgst ? $request->sgst : 0;
		$igst  					= $request->igst  ? $request->cess : 0;
		$cess  					= $request->cess ? $request->cess : 0;
		$cgst_arr  				= $request->cgst_arr ? $request->cgst_arr : 0;
		$sgst_arr  				= $request->sgst_arr ? $request->sgst_arr : 0;
		$igst_arr  				= $request->igst_arr ? $request->igst_arr : 0;
		$cess_arr  				= $request->cess_arr ? $request->cess_arr : 0;
		$cgstrs  				= $request->cgstrs;
		$sgstrs  				= $request->sgstrs;
		$igstrs  				= $request->igstrs;
		$cessrs  				= $request->cessrs;
		$taxrs  				= $request->taxrs;
		$cgstrs_arr  			= $request->cgstrs_arr;
		$sgstrs_arr  			= $request->sgstrs_arr;
		$igstrs_arr  			= $request->igstrs_arr;
		$cessrs_arr  			= $request->cessrs_arr;
		$cess_arr  				= $request->cess_arr;
		$taxrs_arr  			= $request->taxrs_arr;
		$hsn_arr  				= $request->hsn_arr;
		$unit_arr  				= $request->unit_arr;
        $pcs_arr 		    	= $request->pcs_arr;
        $cut_arr 		    	= $request->cut_arr;
        $meter_arr 				= $request->meter_arr;
		$total  				= $request->total;
		$coupon_discount  		= $request->discount;
		$frieght  				= $request->frieght;
		$subtotal  				= $request->subtotal;
		$notes  				= $request->notes;
		$billed_for  			= $request->billed_for;
		
		

		$obj = new Purchase;
		$obj->purchase_number  				= $purchase_number;
		$obj->purchase_type_id  			= 0;
		$obj->bill_based  					= $bill_based;
		$obj->individual_id  				= $individual_id;
		$obj->ind_add_id  					= $ind_add_id;
		$obj->billing_address  				= $billing_address;
		$obj->shiping_address  				= !empty($shiping_address) ? $shiping_address :'NULL';
		$obj->purchased_on  				= $purchased_on;
		// $obj->cgst  						= $cgst;
		// $obj->sgst  						= $sgst;
		// $obj->igst  						= $igst;
		$obj->total  						= $total;
		$obj->subtotal  					= $subtotal;
		$obj->coupon_discount  				= $coupon_discount;
		$obj->frieght  						= $frieght;
		$obj->is_deleted  					= 0;
		$obj->sgstrs  						= array_sum($sgstrs_arr);
		$obj->cgstrs  						= array_sum($cgstrs_arr);
		$obj->igstrs  						= array_sum($igstrs_arr);
		$obj->cess  						= $cess;
		$obj->cessrs  						= array_sum($cessrs_arr);
		$obj->taxrs  						= array_sum($taxrs_arr);
		$obj->executed_by  					= $userId;
		$obj->created_by  					= $userId;
		$obj->cancel_by  					= 0;
		$obj->deleted_by  					= 0;
		$obj->status  						= 1;
		$is_saved 							= $obj->save();
		$purchId 							= $obj->id;
		if($is_saved)
		{
			$mrp_arr 					= $request->mrp_arr;
			$price_arr 					= $request->price_arr;
			$saleprice_arr 				= $request->saleprice_arr;
			$discount_arr 				= $request->discount_arr;
			$qty_arr 					= $request->qty_arr;
			$total_arr 					= $request->total_arr;
			$tax_arr 					= $request->tax_arr;
			$dis_type_arr 				= $request->dis_type_arr;
			$saleprice_wot_arr 			= $request->saleprice_wot_arr;
			$product_name_arr 			= $request->product_name_arr;
			$pro_id_arr 	  			= $request->pro_id_arr;
			$remarks_arr 				= $request->remarks_arr;
			$order_item_priority_arr 	= $request->order_item_priority_arr;
			$grey_quality_arr 			= $request->grey_quality;
			$dyeing_color_arr 			= $request->dyeing_color;
			$coated_pvc_arr 			= $request->coated_pvc;
			$extra_job_arr 				= $request->extra_job;
			$print_job_arr 				= $request->print_job;
			$expect_delivery_date_arr 	= $request->expect_delivery_date;
			$pur_type_arr 				= $request->pur_type_arr;
		
			foreach($product_name_arr as $proidk=>$pro_name)
			{
				$proid 			= $pro_id_arr[$proidk];
				$itemTypeId 	= Item::where('item_id', $proid)->where('status', '1')->value('item_type_id');
				
				 
				$qty 			= $qty_arr[$proidk];
				$trans_date 	= date('Y-m-d');			 
				// if($igst_arr[$proidk] ='null') $igst_arr[$proidk] = 0;
				// else $igst_arr[$proidk] = $igst_arr[$proidk];
				
				$objPI = new PurchaseItem; 
				$objPI->name   				= $product_name_arr[$proidk];
				$objPI->purchase_id   		= $purchId;
				$objPI->bill_based   		= $bill_based;
				$objPI->item_type_id   		= $itemTypeId;
				$objPI->item_id   			= $proid;
				$objPI->quantity   			= $qty_arr[$proidk];
				$objPI->mrp   				= $price_arr[$proidk];
				$objPI->hsn   				= $hsn_arr[$proidk];
				$objPI->unit   				= $unit_arr[$proidk];
				$objPI->pcs   				= $pcs_arr[$proidk];
				$objPI->cut   				= $cut_arr[$proidk];
				$objPI->meter   			= $meter_arr[$proidk];
				$objPI->discount   			= $discount_arr[$proidk];
				$objPI->dis_type   			= $dis_type_arr[$proidk];
				$objPI->saleprice   		= $saleprice_arr[$proidk];
				$objPI->total_price   		= $total_arr[$proidk];
				$objPI->cgst   				= $cgst_arr[$proidk];
				$objPI->sgst   				= $sgst_arr[$proidk];
				$objPI->igst   				= $igst_arr[$proidk];
				$objPI->taxrs   			= $taxrs_arr[$proidk];
				$objPI->cgstrs   			= $cgstrs_arr[$proidk];
				$objPI->sgstrs   			= $sgstrs_arr[$proidk];
				$objPI->igstrs   			= $igstrs_arr[$proidk];  
				$objPI->cessrs   			= $cessrs_arr[$proidk];
				$objPI->cess   				= $cess_arr[$proidk];
				$objPI->remarks   			= $remarks_arr[$proidk];
				$objPI->order_item_priority = $order_item_priority_arr[$proidk];
				$objPI->grey_quality   		= $grey_quality_arr[$proidk];
				$objPI->dyeing_color   		= $dyeing_color_arr[$proidk];
				$objPI->coated_pvc   		= $coated_pvc_arr[$proidk];
				$objPI->extra_job   		= $extra_job_arr[$proidk];
				$objPI->print_job   		= $print_job_arr[$proidk];
				$objPI->expect_delivery_date = date('Y-m-d', strtotime($expect_delivery_date_arr[$proidk]));
				$objPI->receive_qty  		= 0;
				$objPI->left_qty  			= 0;
				$is_savedPI 				= $objPI->save();
				$purcItemId 				= $objPI->id;  

				$dataP   = PurchaseOrder::where('purchase_number', '=', $purchase_number)->where('is_deleted', '=', '0')->first();	
				$purchaseId = $dataP->id;
				$dataPOI = PurchaseOrderItem::where('purchase_id', '=', $purchaseId)->where('item_id', '=', $proid)->where('item_type_id', '=', $itemTypeId)->where('is_deleted', '=', '0')->first();
				$poItemid = $dataPOI->id;
				
				if($poItemid)
				{
					$quantity 		= $dataPOI->quantity;
					$poleftQty 		= $dataPOI->left_qty;
					$receiveQty 	= $dataPOI->receive_qty;
					$totRecQty   	= $qty+$receiveQty; 
					$pur_item_ids 	= $dataPOI->pur_item_ids;  
					$purItemIds     = $pur_item_ids.','. $purcItemId; 
					$leftQty  		= $quantity-($qty+$poleftQty); 
					$obj2  = PurchaseOrderItem::where('id', '=', $poItemid)->update(
					['left_qty' 	 => $leftQty,
					'receive_qty'	 => $totRecQty,			 
					'pur_item_ids'   => $purItemIds]);  
				} 
				 
			} 
			if($is_savedPI)
			{
				Session::put('message', 'Added successfully.');
				Session::put("messageClass","successClass");
				return redirect("/show-purchases");
			}
		}
		else
		{
			Session::put('message', 'Someting Problem.');
			Session::put("messageClass","errorClass");
			return redirect("/show-purchases");
		}







    }

    public function show($id)
    {
        //
    }

    public function print_purchase($id)
    {
		error_reporting(0);
		// echo "<pre>"; print_r($id); exit;
        $pId = base64_decode($id);
		$dataPur = Purchase::where('id', '=', $pId)->where('status', '=', '1')->first();
		// echo "<pre>"; print_r($dataPur); exit;
		$dataPI = PurchaseItem::where('purchase_id', '=', $pId)->where('is_deleted', '=', '0')->get();
		$dataI  = Individual::where('id', '=', $dataPur->individual_id)->where('status', '=', '1')->first();
		$dataIA  = IndividualAddress::where('ind_add_id', '=', $dataPur->ind_add_id)->where('status', '=', '1')->first();

		$dataCom = Company::where('id', '=', '1')->where('status', '=', '1')->first();

		return view('html.purchase.print-purchase', compact("dataPur","dataPI","dataCom","dataI","dataIA"));


    }

	public function print_purchase_new($id = NULL)
    {
		error_reporting(0);
        $pId = base64_decode($id); 
		$dataPur = Purchase::where('id', '=', $pId)->where('status', '=', '1')->first();
		// echo "<pre>"; print_r($dataPur); exit;
		$dataPI = PurchaseItem::where('purchase_id', '=', $pId)->where('is_deleted', '=', '0')->get();
		$dataI  = Individual::where('id', '=', $dataPur->individual_id)->where('status', '=', '1')->first();
		$dataIA  = IndividualAddress::where('ind_add_id', '=', $dataPur->ind_add_id)->where('status', '=', '1')->first(); 
		$dataCom = Company::where('id', '=', '1')->where('status', '=', '1')->first(); 
		
		return view('html.purchase.print-purchase-new', compact("dataPur","dataPI","dataCom","dataI","dataIA")); 
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function deletePurchase(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Purchase::find($FId);
		$obj->is_deleted  = '1';
		$obj->save();
		return $FId;
    }











}
