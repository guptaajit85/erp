<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coting;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Validator, Auth,Session, Hash;

class CotingController extends Controller
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
            $dataI = Coting::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(1);;
		        return view('html.coting.show-cotings',compact("dataI"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_coting()
    {
        //
        $dataI = Coting::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.coting.add-coting',compact("dataI"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_coting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter coting name.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
	
    $obj 	= new Coting;
    $obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();

 ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Cotings';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg =  CommonController::getUserName($userId).' Added Coting '. $request->name ;
		$pageName = 'add-coting';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////
   

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-cotings");
		}   //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coting  $coting
     * @return \Illuminate\Http\Response
     */
    public function show(Coting $coting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coting  $coting
     * @return \Illuminate\Http\Response
     */
    public function edit_coting($id)
	{
		$id = base64_decode($id);
		$data = Coting::where('id', $id)->first();

		$dataI = Coting::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.coting.edit-coting',compact("data","dataI"));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coting  $coting
     * @return \Illuminate\Http\Response
     */
    public function update_coting(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
          ], [
            "name.required"=>"Please enter coting name.",

          ]);

           ////////////////////////// Notification Start Added/////////////////////////////
		       $userId = Auth::id();
		       $modeName = 'Cotings';
		       $urlPage = $_SERVER['HTTP_REFERER'];
		       $mesg =  CommonController::getUserName($userId).' Updated Coting '. $request->name ;
		       $pageName = 'edit-coting';
		       CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		       ////////////////////////// Notification End Added/////////////////////////////
   

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

    $obj = Coting::where('id','=', $request->id)->first();
		$obj->name  				  = addslashes(stripslashes($request->name));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-cotings");
		}

    }  

    public function deleteCoting(Request $request)
        {
            $FId 	= $request->FId;
            $obj 	= Coting::find($FId);
            $obj->status  = '0';
            $obj->save();

             ////////////////////////// Notification Start Added/////////////////////////////
              $userId = Auth::id();
              $modeName = 'Cotings';
              $urlPage = $_SERVER['HTTP_REFERER'];
              $mesg = CommonController::getUserName($userId). ' Deleted Coting '. $obj->name ;
              $pageName = 'show-cotings';
              CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
              ////////////////////////// Notification End Added/////////////////////////////
   
            return $FId;
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coting  $coting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coting $coting)
    {
        //
    }
}
