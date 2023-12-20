<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\ProcessItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

use Validator,Auth, Session, Hash;

class MachineController extends Controller
{
 
    public function __construct()
    {
         $this->middleware('auth');
    }
    public function index(Request $request)
    {
        //
            $search = $request->input('search');
            $dataI = Machine::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
			return view('html.machine.show-machines',compact("dataI"));
  
    }

     
    public function create_machine()
    {         
        $dataI = Machine::where('status', '=', '1')->orderByDesc('id')->get();
        $dataPI = ProcessItem::where('status', '=', '1')->get();  
		return view('html.machine.add-machine',compact("dataI","dataPI"));
    }

    
    public function store_machine(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
            "process_wise"=>"required",
          ], [
            "name.required"=>"Please enter machine name.",
            "process_wise.required"=>"Please enter"
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
			 
			$obj 	= new Machine;
			$obj->name  				= addslashes(stripslashes($request->name));
			$obj->process_wise  		= addslashes(stripslashes($request->process_wise));
			$obj->is_busy  				= $request->is_busy;	
		    $obj->status  				= 1;
		    $obj->created  				= date("Y-m-d H:i:s");
		    $obj->modified  			= date("Y-m-d H:i:s");
		    $is_saved 					= $obj->save();


        ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Machine';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Added Machine '. $request->name ;
		$pageName = 'add-machine';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-machines");
		}    
    }
    
    
    public function edit_machine ($id)
	{
		$id = base64_decode($id);
		$data = Machine::where('id', $id)->first();
		$dataPI = ProcessItem::where('status', '=', '1')->get();   
		return view('html.machine.edit-machine',compact("data","dataPI"));
	}

  
     
    public function update_machine(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
            "process_wise"=>"required",
          ], [
            "name.required"=>"Please enter Machine name.",
            "process_wise.required"=>"Please enter ",

          ]);

          ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Machine';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Updated Machine '. $request->name .' and process wise:'. $request->process_wise;
		$pageName = 'edit-machine';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////


		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$obj = Machine::where('id','=', $request->id)->first();
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->process_wise   		= addslashes(stripslashes($request->process_wise));
		$obj->is_busy  				= $request->is_busy;	
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-machines");
		}

    }  

    public function deleteMachine(Request $request)
	{
		$FId 	= $request->FId;
		$obj 	= Machine::find($FId);
		$obj->status  = '0';
		$obj->save();

	  
		////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Machine';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Deleted Machine '. $obj->name .' and process wise:'. $obj->process_wise;
		$pageName = 'show-machines';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////


		return $FId;
	}
     
    public function destroy(Machine $machine)
    {
        //
    }
}
