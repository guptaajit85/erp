<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedFabric extends Model
{
    use HasFactory;
    protected $table   = 'finished_fabrics';
	public $timestamps = false;
}
