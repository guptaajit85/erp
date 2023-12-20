<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Auth;
use Validator, Session, Hash;

class DepartmentController extends Controller
{
     
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(Request $request)
    {
		$search = $request->input('search');
		$dataI  = Department::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
		return view('html.department.show-departments',compact("dataI"));
  
    }
   
    public function create_department()
    {
		$dataI = Department::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.department.add-department',compact("dataI"));
    }

    public function edit_department ($id)
	{
		$id    = base64_decode($id);
		$data  = Department::where('id', $id)->first(); 
		$dataI = Department::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.department.edit-department',compact("data","dataI"));
	}

     
    public function store_department(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter Department name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Department::create_data($request);
        $obj 	= new Department;
        $obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();


		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-departments");
		}   //
    }
 
	public function update_department(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter Department name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// echo "<pre>"; print_r($request); exit;
		// $is_saved = Department::create_data($request);
        $obj = Department::where('id','=', $request->id)->first();
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-departments");
		}

    }

    public function deleteDepartment(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Department::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

    
    public function destroy(Department $department)
    {
        //
    }
}
