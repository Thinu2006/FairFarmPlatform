<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class Buyer extends Authenticatable implements CanResetPassword
{
    use CanResetPasswordTrait;
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
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id', 'BuyerID');
    }
    
    
}
