<?php

namespace App\Http\Controllers;

use App\Models\DyedFabric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator, Session, Hash;


class DyedFabricController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
     
	 public function index(Request $request)
    {   
	    $qsearch =  $request->qsearch;
        $dataQ = DyedFabric::query()->where([['name', 'LIKE', "%{$qsearch}%"],['status', '=', '1']])->orderByDesc('id')->paginate(20);
		return view('html.dyedfabric.show-dyedfabrics',compact("dataQ","qsearch"));
    }
 
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = DyedFabric::where('id', $id)->first();
		 
		return view('html.dyedfabric.edit-dyedfabric',compact("data"));
    }


	public function create()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.dyedfabric.add-dyedfabric');
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
		
		$obj = new DyedFabric;	 
		$obj->name  					= $request->name;		 
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-dyedfabrics");
		}	
		
    }

    
     
    
    public function update(Request $request, DyedFabric $quality)
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
	 
		 
		$obj = DyedFabric::find($request->id);		 
		$obj->name  					= $request->name; 
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-dyedfabrics");
		}
    }


	public function deleteDyedFabric(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= DyedFabric::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

	
	
	
	
	
}
