<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoatedFabric extends Model
{
    use HasFactory;
    protected $table   = 'coated_fabrics';
	public $timestamps = false;
}
