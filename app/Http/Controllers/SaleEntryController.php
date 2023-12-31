<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SaleEntry;
use App\Models\SaleOrder;
use App\Models\SaleEntryItem;
use App\Models\PackagingOrder;
use App\Models\PackagingOrderItem; 
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\Individual;
use App\Models\IndividualAddress;
use App\Models\Item;

use App\Models\Company;
use App\Http\Controllers\CommonController;

use Validator, Auth, Session, Hash;

class SaleEntryController extends Controller
{
		public function __construct()
		{
			 $this->middleware('auth');
		}

		public function index(Request $request)
		{
			 
			$qsearch 	= trim($request->qsearch);
			$fromDate 	= $request->from_date;
			$toDate 	= $request->to_date; 
			$query = SaleEntry::where('is_deleted', '=', '0')->with('SaleEntryItem')->with('Individual')->with('ItemType')->orderByDesc('sale_entry_id'); 			
			if (!empty($qsearch)) 
			{				
				/*  
				$saleEntryIds = SaleEntryItem::where(function ($subquery) use ($qsearch) {
					$subquery->where(DB::raw("CONCAT(name, ' ', remarks, ' ', unit)"), 'LIKE', '%' . $qsearch . '%');
				})->groupBy('sale_entry_id')->pluck('sale_entry_id')->implode(',');
				*/
				$keyName = (new SaleEntryItem())->getKeyName();
				$saleEntryIds = SaleEntryItem::where(function ($subquery) use ($qsearch, $keyName) {
					$subquery->where(DB::raw("CONCAT(name, ' ', remarks, ' ', unit)"), 'LIKE', '%' . $qsearch . '%');
				})->groupBy($keyName)->pluck($keyName)->implode(',');				

				$individualIds = Individual::where(DB::raw("CONCAT(name, ' ', nick_name, ' ', whatsapp)"), 'LIKE', '%' . $qsearch . '%')
					->where('type', '=', 'customers')->where('status', '=', '1')->pluck('id')->implode(',');    
				$query->whereIn('sale_entry_id', explode(',', $saleEntryIds))->orWhereIn('individual_id', explode(',', $individualIds));
			}   
			elseif (!empty($fromDate) && !empty($toDate)) {
				
				$saleEntryIds = SaleEntry::where('sale_entry_on', '>=',  $fromDate)->where('sale_entry_on', '<=',  $toDate)->pluck('sale_entry_id')->implode(',');   
				$query->whereIn('sale_entry_id', explode(',', $saleEntryIds));
			} 
			$dataP = $query->paginate(20);				 		 
			return view('html.saleentry.show-saleentries',compact("dataP","qsearch","fromDate","toDate"));
		}


		//added by Dinesh
		public function list_sales_entry(Request $request,$id = NULL)
		{
			$individual_id = base64_decode($id);
			$qsearch =  trim($request->qsearch);
			$dataP = SaleEntry::where('individual_id', '=', $individual_id)->where(DB::raw("concat(sale_order_number, billing_address, shipping_address)"), 'LIKE', '%' . $qsearch . '%')->where('is_deleted', '=', '0')->orderByDesc('sale_entry_id')->paginate(20);
			return view('html.saleentry.list-sales-entry',compact("dataP","qsearch"));
		}

		
		public function create()
		{
			$dataIT = ItemType::where('status', '=', '1')->orderByDesc('item_type_id')->get();
			$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
			$dataI = Individual::where('type', '=', 'agents')->where('status', '=', '1')->get();
			return view('html.saleentry.add-saleentry', compact("dataIT","dataUT"));
		}
		
		
		public function createInvoiceForPackage($id)
		{
			$packOrdId 	= base64_decode($id);
			$dataPO 	= PackagingOrder::where('id', $packOrdId)->where('status', '1')->with(['packagingOrderItems.PackagingType', 'packagingOrderItems.Item', 'individual'])->orderByDesc('id')->first();
			$dataIAS  	= IndividualAddress::where('ind_add_id', $dataPO->cus_ship_add_id)->where('address_type', 's')->where('status', '1')->first();
			$dataIAB  	= IndividualAddress::where('ind_add_id', $dataPO->cus_bill_add_id)->where('address_type', 'b')->where('status', '1')->first();		
		 //   echo "<pre>"; print_r($dataIAB); exit;
			$IgstAr 	= config('global.IGST_RATES');
			$CgstAr 	= config('global.CGST_RATES');
			$SgstAr 	= config('global.SGST_RATES');
			$query 		= SaleEntry::where('is_deleted', '=', '0');				 
			$totalRecords = 1001+$query->count();
			return view('html.saleentry.create-invoice-for-package', compact("dataPO", "dataIAS", "dataIAB", "IgstAr", "CgstAr","SgstAr","totalRecords"));
			
		}


		public function genrateInvoiceForPackage(Request $request)
	    {
			//  echo "<pre>"; print_r($request->all()); exit;
			$validator = Validator::make($request->all(), [				 
				'cus_name' => 'required|string',
				'individual_id' => 'required|numeric',			 
			], [
				'cus_name.required' => 'Customer name not found.',	 
			]);
			if ($validator->fails()) {
				$error = $validator->errors()->first();
				Session::put('message', $validator->messages()->first());
				Session::put("messageClass", "errorClass");
				return redirect()->back()->withInput();
			}
		 
		 
			$sale_order_number 		= $request->sale_order_number;
			$individual_id 			= $request->individual_id;
			$sale_entry_on  		= date('Y-m-d', strtotime($request->sale_entry_started)) != '' ? date('Y-m-d', strtotime($request->sale_entry_started)) : date('Y-m-d H:i:s');
			$cus_name 				= $request->cus_name;
			$mobile 				= $request->mobile;
			$email 					= $request->email;
			$gstin 					= $request->gstin;
			$com_state 				= $request->com_state;
			$subtotal 				= $request->subtotal;
			$frieght 				= $request->frieght;
			$discount 				= $request->discount;
			$total 					= $request->total; 
			$shipping_address 		= $request->shiping_address; 
			$billing_address 		= $request->billing_address;
			$packagingOrdId         = $request->packaging_ord_id;				
			  
			$userId = auth()->check() ? auth()->user()->individual_id : null;

			$obj = new SaleEntry;
			$obj->sale_order_number  				= $sale_order_number;
			$obj->packaging_ord_id  				= $packagingOrdId;
			$obj->sale_entry_type_id  				= 0;  		 
			$obj->individual_id  				    = $individual_id;
			$obj->customer_name  				    = $cus_name;
			$obj->billing_address  				  	= $billing_address;
			$obj->shipping_address  				= $shipping_address;
			$obj->sale_entry_on  				    = $sale_entry_on;
			$obj->total  						    = $total;
			$obj->subtotal  					    = $subtotal;
			$obj->coupon_discount  				  	= $discount;
			$obj->frieght  						    = $frieght;			 
			$obj->is_deleted  					    = 0;
			$obj->modified_by               		= $userId;
			$obj->executed_by  					    = $userId;
			$obj->created_by  					    = $userId;
			$obj->created  					        = date('Y-m-d H:i:s');
			$obj->modified  				        = date('Y-m-d H:i:s');
			$obj->cancel_by  					    = 0;
			$obj->deleted_by  					    = 0;
			$obj->status  						    = 1;
			$is_saved 							    = $obj->save();
			$saleEntryId 							= $obj->sale_entry_id; 
			if ($is_saved) 
			{				
				$item_id_arr         	= $request->item_id_arr;
				$qty_name_arr         	= $request->qty_name_arr;	
				$unit_arr         		= $request->unit_arr;
				$pcs_arr         		= $request->pcs_arr;	
				$cut_arr         		= $request->cut_arr;	
				$meter_arr         		= $request->meter_arr;	
				$rate_arr         		= $request->rate_arr;	
				$amount_wot_arr         = $request->amount_wot_arr;		
				$discount_arr        	= $request->discount_arr;	
				$dis_amount_arr        	= $request->dis_amount_arr;	
				$taxable_amount_arr     = $request->taxable_amount_arr;	
				$cgst_arr        		= $request->cgst;	
				$cgstrs_arr        		= $request->cgstrs;	
				$sgst_arr        		= $request->sgst;	
				$sgstrs_arr        		= $request->sgstrs;	
				$igst_arr        		= $request->igst;
				$igstrs_arr        		= $request->igstrs;	
				$tax_amount_arr        	= $request->tax_amount_arr;	
				$net_amount_arr        	= $request->net_amount_arr;					
				$packaging_ord_item_id  = $request->packaging_ord_item_id;		
				$sale_order_id  		= $request->sale_order_id;		
				$sale_order_item_id  	= $request->sale_order_item_id;	
				$pack_type_arr  		= $request->pack_type_arr;		
				$data = [];
				foreach ($qty_name_arr as $proidk => $pro_name) 
				{
					$proid 							= $item_id_arr[$proidk];
					$trans_date 					= date('Y-m-d');
					$data[] = array(
						'sale_entry_id' 			=> $saleEntryId,
						'item_id' 					=> $proid,
						'packaging_ord_id' 			=> $packagingOrdId,
						'packaging_ord_item_id' 	=> $packaging_ord_item_id[$proidk],
						'sale_order_item_id' 		=> $sale_order_item_id[$proidk],
						'sale_order_id' 			=> $sale_order_id[$proidk],
						'pack_type' 				=> $pack_type_arr[$proidk],	
						'name' 						=> $qty_name_arr[$proidk],						 
						'pcs' 						=> $pcs_arr[$proidk],
						'cut' 						=> $cut_arr[$proidk],
						'meter' 					=> $meter_arr[$proidk],
						'rate' 						=> $rate_arr[$proidk],						
						'amount' 					=> $amount_wot_arr[$proidk],						
						'discount'					=> $discount_arr[$proidk],
						'discount_amount' 			=> $dis_amount_arr[$proidk],					
						'taxable_amount' 			=> $taxable_amount_arr[$proidk],	
						'cgstrs' 					=> $cgstrs_arr[$proidk],
						'sgstrs'					=> $sgstrs_arr[$proidk],
						'igstrs' 					=> $igstrs_arr[$proidk],						
						'cgst' 						=> $cgst_arr[$proidk],
						'sgst' 						=> $sgst_arr[$proidk],
						'igst' 						=> $igst_arr[$proidk],						
						'tax_amount' 				=> $tax_amount_arr[$proidk],					
						'net_amount' 				=> $net_amount_arr[$proidk], 				
						'total_price' 				=> $net_amount_arr[$proidk], 					 
						'created_by' 				=> 1,  
						'modified_by' 				=> 1,  
						'unit' 						=> 'Meter',  
						'created' 					=> now(),
						'modified' 					=> now(),
					);
				}

				$res = SaleEntryItem::insert($data);
				if($res) 
				{
					PackagingOrder::where('id', $packagingOrdId)->update([
						'is_invoice_generated' => 'Yes',
						'sale_entry_id' => $saleEntryId,
					]); 
					
					Session::put('message', 'Added successfully.');
					Session::put("messageClass", "successClass");
					return redirect("/show-saleentries");
				} 
				else 
				{         
					Session::put('message', 'Failed to insert SaleEntryItem records.');
					Session::put("messageClass", "errorClass");  
					return redirect("/show-saleentries");					
				}
			} 
			else 
			{     
				Session::put('message', 'Failed to save SaleEntry.');
				Session::put("messageClass", "errorClass"); 
				return redirect("/show-saleentries");
			}
			 

	}
	
	
	
	

		public function store(Request $request)
		{
		// echo "<pre>"; print_r($request->all()); exit;


		$validator = Validator::make($request->all(), [
			"cus_name"=>"required",
			"qty_name_arr"=>"required",
			"amount_arr"=>"required",
			"rate_arr"=>"required",
		], [
			"cus_name.required"=>"Customer name not found.",
			"qty_name_arr.required"=>"Please select your product",
			"amount_arr.required"=>"Product price not found",
			"rate_arr.required"=>"Rate not found",
		]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		  $sale_entry_type = $request->sale_entry_type;
		  $individual_id = $request->individual_id;
		  $cust_type = $request->cust_type;
		  $cus_name = $request->cus_name;
		  $mobile = $request->mobile;
		  $email = $request->email;
		  $userId = Auth::id();

		  $sale_entry_on  = date('Y-m-d', strtotime($request->sale_entry_started)) != '' ? date('Y-m-d', strtotime($request->sale_entry_started)) : date('Y-m-d H:i:s');
		  $sale_order_number = $request->sale_order_number ?  $request->sale_order_number: 0;
		  $bill_based = $request->bill_based;
		  $billing_address  = $request->address;
		  $shipping_address= $request->addressShipping;
		  $unit_arr  = $request->unit_arr;
		  $total  = $request->total;
		  $coupon_discount  = $request->discount;
		  $frieght  = $request->frieght;
		  $subtotal  = $request->subtotal;
		  $notes  = $request->notes;

		  $billed_for  = $request->billed_for;


		  $obj = new SaleEntry;

		  $obj->sale_order_number  					= $sale_order_number;
		  $obj->sale_entry_type_id  				= 0; // $sale_entry_type;
		  $obj->bill_based  					    = $bill_based;
		  $obj->individual_id  				    	= $individual_id;
		  $obj->billing_address  				  	= $billing_address;
		  $obj->shipping_address  					= $shipping_address;
		  $obj->sale_entry_on  				    	= $sale_entry_on;
		  $obj->total  						        = $total;
		  $obj->subtotal  					      	= $subtotal;
		  $obj->coupon_discount  				  	= $coupon_discount;
		  $obj->frieght  						      = $frieght;
		  $obj->agent_id                  ="none";
		  $obj->is_deleted  					    = 0;
		  $obj->modified_by               = $userId;
		  $obj->executed_by  					    = $userId;
		  $obj->created_by  					    = $userId;
		  $obj->created  					        = date('Y-m-d H:i:s');
			$obj->modified  				        = date('Y-m-d H:i:s');
		  $obj->cancel_by  					      = 0;
		  $obj->deleted_by  					    = 0;
		  $obj->status  						      = 1;
		  $is_saved 							        = $obj->save();
		  $sale_entry_id = $obj->sale_entry_id;

	////////////////////////// Notification Start Added/////////////////////////////
	$userId = Auth::id();
	$modeName = 'SaleEntry';
	$urlPage = $_SERVER['HTTP_REFERER'];
	$mesg =  CommonController::getUserName($userId) .' Added Sale Entry '. $request->sale_order_number ;
	$pageName = 'add-saleentry';
	CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
	////////////////////////// Notification End Added/////////////////////////////


		  if($is_saved)
		  {
			$qty_name_arr 		= $request->qty_name_arr;
			$unit_arr 		= $request->unit_arr;
			$pcs_arr 		= $request->pcs_arr;
			$cut_arr 		= $request->cut_arr;
			$meter_arr 		= $request->meter_arr;
			$rate_arr 		= $request->rate_arr;
			$amount_arr 		= $request->amount_arr;
			$discount_arr 		= $request->discount_arr;
			$dis_amount_arr 		= $request->dis_amount_arr;
			$total_arr 		= $request->total_arr;
			$remarks_arr 		= $request->remarks_arr;
			$pro_id_arr 		= $request->pro_id_arr;


			foreach($qty_name_arr as $proidk=>$pro_name)
			{

			  $proid = $pro_id_arr[$proidk];

			  $trans_date=date('Y-m-d');



			  $data[] = array(
						'bill_based' => $bill_based,
						'sale_entry_id' => $sale_entry_id,
						'item_id' => $proid,
						'name' => $qty_name_arr[$proidk],
						'total_price' => $total_arr[$proidk],
						'unit' => $unit_arr[$proidk],
						'pcs' => $pcs_arr[$proidk],
						'cut' => $cut_arr[$proidk],
						'meter' => $meter_arr[$proidk],
						'rate' => $rate_arr[$proidk],
						'amount' => $amount_arr[$proidk],
						'discount' => $discount_arr[$proidk],
						'discount_amount' => $dis_amount_arr[$proidk],
						'net_amount' => $total_arr[$proidk],
						'remarks' => $remarks_arr[$proidk],
						'created_by' => 1,
						'modified_by' => 1,
						'created' => $trans_date,
						'modified' => $trans_date


					);

			}


			$res =  SaleEntryItem::insert($data);

			if($res)
			{
			  Session::put('message', 'Added successfully.');
			  Session::put("messageClass","successClass");
			  return redirect("/show-saleentries");
			}
		  }
		  else
		  {
			Session::put('message', 'Someting Problem.');
			Session::put("messageClass","errorClass");
			return redirect("/show-saleentries");
		  }

	}

		
		
		public function print_sale_entry($sale_entry_id)
		{
			$pId 		= base64_decode($sale_entry_id);
			$dataSalE 	= SaleEntry::where('sale_entry_id', '=', $pId)->where('status', '=', '1')->first();
			$dataPI 	= SaleEntryItem::where('sale_entry_id', '=', $pId)->where('is_deleted', '=', '0')->get();
			$dataI  	= Individual::where('id', '=', $dataSalE->individual_id)->where('status', '=', '1')->first();
			$dataIA  	= IndividualAddress::where('ind_add_id', '=', $dataSalE->ind_add_id)->where('status', '=', '1')->first();
			$dataCom 	= Company::where('id', '=', '1')->where('status', '=', '1')->first();

			return view('html.saleentry.print-saleentry', compact("dataSalE","dataPI","dataCom","dataI","dataIA"));
			
		}


		public function deleteSaleEntry(Request $request)
		{
				$sale_entry_id 	= $request->sale_entry_id;
				$dataSalE = SaleEntry::where('sale_entry_id', '=', $sale_entry_id)->where('is_deleted', '=', '0')->first();
			// dd($dataSalE);
				$dataSalE->is_deleted  = '1';
				$dataSalE->save();
		////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'SaleEntry';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) . 'Deleted Sale Entry '. $obj->sale_order_number;
		$pageName = 'show-saleentries';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


				return $sale_entry_id;
		}

}
