<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Individual;
use App\Models\Person;
use App\Models\ProcessItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 use Auth;
use Validator, Session, Hash;

class IndividualController extends Controller
{


    public function __construct()
    {
         $this->middleware('auth');
	}

    public function index(Request $request)
    { 
		 
		if (empty(CommonController::checkPageViewPermission())) {
			return redirect()->route('home')->with([
				'message' => 'Access denied! You do not have permission to access this page.',
				'messageClass' => 'errorClass'
			]);
		}
		
		error_reporting(0);
		$ind_type =  $request->ind_type;
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch) || !empty($ind_type))
		{
			$dataI = Individual::where(function ($query) use ($qsearch, $ind_type) {
			$query->whereRaw("CONCAT(name, whatsapp, phone, email) LIKE ?", ['%' . $qsearch . '%'])->where('type', '=', $ind_type);
		})->where('status', 1)->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 		
		$dataI->appends(['qsearch' => $qsearch, 'ind_type' => $ind_type]);	
		return view('html.individuals.show-individuals',compact("dataI","qsearch","ind_type"));

    }
	
	public function customers_individuals(Request $request)
    {
		error_reporting(0);
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'customers')->where(DB::raw("concat(name, whatsapp, pan, adhar, tanno, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'customers')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 	
			

		return view('html.individuals.show-customers-individuals',compact("dataI","qsearch"));
    }
	
	public function master_individuals(Request $request)
    { 
		error_reporting(0);
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'master')->where(DB::raw("concat(name, whatsapp, pan, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'master')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 	
		
		return view('html.individuals.show-master-individuals',compact("dataI","qsearch"));  
    }
	
    public function agent_individuals(Request $request)
    {
		error_reporting(0);
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'agents')->where(DB::raw("concat(name, whatsapp, pan, adhar, tanno, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'agents')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 	


		return view('html.individuals.show-agents-individuals',compact("dataI","qsearch"));
    }
	public function labourer_individuals(Request $request)
    { 
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'labourer')->where(DB::raw("concat(name, whatsapp, pan, adhar, tanno, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'labourer')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		}  
		return view('html.individuals.show-labourer-individuals',compact("dataI","qsearch"));
    }

	public function transport_individuals(Request $request)
    {
		 
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'transport')->where(DB::raw("concat(name, whatsapp, pan, adhar, tanno, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'transport')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 	

		return view('html.individuals.show-transport-individuals',compact("dataI","qsearch"));
    }
	
	public function vendors_individuals(Request $request)
    { 
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'vendors')->where(DB::raw("concat(name, whatsapp, pan, adhar, tanno, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'vendors')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		}  
		return view('html.individuals.show-vendors-individuals',compact("dataI","qsearch"));
    }

	public function employee_individuals(Request $request)
    {	 
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch))
		{
			$dataI = Individual::where('type', '=', 'employee')->where(DB::raw("concat(name, whatsapp, pan, adhar, tanno, gstin, company_name, phone, email)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);
		}
		else 
		{ 
			$dataI = Individual::where('type', '=', 'employee')->where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 
		return view('html.individuals.show-employee-individuals',compact("dataI","qsearch"));
    }

    public function edit_individual ($id)
	{
		$id = base64_decode($id);
		$data = Individual::where('id', $id)->first();
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		$dataPI = ProcessItem::where('status', '=', '1')->get();
		return view('html.individuals.edit-individual',compact("data","dataI","dataPI"));
	}

	public function viewpersons($id=null)
    {

		// echo "sdsdsdsd"; exit;
		$indID = base64_decode($id);
		$data = Individual::where('id', $indID)->first();
		$dataP = Person::where('consignee_id', '=', $indID)->where('status', '=', '1')->orderByDesc('id')->paginate(20);

		return view('html.individuals.show-persons',compact("data","indID","dataP"));
    }
    
	public function create_individual()
    {
		error_reporting(0);
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		$dataPI = ProcessItem::where('status', '=', '1')->get();
		  // echo '<pre>';print_r($dataPI); exit;
		return view('html.individuals.add-individual',compact("dataI","dataPI"));
    }


	public function store_individual(Request $request)
    {
		// echo "<pre>"; print_r($request->all()); exit;
		 
		$rules = [
			'type' => 'required|in:agents,customers,master,labourer,vendors,transport,employee',
			'name' => 'required',
			'phone' => 'required|numeric|digits:10',
			'email' => 'required|email',
			'pan' => 'nullable',
			'whatsapp' => 'required|numeric|digits:10',
			'is_verified' => 'in:yes,no',
		]; 
	   
		if ($request->input('type') === 'employee') {
			$rules['password'] = 'required';
		}  
		$messages = [
			'type.required' => 'Please select Individual Type.',
			'type.in' => 'Invalid Individual Type selected.',
			'name.required' => 'Please enter your name.',
			'phone.required' => 'Please enter your mobile number.',
			'phone.numeric' => 'Mobile number must be numeric.',
			'phone.digits' => 'Mobile number must be 10 digits long.',
			'email.required' => 'Please enter your email address.',
			'email.email' => 'Please enter a valid email address.',
			'password.required' => 'Please enter a password.',
			'whatsapp.required' => 'Please enter your WhatsApp number.',
			'whatsapp.numeric' => 'WhatsApp number must be numeric.',
			'whatsapp.digits' => 'WhatsApp number must be 10 digits long.',
			'is_verified.in' => 'Invalid verification status selected.',
		]; 
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) 
		{
			return back()->withErrors($validator)->withInput();
		} 
		
		$obj = new Individual;
		$obj->type  				= $request->type;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));			 
		$obj->process_type_id  		= $request->process_type_id;
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;		
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		$indId                      = $obj->id; 
		
		if ($request->input('type') === 'employee') 
		{
			$email = $request->email;	
			$userD  = User::where('email','=', $email)->first();	
			if(empty($userD))
			{
				$password = $request->password;
				$objM 	= new User;
				$objM->name  						= $request->name; 
				$objM->individual_id  				= $indId;
				$objM->email  						= $request->email;
				$objM->password  					= Hash::make($password);
				$objM->created_at  					= date("Y-m-d H:i:s");
				$objM->updated_at  					= date("Y-m-d H:i:s");
				$is_saved 							= $objM->save();
				$userId                             = $objM->id; 	
			} 
			else 
			{
				Session::put('message', 'Email Id already exists.');
				Session::put("messageClass","errorClass");	
				return back();				
			}
			
				 
		}   
		if($is_saved)
		{
			Session::put('message', 'Individual details added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individuals");
		}

    }
	
	public function store_transport_details(Request $request)
    {
		$obj = new Transport_Details;
		$obj->name  				= $request->name;
		$obj->from  				= $request->from;
		$obj->to  			    	= $request->to;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individuals");
		}
    }

	public function update_individual(Request $request)
	{
		$validator = Validator::make($request->all(), [
			"name" => "required",
			"phone" => "required",
			"email" => "required|email",
			"id" => "required",
		], [
			"name.required" => "Please enter first name.",
			"phone.required" => "Please enter your phone number.",
			"email.required" => "Please enter a valid email address.",
			"id.required" => "Something went wrong.",
		]);

		if ($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator);
		}

		$individual = Individual::find($request->id);

		if (!$individual) {
			return redirect()->back()->with('message', 'Individual not found.')->with("messageClass", "errorClass");
		}

		$individual->name 				= addslashes(stripslashes($request->name));
		$individual->process_type_id 	= $request->process_type_id;
		$individual->type 				= $request->type;
		$individual->company_name 		= addslashes(stripslashes($request->company_name));
		$individual->nick_name 			= addslashes(stripslashes($request->nick_name));
		$individual->email 				= addslashes(stripslashes($request->email));
		$individual->gstin 				= $request->gstin;
		$individual->pan 				= $request->pan;
		$individual->tanno 				= $request->tanno;
		$individual->phone 				= $request->phone;
		$individual->adhar 				= $request->adhar;
		$individual->whatsapp 			= $request->whatsapp;
		$individual->verified_remark 	= $request->verified_remark;
		$individual->is_verified 		= $request->is_verified;
		$individual->type 				= $request->type;
		$individual->status 			= 1;
		$individual->modified 			= date("Y-m-d H:i:s");
		$individual->save();

		if ($request->input('type') === 'employee' || $request->input('type') === 'master')
		{
			$user = User::where('individual_id', $request->id)->first();
			if ($user) 
			{
				$password 			= $request->password;
				$user->name 		= $request->name;
				$user->email 		= $request->email;
				$user->password 	= !empty($password) ? Hash::make($password) : $user->password;
				$user->updated_at 	= date("Y-m-d H:i:s");
				$user->save();
			} else {
				$existingUser = User::where('email', $request->email)->first();
				if (!$existingUser) {
					  $password = $request->password;
					 
					$user = new User([
						'name' => $request->name,
						'individual_id' => $request->id,
						'email' => $request->email,
						'password' => Hash::make($password),
						'created_at' => date("Y-m-d H:i:s"),
						'updated_at' => date("Y-m-d H:i:s"),
					]);
					// echo "<pre>"; print_r($user); exit;
					$user->save();
				} else {
					return redirect()->back()->with('message', 'Email Id already exists.')->with("messageClass", "errorClass");
				}
			}
		} elseif ($request->input('type') !== 'employee' || $request->input('type') !== 'master') {
			$user = User::where('individual_id', $request->id)->first();
			if ($user) {
				$user->status = 0;
				$user->save();
			}
		}
		return redirect("/show-individuals")->with('message', 'Updated successfully.')->with("messageClass", "successClass");
	}

 
    public function deleteIndividual(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Individual::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

    public function destroy($id)
    {
        //
    }
	
	public function create_customer_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individuals.add-customer-individual',compact("dataI"));
    }
    
	public function store_customer_individual(Request $request)
    { 
		$validator = Validator::make($request->all(), [
            "name"=>"required",
            "phone"=>"required",
            "email"=>"required",
          ], [
            "name.required"=>"Please enter first name.",
            "phone.required"=>"Please enter your phone number.",
            "email.required"=>"Please enter email.",
          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-customers-individuals");
		}

    }

	public function create_master_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		$dataPI = ProcessItem::where('status', '=', '1')->get();
		//echo '<pre>';print_r($dataPI);die;
		return view('html.individuals.add-master-individual',compact("dataI","dataPI"));
    }
    
	public function store_master_individual(Request $request)
    { 
		$validator = Validator::make($request->all(), [
			"name"=>"required",
			"phone"=>"required",
			"email"=>"required",
		], [
			"name.required"=>"Please enter first name.",
			"phone.required"=>"Please enter your phone number.",
			"email.required"=>"Please enter email.",
		]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->process_type_id  					= $request->process_type_id;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-master-individuals");
		}

    }	
	
	public function create_agent_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individuals.add-agent-individual',compact("dataI"));
    }
    
	public function store_agent_individual(Request $request)
    {
	  
		$validator = Validator::make($request->all(), [
			"name"=>"required",
			"phone"=>"required",
			"email"=>"required",
		], [
			"name.required"=>"Please enter first name.",
			"phone.required"=>"Please enter your phone number.",
			"email.required"=>"Please enter email.",
		]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-agents-individuals");
		}

    }
	
	public function create_labourer_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individuals.add-labourer-individual',compact("dataI"));
    }
    public function store_labourer_individual(Request $request)
    {
		$validator = Validator::make($request->all(), [
			"name"=>"required",
			"phone"=>"required",
			"email"=>"required",
		], [
			"name.required"=>"Please enter first name.",
			"phone.required"=>"Please enter your phone number.",
			"email.required"=>"Please enter email.",
		]); 
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-labourer-individuals");
		}

    }
	
	public function create_vendor_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individuals.add-vendor-individual',compact("dataI"));
    }
    
	public function store_vendor_individual(Request $request)
    {
		$validator = Validator::make($request->all(), [
			"name"=>"required",
			"phone"=>"required",
			"email"=>"required",
		], [
			"name.required"=>"Please enter first name.",
			"phone.required"=>"Please enter your phone number.",
			"email.required"=>"Please enter email.",
		]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-vendors-individuals");
		}

    }
	
	public function create_employee_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individuals.add-employee-individual',compact("dataI"));
    }
	
    public function store_employee_individual(Request $request)
    {
	   
		$validator = Validator::make($request->all(), [
			"name"=>"required",
			"phone"=>"required",
			"email"=>"required",
		], [
			"name.required"=>"Please enter first name.",
			"phone.required"=>"Please enter your phone number.",
			"email.required"=>"Please enter email.",
		]);
		
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-employee-individuals");
		}

    }
	
	public function create_transport_individual()
    {
		$dataI = Individual::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.individuals.add-transport-individual',compact("dataI"));
    }
	
    public function store_transport_individual(Request $request)
    {	   
		$validator = Validator::make($request->all(), [
			"name"=>"required",
			"phone"=>"required",
			"email"=>"required",
		], [
			"name.required"=>"Please enter first name.",
			"phone.required"=>"Please enter your phone number.",
			"email.required"=>"Please enter email.",
		]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Individual::create_data($request);
		$obj = new Individual;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->company_name  		= addslashes(stripslashes($request->company_name));
		$obj->nick_name  			= addslashes(stripslashes($request->nick_name));
		$obj->email  				= addslashes(stripslashes($request->email));
		$obj->gstin  				= $request->gstin;
		$obj->pan  					= $request->pan;
		$obj->tanno  				= $request->tanno;
		$obj->phone  				= $request->phone;
		$obj->adhar  				= $request->adhar;
		$obj->whatsapp  			= $request->whatsapp;
		$obj->verified_remark  		= $request->verified_remark;
		$obj->is_verified  			= $request->is_verified;

		$obj->type  				= $request->type;
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-transport-individuals");
		}

    }
	

}
