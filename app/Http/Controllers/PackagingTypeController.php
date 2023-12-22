<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PackagingType;
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
		//	echo "sdsdsdsdsds"; exit;
		$query 	= PackagingType::where('status', '=', '1')->orderByDesc('id'); 
		$dataP  = $query->paginate(20); 		 
		$priorityArr = config('global.priorityArr');
		return view('html.packagingtype.show-packagingtypes', compact("dataP","priorityArr"));
     
	}

	public function create_packagingtype()
    {
        return view('html.packagingtype.add-packagingtype');
    }

   
    public function store_packagingtype(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|string|max:100",

          ], [
            "name.required"=>"Please enter name.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		
		$obj = new PackagingType;
		$obj->name  					= $request->name;
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-packagingtypes");
		}
    } 
    
	public function edit_packagingtype($id)
    {      
		$unit_type_id = base64_decode($id);
		$data = PackagingType::where('id', $unit_type_id)->first(); 
		return view('html.packagingtype.edit-packagingtype',compact("data"));        
    }
 
    public function update_packagingtype(Request $request)
    {	
		// echo "<pre>"; print_r($request->all()); exit;
        $validator = Validator::make($request->all(), [
            "name"=>"required|string|max:100",
          ], [
            "name.required"=>"Please enter name.",

          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		} 
		$obj = PackagingType::find($request->id);
		$obj->name  					= $request->name; 
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-packagingtypes");
		}

    }
	
    public function deletePackagingType(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= PackagingType::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
		





	
	
	
	
	
}
