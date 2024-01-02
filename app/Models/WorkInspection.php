<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkInspection extends Model
{ 
	use HasFactory; 
	protected $table  = 'work_inspections';	
	public $timestamps = false;	
	 
	
    public function WorkOrder()
	{
		return $this->belongsTo(WorkOrder::class, 'work_order_id', 'work_order_id');
	}
	
	public function GatePass()
    {
        return $this->hasOne(GatePass::class, 'inspection_id', 'id');
    }
	 
	
}
