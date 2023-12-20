<?php

namespace App\Http\Controllers;

use App\Models\HSN;
use App\Models\GstRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth, Session, Hash;

class HSNController extends Controller
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
        $dataI =  HSN::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
		return view('html.hsn.show-hsns',compact("dataI"));
    }



	 public function beam_card(Request $request)
    {

		return view('html.hsn.beam-card');
    }

  public function beam_card_first(Request $request)
    {

		return view('html.hsn.beam-card-first');
    }

   public function job_card(Request $request)
    {

		return view('html.hsn.job-card');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_hsn()
    {
        //
        $dataI = HSN::where('status', '!=', '0')->orderByDesc('id')->get();
        $gstRateData = GstRate::where('status', '!=', '0')->orderByDesc('gst_rate_id')->get();
		return view('html.hsn.add-hsn',compact("dataI","gstRateData"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_hsn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|string|max:100"
          ], [
            "name.required"=>"Please enter hsn code."

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

    $obj 	= new HSN;
    $obj->name  				      = addslashes(stripslashes($request->name));
    $obj->gst_rate_id  				      = addslashes(stripslashes($request->gst_rate_id));

    $obj->description  				= addslashes(stripslashes($request->description));
		$obj->status  				    = 1;
		$obj->created  				    = date("Y-m-d H:i:s");
		$obj->modified  			    = date("Y-m-d H:i:s");
		$is_saved 					      = $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'HSN';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg =  CommonController::getUserName($userId).' Added HSN '. $request->name .' and description '. $request->description;
        $pageName = 'add-hsn';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////////////////////// Notification End Added/////////////////////////////



		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-hsns");
		}   //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HSN  $hSN
     * @return \Illuminate\Http\Response
     */
    public function show(HSN $hSN)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HSN  $hSN
     * @return \Illuminate\Http\Response
     */
    public function edit_hsn ($id)
	{
		$id = base64_decode($id);
		$data = HSN::where('id', $id)->first();

		$dataI = HSN::where('status', '!=', '0')->orderByDesc('id')->get();
		 $gstRateData = GstRate::where('status', '!=', '0')->orderByDesc('gst_rate_id')->get();
		return view('html.hsn.edit-hsn',compact("data","dataI","gstRateData"));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HSN  $hSN
     * @return \Illuminate\Http\Response
     */
    public function update_hsn(Request $request)
    {
		$validator = Validator::make($request->all(), [
      "name"=>"required|string|max:100"
    ], [
      "name.required"=>"Please enter hsn code."
    ]);

    ////////////////////////// Notification Start Added/////////////////////////////
    $userId = Auth::id();
    $modeName = 'HSN';
    $urlPage = $_SERVER['HTTP_REFERER'];
    $mesg =  CommonController::getUserName($userId).' Updated HSN '. $request->name .' and description '. $request->description;
    $pageName = 'edit-hsn';
    CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
    ////////////////////////// Notification End Added/////////////////////////////



		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
    $obj = HSN::where('id','=', $request->id)->first();
		$obj->name  				  = addslashes(stripslashes($request->name));
		$obj->gst_rate_id  				  = addslashes(stripslashes($request->gst_rate_id));
    $obj->description  				= addslashes(stripslashes($request->description));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-hsns");
		}

    }
    public function deleteHSN(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= HSN::find($FId);
		$obj->status  = '0';
		$obj->save();

       ////////////////////////// Notification Start Added/////////////////////////////
       $userId = Auth::id();
       $modeName = 'HSN';
       $urlPage = $_SERVER['HTTP_REFERER'];
       $mesg = CommonController::getUserName($userId). ' Deleted HSN '. $obj->name .' and description '. $obj->description;
       $pageName = 'show-hsns';
       CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
       ////////////////////////// Notification End Added/////////////////////////////


		return $FId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HSN  $hSN
     * @return \Illuminate\Http\Response
     */
    public function destroy(HSN $hSN)
    {
        //
    }
}
