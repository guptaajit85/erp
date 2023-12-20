<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;
    protected $table   = 'item_type';
	public $timestamps = false;
    protected $primaryKey = 'item_type_id';
	
	
	public function WarehouseItem(){
		return $this->hasOne(WarehouseItem::class, 'item_type_id', 'item_type_id');
	}
	
	public function WarehouseItemStock(){
		return $this->hasMany(WarehouseItemStock::class, 'item_type_id', 'item_type_id')->where('is_allotted_stock', '=', 'No');
	}
}
