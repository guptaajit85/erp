<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualType extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table   = 'individual_types';
	public $timestamps = false;
}
