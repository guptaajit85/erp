<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperTube extends Model
{
    use HasFactory;
    protected $table   = 'paper_tubes';
	public $timestamps = false;

}
