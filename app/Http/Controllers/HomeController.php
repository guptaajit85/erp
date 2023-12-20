<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Models\PurchaseOrderItem;
use App\Http\Controllers\CommonController;
use Auth;
use Validator;
use Session;
use Hash;


class HomeController extends Controller
{
    
    public function __construct()
    {
         $this->middleware('auth');
    }
    
    public function index()
    {
			// $userAgent = serialize($_SERVER);
			// echo "<pre>"; print_r($userAgent);  exit;
		
		$totalSaleOrd 				= SaleOrderItem::where('is_work_order_created', 0)->count();
		$totalWorkOrderprocess 		= SaleOrderItem::where('is_work_order_created', 1)->count();
		$totalPurchaseOrderItems 	= PurchaseOrderItem::where('is_deleted', 0)->count();
		return view('html.home',compact("totalSaleOrd","totalWorkOrderprocess","totalPurchaseOrderItems"));
    }
	
    public function dashboard()
    {
		$totalSaleOrd 				= SaleOrderItem::where('is_work_order_created', 0)->count();
		$totalWorkOrderprocess 		= SaleOrderItem::where('is_work_order_created', 1)->count();
		$totalPurchaseOrderItems 	= PurchaseOrderItem::where('is_deleted', 0)->count();
      
		return view('html.home',compact("totalSaleOrd","totalWorkOrderprocess","totalPurchaseOrderItems"));
    }
}
