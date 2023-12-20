<?php

namespace App\Http\Controllers;

use App\Models\Dying;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator, Session, Hash;

class DyingController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
   
    public function index(Request $request)
    {
		$qsearch =  $request->qsearch;
        $dataQ = Dying::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->orderByDesc('id')->paginate(2);
		return view('html.dying.show-dyings',compact("dataQ","qsearch"));
    }

    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = Dying::where('id', $id)->first();
		 
		return view('html.dying.edit-dying',compact("data"));
    }


	public function create()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.dying.add-dying');
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
		
		$obj = new Dying;	 
		$obj->name  					= $request->name;		 
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-dyings");
		}	
		
    }

    
     
    
    public function update(Request $request, Dying $dying)
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
	 
		 
		$obj = Dying::find($request->id);		 
		$obj->name  					= $request->name; 
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-dyings");
		}
    }


	public function deleteDying(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Dying::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

	
	
    
    public function destroy(Quality $quality)
    {
        //
    }
}
