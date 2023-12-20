<?php

namespace App\Http\Controllers;
use App\Models\IndividualType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Validator, Session, Hash;

class IndividualTypeController extends Controller
{
	
	public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $qsearch =  trim($request->qsearch);
		$dataQ = IndividualType::where('status', '=', '1')->where('name', 'LIKE', "%$qsearch%")->orderBy('id', 'ASC')->paginate(20);
		
		return view('html.individualtype.show-individualtypes',compact("dataQ","qsearch"));
    }

    
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = IndividualType::where('id', $id)->first();
		 
		return view('html.individualtype.edit-individualtype',compact("data"));
    }


	public function create()
    {
		// $dataP = IndividualType::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individualtype.add-individualtype');
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
		
		$obj = new IndividualType;
		$obj->name  					= $request->name;			
		
		//$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individualtypes");
		}	
    }

        
    public function update(Request $request, IndividualType $individualtype)
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
	 
		 
		$obj = IndividualType::find($request->id);		 
		$obj->name  					= $request->name; 
				
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individualtypes");
		}
    }
    
    public function deleteIndividualType(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= IndividualType::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }
    
    public function destroy($id)
    {
        //
    }
}