<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable  
{
    use HasFactory, Notifiable;
    protected $guard = 'admin';
    protected $table = 'admin';
    protected $primaryKey = 'AdminID';
    
    protected $fillable = [
        'Username', 
        'Email',
        'Password',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
