<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingOrderItem extends Model
{
    use HasFactory; 
	protected $table   = 'packaging_order_items';
	public $timestamps = false;	
}
