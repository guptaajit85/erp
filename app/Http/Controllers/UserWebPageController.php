<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllPage; 
use App\Models\UserWebPage; 
use App\Models\User; 
use Illuminate\Support\Facades\DB;
use Auth;
use Validator, Session, Hash;
use App\Http\Controllers\CommonController;

class UserWebPageController extends Controller
{
    
	public function __construct()
    {
       $this->middleware('auth');
	}
	
    public function index(Request $request)
    { 
		error_reporting(0);
		$dataI = UserWebPage::where('status', '=', '1')->groupBy('user_id')->orderByDesc('id')->paginate(20);	
		return view('html.userwebpages.show-userwebpages',compact("dataI"));
    }     
     
    public function create()
    {
		error_reporting(0);
		return view('html.userwebpages.add-userwebpage');
    }
    
    public function store(Request $request)
	{
		// echo "<pre>"; print_r($request->all()); exit;	
		$validator = Validator::make($request->all(), [
			"user_id" => "required",
			"page_id" => "required|array|min:1",
		], [
			"user_id.required" => "Please select a user.",
			"page_id.required" => "Please select at least one page.",
		]);

		if ($validator->fails()) {
			 
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();			
		}

		$userId 		= $request->user_id;
		$pageIdArr 		= $request->page_id;
		$data = UserWebPage::where('user_id', $userId)->first();

		if ($data) {
			Session::flash('message', 'This user already has page permissions.');
			Session::flash("messageClass", "errorClass");
			return redirect()->back()->withInput();
		} else {
			$is_saved = false;

			foreach ($pageIdArr as $pageId) 
			{
				$obj = new UserWebPage();
				$obj->user_id 				= $userId;
				$obj->page_id 				= $pageId;
				$obj->created  				= date("Y-m-d H:i:s");
				$obj->modified  			= date("Y-m-d H:i:s");
				$obj->status = 1;
				$is_saved = $obj->save();
			}

			if ($is_saved) {
				Session::flash('message', 'Added successfully.');
				Session::flash("messageClass", "successClass");
				return redirect("/show-userwebpages");
			}
		}
	}
		 
    public function show($id)
    {
        //
    }
     
    public function edit($id)
    {
		error_reporting(0);
        $id = base64_decode($id);
		$data  = UserWebPage::where('id', $id)->first(); 
		// echo "<pre>"; print_r($data); exit;
		return view('html.userwebpages.edit-userwebpage',compact("data"));
    }
     
    public function create_userwebpage($id)
    {
	    error_reporting(0);
        $userId = base64_decode($id);	
		$data  = User::where('id', $userId)->first(); 
		 
		return view('html.userwebpages.indadd-userwebpage',compact("userId","data"));
    }
    
    public function update(Request $request)
    {
		// echo "<pre>"; print_r($request->all()); exit;
        
		
		$validator = Validator::make($request->all(), [
			"user_id" => "required",
			"page_id" => "required|array|min:1",
		], [
			"user_id.required" => "Please select a user.",
			"page_id.required" => "Please select at least one page.",
		]);

		if ($validator->fails()) {
			 
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();			
		}

		$userId 	= $request->user_id;
		$pageIdArr	= $request->page_id;

		UserWebPage::where('user_id', '=', $userId)->delete();
			
		$is_saved = false;
		foreach ($pageIdArr as $pageId) 
		{
			$obj = new UserWebPage();
			$obj->user_id 				= $userId;
			$obj->page_id 				= $pageId;
			$obj->created  				= date("Y-m-d H:i:s");
		    $obj->modified  			= date("Y-m-d H:i:s");
			$obj->status = 1;
			$is_saved = $obj->save();
		}

		if ($is_saved) {
			Session::flash('message', 'Updated successfully.');
			Session::flash("messageClass", "successClass");
			return redirect("/show-userwebpages");
		}
		
		
    }

    public function deleteUserWebPage(Request $request)
    { 
		$userId 	= $request->userId;
		$dataUWP    = UserWebPage::where('user_id', $userId)->get();  
		foreach($dataUWP as $row) 
		{
			$FId = $row->id;	
			$obj 	= UserWebPage::find($FId);
			$obj->status  	= '0';
			$isDelete 		= $obj->save();
		}			
		return $isDelete;
    }
	
    public function destroy($id)
    {
        //
    }

}
