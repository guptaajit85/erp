<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WarehouseCompartment;
use App\Models\Warehouse;
use App\Models\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator,Auth, Session, Hash;
class WareHouseCompartmentController extends Controller
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
		$dataI = WarehouseCompartment::query()->where([['warehousename', 'LIKE', "%{$search}%"],['status', '=', '1']])->paginate(20);
		return view('html.warehousecompartment.show-warehousecompartment',compact("dataI")); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_warehousecompartment()
    {
     
        //
        $dataW = Warehouse::where('status', '=', '1')->get();
        $dataI = Individual::where('status', '=', '1')->where('type', '=', 'employee')->orderByDesc('id')->get();
		
		
        return view('html.warehousecompartment.add-warehousecompartment',compact("dataW","dataI"));
    }

    

     public function edit_warehousecompartment($id)
     {
      
         $id = base64_decode($id);
         $data  = WarehouseCompartment::where('id', $id)->first();
		 $dataI = Individual::where('status', '=', '1')->where('type', '=', 'employee')->orderByDesc('id')->get();
         $dataW = Warehouse::where('status', '=', '1')->get();
		 
		// echo "<pre>"; print_r($dataW); exit;
         return view('html.warehousecompartment.edit-warehousecompartment',compact("data","dataW","dataI"));
     }
    
    public function store_warehousecompartment(Request $request)
    {
      // echo "<pre>"; print_r($request->all()); exit; 

        $validator = Validator::make($request->all(), [
            "warehouseCompartmentname"=>"required|string|max:100",
            "warehouseid"=>"required",
          ], [
            "warehouseCompartmentname.required"=>"Please enter ware house  name.",
            "warehouseid.required"=>"Please enter ware house  id",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
	 
		$obj 	= new WarehouseCompartment;
		$obj->warehousename  			= addslashes(stripslashes($request->warehouseCompartmentname));
		$obj->warehouseid  				= $request->warehouseid;
		$obj->ind_emp_id  				= $request->ind_emp_id;

		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 					  	= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'WarehouseCompartment';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Added Warehouse Compartment '. $request->warehousename ;
		$pageName = 'add-warehouseCompartment';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////
   

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-warehousecompartment");
		}   //
    }

    
    public function update_warehouseCompartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "warehouseCompartmentname"=>"required|string|max:100",
            "warehouseid"=>"required",
          ], [
            "warehouseCompartmentname.required"=>"Please enter ware house  name.",
            "warehouseid.required"=>"Please enter ware house  id",
          ]);

               ////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'WarehouseCompartment';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Updated Warehouse Compartment '. $request->warehousename ;
		$pageName = 'edit-warehouseCompartment';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////
   
          if ($validator->fails())
          {
              $error = $validator->errors()->first();
              Session::put('message', $validator->messages()->first());
              Session::put("messageClass","errorClass");
              return redirect()->back()->withInput();
          }
      $obj = WarehouseCompartment::where('id','=', $request->id)->first();

          $obj->warehousename  				= addslashes(stripslashes($request->warehouseCompartmentname));
          $obj->warehouseid  				= $request->warehouseid;
		      $obj->ind_emp_id  				= $request->ind_emp_id;
          $obj->status  					= 1;
          $obj->created  					= date("Y-m-d H:i:s");
          $obj->modified  					= date("Y-m-d H:i:s");
          $is_saved 						= $obj->save();
          if($is_saved)
          {
              Session::put('message', 'Updated successfully.');
              Session::put("messageClass","successClass");
              return redirect("/show-warehousecompartment");
          }  
    }
    public function deletewarehouseCompartment(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= WarehouseCompartment::find($FId);
		$obj->status  = '0';
		$obj->save();

    	////////////////////////// Notification Start Added/////////////////////////////
		$userId = Auth::id();
		$modeName = 'WarehouseCompartment';
		$urlPage = $_SERVER['HTTP_REFERER'];
		$mesg = CommonController::getUserName($userId) .' Deleted Warehouse Compartment '. $obj->warehousename;
		$pageName = 'show-warehousecompartment';
		CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
		////////////////////////// Notification End Added/////////////////////////////


		return $FId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WarehouseCompartment  $WarehouseCompartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(WarehouseCompartment $wareHouseCompartment)
    {
        //
    }
}
