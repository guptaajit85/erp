<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use Validator, Session, Hash;

class CityController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }
	
    public function index(Request $request)
    {
        $qsearch =  $request->qsearch;
		$dataQ = City::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->orderByDesc('id')->paginate(20);
		// echo "<pre>"; print_r($dataQ);  exit;
		return view('html.city.show-cities',compact("dataQ","qsearch"));
    }

    
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = City::where('id', $id)->first();
		 
		return view('html.city.edit-city',compact("data"));
    }


	public function create()
    {
		// $dataP = City::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.city.add-city');
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
		
		$obj = new City;	 
        $obj->state_id  				= $request->state_id;
		$obj->name  					= $request->name;	
		
		
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-cities");
		}	
    }

    
    
    
    

    
    public function update(Request $request, City $city)
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
	 
		 
		$obj = City::find($request->id);	
        $obj->state_id 			    = $request->state_id;	 
		$obj->name  					= $request->name; 
				
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-cities");
		}
    }
    
    public function deleteCity(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= City::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
    
    public function destroy($id)
    {
        //
    }
}
