<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\UserModuleAssignment;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Auth;
use Validator;
use Session;
use Hash;

class ModuleController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
		$qsearch =  trim($request->qsearch);
        $dataP = Module::where('status', '=', '1')->where('page_name', 'LIKE', "%$qsearch%")
        ->orderByDesc('id')->paginate(20);
        //echo "<pre>"; print_r($dataP); exit;
		return view('html.module.show-modules',compact("dataP","qsearch"));
    }


    public function create()
    {
        $dataP = User::orderByDesc('id')->get();

        return view('html.module.add-module',compact("dataP"));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "page_name"=>"required",
          ], [
            "page_name.required"=>"Please enter page name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$obj = new Module;
		//$obj->user_id  			    = $request->user_id;
		$obj->heading  			    = $request->heading;
        $obj->page_name  			= $request->page_name;

		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-modules");
		}
    }


    public function show(Module $module)
    {
        //
    }





    public function edit($id)
    {
        $id = base64_decode($id);
		$data = Module::where('id', $id)->first();

		$dataP = User::orderByDesc('id')->get();
		return view('html.module.edit-module',compact("dataP","data"));
    }


    public function update(Request $request, Module $module)
    {
        $validator = Validator::make($request->all(), [
            "page_name"=>"required",
          ], [
            "module name.required"=>"Please enter module name.",
          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$obj = Module::find($request->id);

		//$obj->user_id  			= $request->user_id;
		$obj->heading  				= $request->heading;
		$obj->page_name  				= $request->page_name;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-modules");
		}

    }

    public function deleteModule(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Module::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }


    public function destroy(Module $module)
    {

    }
}
