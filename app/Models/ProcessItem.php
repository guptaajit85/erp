<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessItem extends Model
{
    use HasFactory; 
    protected $table   = 'process_items';
	public $timestamps = false;


	public function WarehouseItem(){
		return $this->hasOne(WarehouseItem::class, 'process_type_id', 'id');
	}
	
    
}
