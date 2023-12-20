<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Individual;
use App\Models\Module;
use App\Models\UserModuleAssignment;
use App\Models\UserWebPage;
use Illuminate\Http\Request;
use Validator, Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CommonController;

class UserController extends Controller
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
		$ind_type =  $request->ind_type;
		$qsearch  =  trim($request->qsearch);
		if(!empty($qsearch) || !empty($ind_type))
		{
			$dataU = User::where(function ($query) use ($qsearch, $ind_type) {
			$query->whereRaw("CONCAT(name, whatsapp, phone_no, email) LIKE ?", ['%' . $qsearch . '%'])->where('type', '=', $ind_type);
			})->where('status', 1)->paginate(20);
		}
		else 
		{ 
			$dataU = User::where('status', '=', '1')->orderByDesc('id')->paginate(20); 
		} 
		
		$dataU->appends(['qsearch' => $qsearch, 'ind_type' => $ind_type]);		  
        return view('html.user.show-users', compact('dataU','qsearch','ind_type'));
     }

    
    public function create_user()
    {
      
        $dataI = Individual::where('id', 1)
        ->with('User')
        ->first();
        $dataU = User::orderByDesc('id')->get();
        $dataM=Module::orderByDesc('id')->get();
        //echo "<pre>"; print_r($dataI); exit;

            return view('html.user.add-user',compact("dataI","dataU","dataM"));

    }

    
    public function store_user(Request $request)
    {
        
		 // echo "<pre>"; print_r($request->all()); exit;
			$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
			$validator = Validator::make($request->all(), [
			'photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000),
			'max:2048'
			],
			'aadhar_photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000), // Adjust dimensions as needed
			'max:2048'  
			],
			'voter_photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000), // Adjust dimensions as needed
			'max:2048'  
			],
			'pan_photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000), // Adjust dimensions as needed
			'max:2048'  
			],
            "name"=>"required|string|max:100",  
            "address"=>"required|string|max:100",
            "phone_no"=>"required|regex:/^[0-9]{10}$/",
            "email"=>"required|email|unique:users,email|max:255", 
            //'pan_number' => 'required|regex:/^[A-Z]{5}\d{4}[A-Z]{1}$/i|unique:users,pan_number',
            "reference"=>"required|max:100",
            "emergency_phone"=>"required|regex:/^[0-9]{10}$/", 
            'password' => 'required|string|min:8',   
		  ], [
			"photo.required"=>"Please enter  Photo",
			"name.required"=>"Please enter  Name",  
			"address.required"=>"Please enter Address",
			"phone_no.required"=>"Please enter Phone Number",
			"email.required"=>"Please enter Email Id", 
			// "pan_number.required"=>"Please enter Pan Card Number", 
			"reference.required"=>"Please enter Reference ",
			"emergency_phone.required"=>"Please enter Emergency Phone Number", 
			"password.required"=>"Please enter Password",			
		  ]);

        if ($validator->fails())
        {
            $error = $validator->errors()->first();
            Session::put('message', $validator->messages()->first());
            Session::put("messageClass","errorClass");
            return redirect()->back()->withInput();
        }
        $password = $request->password;

        $obj 	= new User;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = uniqid('photo_', true) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('photos'), $photoName); // Adjust the storage path

            $obj->photo=$photoName;
        }
        if ($request->hasFile('aadhar_photo')) {
            $photo = $request->file('aadhar_photo');
            $photoName = uniqid('aadhar_photo_', true) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('user_document'), $photoName); // Adjust the storage path

            $obj->aadhar_photo=$photoName;
        }
        if ($request->hasFile('voter_photo')) {
            $photo = $request->file('voter_photo');
            $photoName = uniqid('voter_photo_', true) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('user_document'), $photoName); // Adjust the storage path

            $obj->voter_photo=$photoName;
        }
        if ($request->hasFile('pan_photo')) {
            $photo = $request->file('pan_photo');
            $photoName = uniqid('pan_photo_', true) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('user_document'), $photoName); // Adjust the storage path

            $obj->pan_photo=$photoName;
        }
		
		
        $obj->name  						= $request->name; 
        $obj->gstin  						= $request->gstin;  
        $obj->type  						= $request->type;  
        $obj->individual_id  				= $request->individual_id;
		$obj->address  						= $request->address;
		$obj->phone_no  					= $request->phone_no;
		$obj->email  						= $request->email;
        $obj->aadhar_number  				= $request->aadhar_number;
        $obj->voter_id  					= $request->voter_id;
        $obj->pan_number  					= $request->pan_number;
        $obj->whatsapp  					= $request->whatsapp;
        $obj->reference  					= $request->reference;
        $obj->emergency_phone  				= $request->emergency_phone;
        $obj->fam_name  					= $request->fam_name;
        $obj->fam_phone  					= $request->fam_phone;
        $obj->password  					= Hash::make($password);
		$obj->created_at  					= date("Y-m-d H:i:s");
        $obj->updated_at  					= date("Y-m-d H:i:s");
		$is_saved 							= $obj->save();
        $userId                             = $obj->id; 
		if($is_saved)
		{
			Session::put('message', 'User Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-users");
		}

		 
    }

    
    public function show(User $user)
    {
        //
    }

   
    public function edit_user($id)
    {
        $id = base64_decode($id);
        $dataI = User::where('id', $id)->first();
        //echo"<pre>"; print_r($dataI);exit;
        return view('html.user.edit-user',compact("dataI"));
    }
 
    public function update_user(Request $request)
    {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        $validator = Validator::make($request->all(), [
         'photo' => [
             'image',
             function ($attribute, $value, $fail) use ($allowedMimeTypes) {
                 if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
                     $fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
                 }
             },
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000),  
			'max:2048'  
			],
			'aadhar_photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000),  
			'max:2048'  
			],
			'voter_photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000),  
			'max:2048'  
			],
			'pan_photo' => [
			'image',
			function ($attribute, $value, $fail) use ($allowedMimeTypes) {
			if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
			$fail("The $attribute must be a file of type: " . implode(', ', $allowedMimeTypes));
			}
			},
			Rule::dimensions()->maxWidth(2000)->maxHeight(2000), 
			'max:2048'  
			],
             "name"=>"required|string|max:100",
             "user_name"=>"required|string|max:100",
             "individual_id"=>"required|string|max:100",
             "address"=>"required|string|max:100",
             "phone_no"=>"required|regex:/^[0-9]{10}$/",
             "email"=>"required|email|unique:users,email,".$request->id,
             'aadhar_number' => 'required|regex:/^\d{12}$/|unique:users,aadhar_number,'.$request->id,
             'voter_id' => 'required|string|max:10|unique:users,voter_id,'.$request->id,
             'pan_number' => 'required|regex:/^[A-Z]{5}\d{4}[A-Z]{1}$/i|unique:users,pan_number,'.$request->id,
             "reference"=>"required|string|max:100",
             "emergency_phone"=>"required|regex:/^[0-9]{10}$/",
             "fam_name"=>"required|max:100",
             "fam_phone"=>"required|regex:/^[0-9]{10}$/",

       ], [
         "photo.required"=>"Please enter  Photo",
         "name.required"=>"Please enter  Name",
         "user_name.required"=>"Please enter User Name",
         "individual_id.required"=>"Ther is No  Individual Id",
         "address.required"=>"Please enter Address",
         "phone_no.required"=>"Please enter Phone Number",
         "email.required"=>"Please enter Email Id",
         "aadhar_number.required"=>"Please enter Aadhar Number",
         "aadhar_photo.required"=>"Please enter Aadhar Card Photo",
         "voter_id.required"=>"Please enter Voter Id Number",
         "voter_photo.required"=>"Please enter VOter Id Photo",
         "pan_number.required"=>"Please enter Pan Card Number",
         "pan_photo.required"=>"Please enter Pan Card Photo",
         "reference.required"=>"Please enter Reference ",
         "emergency_phone.required"=>"Please enter Emergency Phone Number",
         "fam_name.required"=>"Please enter Family Member Name",
         "fam_phone.required"=>"Please enter Family Member Phone Number",
       ]);
          if ($validator->fails())
          {
              $error = $validator->errors()->first();
              Session::put('message', $validator->messages()->first());
              Session::put("messageClass","errorClass");
              return redirect()->back()->withInput();
          }
		$obj = User::where('id','=', $request->id)->first();

		if ($request->hasFile('photo')) {
		$photo = $request->file('photo');
		$photoName = uniqid('photo_', true) . '.' . $photo->getClientOriginalExtension();
		$photo->move(public_path('photos'), $photoName); // Adjust the storage path

		$obj->photo=$photoName;
		}
		if ($request->hasFile('aadhar_photo')) {
		$photo = $request->file('aadhar_photo');
		$photoName = uniqid('aadhar_photo_', true) . '.' . $photo->getClientOriginalExtension();
		$photo->move(public_path('user_document'), $photoName); // Adjust the storage path

		$obj->aadhar_photo=$photoName;
		}
		if ($request->hasFile('voter_photo')) {
		$photo = $request->file('voter_photo');
		$photoName = uniqid('voter_photo_', true) . '.' . $photo->getClientOriginalExtension();
		$photo->move(public_path('user_document'), $photoName); // Adjust the storage path

		$obj->voter_photo=$photoName;
		}
		if ($request->hasFile('pan_photo')) {
		$photo = $request->file('pan_photo');
		$photoName = uniqid('pan_photo_', true) . '.' . $photo->getClientOriginalExtension();
		$photo->move(public_path('user_document'), $photoName); // Adjust the storage path

		$obj->pan_photo=$photoName;
		}
		if(isset($request->password)){
		$password=$request->password;
		$obj->password  					= Hash::make($password);
		} 
		
		$obj->name  						= $request->name;
		$obj->user_name  					= $request->user_name;
        $obj->individual_id  				= $request->individual_id;
		$obj->address  						= $request->address;
		$obj->phone_no  					= $request->phone_no;
		$obj->email  						= $request->email;
        $obj->aadhar_number  				= $request->aadhar_number;
        $obj->voter_id  					= $request->voter_id;
        $obj->pan_number  					= $request->pan_number;
        $obj->reference  					= $request->reference;
        $obj->emergency_phone  				= $request->emergency_phone;
        $obj->fam_name  					= $request->fam_name;
        $obj->fam_phone  					= $request->fam_phone; 
        $obj->updated_at  					= date("Y-m-d H:i:s");
		$is_saved 							= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individuals");
		}
    }

 
    public function destroy(User $user)
    {
        //
    }
}
