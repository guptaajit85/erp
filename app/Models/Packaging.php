<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;
    protected $primaryKey = 'packaging_id';
    protected $table   = 'packaging';
	public $timestamps = false;
}
