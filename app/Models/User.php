<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table   = 'users';
	public $timestamps = false;
   
     
    protected $fillable = [
        'name',
        'email',
        'individual_id',  
        'password', 
        'created_at', 
        'updated_at', 
    ];	 
     
    protected $hidden = [
        'password',
        'remember_token',
    ]; 
	 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


	public function userWebPages()
    {
        return $this->hasMany(UserWebPage::class, 'user_id', 'id');
    }

	
	
	public function Individual()
    {
        return $this->hasOne(Individual::class, 'id', 'individual_id');
    }
	
	
	
	
}