<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Validator, Session, Hash;

class VehicleController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth');
}
    public function index(Request $request)
    {
        $search = $request->input('search');
            $dataP = Vehicle::query()
            ->where([['lorry_number', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orWhere([['owner_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orWhere([['owner_phone', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->with('vehicledetail')
            ->orderByDesc('id')
            ->paginate(2);
            return view('html.vehicle.show-vehicles',compact("dataP"));
   }

    public function edit_vehicle($id)
    {
        {
            $id = base64_decode($id);
            $data = Vehicle::where('id', $id)->first();

            $dataI = Brand::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.vehicle.edit-vehicle',compact("data","dataI"));
        }
    }


	public function create_vehicle()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		$dataI = Brand::where('status', '=', '1')->orderByDesc('id')->get();
        return view('html.vehicle.add-vehicle',compact("dataI"));

    }



    public function store_vehicle(Request $request)
    {
		$validator = Validator::make($request->all(), [
            "lorry_type"=>"required|string|max:100",
            "lorry_owner"=>"required|string|max:100",
            "vehicle_type"=>"required|string|max:100",
            "body_type"=>"required|string|max:100",
            "lorry_number"=>"required|string|max:100",
            "brand_id"=>"required",
            "gvw"=>"required|regex:/^[0-9]{1,8}$/",
            "chasis_weight"=>"required|regex:/^[0-9]{1,8}$/",
            "lorryowner_id"=>"required",
            "owner_name"=>"required|max:100",
            "owner_address"=>"required|string|max:100",
            "owner_phone"=>"required|regex:/^[0-9]{10}$/",
            "chassis_no"=>"required|string|max:100",
            "modeltype"=>"required|string|max:100",
            "tds_declare"=>"required|string|max:100",
            "npno"=>"required|string|max:100",
            "policy_no"=>"required|string|max:100",
            "policy_date"=>"required|string|max:100",
            "valid_date"=>"required|string|max:100",
            "colour"=>"required|string|max:100",
          ], [
            "lorry_type.required"=>"Please enter lorry type.",
            "lorry_owner.required"=>"Please enter lorry owner.",
            "vehicle_type.required"=>"Please enter vehicle type.",
            "body_type.required"=>"Please enter body type.",
            "lorry_number.required"=>"Please enter lorry number.",
            "brand_id.required"=>"Please enter brand id.",
            "gvw.required"=>"Please enter gvw.",
            "chasis_weight.required"=>"Please enter chasis weight.",
            "lorryowner_id.required"=>"Please enter lorryowner id.",
            "owner_name.required"=>"Please enter owner name.",
            "owner_address.required"=>"Please enter owner address.",
            "owner_phone.required"=>"Please enter owner phone.",
            "chassis_no.required"=>"Please enter chassis no.",
            "modeltype.required"=>"Please enter modeltype.",
            "tds_declare.required"=>"Please enter tds declare.",
            "npno.required"=>"Please enter npno.",
            "policy_no.required"=>"Please enter policy no.",
            "policy_date.required"=>"Please enter policy date.",
            "valid_date.required"=>"Please enter valid date.",
            "colour.required"=>"Please enter colour.",
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

		$obj = new Vehicle;
		$obj->lorry_type  					= $request->lorry_type;
		$obj->lorry_owner  					= $request->lorry_owner;
		$obj->vehicle_type  				= $request->vehicle_type;
		$obj->body_type  					= $request->body_type;
		$obj->lorry_number  				= $request->lorry_number;
		$obj->brand_id  					= $request->brand_id;
		$obj->gvw  							= $request->gvw;
		$obj->chasis_weight  				= $request->chasis_weight;
		$obj->lorryowner_id  				= $request->lorryowner_id;
		$obj->owner_name  					= $request->owner_name;
		$obj->owner_address  				= $request->owner_address;
		$obj->owner_phone  					= $request->owner_phone;
		$obj->pan_number  					= $request->pan_number;
		$obj->engine_no  					= $request->engine_no;
		$obj->chassis_no  					= $request->chassis_no;
		$obj->modeltype  					= $request->modeltype;
		$obj->tds_declare  					= $request->tds_declare;
		$obj->npno  						= $request->npno;
		$obj->policy_no  					= $request->policy_no;
		$obj->policy_date  					= $request->policy_date;
		$obj->valid_date  					= $request->valid_date;
		$obj->colour  						= $request->colour;
		//$obj->created_by  					= $request->created_by;
		//$obj->modified_by  					= $request->modified_by;
		//$obj->status  						= 1;
		$obj->created  						= date("Y-m-d H:i:s");
		$obj->modified  					= date("Y-m-d H:i:s");
		$is_saved 							= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-vehicles");
		}

    }




    public function update_vehicle(Request $request, Vehicle $vehicle)
    {
       $validator = Validator::make($request->all(), [
        "lorry_type"=>"required|string|max:100",
        "lorry_owner"=>"required|string|max:100",
        "vehicle_type"=>"required|string|max:100",
        "body_type"=>"required|string|max:100",
        "lorry_number"=>"required|string|max:100",
        "brand_id"=>"required",
        "gvw"=>"required|regex:/^[0-9]{1,8}$/",
        "chasis_weight"=>"required|regex:/^[0-9]{1,8}$/",
        "lorryowner_id"=>"required",
        "owner_name"=>"required|max:100",
        "owner_address"=>"required|string|max:100",
        "owner_phone"=>"required|regex:/^[0-9]{10}$/",
        "chassis_no"=>"required|string|max:100",
        "modeltype"=>"required|string|max:100",
        "tds_declare"=>"required|string|max:100",
        "npno"=>"required|string|max:100",
        "policy_no"=>"required|string|max:100",
        "policy_date"=>"required|string|max:100",
        "valid_date"=>"required|string|max:100",
        "colour"=>"required|string|max:100",
      ], [
        "lorry_type.required"=>"Please enter lorry type.",
        "lorry_owner.required"=>"Please enter lorry owner.",
        "vehicle_type.required"=>"Please enter vehicle type.",
        "body_type.required"=>"Please enter body type.",
        "lorry_number.required"=>"Please enter lorry number.",
        "brand_id.required"=>"Please enter brand id.",
        "gvw.required"=>"Please enter gvw.",
        "chasis_weight.required"=>"Please enter chasis weight.",
        "lorryowner_id.required"=>"Please enter lorryowner id.",
        "owner_name.required"=>"Please enter owner name.",
        "owner_address.required"=>"Please enter owner address.",
        "owner_phone.required"=>"Please enter owner phone.",
        "chassis_no.required"=>"Please enter chassis no.",
        "modeltype.required"=>"Please enter modeltype.",
        "tds_declare.required"=>"Please enter tds declare.",
        "npno.required"=>"Please enter npno.",
        "policy_no.required"=>"Please enter policy no.",
        "policy_date.required"=>"Please enter policy date.",
        "valid_date.required"=>"Please enter valid date.",
        "colour.required"=>"Please enter colour.",

          ]);
		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}


		$obj = Vehicle::find($request->id);
		$obj->lorry_type  					= $request->lorry_type;
		$obj->lorry_owner  					= $request->lorry_owner;
		$obj->vehicle_type  				= $request->vehicle_type;
		$obj->body_type  					= $request->body_type;
		$obj->lorry_number  				= $request->lorry_number;
		$obj->brand_id  					= $request->brand_id;
		$obj->gvw  							= $request->gvw;
		$obj->chasis_weight  				= $request->chasis_weight;
		$obj->lorryowner_id  				= $request->lorryowner_id;
		$obj->owner_name  					= $request->owner_name;
		$obj->owner_address  				= $request->owner_address;
		$obj->owner_phone  					= $request->owner_phone;
		$obj->pan_number  					= $request->pan_number;
		$obj->engine_no  					= $request->engine_no;
		$obj->chassis_no  					= $request->chassis_no;
		$obj->modeltype  					= $request->modeltype;
		$obj->tds_declare  					= $request->tds_declare;
		$obj->npno  						= $request->npno;
		$obj->policy_no  					= $request->policy_no;
		$obj->policy_date  					= $request->policy_date;
		$obj->valid_date  					= $request->valid_date;
		$obj->colour  						= $request->colour;
		//$obj->created_by  					= $request->created_by;
		//$obj->modified_by  					= $request->modified_by;
		//$obj->status  						= 1;
		$obj->created  						= date("Y-m-d H:i:s");
		$obj->modified  					= date("Y-m-d H:i:s");
		$is_saved 							= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-vehicles");
		}
    }


	public function deleteVehicle(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Vehicle::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



}
?>
