<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Validator, Session,Auth, Hash;
use App\Http\Controllers\CommonController;

class BrandController extends Controller
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
		$dataP = Brand::query()
		->where([['brand_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
		->orderByDesc('id')
		->paginate(20);
		return view('html.brand.show-brands',compact("dataP"));
    }

    
    public function create_brand()
    {
        return view('html.brand.add-brand');

    }

    
    public function store_brand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "brand_name"=>"required|max:100",

          ], [
            "brand_name.required"=>"Please enter name.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

	/*	$is_saved = brand::create_data($request);*/

		$obj = new Brand;
		$obj->brand_name  					= $request->brand_name;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Brand';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Added Brand '. $request->brand_name ;
        $pageName = 'add-brand';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-brands");
		}
    }

    
    public function show(Brand $brand)
    {
        //
    }

   
    public function edit_brand($id)
    {
        {
            $id = base64_decode($id);
            $data = Brand::where('id', $id)->first();

            $dataP = Brand::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.brand.edit-brand',compact("data","dataP"));
        }
    }

    
    public function update_brand(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(), [
            "brand_name"=>"required|max:100",
          ], [
            "brand_name.required"=>"Please enter name.",

          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		// echo "<pre>"; print_r($request); exit;
		// $is_saved = Person::create_data($request);

		$obj = Brand::find($request->id);
		$obj->brand_name  					= $request->brand_name;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Brand';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Updated Brand '. $request->brand_name ;
        $pageName = 'edit-brand';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-brands");
		}

    }
    public function deleteBrand(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Brand::find($FId);
		$obj->status  = '0';
		$obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Brand';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Deleted Brand '. $obj->brand_name ;
        $pageName = 'show-brands';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		return $FId;
    }

    
    public function destroy(Brand $brand)
    {
        //
    }
}
