<?php

namespace App\Http\Controllers;
use App\Models\UserModuleAssignment;
use App\Models\User;
use App\Models\Module;
use Validator, Session, Hash;
use Illuminate\Http\Request;

class UserModuleAssignmentController extends Controller
{
    
    public function __construct()
    {
         $this->middleware('auth');
}
    public function index(Request $request)
    { 
		error_reporting(0);
        $dataM  = Module::orderByDesc('id')->get();
        $dataUM = UserModuleAssignment::where('status', '=', '1')
        ->with('userdetail')
        ->orderByDesc('id')
        ->paginate(20);
 		
        return view('html.usermoduleassignment.show-usermoduleassignments', compact('dataUM','dataM'));

     }

     
    public function create_usermoduleassignment()
    {
        $dataI = User::orderByDesc('id')->get();
        $dataM=Module::orderByDesc('id')->get();
        return view('html.usermoduleassignment.add-usermoduleassignment',compact("dataI","dataM"));
    }


    public function store_usermoduleassignment(Request $request)
    {
       // echo "<pre>"; print_r($request->all()); exit;

        $validator = Validator::make($request->all(), [
            "user_id"=>"required",
            "page_name"=>"required",
        ], [
            "user_id.required"=>"Please enter User Name",
            "page_name.required"=>"Please enter Pages",
        ]);

        if ($validator->fails())
        {
            $error = $validator->errors()->first();
            Session::put('message', $validator->messages()->first());
            Session::put("messageClass","errorClass");
            return redirect()->back()->withInput();
        }
        // $is_saved = Department::create_data($request);
        $p=$request->page_name;
        //echo "<pre>"; print_r($p); exit;
        // $pa=implode(",",$p);
        UserModuleAssignment::where('user_id', '=', $request->user_id)->update(['status' => 0]);
        foreach($p as $page)
        {
            $obj 	= new UserModuleAssignment;
            $obj->user_id  					= $request->user_id;
            $obj->page_name  					= $page;
            $obj->created  					= date("Y-m-d H:i:s");
            $obj->modified  					= date("Y-m-d H:i:s");
            $is_saved 						= $obj->save();
        }

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-individuals");
		}

    }


    public function show(UserModuleAssignment $UserModuleAssignment)
    {
        //
    }


    public function edit_usermoduleassignment($user_id)
    {

		$user_id = base64_decode($user_id);
        // $data = UserModuleAssignment::where('user_id', $id)->get();
        $dataUM = UserModuleAssignment::where('user_id','=' ,$user_id)->where('status','=','1')->with('pagedetail')->get();
        $dataM = Module::orderByDesc('id')->where('status','=','1')->with('UserModuleAssignment')->get();
        $dataU = User::orderByDesc('id')->get();
        $userModArr=array();
        foreach($dataUM as $um)
        {
            $userModArr[] = $um->page_name;
        }
        // echo "<pre>"; print_r($dataM);
        // echo "<pre>"; print_r($dataUM); exit;
        return view('html.usermoduleassignment.edit-usermoduleassignment', compact("user_id","dataUM","userModArr", "dataU", "dataM"));

    }

     
    public function update_usermoduleassignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "page_name" => "required",
        ], [
            "user_id.required" => "Please enter User Name",
            "page_name.required" => "Please enter Pages",
        ]);

        if ($validator->fails()) {
            Session::put('message', $validator->messages()->first());
            Session::put("messageClass", "errorClass");
            return redirect()->back()->withInput();
        }

        UserModuleAssignment::where('user_id', '=', $request->user_id)->update(['status' => 0]);

        foreach ($request->page_name as $page) {
            $obj = new UserModuleAssignment;
            $obj->user_id = $request->user_id;
            $obj->page_name = $page;
            $obj->created = now();
            $obj->modified = now();
            $is_saved = $obj->save();
        }

        if ($is_saved) {
            Session::put('message', 'Updated successfully.');
            Session::put("messageClass", "successClass");
            return redirect("/show-usermoduleassignments");
			 
        }
    }
    public function deleteUserModuleAssignment(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= UserModuleAssignment::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserModuleAssignment  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserModuleAssignment $UserModuleAssignment)
    {
        //
    }
}
