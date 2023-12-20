<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use Illuminate\Http\Request;

use Validator, Session, Hash;
class PackagingController extends Controller
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
            $dataP = Packaging::query()
            ->where([['packaging_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orderByDesc('packaging_id')
            ->paginate(2);
           return view('html.packaging.show-packagings',compact("dataP"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_packaging()
    {
        return view('html.packaging.add-packaging');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_packaging(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "packaging_name"=>"required",
            "packaging_des"=>"required",

          ], [
            "packaging_name.required"=>"Please enter name.",
            "packaging_des.required"=>"Please enter Description.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}


		$obj = new Packaging;
		$obj->packaging_name  					= $request->packaging_name;
        $obj->packaging_des  					= $request->packaging_des;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-packagings");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Packaging  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function show(Packaging $qualityType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Packaging  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function edit_packaging($packaging_id)
    {
        {
            $packaging_id = base64_decode($packaging_id);
            $data = Packaging::where('packaging_id', $packaging_id)->first();

            $dataP = Packaging::where('status', '!=', '0')->orderByDesc('packaging_id')->get();
            return view('html.packaging.edit-packaging',compact("data","dataP"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Packaging  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function update_packaging(Request $request, Packaging $qualityType)
    {
        $validator = Validator::make($request->all(), [
            "packaging_name"=>"required|string|max:100",
            "packaging_des"=>"required|string|max:100",

          ], [
            "packaging_name.required"=>"Please enter name.",
            "packaging_des.required"=>"Please enter Description.",

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

		$obj = Packaging::find($request->packaging_id);
		$obj->packaging_name  					= $request->packaging_name;
        $obj->packaging_des  					= $request->packaging_des;
		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-packagings");
		}

    }
    public function deletePackaging(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Packaging::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Packaging  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packaging $qualityType)
    {
        //
    }
}
