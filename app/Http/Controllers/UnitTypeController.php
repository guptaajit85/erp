<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use Illuminate\Http\Request;

use Validator, Session, Hash;
class UnitTypeController extends Controller
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
        $search = $request->search;
            $dataP = UnitType::query()
            ->where([['unit_type_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orderByDesc('unit_type_id')
            ->paginate(20);
           return view('html.unittype.show-unittypes',compact("dataP"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_unittype()
    {
        return view('html.unittype.add-unittype');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_unittype(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "unit_type_name"=>"required|string|max:100",

          ], [
            "unit_type_name.required"=>"Please enter name.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}


		$obj = new UnitType;
		$obj->unit_type_name  					= $request->unit_type_name;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-unittypes");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function show(UnitType $qualityType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function edit_unittype($unit_type_id)
    {
        {
            $unit_type_id = base64_decode($unit_type_id);
            $data = UnitType::where('unit_type_id', $unit_type_id)->first();

            $dataP = UnitType::where('status', '!=', '0')->orderByDesc('unit_type_id')->get();
            return view('html.unittype.edit-unittype',compact("data","dataP"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function update_unittype(Request $request, UnitType $qualityType)
    {
        $validator = Validator::make($request->all(), [
            "unit_type_name"=>"required|string|max:100",
          ], [
            "unit_type_name.required"=>"Please enter name.",

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

		$obj = UnitType::find($request->unit_type_id);
		$obj->unit_type_name  					= $request->unit_type_name;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-unittypes");
		}

    }
    public function deleteUnitType(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= UnitType::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitType $qualityType)
    {
        //
    }
}

