<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouseCompartment extends Model
{
    use HasFactory;
    protected $table   = 'ware_house_compartments';
	public $timestamps = false;
	
	public function Warehouse(){
		return $this->hasOne(Warehouse::class, 'id', 'warehouseid');
	}
	
}
