<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityType extends Model
{
    use HasFactory;
    protected $table   = 'quality_types';
	public $timestamps = false;
}
