<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Company;
use Illuminate\Http\Request;
use Validator, Session, Hash;

class CompanyController extends Controller
{
     
	 
	 public function __construct()
    {
         $this->middleware('auth');
    }
 
    public function index(Request $request)
    {


        $dataP = Company::query()
        ->where('status', '!=', '0')
        ->with('statedetail')
        ->orderByDesc('id')
        ->paginate(2);

        return view('html.company.show-companies', compact('dataP'));

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_company()
    {
        $dataI = State::where('status', '=', '1')->orderByDesc('id')->get();
        return view('html.company.add-company',compact("dataI"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_company(Request $request)
    {
       // echo "<pre>"; print_r($request->all()); exit;

       $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
            "email"=>"required",
            "address_1"=>"required|string|max:555",
            "address_2"=>"required|string|max:555",
            "state_id"=>"required|max:100",
            "city_name"=>"required|max:100",
            "phone"=>"required|string|min:10|max:10",
            "zip_code"=>"required|string|min:6|max:6",

      ], [
        "name.required"=>"Please enter  name",
        "email.required"=>"Please Email",
        "address_1.required"=>"Please enter address 1.",
        "address_2.required"=>"Please enter address 2.",
        "state_id.required"=>"Please enter state id.",
        "city_name.required"=>"Please enter city name.",
        "phone.required"=>"Please enter exactly 10 number.",
        "zip_code.required"=>"Please enter zip code.",
      ]);

        if ($validator->fails())
        {
            $error = $validator->errors()->first();
            Session::put('message', $validator->messages()->first());
            Session::put("messageClass","errorClass");
            return redirect()->back()->withInput();
        }
        // $is_saved = Department::create_data($request);
        $obj 	= new Company;
		$obj->name  					= $request->name;
        $obj->email  					= $request->email;
		$obj->address_1  					= $request->address_1;
        $obj->address_2  					= $request->address_2;
        $obj->state_id  					= $request->state_id;
        $obj->city_name  					= $request->city_name;
        $obj->phone  					= $request->phone;
        $obj->zip_code  					= $request->zip_code;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-companies");
		}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(Company $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit_company($id)
    {
        $id = base64_decode($id);
        $data = Company::where('id', $id)->first();

        $dataI = State::where('status', '!=', '0')->orderByDesc('id')->get();
        return view('html.company.edit-company',compact("data","dataI"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update_company(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required|max:100",
            "email"=>"required",
            "address_1"=>"required|max:1000",
            "address_2"=>"required|max:1000",
            "state_id" =>"required|max:100",
            "city_name"=>"required|max:100",
            "phone"=>"required|string|min:10|max:10",
            "zip_code"=>"required|string|min:6|max:6",

      ], [
        "name.required"=>"Please enter  name",
        "email.required"=>"Please Email",
        "address_1.required"=>"Please enter address 1.",
        "address_2.required"=>"Please enter address 2.",
        "state_id.required"=>"Please enter state id.",
        "city_name.required"=>"Please enter city name.",
        "phone.required"=>"Please enter exactly 10 number.",
        "zip_code.required"=>"Please enter zip code.",
      ]);
          if ($validator->fails())
          {
              $error = $validator->errors()->first();
              Session::put('message', $validator->messages()->first());
              Session::put("messageClass","errorClass");
              return redirect()->back()->withInput();
          }
      $obj = Company::where('id','=', $request->id)->first();

      $obj->name  					    = $request->name;
      $obj->email  					    = $request->email;
      $obj->address_1  					= $request->address_1;
      $obj->address_2  					= $request->address_2;
      $obj->state_id  					= $request->state_id;
      $obj->city_name  					= $request->city_name;
      $obj->phone  					    = $request->phone;
      $obj->zip_code  					= $request->zip_code;
		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-companies");
		}
    }
    public function deleteCompany(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Company::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $bankAccount)
    {
        //
    }
}
