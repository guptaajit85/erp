<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator,Auth, Session, Hash;


class BankController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
}
    public function index(Request $request)
    {
            $search = $request->search;

            $dataP = Bank::query()->where([['bank_name', 'LIKE', "%{$search}%"],['status', '=', '1']])->orderByDesc('id')->paginate(12);
			// echo "<pre>"; print_r($dataP); exit;


           return view('html.bank.show-banks',compact("dataP"));
    }

    public function create_bank()
    {
        return view('html.bank.add-bank');
    }


    public function store_bank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bank_name"=>"required|max:100",

          ], [
            "bank_name.required"=>"Please enter name.",

          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}

	/*	$is_saved = bank::create_data($request);*/

		$obj = new Bank;
		$obj->bank_name  					= $request->bank_name;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Bank';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Added Bank '. $request->bank_name ;
        $pageName = 'add-bank';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-banks");
		}

    }


    public function show(bank $bank)
    {
        //
    }


    public function edit_bank($id)
    {
        {
            $id = base64_decode($id);
            $data = Bank::where('id', $id)->first();

            $dataP = Bank::where('status', '!=', '0')->orderByDesc('id')->get();
            return view('html.bank.edit-bank',compact("data","dataP"));

        }
    }


    public function update_bank(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bank_name"=>"required|max:100",
          ], [
            "bank_name.required"=>"Please enter name.",

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

		$obj = Bank::find($request->id);
		$obj->bank_name  					= $request->bank_name;

		// $obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();

        ////////////////////////// Notification Start Added/////////////////////////////
        $userId = Auth::id();
        $modeName = 'Bank';
        $urlPage = $_SERVER['HTTP_REFERER'];
        $mesg = CommonController::getUserName($userId) .' Updated Bank '. $request->bank_name ;
        $pageName = 'edit-bank';
        CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
        ////////

		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-banks");
		}

    }
    public function deleteBank(Request $request)
    {
		$FId 	= $request->FId;
		$obj 	= Bank::find($FId);
		$obj->status  = '0';
		$obj->save();

       ////////////////////////// Notification Start Added/////////////////////////////
       $userId = Auth::id();
       $modeName = 'Bank';
       $urlPage = $_SERVER['HTTP_REFERER'];
       $mesg = CommonController::getUserName($userId) .' Deleted Bank '. $obj->bank_name ;
       $pageName = 'show-banks';
       CommonController::store_notification($userId,$modeName,$urlPage,$mesg,$pageName);
       ////////

		return $FId;
    }


    public function destroy(bank $bank)
    {
        //
    }

}
