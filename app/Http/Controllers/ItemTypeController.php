<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ItemType;
use App\Models\UnitType;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Validator,Auth, Session, Hash;

class ItemTypeController extends Controller
{
    //
    public function __construct()
    {
         $this->middleware('auth');
    }
    public function index(Request $request)
    {
        //
            $search = $request->input('search');
            $dataI = ItemType::query()->where([['item_type_name', 'LIKE', "%{$search}%"],['status', '=', '1']])->orderbyDesc('item_type_id')->paginate(10);
           return view('html.itemtype.show-itemtypes',compact("dataI"));
     }

     public function create_itemtype()
     {
         //
         $dataI = ItemType::where('status', '!=', '0')->orderByDesc('item_type_id')->get();
         $unitTypeData = UnitType::where('status', '!=', '0')->orderByDesc('unit_type_id')->get();
		 
         return view('html.itemtype.add-itemtype',compact("dataI","unitTypeData"));
     }
     
     public function edit_itemtype ($item_type_id)
     {
         $item_type_id = base64_decode($item_type_id);
         $data = ItemType::where('item_type_id', $item_type_id)->first();
 
         $dataI = ItemType::where('status', '!=', '0')->orderByDesc('item_type_id')->get();
		 $unitTypeData = UnitType::where('status', '!=', '0')->orderByDesc('unit_type_id')->get();
         return view('html.itemtype.edit-itemtype',compact("data","dataI","unitTypeData"));
     }

     public function store_itemtype(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "item_type_name"=>"required|max:100",
          ], [
            "item_type_name.required"=>"Please enter Item type name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
        $obj 	= new ItemType;
        $obj->item_type_name  				= addslashes(stripslashes($request->item_type_name));
        $obj->unit_type_id  				= $request->unit_type_id;
		    $obj->status  				= 1;
		    $obj->created  				= date("Y-m-d H:i:s");
		    $obj->modified  			= date("Y-m-d H:i:s");
		    $is_saved 					= $obj->save();

  	////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'ItemType';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg =  CommonController::getUserName($userId) .'Added Item Type '. $request->name;
		$pageName = 'add-itemtype';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-itemtypes");
		}   //
    }


    public function update_itemtype(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "item_type_name"=>"required|max:100",
          ], [
            "item_type_name.required"=>"Please enter Item Type name.",
          ]);

  	////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'ItemType';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg =  CommonController::getUserName($userId) .'Updated Item Type '. $request->name;
		$pageName = 'edit-itemtype';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
        $obj = ItemType::where('item_type_id','=', $request->item_type_id)->first();
        $obj->item_type_name  	    = addslashes(stripslashes($request->item_type_name));
        $obj->unit_type_id  	    = addslashes(stripslashes($request->unit_type_id));
        $obj->status  				= 1;
        $obj->created  				= date("Y-m-d H:i:s");
        $obj->modified  			= date("Y-m-d H:i:s");
        $is_saved 					= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-itemtypes");
		}

    }

    public function deleteItemType(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= ItemType::find($FId);
		$obj->status  = '0';
		$obj->save();
   
    		
			////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'ItemType';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg =  CommonController::getUserName($userId) .'Deleted Item Type '. $obj->item_type_name;
		$pageName = 'show-itemtypes';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


		return $FId;
    }
}
