<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;
use Validator,Auth, Session, Hash;

class StationController extends Controller
{
    //
    public function __construct()
    {
         $this->middleware('auth');
    }
    public function index(Request $request)
    {
      $qsearch =  $request->qsearch;
      $dataQ = Station::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->orderByDesc('id')->paginate(20);
      return view('html.station.show-stations',compact("dataQ","qsearch"));
        //
    }
    public function create_station()
    {
      $dataI = State::where('status', '!=', '0')->orderByDesc('id')->get();
        return view('html.station.add-station',compact("dataI"));
    }

    public function edit_station($id)
    {
     
      $id = base64_decode($id);
      $data  = Station::where('id', $id)->first();
      $dataI = State::where('status', '!=', '0')->orderByDesc('id')->get();
      return view('html.station.edit-station',compact("data","dataI"));
    }

    public function store_station(Request $request)
    {

		  $validator = Validator::make($request->all(), [
			"name"=>"required",    
			"state_id"=>"required",        
		  ], [
			"name.required"=>"Please enter  station name.",     
			"state_id.required"=>"Please enter state name",       
		  ]);

		if ($validator->fails())
		{
		  $error = $validator->errors()->first();
		  Session::put('message', $validator->messages()->first());
		  Session::put("messageClass","errorClass");
		  return redirect()->back()->withInput();
		}		 

		$obj = new Station;	 
		$obj->state_id  				= $request->state_id;
		$obj->name  					= $request->name;	
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		
	    ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Station';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Added Station '. $request->name ;
		$pageName = 'add-station';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////
   

		if($is_saved)
		{
		  Session::put('message', 'Added successfully.');
		  Session::put("messageClass","successClass");
		  return redirect("/show-stations");
		}	
    }


    public function update_station(Request $request)
    {
		$validator = Validator::make($request->all(), [
		"name"=>"required",  
		"state_id"=>"required",           
		], [
		"name.required"=>"Please enter name.",      
		"state_id.required"=>"Please enter state name",        
		]);

	  ////////////////////////// Notification Start Added/////////////////////////////
	  $userId = Auth::id();
	  $modeName = 'Station';
	  $urlPage = $_SERVER['HTTP_REFERER'];
	  $mesg = CommonController::getUserName($userId) .' Updated Station '. $request->name ;
	  $pageName = 'edit-station';
	  CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
	  ////////////////////////// Notification End Added/////////////////////////////
 
		if ($validator->fails())
		{
		  $error = $validator->errors()->first();
		  Session::put('message', $validator->messages()->first());
		  Session::put("messageClass","errorClass");
		  return redirect()->back()->withInput();
		}

		 
		$obj = Station::find($request->id);	

		$obj->state_id 			   	    = $request->state_id;	 
		$obj->name  					= $request->name; 
			
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
		  Session::put('message', 'Updated successfully.');
		  Session::put("messageClass","successClass");
		  return redirect("/show-stations");
		}


    }
    public function deleteStation(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Station::find($FId);
		$obj->status  = '0';
		$obj->save();

		
			////////////////////////// Notification Start Added/////////////////////////////
			$userId = Auth::id();
			$modeName = 'Station';
			$urlPage = $_SERVER['HTTP_REFERER'];
			$mesg = CommonController::getUserName($userId) .' Deleted Station '. $obj->name;
			$pageName = 'show-stations';
			CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
			////////////////////////// Notification End Added/////////////////////////////
	

		return $FId;
    }

}
