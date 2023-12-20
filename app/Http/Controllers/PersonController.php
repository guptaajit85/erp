<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use Validator, Session, Hash;


class PersonController extends Controller
{
    
	public function __construct()
    {
         $this->middleware('auth');
    }
 
    public function index(Request $request, $id)
    {   
		$qsearch = trim($request->qsearch);		 
		$indID   = base64_decode($id);
		$data    = Individual::where('id', $indID)->first();		 
		$dataP   = Person::where('individual_id', '=', $indID)->where(DB::raw("concat(name, email, mobile, call_no, whatsapp)"), 'LIKE', '%' . $qsearch . '%')->where('status', '=', '1')->orderByDesc('id')->paginate(20);		
		return view('html.person.show-persons',compact("data","indID","dataP","qsearch"));
    }

    public function edit_person ($id)
	{
		$id = base64_decode($id);
		$data = Person::where('id', $id)->first(); 
        $indID = $data->individual_id;  
		$dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.person.edit-person',compact("data","dataP","indID"));
	}



	public function create_person($id)
    {
		$indID = base64_decode($id);
		$data = Individual::where('id', $indID)->first(); 		 
		return view('html.person.add-person',compact("data","indID"));
    }


	public function store_person(Request $request)
    {
	    // echo "<pre>"; print_r($request->all()); exit;  
		$validator = Validator::make($request->all(), [
            "name"=>"required",
            "mobile"=>"required",
            "email"=>"required",
          ], [
            "name.required"=>"Please enter name.",
            "mobile.required"=>"Please enter mobile number.",
            "email.required"=>"Please enter email.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		$new_filename 	= '';
		if($request->hasFile('pimage'))
		{  
			$name 			= $request->file('pimage')->getClientOriginalName(); 
			$name_s 		= explode(".",$name);
			$new_filename 	= substr($name_s[0],0,15)."_".date("YmdHis").".".$name_s[1]; 
			$path = $request->file('pimage')->move(public_path('storage/images'), $new_filename); 
		}
		
	/*	$is_saved = Person::create_data($request);*/
		
		$obj = new Person;		
		$obj->individual_id  			= $request->individual_id;
		$obj->name  					= $request->name;
		$obj->email  					= $request->email;
		$obj->mobile  					= $request->mobile;		
		$obj->dob  						= $request->dob;
		$obj->doa  						= $request->doa;
		$obj->image  					= $new_filename;
		$obj->fb_link  					= $request->fb_link;
		$obj->call_no  					= $request->call_no;		
		$obj->whatsapp  				= $request->whatsapp;
		
		if($request->is_po_genrated)	$obj->is_po_genrated  						= $request->is_po_genrated;
		else $obj->is_po_genrated  													= 0;
		if($request->is_work_order_genrated)	$obj->is_work_order_genrated  		= $request->is_work_order_genrated;
		else $obj->is_work_order_genrated  											= 0;
		if($request->is_warp_process)	$obj->is_warp_process  						= $request->is_warp_process;
		else $obj->is_warp_process  												= 0;
		if($request->is_drawing_process)	$obj->is_drawing_process  				= $request->is_drawing_process;
		else $obj->is_drawing_process  												= 0;
		if($request->is_weave_process)	$obj->is_weave_process  					= $request->is_weave_process;
		else $obj->is_weave_process  												= 0;
		if($request->is_dyeing_process)	$obj->is_dyeing_process  					= $request->is_dyeing_process;
		else $obj->is_dyeing_process  												= 0;
		if($request->is_coting_process)	$obj->is_coting_process  					= $request->is_coting_process;
		else $obj->is_coting_process  												= 0;
		if($request->is_work_order_completed)	$obj->is_work_order_completed  		= $request->is_work_order_completed;
		else $obj->is_work_order_completed  										= 0;
		if($request->is_invoice_generated)	$obj->is_invoice_generated  			= $request->is_invoice_generated;
		else $obj->is_invoice_generated  											= 0;
		if($request->is_packing)	$obj->is_packing  								= $request->is_packing;
		else $obj->is_packing  														= 0;
		if($request->is_dispatch)	$obj->is_dispatch  								= $request->is_dispatch; 
		else $obj->is_dispatch  													= 0;

		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-persons/".base64_encode($obj->individual_id));
		}

    }


	public function update_person(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required",
            "mobile"=>"required",
            "email"=>"required",
          ], [
            "name.required"=>"Please enter name.",
            "mobile.required"=>"Please enter mobile number.",
            "email.required"=>"Please enter email.",
          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// echo "<pre>"; print_r($request->all());
		 // echo "<pre>"; print_r($request->hasFile('pimage1')); exit;
		$obj = Person::find($request->id);	
		$new_filename 	= $obj->image;		
		if($request->hasFile('pimage1'))
		{  
			$name 			= $request->file('pimage1')->getClientOriginalName(); 
			$name_s 		= explode(".",$name);
			$new_filename 	= substr($name_s[0],0,15)."_".date("YmdHis").".".$name_s[1]; 
			$path = $request->file('pimage1')->move(public_path('storage/images'), $new_filename); 
		}
		 
			 
		$obj->individual_id  			= $request->individual_id;
		$obj->name  					= $request->name;
		$obj->email  					= $request->email;
		$obj->mobile  					= $request->mobile;		
		$obj->dob  						= $request->dob;
		$obj->doa  						= $request->doa;
		$obj->image  					= $new_filename;
		$obj->fb_link  					= $request->fb_link;
		$obj->call_no  					= $request->call_no;		
		$obj->whatsapp  				= $request->whatsapp;
		
		if($request->is_po_genrated)	$obj->is_po_genrated  						= $request->is_po_genrated;
		else $obj->is_po_genrated  													= 0;
		if($request->is_work_order_genrated)	$obj->is_work_order_genrated  		= $request->is_work_order_genrated;
		else $obj->is_work_order_genrated  											= 0;
		if($request->is_warp_process)	$obj->is_warp_process  						= $request->is_warp_process;
		else $obj->is_warp_process  												= 0;
		if($request->is_drawing_process)	$obj->is_drawing_process  				= $request->is_drawing_process;
		else $obj->is_drawing_process  												= 0;
		if($request->is_weave_process)	$obj->is_weave_process  					= $request->is_weave_process;
		else $obj->is_weave_process  												= 0;
		if($request->is_dyeing_process)	$obj->is_dyeing_process  					= $request->is_dyeing_process;
		else $obj->is_dyeing_process  												= 0;
		if($request->is_coting_process)	$obj->is_coting_process  					= $request->is_coting_process;
		else $obj->is_coting_process  												= 0;
		if($request->is_work_order_completed)	$obj->is_work_order_completed  		= $request->is_work_order_completed;
		else $obj->is_work_order_completed  										= 0;
		if($request->is_invoice_generated)	$obj->is_invoice_generated  			= $request->is_invoice_generated;
		else $obj->is_invoice_generated  											= 0;
		if($request->is_packing)	$obj->is_packing  								= $request->is_packing;
		else $obj->is_packing  														= 0;
		if($request->is_dispatch)	$obj->is_dispatch  								= $request->is_dispatch; 
		else $obj->is_dispatch     	= 0; 									
		 	 
		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-persons/".base64_encode($obj->individual_id));
		}

    }

    public function deletePerson(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Person::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }


    public function destroy(Person $person)
    {
        //
    }
}
