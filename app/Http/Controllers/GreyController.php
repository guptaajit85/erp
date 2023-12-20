<?php

namespace App\Http\Controllers;

use App\Models\Grey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth, Session, Hash;

class GreyController extends Controller
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
        //
            $search = $request->input('search');
            $dataI = Grey::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
            return view('html.grey.show-greys',compact("dataI"));
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_grey()
    {
        //
        $dataI = Grey::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.grey.add-grey',compact("dataI"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_grey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter grey name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Department::create_data($request);
    $obj 	= new Grey;
    $obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();

    	    ////////////////////////// Notification Start Added/////////////////////////////
          $userId = Auth::id();
          $modeName = 'Grey';
          $urlPage = $_SERVER['HTTP_REFERER'];
          $mesg = CommonController::getUserName($userId). ' Added Grey '. $request->name;
          $pageName = 'add-grey';
          CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
          ////////////////////////// Notification End Added/////////////////////////////


		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-greys");
		}   //
    }

     
    public function edit_grey ($id)
	{
		$id = base64_decode($id);
		$data = Grey::where('id', $id)->first();

		$dataI = Grey::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.grey.edit-grey',compact("data","dataI"));
	}

    
 
    public function update_grey(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter Grey name.",

          ]);

          ////////////////////////// Notification Start Added/////////////////////////////
          $userId = Auth::id();
          $modeName = 'Grey';
          $urlPage = $_SERVER['HTTP_REFERER'];
          $mesg = CommonController::getUserName($userId). ' Updated Grey '. $request->name;
          $pageName = 'edit-grey';
          CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
          ////////////////////////// Notification End Added/////////////////////////////


		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

    $obj = Grey::where('id','=', $request->id)->first();
		$obj->name  				  = addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-greys");
		}

    }  



public function deleteGrey(Request $request)
        {
            $FId 	= $request->FId;
            $obj 	= Grey::find($FId);
            $obj->status  = '0';
            $obj->save();
  
             ////////////////////////// Notification Start Added/////////////////////////////
          $userId = Auth::id();
          $modeName = 'Grey';
          $urlPage = $_SERVER['HTTP_REFERER'];
          $mesg = CommonController::getUserName($userId). ' Deleted Grey '. $obj->name;
          $pageName = 'show-greys';
          CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
          ////////////////////////// Notification End Added/////////////////////////////

            return $FId;
        }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grey  $grey
     * @return \Illuminate\Http\Response
     */
  
}
