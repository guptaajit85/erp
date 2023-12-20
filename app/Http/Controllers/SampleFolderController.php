<?php

namespace App\Http\Controllers;

use App\Models\SampleFolder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth,Session, Hash;
use App\Http\Controllers\CommonController;


class SampleFolderController extends Controller
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
        $search = $request->input('search');
        $dataI =  SampleFolder::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(1);
		return view('html.samplefolder.show-samplefolders',compact("dataI"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_samplefolder()
    {
        //
        $dataI = SampleFolder::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.samplefolder.add-samplefolder',compact("dataI"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_samplefolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter Sample folder name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

    $obj 	= new SampleFolder;
    $obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
  ////////////////////////// Notification Start Added/////////////////////////////
  $userId = Auth::id();
  $modeName = 'SampleFolder';
  $urlPage = $_SERVER['HTTP_REFERER'];
  $mesg = CommonController::getUserName($userId) .' Added Sample Folder '. $request->name ;
  $pageName = 'add-samplefolder';
  CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
  ////////////////////////// Notification End Added/////////////////////////////
 

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-samplefolders");
		}   //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SampleFolder  $sampleFolder
     * @return \Illuminate\Http\Response
     */
    public function show(SampleFolder $sampleFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SampleFolder  $sampleFolder
     * @return \Illuminate\Http\Response
     */
    public function edit_samplefolder ($id)
	{
		$id = base64_decode($id);
		$data = SampleFolder::where('id', $id)->first();

		$dataI = SampleFolder::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.samplefolder.edit-samplefolder',compact("data","dataI"));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SampleFolder  $sampleFolder
     * @return \Illuminate\Http\Response
     */
    public function update_samplefolder(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter Sample folder name.",

          ]);

          ////////////////////////// Notification Start Added/////////////////////////////
  $userId = Auth::id();
  $modeName = 'SampleFolder';
  $urlPage = $_SERVER['HTTP_REFERER'];
  $mesg = CommonController::getUserName($userId) .' Updated Sample Folder '. $request->name ;
  $pageName = 'edit-samplefolder';
  CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
  ////////////////////////// Notification End Added/////////////////////////////
 

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
    $obj = SampleFolder::where('id','=', $request->id)->first();
		$obj->name  				  = addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-samplefolders");
		}

    }
    public function deleteSampleFolder(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= SampleFolder::find($FId);
		$obj->status  = '0';
		$obj->save();

    	
			////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'SampleFolder';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Deleted Sample Folder '. $obj->name ;
		$pageName = 'show-samplefolders';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


		return $FId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SampleFolder  $sampleFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SampleFolder $sampleFolder)
    {
        //
    }
}
