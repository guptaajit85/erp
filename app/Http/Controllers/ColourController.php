<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Colour;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


use Validator,Auth, Session, Hash;

class ColourController extends Controller
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
            $dataI = Colour::query()->where([['name', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
            return view('html.colour.show-colours',compact("dataI"));
     }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_colour()
    {
        //
        $dataI = Colour::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.colour.add-colour',compact("dataI"));
    }
    
    public function edit_colour ($id)
	{
    // echo "<pre>";  print_r( $_SERVER['HTTP_REFERER']); exit;
   
		$id = base64_decode($id);
		$data = Colour::where('id', $id)->first();

		$dataI = Colour::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.colour.edit-colour',compact("data","dataI"));
	}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function store_colour(Request $request)
    {
      // echo "<pre>";  print_r($request->url()); exit;

        $validator = Validator::make($request->all(), [
            "name"=>"required|string|max:100",
            "code"=>"required",
          ], [
            "name.required"=>"Please enter colour name.",
            "code.required"=>"Please enter colour code.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// $is_saved = Department::create_data($request);
		$obj 	= new Colour;
		$obj->name  				= addslashes(stripslashes($request->name));
		$obj->code  				= addslashes(stripslashes($request->code));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();

    
	    ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Colour';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Added Colour '. $request->name .' and code '. $request->code;
		$pageName = 'add-colour';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////
   
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-colours");
		}   //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
	 
    public function update_colour(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "name"=>"required|string|max:100",
            'code'=>"required",
          ], [
            "name.required"=>"Please enter Colour name.",
            "code.required"=>"Please enter colour code.",
          ]);
		  
		  
		////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Colour';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .'Updated Colour '. $request->name .' and code '. $request->code;
		$pageName = 'edit-colour';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$obj = Colour::where('id','=', $request->id)->first();
    
		$obj->name  				  = addslashes(stripslashes($request->name));
		$obj->code  				  = addslashes(stripslashes($request->code));
		$obj->status  				= 1;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-colours");
		}

    }

    public function deleteColour(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Colour::find($FId);
		$obj->status  = '0';
		$obj->save();
		
		
			////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'Colour';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Deleted Colour '. $obj->name .' and code '. $obj->code;
		$pageName = 'show-colours';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////

		
		return $FId;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colour  $colour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colour $colour)
    {
        //
    }
}
