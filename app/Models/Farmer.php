<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;


class Farmer extends Authenticatable implements CanResetPassword
{
    use CanResetPasswordTrait;
    use HasFactory,Notifiable;

    protected $guard = 'farmer';
    protected $table = 'farmers';
    protected $primaryKey = 'FarmerID';

    protected $fillable = [
        'FullName', 
        'NIC', 
        'ContactNo', 
        'Address', 
        'Email', 
        'password',
    
    ]; 
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'farmer_id', 'FarmerID');
    }
}
