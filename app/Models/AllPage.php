<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllPage extends Model
{ 
	use HasFactory; 
	protected $table   = 'all_pages';
	protected $primaryKey = 'id';
	public $timestamps = false;
	
	
	public function userWebPages()
    {
        return $this->hasMany(UserWebPage::class, 'page_id', 'id');
    }
	
	
	
	
}
