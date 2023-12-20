<?php

namespace App\Http\Controllers;

use App\Models\FinishedFabric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator, Session, Hash;

class FinishedFabricController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
	
    public function index(Request $request)
    {
 

		$qsearch =  $request->qsearch;
		 
		$dataQ = FinishedFabric::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->orderByDesc('id')->paginate(2);
		return view('html.finishedfabric.show-finishedfabrics',compact("dataQ","qsearch"));

    }
 
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = FinishedFabric::where('id', $id)->first();
		 
		return view('html.finishedfabric.edit-finishedfabric',compact("data"));
    }


	public function create()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.finishedfabric.add-finishedfabric');
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
		
		$obj = new FinishedFabric;	 
		$obj->name  					= $request->name;		 
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-finishedfabrics");
		}	
		
    }

    
     
    
    public function update(Request $request, FinishedFabric $quality)
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
	 
		 
		$obj = FinishedFabric::find($request->id);		 
		$obj->name  					= $request->name; 
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-finishedfabrics");
		}
    }


	public function deleteFinishedFabric(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= FinishedFabric::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }




}
