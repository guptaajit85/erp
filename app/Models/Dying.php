<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dying extends Model
{
    use HasFactory;
    protected $table   = 'dyings';
	public $timestamps = false;
}
