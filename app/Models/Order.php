<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'farmer_id',
        'paddy_type_id',
        'price_per_kg',
        'quantity',
        'total_amount',
        'status',
        'delivered_at',  // Add this
        'completed_at' // pending, accepted, delivery_started, delivered, completed, cancelled
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime'
    ];
 

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'BuyerID');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id', 'FarmerID');
    }

    public function paddyType()
    {
        return $this->belongsTo(PaddyType::class, 'paddy_type_id', 'PaddyID');
    }
    public function farmerSellingPaddyType()
    {
        return $this->belongsTo(FarmerSellingPaddyType::class, 'paddy_type_id', 'PaddyID');
    }
}