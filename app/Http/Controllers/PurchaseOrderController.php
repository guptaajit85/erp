<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\Individual;
use App\Models\IndividualAddress;
use App\Models\Item;
use App\Models\PurchaseOrderItem;
use App\Models\Company;

use Validator, Auth, Session, Hash;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(Request $request)
    {
		$qsearch =  trim($request->qsearch);
		$dataP = PurchaseOrder::where(DB::raw("concat(purchase_number, billing_address)"), 'LIKE', '%' . $qsearch . '%')->where('is_deleted', '=', '0')->paginate(20);
		// echo"<pre>"; print_r($dataP); exit;
		return view('html.purchaseorder.show-purchaseorders',compact("dataP","qsearch"));
    }


    //added by Dinesh
    public function list_purchage_order(Request $request,$id = NULL)
    {

		$individual_id = base64_decode($id);
        $qsearch =  trim($request->qsearch);
		$dataP = PurchaseOrder::where('individual_id', '=', $individual_id)->where(DB::raw("concat(purchase_number, billing_address, shiping_address)"), 'LIKE', '%' . $qsearch . '%')->where('is_deleted', '=', '0')->paginate(20);
		// echo"<pre>"; print_r($dataP); exit;
		return view('html.purchaseorder.list-purchage-order',compact("dataP","qsearch"));
    }


    public function create_purchaseorder()
    {
        $dataIT = ItemType::where('status', '=', '1')->get();
		$dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
		return view('html.purchaseorder.add-purchaseorder', compact("dataIT","dataUT"));
    }


    public function store_purchaseorder(Request $request)
    {

		//  echo "<pre>"; print_r($request->all()); exit;
		$validator = Validator::make($request->all(), [
		"pur_type"=>"required",
		"product_name_arr"=>"required",
		"mrp_arr"=>"required",
		], [
		"pur_type.required"=>"Please item Type",
		"product_name_arr.required"=>"Please select your product",
		"mrp_arr.required"=>"Product price not found",
		]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$pur_type 		= $request->pur_type;
		$individual_id 	= $request->individual_id;
		$cust_type 		= $request->cust_type;
		$cus_name 		= $request->cus_name;
		$mobile 		= $request->mobile;
		$email 			= $request->email;
		$ind_add_id 	= $request->ind_add_id;
		$userId 		= Auth::id();
		$purchased_on   = date('Y-m-d', strtotime($request->purchase_started)) != '' ? date('Y-m-d', strtotime($request->purchase_started)) : date('Y-m-d H:i:s');
		
		$purchase_number 	= $request->purchase_number;
		$bill_based 		= $request->bill_based;
		$billing_address  	= $request->address;
		$tax 				= $request->tax;
		$cgst  				= $request->cgst ? $request->cgst : 0;
		$sgst  				= $request->sgst ? $request->sgst : 0;
		$igst  				= $request->igst  ? $request->cess : 0;
		$cess  				= $request->cess ? $request->cess : 0;
		$cgst_arr  			= $request->cgst_arr;
		$sgst_arr  			= $request->sgst_arr;
		$igst_arr  			= $request->igst_arr;
		$cess_arr  			= $request->cess_arr;
		$cgstrs  			= $request->cgstrs;
		$sgstrs  			= $request->sgstrs;
		$igstrs  			= $request->igstrs;
		$cessrs  			= $request->cessrs;
		$taxrs  			= $request->taxrs;
		$cgstrs_arr  		= $request->cgstrs_arr;
		$sgstrs_arr  		= $request->sgstrs_arr;
		$igstrs_arr  		= $request->igstrs_arr;
		$cessrs_arr  		= $request->cessrs_arr;
		$cess_arr  			= $request->cess_arr;
		$taxrs_arr  		= $request->taxrs_arr;
		$hsn_arr  			= $request->hsn_arr;
		$unit_arr  			= $request->unit_arr;
		$total 				= $request->total;
		$coupon_discount  	= $request->discount;
		$frieght  			= $request->frieght;
		$subtotal  			= $request->subtotal;
		$notes  			= $request->notes;
		$billed_for  		= $request->billed_for;


		$obj = new PurchaseOrder;

		$obj->purchase_number  				= $purchase_number;
		// $obj->purchase_type_id  			= $pur_type;
		$obj->bill_based  					= $bill_based;
		$obj->individual_id  				= $individual_id;
		$obj->ind_add_id  					= $ind_add_id;
		$obj->billing_address  				= $billing_address;
		$obj->shiping_address  				= 'NULL';
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
		$purchaseId = $obj->id;
		if($is_saved)
		{
			$mrp_arr 				= $request->mrp_arr;
			$price_arr 				= $request->price_arr;
			$saleprice_arr 			= $request->saleprice_arr;
			$discount_arr 			= $request->discount_arr;
			$qty_arr 				= $request->qty_arr;
			$total_arr 				= $request->total_arr;
			$tax_arr 				= $request->tax_arr;
			$dis_type_arr 			= $request->dis_type_arr;
			$saleprice_wot_arr 		= $request->saleprice_wot_arr;
			$product_name_arr 		= $request->product_name_arr;
			$pro_id_arr 			= $request->pro_id_arr;
			$pur_type_arr 			= $request->pur_type_arr;
			$meter_arr 				= $request->meter_arr;

			foreach($product_name_arr as $proidk=>$pro_name)
			{

				$proid 		= $pro_id_arr[$proidk];
				$itemTypeId = Item::where('item_id', $proid)->where('status', '1')->value('item_type_id');
				$qty 		= $qty_arr[$proidk];
				$trans_date	= date('Y-m-d');
				
				$data[] = array(
						'bill_based' 	=> $bill_based,
						'purchase_id' 	=> $purchaseId,
						'item_id' 		=> $proid,
						'item_type_id' 	=> $itemTypeId,
						'quantity' 		=> $qty_arr[$proidk],
						'pur_item_ids' 	=> $pur_type_arr[$proidk],
						'meter' 		=> $meter_arr[$proidk],
						'mrp' 			=> $price_arr[$proidk],
						'hsn' 			=> $hsn_arr[$proidk],
						'unit' 			=> $unit_arr[$proidk],
						'discount' 		=> $discount_arr[$proidk],
						'dis_type' 		=> $dis_type_arr[$proidk],
						'saleprice' 	=> $saleprice_arr[$proidk],
						'total_price' 	=> $total_arr[$proidk],
						'saleprice_wot' => $saleprice_wot_arr[$proidk],
						// 'tax' => $tax_arr[$proidk],
						'cgst' 			=> $cgst_arr[$proidk],
						'sgst' 			=> $sgst_arr[$proidk],
						'igst' 			=> $igst_arr[$proidk],
						'taxrs' 		=> $taxrs_arr[$proidk],
						'cgstrs' 		=> $cgstrs_arr[$proidk],
						'sgstrs' 		=> $sgstrs_arr[$proidk],
						'igstrs' 		=> $igstrs_arr[$proidk],
						'cessrs' 		=> $cessrs_arr[$proidk],
						'cess' 			=> $cess_arr[$proidk],
						'dis_type' 		=> $dis_type_arr[$proidk],
						'receive_qty' 	=> 0,
						'left_qty' 		=> 0,
						'name' 			=> $product_name_arr[$proidk]

					);

			}


			$res =  PurchaseOrderItem::insert($data);

			if($res)
			{
				Session::put('message', 'Added successfully.');
				Session::put("messageClass","successClass");
				return redirect("/show-purchaseorders");
			}
		}
		else
		{
			Session::put('message', 'Someting Problem.');
			Session::put("messageClass","errorClass");
			return redirect("/show-purchaseorders");
		}







    }


    public function show($id)
    {
        //
    }


    public function print_purchaseorder($id)
    {
		error_reporting(0);
		// echo "<pre>"; print_r($id); exit;
        $pId = base64_decode($id);
		$dataPur = PurchaseOrder::where('id', '=', $pId)->where('status', '=', '1')->first();
		// echo "<pre>"; print_r($dataPur); exit;
		$dataPI = PurchaseOrderItem::where('purchase_id', '=', $pId)->where('is_deleted', '=', '0')->get();
		$dataI  = Individual::where('id', '=', $dataPur->individual_id)->where('status', '=', '1')->first();
		$dataIA  = IndividualAddress::where('ind_add_id', '=', $dataPur->ind_add_id)->where('status', '=', '1')->first();

		$dataCom = Company::where('id', '=', '1')->where('status', '=', '1')->first();

		return view('html.purchaseorder.print-purchaseorder', compact("dataPur","dataPI","dataCom","dataI","dataIA"));


    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function deletePurchaseOrder(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= PurchaseOrder::find($FId);
		$obj->is_deleted  = '1';
		$obj->save();
		return $FId;
    }



}
