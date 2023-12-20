<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
	protected $table   = 'departments';
	public $timestamps = false;

    function create_data($request)
    {
        $obj = Department::where('id','=', $request->id)->first();
		if(empty($obj))
		{
            $obj = new Department;
        }

        $obj->name  				= addslashes(stripslashes($request->name));
		$obj->status  				= $request->status;
		$obj->created  				= date("Y-m-d H:i:s");
		$obj->modified  			= date("Y-m-d H:i:s");
		$is_saved 					= $obj->save();
        return $is_saved;
    }
}
