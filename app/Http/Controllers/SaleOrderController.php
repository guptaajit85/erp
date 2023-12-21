<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\SaleOrder;
use App\Models\User;
use App\Models\ItemType;
use App\Models\UnitType;
use App\Models\Individual;
use App\Models\SaleOrderItem;
use App\Models\IndividualAddress;
use App\Models\Item;
use App\Models\Company;
use App\Models\PurchaseItem;
use App\Http\Controllers\CommonController;
use Auth;
use Validator;
use Session;
use Hash;

class SaleOrderController extends Controller
{

  public function __construct()
  {
       $this->middleware('auth');
  }

	public function index(Request $request)
	{ 	
		$qsearch 		= trim($request->qsearch);
		$qnamesearch 	= trim($request->qnamesearch);
		$priority 		= $request->priority;
		$fromDate 		= $request->from_date;
		$toDate 		= $request->to_date;
		$ordNumSearch 	= $request->ordNumSearch; 
		$query = SaleOrder::where('is_deleted', '=', '0')->with('SaleOrderItem')->with('Individual')->with('ItemType')->orderByDesc('sale_order_id');		
		if (!empty($qsearch)) 
		{  
			$individualIds = Individual::where(DB::raw("CONCAT(name, ' ', nick_name, ' ', whatsapp)"), 'LIKE', '%' . $qsearch . '%')->where('type', '=', 'customers')->where('status', '=', '1')->pluck('id')->implode(',');     
			$query->whereIn('individual_id', explode(',', $individualIds));		
		}
		if (!empty($qnamesearch)) 
		{ 
			$saleOrderIds = SaleOrderItem::where(function ($subquery) use ($qnamesearch) {
				$subquery->where(DB::raw("CONCAT(name, ' ', grey_quality, ' ', dyeing_color)"), 'LIKE', '%' . $qnamesearch . '%');
			})->groupBy('sale_order_id')->pluck('sale_order_id')->implode(',');   
			
			$individualIds = Individual::where(DB::raw("CONCAT(name, ' ', nick_name, ' ', whatsapp)"), 'LIKE', '%' . $qnamesearch . '%')->where('type', '=', 'customers')->where('status', '=', '1')->pluck('id')->implode(',');     
			$query->whereIn('sale_order_id', explode(',', $saleOrderIds))->orWhereIn('individual_id', explode(',', $individualIds));		
		} 
		if (!empty($priority)) 
		{     
			$saleOrderIds = SaleOrderItem::where('order_item_priority', 'LIKE', '%' . $priority . '%')->groupBy('sale_order_id')->pluck('sale_order_id')->implode(',');    
			$query->whereIn('sale_order_id', explode(',', $saleOrderIds));
		}
		if (!empty($ordNumSearch)) 
		{
			$ordNumSearchArray = explode(',', $ordNumSearch);
			$saleOrderIds = SaleOrder::whereIn('sale_order_number', $ordNumSearchArray)->pluck('sale_order_id');
			$query->whereIn('sale_order_id', $saleOrderIds);
		}
		
		if (!empty($fromDate) && !empty($toDate)) 
		{
			
			$fromDate 		= date('Y-m-d', strtotime($request->from_date));
			$toDate 		= date('Y-m-d', strtotime($request->to_date));		
			$saleOrderIds = SaleOrderItem::where('expect_delivery_date', '>=',  $fromDate)->where('expect_delivery_date', '<=',  $toDate)->groupBy('sale_order_id')->pluck('sale_order_id')->implode(',');     
			$query->whereIn('sale_order_id', explode(',', $saleOrderIds));
		} 
		$dataP = $query->paginate(20);
		
		$priorityArr = config('global.priorityArr');		 
		return view('html.saleorder.show-saleorders',compact("dataP","qsearch","qnamesearch","priorityArr","priority","fromDate","toDate","ordNumSearch"));
	}

  
	public function list_sales_order(Request $request, $id)
	{

		$id = base64_decode($id);
		$indvId = $id ;
		$qsearch =  trim($request->qsearch);
		$dataP = SaleOrder::where('individual_id', '=',$id)->where(DB::raw("concat(sale_order_number,billing_address, shiping_address)"), 'LIKE', '%' . $qsearch . '%')->with('SaleOrderItem')->with('Individual')->with('ItemType')->where('is_deleted', '=', '0')->orderByDesc('sale_order_id')->paginate(20);

	  return view('html.saleorder.list-sales-order',compact("dataP","qsearch","indvId"));
	}



	public function show_sale_order_items(Request $request)
	{
		
		
		$perPage 		= config('global.PER_PAGE');
		$priorityArr 	= config('global.priorityArr');
		$qsearch 		= trim($request->qsearch);
		$qnamesearch 	= trim($request->qnamesearch);
		$ordNumSearch 	= trim($request->ordNumSearch);
 
	  	$fromDate 		= $request->from_date;
	  	$toDate 		= $request->to_date;
	// echo "<pre>"; print_r($request->all()); exit;	
		$priority 		= $request->priority;
		
		$query = SaleOrderItem::where('is_deleted', '=', '0')->where('is_work_order_created', '=', '0')->with('SaleOrder');
		
		if (!empty($qsearch)) 
		{
			// Apply search by individual name
			$individualIds = Individual::where('name', 'like', "%$qsearch%")->pluck('id');
			$saleOrderIds = SaleOrder::whereIn('individual_id', $individualIds)->pluck('sale_order_id');
			$query->whereIn('sale_order_id', $saleOrderIds);
		}
		if (!empty($ordNumSearch)) 
		{
			$ordNumSearchArray = explode(',', $ordNumSearch);
			$saleOrderIds = SaleOrder::whereIn('sale_order_number', $ordNumSearchArray)->pluck('sale_order_id');
			$query->whereIn('sale_order_id', $saleOrderIds);
		}
		if (!empty($qnamesearch)) 
		{
			 
			$query->where('name', 'like', "%$qnamesearch%");
		}
		if (!empty($request->from_date)) 
		{
			$fromDate 		= date('Y-m-d', strtotime($request->from_date));
	     	$toDate 		= date('Y-m-d', strtotime($request->to_date));
			 
			$query->where(function ($query) use ($fromDate, $toDate) {
				$query->where('expect_delivery_date', '>=', $fromDate)->where('expect_delivery_date', '<=', $toDate);
			});
		}
		if (isset($priority) && $priority !== '') {
			 
			$query->where('order_item_priority', 'LIKE', "%$priority%");
		}
  
		$dataSOI = $query->paginate($perPage); 
		
		return view('html.saleorder.show-saleorderitems', compact("dataSOI", "qsearch", "qnamesearch", "fromDate", "toDate", "priorityArr", "ordNumSearch", "priority"));
	}



	public function create($individual_id = NULL)
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
	  $dataIT = ItemType::where('status', '=', '1')->get();
	  $dataUT = UnitType::where('status', '=', '1')->orderByDesc('unit_type_id')->get();
	  $dataI = Individual::where('type', '=', 'agents')->where('status', '=', '1')->get();
	  $dataE = Individual::where('type', '=', 'employee')->where('status', '=', '1')->get();
	  $dataSO = SaleOrder::where('is_deleted', '=', '0')->count();
	  $totSleord = $dataSO+1;

	  return view('html.saleorder.add-saleorder', compact("dataIT","dataUT","dataI","dataE","totSleord","priorityArr","ExpDeliveryDate","expDeliverydays"));
  }


  public function store(Request $request)
  {
			$validator = Validator::make($request->all(), [
				"lot_number"=>"required",
				"sale_order_number"=>"required",
				"sale_order_date"=>"required",
				//"cus_name"=>"required",
        "cus_name"=>"required_if:sale_order_type,Customer",
				//"address"=>"required",
        "address"=>"required_if:sale_order_type,Customer",
				//"shiping_address"=>"required",
        "shiping_address"=>"required_if:sale_order_type,Customer",
				"product_name_arr"=>"required",
				"rate_arr"=>"required",
			], [
				"lot_number.required"=>"Lot Number not found.",
				"sale_order_number.required"=>"Sale Order Number Not Found",
				"sale_order_date.required"=>"Sale Order date not found",
				"cus_name.required"=>"Customer name not found",
				"address.required"=>"Billing Address not found",
				"shiping_address.required"=>"Shipping Address not found",
				"product_name_arr.required"=>"Please Select Your Order Item.",
				"rate_arr.required"=>"Your Selected item Amount Not Found.",
			]);
      //dd($request->all());
			if ($validator->fails())
			{
				$error = $validator->errors()->first();
				Session::put('message', $validator->messages()->first());
				Session::put("messageClass","errorClass");
				return redirect()->back()->withInput();
			}

		  //  echo "<pre>"; print_r($request->all()); exit;

			$sale_order_type 		= $request->sale_order_type;
			$ind_add_id 			= $request->ind_add_id;
			$individual_id 			= $request->individual_id;
			$sale_order_date  		= date('Y-m-d', strtotime($request->sale_order_date)) != '' ? date('Y-m-d', strtotime($request->sale_order_date)) : date('Y-m-d H:i:s');
			$order_priority 		= $request->order_priority;
			$bill_based 			= $request->bill_based;
			$billing_address  		= $request->address;
			$shiping_address  		= $request->shiping_address;
			$sales_order  			= $request->sales_order;
			$order_by_employee  	= $request->order_by_employee ? $request->order_by_employee : 0;
			$total 					= $request->total;
			$subtotal 				= $request->subtotal;
			$frieght 				= $request->frieght;
			$sale_order_number 		= $request->sale_order_number;
			$lot_number 			= $request->lot_number;
			$items 					= $request->items ? $request->items : 0;
			$amount 				= $request->amount ? $request->amount : 0;
			$discount_amount 		= $request->discount_amount ? $request->discount_amount : 0;
			$total_amount_without_roundoff = $request->total_amount_without_roundoff;
			$roundoff 				= $request->roundoff;
			$total_amount_after_roundoff = $request->total_amount_after_roundoff;
			$status 				= $request->status;
			$created_by 			= $request->created_by;
			$modified_by 			= $request->modified_by;
			$executed_by 			= $request->executed_by;
			$created 				= $request->created;
			$modified 				= $request->modified;
			$is_deleted 			= $request->is_deleted;
			$is_return 				= $request->is_return;
			$unit_arr  				= $request->unit_arr;
			$pcs_arr  				= $request->pcs_arr;
			$taxrs 					= $request->taxrs;
			$taxrs_arr  			= $request->taxrs_arr;
			$ind_agent_id 			= $request->ind_agent_id;
			$meter_arr 				= $request->meter_arr;
			$rate_arr 				= $request->rate_arr;
			$amount_arr 			= $request->amount_arr;
			$remarks_arr 			= $request->remarks_arr;

			$userId = Auth::id();
			$userD  = User::find($userId);
			$indId  = $userD->individual_id;

			$obj = new SaleOrder;
			$obj->sale_order_type  			                 	= $sale_order_type;
			$obj->individual_id  			                   	= $individual_id;
			$obj->sale_order_date  			                	= $sale_order_date;
			$obj->order_priority  			                 	= $order_priority;
			$obj->bill_based  					                = $bill_based;
			$obj->billing_address  			                 	= $billing_address;
			$obj->shiping_address  			                 	= $shiping_address;
			$obj->sales_order  					                = $sales_order;
			$obj->order_by_employee  					        = $order_by_employee;
			$obj->total  					                   	= $total;
			$obj->subtotal  			                     	= $subtotal;
			$obj->frieght  					                    = $frieght;
			$obj->sale_order_number  			                = $sale_order_number;
			$obj->lot_number  			                		= $lot_number;
			$obj->ind_agent_id         	                 		= $ind_agent_id;
			$obj->items           		                 		= $items;
			$obj->amount          			                 	= $amount;
			$obj->ind_add_id          			                = $ind_add_id;
			$obj->discount_amount  			                	= $discount_amount;
			$obj->total_amount_without_roundoff  				= $total;
			$obj->roundoff  				                    = $discount_amount;
			$obj->total_amount_after_roundoff  			     	= $total-$discount_amount;
			$obj->status  					                   	= 1;
			$obj->created_by  				                   	= $indId;
			$obj->modified_by  			                		= $indId;
			$obj->executed_by  				                  	= $indId;
			$obj->created  					                    = date('Y-m-d H:i:s');
			$obj->modified  				                  	= date('Y-m-d H:i:s');
			$obj->is_deleted  			                  		= 0;
			$obj->is_return   			                  		= 0;
			$obj->cancel_by  				                    = $indId;
			$obj->deleted_by  			                  		= $indId;
			$is_saved 						                    = $obj->save();
			$sale_order_Id                                      = $obj->sale_order_id;

		  if($is_saved)
		  {
			$pro_id_arr 			= $request->pro_id_arr;
			$dis_type_arr 			= $request->dis_type_arr;
			$product_name_arr 		= $request->product_name_arr;
			$unit_arr 	        	= $request->unit_arr;
			$pcs_arr 		    	= $request->pcs_arr;
			$cut_arr 		    	= $request->cut_arr;
			$meter_arr 				= $request->meter_arr;
			$rate_arr 				= $request->rate_arr;
			$amount_arr 			= $request->amount_arr;
			$discount_arr 			= $request->discount_arr;
            $discount_amount_arr 	= $request->discount_amount_arr;
			$total_arr 				= $request->total_arr;
			$remarks_arr 			= $request->remarks_arr;
			$order_item_priority_arr = $request->order_item_priority_arr;

			$grey_quality_arr 		= $request->grey_quality;
			$dyeing_color_arr 		= $request->dyeing_color;
			$coated_pvc_arr 		= $request->coated_pvc;
			$extra_job_arr 			= $request->extra_job;
			$print_job_arr 			= $request->print_job;
			$expect_delivery_date_arr 			= $request->expect_delivery_date;

			foreach($product_name_arr as $proidk=>$pro_name)
			{
				$proid 		= $pro_id_arr[$proidk];
				$itemTypeId = DB::table('items')->where('item_id', $proid)->value('item_type_id');

				// $sale_order_type = $sale_order_type_arr[$proidk];
				$trans_date = date('Y-m-d');
				$data[] = array(
					// 'bill_based' 		=> $bill_based,
					'sale_order_Id' 	=> $sale_order_Id,
					'item_id' 			=> $proid,
					'item_type_id' 		=> $itemTypeId,
					'name' 				=> $product_name_arr[$proidk],
					'dis_type' 			=> $dis_type_arr[$proidk],
					'total_price' 		=> $total_arr[$proidk],
					'unit' 				=> $unit_arr[$proidk],
					'pcs' 				=> $pcs_arr[$proidk],
					'cut' 				=> $cut_arr[$proidk],
					'meter' 			=> $meter_arr[$proidk],
					'rate' 				=> $rate_arr[$proidk],
					'amount' 			=> $amount_arr[$proidk],
					'discount' 			=> $discount_arr[$proidk],
					'discount_amount' 	=> $discount_amount_arr[$proidk],
					'net_amount' 		=> $total_arr[$proidk],
					'remarks' 			=> $remarks_arr[$proidk],
					'order_item_priority' => $order_item_priority_arr[$proidk],
					'grey_quality' 		=> $grey_quality_arr[$proidk],
					'dyeing_color' 		=> $dyeing_color_arr[$proidk],
					'coated_pvc' 		=> $coated_pvc_arr[$proidk],
					'extra_job' 		=> $extra_job_arr[$proidk],
					'print_job' 		=> $print_job_arr[$proidk],
					'expect_delivery_date' 	=> date('Y-m-d', strtotime($expect_delivery_date_arr[$proidk])),
					'created_by' 		=> 1,
					'modified_by' 		=> 1,
					'created' 			=> $trans_date,
					'modified' 			=> $trans_date
				);
			}

			$res =  SaleOrderItem::insert($data);
			if($res)
			{
			  Session::put('message', 'Added successfully.');
			  Session::put("messageClass","successClass");
			  return redirect("/show-saleorders");
			}
		  }
		  else
		  {
			Session::put('message', 'Someting Problem.');
			Session::put("messageClass","errorClass");
			return redirect("/show-saleorders");
		  }







  }


  public function show($id)
  {
      //
  }


	public function print_saleorder($id)
	{ 
		$pId = base64_decode($id);
		//  echo "<pre>"; print_r($pId); exit;
		$dataPur = SaleOrder::where('sale_order_id', '=', $pId)->where('status', '=', '1')->first();
		// echo "<pre>"; print_r($dataPur); exit;
		$dataPI = SaleOrderItem::where('sale_order_id', '=', $pId)->where('is_deleted', '=', '0')->get();
		$dataI  = Individual::where('id', '=', $dataPur->individual_id)->where('status', '=', '1')->first();
		$dataIA  = IndividualAddress::where('ind_add_id', '=', $dataPur->ind_add_id)->where('status', '=', '1')->first();
		//  echo "<pre>"; print_r($dataIA); exit;
		$dataCom = Company::where('id', '=', '1')->where('status', '=', '1')->first();
		return view('html.saleorder.print-saleorder', compact("dataPur","dataPI","dataCom","dataI","dataIA"));
	}
	
	public function show_saleorder_work_order_details($id)
	{ 
		$pId 		= base64_decode($id); 
		$dataPur 	= SaleOrder::where('sale_order_id', '=', $pId)->where('is_deleted', '=', '0')->with('SaleOrderItem')->with('ItemType')->first(); 
		$dataPI 	= SaleOrderItem::where('sale_order_id', '=', $pId)->where('is_deleted', '=', '0')->get();
		$dataI  	= Individual::where('id', '=', $dataPur->individual_id)->where('status', '=', '1')->first();
		$dataIA  	= IndividualAddress::where('ind_add_id', '=', $dataPur->ind_add_id)->where('status', '=', '1')->first();
		 
	 	// echo "<pre>"; print_r($dataPur);  
		return view('html.saleorder.show-saleorder-workorder-details', compact("dataPur","dataPI","dataI","dataIA"));


	}


  public function edit($id)
  {
      //
  }

  public function update(Request $request, $id)
  {
      //
  }

  public function deleteSaleOrder(Request $request)
  {
  //  echo "<pre>"; print_r($request->all()); exit;

  $FId 	= $request->FId;
  // $obj 	= SaleOrder::find($FId);
  $obj  = SaleOrder::where('sale_order_id', '=', $FId)->where('status', '=', '1')->first();
  $obj->is_deleted  = '1';
  $obj->save();
  return $FId;
  }











}
