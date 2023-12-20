<?php

namespace App\Http\Controllers;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use Validator, Session, Hash;

class StateController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
	
    public function index(Request $request)
    {
        $qsearch =  $request->qsearch;
		$dataQ = State::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->with('statedetail')->orderBy('id', 'ASC')->paginate(20);
		
		return view('html.state.show-states',compact("dataQ","qsearch"));
    }

    
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = State::where('id', $id)->first();
		 
		return view('html.state.edit-state',compact("data"));
    }


	public function create()
    {
		// $dataP = State::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.state.add-state');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required",            
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
		
		$obj = new State;	 
        $obj->country_id  			= $request->country_id;
		$obj->name  					= $request->name;	
		
		
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-states");
		}	
    }

    
    
    public function update(Request $request, State $state)
    {
       $validator = Validator::make($request->all(), [
            "name"=>"required",             
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
	 
		 
		$obj = State::find($request->id);	
        $obj->country_id 			    = $request->country_id;	 
		$obj->name  					= $request->name; 
				
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-states");
		}
    }
    
    public function deleteState(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= State::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
    
    public function destroy($id)
    {
        //
    }
}
