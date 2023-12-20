<?php

namespace App\Http\Controllers;

use App\Models\CoatedFabric;
use Illuminate\Http\Request;

use Validator, Session, Hash;


class CoatedFabricController extends Controller
{
     public function __construct()
    {
         $this->middleware('auth');
    }
	 
	 public function index(Request $request)
    {
		$qsearch =  $request->qsearch;
        $dataQ =CoatedFabric::query()->where([['name', 'LIKE', "%{$qsearch}%"],['status', '=', '1']])->orderByDesc('id')->paginate(20);
        return view('html.coatedfabric.show-coatedfabrics',compact("dataQ","qsearch"));
    }
 
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = CoatedFabric::where('id', $id)->first();
		 
		return view('html.coatedfabric.edit-coatedfabric',compact("data"));
    }


	public function create()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.coatedfabric.add-coatedfabric');
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
		
		$obj = new CoatedFabric;	 
		$obj->name  					= $request->name;		 
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-coatedfabrics");
		}	
		
    }

    
     
    
    public function update(Request $request, CoatedFabric $quality)
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
	 
		 
		$obj = CoatedFabric::find($request->id);		 
		$obj->name  					= $request->name; 
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-coatedfabrics");
		}
    }


	public function deleteCoatedFabric(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= CoatedFabric::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
}
