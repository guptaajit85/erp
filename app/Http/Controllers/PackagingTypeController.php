<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\WarehouseBalanceItem;
use Validator, Auth, Session, Hash;
use App\Http\Controllers\CommonController;

class PackagingTypeController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
	
	
	public function index()
    { 
		 
		$query = WorkOrder::where('status', '=', '1')->orderByDesc('id');

		 
		$dataWI = $query->paginate(20); 
		 
		$priorityArr = config('global.priorityArr');
		return view('html.workorder.show-workorders', compact("dataWI","cusSearch","individualId","itemSearch","ordNumSearch","priority","dataMas","machine","processI","dataW","dataF","dataIT","dataI","dataITP","priorityArr"));
    }

	
	
	
	
	
}
