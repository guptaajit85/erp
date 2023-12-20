<?php

namespace App\Http\Controllers;

use App\Models\Quality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use Validator, Session, Hash;

class QualityController extends Controller
{
     
	public function __construct()
    {
         $this->middleware('auth');
    }
     
    public function index(Request $request)
    {
		$qsearch =  $request->qsearch;		 
		$dataQ = Quality::where(DB::raw("concat(name, internal_name, external_name)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->paginate(20);	
		return view('html.quality.show-qualities',compact("dataQ","qsearch"));
    }
 
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = Quality::where('id', $id)->first();
		 
		return view('html.quality.edit-quality',compact("data"));
    }


	public function create()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.quality.add-quality');
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
		
		$obj = new Quality;	 
		$obj->name  					= $request->name;	
		$obj->internal_name  			= $request->internal_name;	
		$obj->external_name  			= $request->external_name;	
		
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-qualities");
		}	
		
    }

    
     
    
    public function update(Request $request, Quality $quality)
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
	 
		 
		$obj = Quality::find($request->id);		 
		$obj->name  					= $request->name; 
		$obj->internal_name  			= $request->internal_name;
		$obj->external_name  			= $request->external_name;
		
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-qualities");
		}
    }


	public function deleteQuality(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Quality::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

	
	
    
    public function destroy(Quality $quality)
    {
        //
    }
}
