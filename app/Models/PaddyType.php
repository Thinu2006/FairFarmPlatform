<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaddyType extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'PaddyID';

    protected $fillable = [
        'PaddyName', 
        'MaxPricePerKg', 
        'Image'
    ];


    //One Paddytype has many selling paddy types 
    public function paddyListings ()
    {
        return $this->hasMany(FarmerPaddyListings ::class, 'PaddyID');
    }
    
    //One paddy type has many orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'PaddyID');
    }
}
