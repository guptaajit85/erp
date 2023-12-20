<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\ServiceProvider;
 
use Illuminate\Http\Request;
use App\Models\AllPage; 
use Illuminate\Support\Facades\DB;
use Auth;
use Validator, Session, Hash;

class AllPageController extends Controller
{
     
	public function __construct()
    {
        $this->middleware('auth');
	}
	
    public function index(Request $request)
    {  
		$dataI = AllPage::where('status', '=', '1')->orderByDesc('id')->paginate(200); 		 
		return view('html.allpages.show-allpages',compact("dataI"));
    }
     
    public function create()
    {
		// $dataP = Person::where('status', '!=', '0')->orderByDesc('id')->get();
		return view('html.allpages.add-allpage');
    } 
	
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "page_title"=>"required", 
			"page_name"=>"required|page_name|unique:all_pages,page_name|max:255",
          ], [
            "page_title.required"=>"Please enter page title.", 
			"page_name.required"=>"Please enter page name.",            
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		
	 
		
		$obj = new AllPage;	 
		$obj->page_title  		= $request->page_title;		 
		$obj->page_name  		= $request->page_name;		 
		$obj->status  			= 1;		 
		$is_saved 				= $obj->save();		
		
		if($is_saved)
		{
			Session::put('message', 'Added successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-allpages");
		}	
    }

   
    public function show($id)
    {
        //
    }

     
    public function edit($id)
    {
        $id = base64_decode($id);
		$data  = AllPage::where('id', $id)->first(); 
		return view('html.allpages.edit-allpage',compact("data"));
    }
 
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "page_title"=>"required",       
			"page_name"=>"required",            
          ], [
            "page_title.required"=>"Please enter page title.", 
			"page_name.required"=>"Please enter page name.",            
          ]);

		if ($validator->fails())
		{
			$error = $validator->errors()->first();
			Session::put('message', $validator->messages()->first());
			Session::put("messageClass","errorClass");
			return redirect()->back()->withInput();
		}
		
		$obj = AllPage::find($request->id);		 
		$obj->page_title  				= $request->page_title;		 
		$obj->page_name  				= $request->page_name;		 
		$obj->status  					= 1;
		$is_saved 						= $obj->save();
		
		if($is_saved)
		{
			Session::put('message', 'Updated successfully.');
			Session::put("messageClass","successClass");
			return redirect("/show-allpages");
		}
    }

    public function deleteAllPage(Request $request)
    {
		// echo "<pre>"; print_r($request->all()); exit;
		$FId 	= $request->FId;
		$obj 	= AllPage::find($FId);
		$obj->status  = '0';
		$obj->save();
		return $FId;
    }

 
}
