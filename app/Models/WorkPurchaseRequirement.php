<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPurchaseRequirement extends Model
{
    use HasFactory;
	protected $table   = 'work_purchase_requirements';
	public $timestamps = false;
} 
