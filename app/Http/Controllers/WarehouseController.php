<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Auth;
use Validator; 
use Session; 
use Hash;


class WarehouseController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
	
    public function index(Request $request)
    {
		$qsearch 	= trim($request->qsearch);
		$dataP 		= Warehouse::query()->where('status', '=', '1')->where(function ($query) use ($qsearch) {
		$query->where('warehouse_name', 'LIKE', "%$qsearch%")
			->orWhere('location', 'LIKE', "%$qsearch%")
			->orWhere('capacity', 'LIKE', "%$qsearch%")
			->orWhere('supervisor_name', 'LIKE', "%$qsearch%")
			->orWhere('contact_number', 'LIKE', "%$qsearch%");
		})->orderByDesc('id')->paginate(20);
		
		return view('html.warehouse.show-warehouses',compact("dataP","qsearch"));
    }
 

    public function create_warehouse()
    {		
		$dataU = User::where('status', '=', '1')->orderByDesc('id')->get();        
		return view('html.warehouse.add-warehouse',compact("dataU"));
    }

    
    
    public function store_warehouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "warehouse_name"=>"required",
          ], [
            "warehouse_name.required"=>"Please enter warehouse name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
				
		$obj = new Warehouse;		
		 
		$obj->warehouse_name  			= $request->warehouse_name;
		$obj->location  				= $request->location;
		$obj->capacity  				= $request->capacity;		
		$obj->supervisor_name  			= $request->supervisor_name;
		$obj->contact_number  			= $request->contact_number;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-warehouses");
		}

    }

   
    public function show(warehouse $warehouse)
    {
        //
    }

    
    public function edit_warehouse ($id)
	{
		$id    = base64_decode($id);
		$data  = Warehouse::where('id', $id)->first(); 
		$dataU = User::where('status', '=', '1')->orderByDesc('id')->get();        
		return view('html.warehouse.edit-warehouse',compact("data","dataU"));
	}

    
	public function update_warehouse(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "warehouse_name"=>"required",
          ], [
            "warehouse name.required"=>"Please enter warehouse name.",
          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
				 
		$obj = Warehouse::find($request->id);
	 
		 
		$obj->warehouse_name  			= $request->warehouse_name;
		$obj->location  				= $request->location;
		$obj->capacity  				= $request->capacity;		
		$obj->supervisor_name  			= $request->supervisor_name;
		$obj->contact_number  			= $request->contact_number;
		 	 
		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-warehouses");
		}

    } 

    public function deleteWarehouse(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Warehouse::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
}
