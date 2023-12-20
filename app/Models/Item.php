<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	use HasFactory; 
	protected $table   = 'items';
	protected $primaryKey = 'item_id';
	public $timestamps = false;
	
	
	public function ItemType()
    {
        return $this->hasOne(ItemType::class,'item_type_id','item_type_id');
    }
	public function UnitType()
    {
        return $this->hasOne(UnitType::class,'unit_type_id','unit_type_id');
    }
	
	public function collection()
    {
        return Item::all();
    }
	
	
}
