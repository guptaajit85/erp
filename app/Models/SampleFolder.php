<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleFolder extends Model
{
    use HasFactory;
    protected $table   = 'sample_folders';
	public $timestamps = false;

   
}
