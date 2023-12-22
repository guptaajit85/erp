<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingOrder extends Model
{
	protected $table = 'packaging_orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function packagingOrderItems()
    {
        return $this->hasMany(PackagingOrderItem::class, 'packaging_ord_id', 'id');
    }
	
	public function Individual(){
		return $this->hasOne(Individual::class, 'id', 'customer_id');
	}
	
	
	
	
	 
	
}
