<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table   = 'modules';
	public $timestamps = false;

    public function UserModuleAssignment()
    {
        return $this->hasmany(UserModuleAssignment::class,'page_name','page_name');
    }

}





