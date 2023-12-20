<?php

namespace App\Http\Controllers;

use App\Models\Stationary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth,Session, Hash;
use App\Http\Controllers\CommonController;


class StationaryController extends Controller
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
        $dataI =  Stationary::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
		return view('html.stationary.show-stationaries',compact("dataI"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_stationary()
    {
        //
        $dataI = Stationary::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.stationary.add-stationary',compact("dataI"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_stationary(Request $request)
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
    $obj 	= new Stationary;
    $obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();

      ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Stationary';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Added Stationary '. $request->name ;
		$pageName = 'add-stationary';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////
   

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-stationaries");
		}   //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function show(Stationary $stationary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function edit_stationary ($id)
	{
		$id = base64_decode($id);
		$data = Stationary::where('id', $id)->first();

		$dataI = Stationary::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.stationary.edit-stationary',compact("data","dataI"));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function update_stationary(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|string|max:100",
          ], [
            "name.required"=>"Please enter Stationary name.",

          ]);

   ////////////////////////// Notification Start Added/////////////////////////////
   $userId = Auth::id();
   $modeName = 'Stationary';
   $urlPage = $_SERVER['HTTP_REFERER'];
   $mesg = CommonController::getUserName($userId) .' Updated Stationary '. $request->name ;
   $pageName = 'edit-stationary';
   CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
   ////////////////////////// Notification End Added/////////////////////////////
  

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

    $obj = Stationary::where('id','=', $request->id)->first();
		$obj->name  				  = addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-stationaries");
		}

    }  
    public function deleteStationary(Request $request)
    {
        $FId 	= $request->FId;
        $obj 	= Stationary::find($FId);
        $obj->status  = '0';
        $obj->save();

        		////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Stationary';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Deleted Stationary '. $obj->name ;
		$pageName = 'show-stationaries';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


        return $FId;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stationary  $stationary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stationary $stationary)
    {
        //
    }
}
