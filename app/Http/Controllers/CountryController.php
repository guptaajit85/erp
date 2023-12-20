<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use Validator, Session, Hash;

class CountryController extends Controller
{
	public function __construct()
    {
         $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $qsearch =  $request->qsearch;
		$dataQ = Country::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->orderBy('id', 'ASC')->paginate(20);
		
		return view('html.country.show-countries',compact("dataQ","qsearch"));
    }

    
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = Country::where('id', $id)->first();
		 
		return view('html.country.edit-country',compact("data"));
    }


	public function create()
    {
		// $dataP = Country::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.country.add-country');
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
		
		$obj = new Country;	 
        $obj->sortname  			= $request->sortname;
		$obj->name  					= $request->name;	
		
		
		//$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-countries");
		}	
    }

    
    
    
    

    
    public function update(Request $request, Country $country)
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
	 
		 
		$obj = Country::find($request->id);	
        $obj->sortname  			    = $request->sortname;	 
		$obj->name  					= $request->name; 
				
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-countries");
		}
    }
    
    public function deleteCountry(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Country::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
    
    public function destroy($id)
    {
        //
    }
}
