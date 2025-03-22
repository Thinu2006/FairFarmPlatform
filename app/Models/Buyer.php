<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Buyer extends Authenticatable
{
    use HasFactory,Notifiable;
    protected $guard = 'buyer';
    protected $table = 'buyers';
    protected $primaryKey = 'BuyerID';


    protected $fillable = [
        'FullName', 
        'NIC', 
        'ContactNo', 
        'Address', 
        'Email', 
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
