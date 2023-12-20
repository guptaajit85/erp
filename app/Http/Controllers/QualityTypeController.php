<?php

namespace App\Http\Controllers;

use App\Models\QualityType;
use Illuminate\Http\Request;
use Validator, Session, Hash;
class QualityTypeController extends Controller
{


	public function __construct()
    {
         $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->search;
            $dataP = QualityType::query()
            ->where([['qualitytype_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
            ->orderByDesc('id')
            ->paginate(20);
           return view('html.qualitytype.show-qualitytypes',compact("dataP"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_qualitytype()
    {
        return view('html.qualitytype.add-qualitytype');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_qualitytype(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "qualitytype_name"=>"required|string|max:100",

          ], [
            "qualitytype_name.required"=>"Please enter name.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}


		$obj = new QualityType;
		$obj->qualitytype_name  					= $request->qualitytype_name;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-qualitytypes");
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QualityType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function show(QualityType $qualityType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QualityType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function edit_qualitytype($id)
    {
        {
            $id = base64_decode($id);
            $data = QualityType::where('id', $id)->first();

            $dataP = QualityType::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.qualitytype.edit-qualitytype',compact("data","dataP"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QualityType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function update_qualitytype(Request $request, QualityType $qualityType)
    {
        $validator = Validator::make($request->all(), [
            "qualitytype_name"=>"required|string|max:100",
          ], [
            "qualitytype_name.required"=>"Please enter name.",

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

		$obj = QualityType::find($request->id);
		$obj->qualitytype_name  					= $request->qualitytype_name;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-qualitytypes");
		}

    }
    public function deleteQualityType(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= QualityType::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QualityType  $qualityType
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityType $qualityType)
    {
        //
    }
}
