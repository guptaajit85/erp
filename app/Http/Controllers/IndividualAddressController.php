<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Individual;
use App\Models\IndividualAddress;
use Illuminate\Http\Request;
use Validator, Session,Auth, Hash;
use App\Http\Controllers\CommonController;

class IndividualAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
         $this->middleware('auth');
	}
	
    public function index(Request $request)
    {
		error_reporting(0);
        $ind_type =  $request->ind_type;
        $search = $request->search;
            $dataP = IndividualAddress::query()
            ->where([['zip_code', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->where([['address_type', 'LIKE', "%{$ind_type}%"],['status', '=', '1']])
            ->with('statedetail')
            ->with('indidetail')
            ->orderByDesc('ind_add_id')
            ->paginate(20);
           return view('html.individualaddress.show-individualaddresses',compact("dataP","search","ind_type"));

    } 
	
	public function get_individual_addresses_list(Request $request, $id)
    {
	 error_reporting(0);
		$ind_type 	= $request->ind_type;
		$indID 		= base64_decode($id);
		$search 	= $request->search; 
		$query = IndividualAddress::where('individual_id', '=', $indID)
			->where('status', 1)
			->where(function ($q) use ($search) {
				$q->where('zip_code', 'LIKE', "%{$search}%");
			})
			->with('statedetail')
			->with('indidetail')
			->orderByDesc('ind_add_id'); 
		$dataP = $query->paginate(20);		 
		return view('html.individualaddress.show-individual-member-addresses',compact("dataP","search","ind_type","indID"));
    }

    
    public function create_individualaddress()
    {
        $dataI = State::where('status', '=', '1')->get();
        $dataM = Individual::where('status', '=', '1')->orderByDesc('id')->get();
        return view('html.individualaddress.add-individualaddress',compact("dataI","dataM"));
    }
    
    public function create($id)
    {
		$indID = base64_decode($id);
        $dataI = State::where('status', '=', '1')->get();
        $dataM = Individual::where('id', '=', $indID)->first();
        return view('html.individualaddress.add-individual-member-address',compact("dataI","dataM","indID"));
    }

    
    public function store_individualaddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "individual_id"=>"required|string|max:100",
            "address_type"=>"required|string|max:100",
            "address_1"=>"required|string|max:5555",
            "address_2"=>"required|string|max:5555",
            "state_id"=>"required|string|max:100",
            "city"=>"required|string|max:100",
            "zip_code"=>"required|string|min:6|max:6",

          ], [
            "individual_id.required"=>"Please enter individual id .",
            "address_type.required"=>"Please enter address type.",
            "address_1.required"=>"Please enter address 1.",
            "address_2.required"=>"Please enter address 2.",
            "state_id.required"=>"Please enter state id.",
            "city.required"=>"Please enter city.",
            "zip_code.required"=>"Please enter zip code.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}


		$obj = new IndividualAddress;
        $obj->individual_id  					= $request->individual_id;
		$obj->address_type  					= $request->address_type;
        $obj->address_1  					= $request->address_1;
        $obj->address_2  					= $request->address_2;
        $obj->state_id  					= $request->state_id;
        $obj->city  					= $request->city;
        $obj->zip_code  					= $request->zip_code;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'IndividualAddress';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $individual_name=Individual::where('id','=',$request->individual_id)->first();
        $mesg = CommonController::getUserName($userId) .' Added Individual Address '.$individual_name->name  ;
        $pageName = 'add-individualaddress';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individualaddresses");
		}
    }
     
    public function store(Request $request)
    {
		 
        $validator = Validator::make($request->all(), [
            "individual_id"=>"required|string|max:100",
            "address_type"=>"required|string|max:100",
            "address_1"=>"required|string|max:5555",
            "address_2"=>"required|string|max:5555",
            "state_id"=>"required|string|max:100",
            "city"=>"required|string|max:100",
            "zip_code"=>"required|string|min:6|max:6",
          ], [
            "individual_id.required"=>"Please enter individual id .",
            "address_type.required"=>"Please enter address type.",
            "address_1.required"=>"Please enter address 1.",
            "address_2.required"=>"Please enter address 2.",
            "state_id.required"=>"Please enter state id.",
            "city.required"=>"Please enter city.",
            "zip_code.required"=>"Please enter zip code.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		} 
		$obj = new IndividualAddress;
        $obj->individual_id  					= $request->individual_id;
		$obj->address_type  					= $request->address_type;
        $obj->address_1  						= $request->address_1;
        $obj->address_2  						= $request->address_2;
        $obj->state_id  						= $request->state_id;
        $obj->city  							= $request->city;
        $obj->zip_code  						= $request->zip_code;
		$obj->created  							= date("Y-m-d H:i:s"); 
		$is_saved 								= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'IndividualAddress';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $individual_name=Individual::where('id','=',$request->individual_id)->first();
        $mesg = CommonController::getUserName($userId) .' Added Individual Address '.$individual_name->name  ;
        $pageName = 'add-individualaddress';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName); 
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass"); 			
			return redirect("/show-individual-member-addresses/".base64_encode($obj->individual_id));
		}
    }
 
    
	
	public function show(IndividualAddress $individualAddress)
    {
        //
    } 
    
    public function edit_individualaddress($ind_add_id)
    {        
		$ind_add_id= base64_decode($ind_add_id);
		$data = IndividualAddress::where('ind_add_id', $ind_add_id)->first();
		$dataI = State::where('status', '=', '1')->get();
		$dataM = Individual::where('status', '=', '1')->orderByDesc('id')->get();
		return view('html.individualaddress.edit-individualaddress',compact("data","dataI","dataM"));
        
    }   
	
    public function edit($ind_add_id)
    {         
		$ind_add_id= base64_decode($ind_add_id);
		$data = IndividualAddress::where('ind_add_id', $ind_add_id)->first();
		$indID = $data->individual_id;
		// 	echo "<pre>"; print_r($data); exit;
		$dataI = State::where('status', '=', '1')->get();
		$dataM = Individual::where('id', '=', $indID)->first();
		return view('html.individualaddress.edit-individual-member-address',compact("data","dataI","dataM","indID"));
        
    } 
    
	
	
    public function update_individualaddress(Request $request)
    { 
        //echo "<pre>"; print_r($request->all()); exit;
        $validator = Validator::make($request->all(), [
            "individual_id"=>"required|string|max:100",
            "address_type"=>"required|string|max:100",
            "address_1"=>"required|string|max:5555",
            "address_2"=>"required|string|max:5555",
            "state_id"=>"required|string|max:100",
            "city"=>"required|string|max:100",
            "zip_code"=>"required|string|min:6|max:6",

          ], [
            "individual_id.required"=>"Please enter individual id .",
            "address_type.required"=>"Please enter address type.",
            "address_1.required"=>"Please enter address 1.",
            "address_2.required"=>"Please enter address 2.",
            "state_id.required"=>"Please enter state id.",
            "city.required"=>"Please enter city.",
            "zip_code.required"=>"Please enter zip code.",

          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		// $is_saved = Person::create_data($request);

		$obj = IndividualAddress::where('ind_add_id','=', $request->ind_add_id)->first();
        $obj->individual_id  					= $request->individual_id;
		$obj->address_type  					= $request->address_type;
        $obj->address_1  					= $request->address_1;
        $obj->address_2  					= $request->address_2;
        $obj->state_id  					= $request->state_id;
        $obj->city  					= $request->city;
        $obj->zip_code  					= $request->zip_code;
		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'IndividualAddress';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $individual_name=Individual::where('id','=',$request->individual_id)->first();
        $mesg = CommonController::getUserName($userId) .' Updated Individual Address '. $individual_name->name ;
        $pageName = 'edit-individualaddress';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individualaddresses");
		}

    }
   
    public function update(Request $request)
    { 
        //echo "<pre>"; print_r($request->all()); exit;
        $validator = Validator::make($request->all(), [
            "individual_id"=>"required|string|max:100",
            "address_type"=>"required|string|max:100",
            "address_1"=>"required|string|max:5555",
            "address_2"=>"required|string|max:5555",
            "state_id"=>"required|string|max:100",
            "city"=>"required|string|max:100",
            "zip_code"=>"required|string|min:6|max:6",

          ], [
            "individual_id.required"=>"Please enter individual id .",
            "address_type.required"=>"Please enter address type.",
            "address_1.required"=>"Please enter address 1.",
            "address_2.required"=>"Please enter address 2.",
            "state_id.required"=>"Please enter state id.",
            "city.required"=>"Please enter city.",
            "zip_code.required"=>"Please enter zip code.",

          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

	 

		$obj = IndividualAddress::where('ind_add_id','=', $request->ind_add_id)->first();
        $obj->individual_id  			= $request->individual_id;
		$obj->address_type  			= $request->address_type;
        $obj->address_1  				= $request->address_1;
        $obj->address_2  				= $request->address_2;
        $obj->state_id  				= $request->state_id;
        $obj->city  					= $request->city;
        $obj->zip_code  				= $request->zip_code;
		// $obj->status  				= 1;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'IndividualAddress';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $individual_name=Individual::where('id','=',$request->individual_id)->first();
        $mesg = CommonController::getUserName($userId) .' Updated Individual Address '. $individual_name->name ;
        $pageName = 'edit-individualaddress';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			 
			return redirect("/show-individual-member-addresses/".base64_encode($obj->individual_id));
		}

    }
   

   
	public function deleteIndividualAddress(Request $request)
    {	// error_reporting(0); 
	
	// 	echo "<pre>"; print_r($request->all()); exit;
		$FId 	= $request->FId; 
		$obj = IndividualAddress::where('ind_add_id','=', $FId)->first();		
		// echo "<pre>"; print_r($obj);  exit;		
		IndividualAddress::where('ind_add_id', $FId)->update(['status' => 0]); 
		return $FId;
    }
	
	
	public function updateDefaultAddress(Request $request)
    {    
		// echo "<pre>"; print_r($request->all());  exit;		
		$addressId 	= $request->FId;  
		$obj = IndividualAddress::where('ind_add_id','=', $addressId)->first();		
		if ($obj) 
		{			 
			$indId 			= $obj->individual_id;
			$addressType 	= $obj->address_type;
			
			IndividualAddress::where('individual_id', $indId)
				->where('address_type', $addressType)
				->update(['default_address' => 1]);
			 
			IndividualAddress::where('ind_add_id', '!=', $addressId)
				->where('individual_id', $indId)
				->where('address_type', $addressType)
				->update(['default_address' => 0]);

			return response()->json(['message' => 'Default address updated successfully']);
		} else {
			return response()->json(['error' => 'Record not found']);
		}

    }
	
	 
	
	
 
    public function destroy(IndividualAddress $individualAddress)
    {
        //
    }
}
