<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Validator,Auth, Session, Hash;
use App\Http\Controllers\CommonController;

class BankAccountController extends Controller
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
		error_reporting(0);
        $search = $request->input('search');


        $dataP = BankAccount::query()
        ->where([['account_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
        ->orWhere([['account_number', 'LIKE', "%{$search}%"],['status', '=', '1']])
        //->orWhere([['bankdetail->bank_name', 'LIKE', "%{$search}%"],['status', '=', '1']])
        ->orWhere([['ifsc_code', 'LIKE', "%{$search}%"],['status', '=', '1']])
        ->with('bankdetail')
        ->orderByDesc('id')
        ->paginate(2);
		// $dataP = BankAccount::where('status', '=', '1')->with('bankdetail')->get();



		// echo "<pre>"; print_r($dataP); exit;

        return view('html.bankaccount.show-bankaccounts', compact('dataP'));

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_bankaccount()
    {
        $dataI = Bank::where('status', '=', '1')->orderByDesc('id')->get();
        return view('html.bankaccount.add-bankaccount',compact("dataI"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_bankaccount(Request $request)
    {
       // echo "<pre>"; print_r($request->all()); exit;

       $validator = Validator::make($request->all(), [
        "account_number"=>"required|regex:/^[0-9]{8,16}$/",
            "account_name"=>"required|max:100",
            "ifsc_code"=>"required|string|max:10",
            "bank_id"=>"required|regex:/^[0-9]{1,4}$/",
            "bank_branch"=>"required|string|max:50",
            "bank_address"=>"required|max:100",
      ], [
        "account_number.required"=>"Please enter account name",
        "account_name.required"=>"Please enter account name",
        "ifsc_code.required"=>"Please ifsc code",
        "bank_id.required"=>"Please enter bank id",
        "bank_branch.required"=>"Please enter bank branch",
        "bank_address.required"=>"Please enter bank address",
      ]);

        if ($validator->fails())
        {
            $error = $validator->errors()->first();
            Session::put('message', $validator->messages()->first());
            Session::put("messageClass","errorClass");
            return redirect()->back()->withInput();
        }
        // $is_saved = Department::create_data($request);
        $obj 	= new BankAccount;
        $obj->account_number  					= $request->account_number;
		$obj->account_name  					= $request->account_name;
		$obj->ifsc_code  					= $request->ifsc_code;
		$obj->bank_id  						= $request->bank_id;
		$obj->bank_branch  						= $request->bank_branch;
		$obj->bank_address  					= $request->bank_address;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'BankAccount';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Added Bank Account '. $request->account_number ;
        $pageName = 'add-bankaccount';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-bankaccounts");
		}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit_bankaccount($id)
    {
        $id = base64_decode($id);
        $data = BankAccount::where('id', $id)->first();

        $dataI = bank::where('status', '!=', '0')->orderByDesc('id')->get();
        return view('html.bankaccount.edit-bankaccount',compact("data","dataI"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update_bankaccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "account_number"=>"required|regex:/^[0-9]{8,16}$/",
            "account_name"=>"required|max:100",
            "ifsc_code"=>"required|string|max:10",
            "bank_id"=>"required|regex:/^[0-9]{1,4}$/",
            "bank_branch"=>"required|string|max:50",
            "bank_address"=>"required|max:100",
          ], [
            "account_number.required"=>"Please enter account name",
            "account_name.required"=>"Please enter account name",
            "ifsc_code.required"=>"Please ifsc code",
            "bank_id.required"=>"Please enter bank id",
            "bank_branch.required"=>"Please enter bank branch",
            "bank_address.required"=>"Please enter bank address",
          ]);
          if ($validator->fails())
          {
              $error = $validator->errors()->first();
              Session::put('message', $validator->messages()->first());
              Session::put("messageClass","errorClass");
              return redirect()->back()->withInput();
          }
      $obj = BankAccount::where('id','=', $request->id)->first();

        $obj->account_number  					= $request->account_number;
		$obj->account_name  					= $request->account_name;
		$obj->ifsc_code  					= $request->ifsc_code;
		$obj->bank_id  						= $request->bank_id;
		$obj->bank_branch  						= $request->bank_branch;
		$obj->bank_address  					= $request->bank_address;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");

		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'BankAccount';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Updated Bank Account '. $request->account_number ;
        $pageName = 'edit-bankaccount';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-bankaccounts");
		}
    }
    public function deleteBankAccount(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= BankAccount::find($FId);
		$obj->status  = '0';
		$obj->save();
        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'BankAccount';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Deleted Bank Account '. $obj->account_number ;
        $pageName = 'show-bankaccounts';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////
		return $FId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        //
    }
}
