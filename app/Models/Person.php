<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
     
	use HasFactory;
	protected $table   = 'people';
	public $timestamps = false;
	
	
	
	function create_data($request)
    {
        $obj = Person::where('id','=', $request->id)->first();
		if(empty($obj))
		{
            $obj = new Person;
        }
 
		$obj->consignee_id  			= $request->consignee_id;
		$obj->name  					= $request->name;
		$obj->email  					= $request->email;
		$obj->mobile  					= $request->mobile;		
		$obj->dob  						= $request->dob;
		$obj->doa  						= $request->doa;
		$obj->image  					= $request->image;
		$obj->fb_link  					= $request->fb_link;
		$obj->call_no  					= $request->call_no;		
		$obj->whatsapp  				= $request->whatsapp;
		$obj->is_bilty  				= $request->is_bilty;
		$obj->is_pod  					= $request->is_pod;
		$obj->is_statement  			= $request->is_statement;
		$obj->is_booking  				= $request->is_booking;
		$obj->is_money_receipt  		= $request->is_money_receipt;
		$obj->is_payment_reminder  		= $request->is_payment_reminder;
		$obj->is_stock_reminder  		= $request->is_stock_reminder;
		$obj->created_by  				= 1;
		$obj->modified_by  				= 1;		 
		$obj->status  					= 1;
		$obj->created  					= date("Y-m-d H:i:s");
		$obj->modified  				= date("Y-m-d H:i:s");
		$is_saved 						= $obj->save();
        return $is_saved;
		 
		  
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
    }
	
}
