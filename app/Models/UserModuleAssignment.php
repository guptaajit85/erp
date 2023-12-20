<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModuleAssignment extends Model
{
    use HasFactory;
    protected $table   = 'user_module_assignment';
	public $timestamps = false;

    public  function userdetail()
    {
       return $this->hasOne(User::class, 'id','user_id');
    }
    public  function pagedetail()
    {
       return $this->hasOne(Module::class, 'page_name','page_name');
    }
    // public  function modeldetail()
    // {
    //    return $this->belongsTo(Model::class, 'page_id','id');
    // }
	
	 
}
