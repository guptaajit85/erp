<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
	protected $table   = 'purchases';
	public $timestamps = false;
	 
	 
	public function PurchaseItem(){
		return $this->hasMany(PurchaseItem::class, 'purchase_id', 'id');
	}
	
	
}
