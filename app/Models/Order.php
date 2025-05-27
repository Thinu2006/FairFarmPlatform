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
        'cancelled_by',
        'cancelled_at',
        'delivered_at',  
        'completed_at' 
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime'
    ];
 
    // Query Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeDeliveryStarted($query)
    {
        return $query->where('status', 'delivery_started');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFarmerCancelled($query)
    {
        return $query->where('status', 'farmer_cancelled');
    }

    public function scopeBuyerCancelled($query)
    {
        return $query->where('status', 'buyer_cancelled');
    }

    public function scopeCancelled($query)
    {
        return $query->whereIn('status', ['farmer_cancelled', 'buyer_cancelled']);
    }

    // Relationships
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

    // Status check methods
    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isDeliveryStarted()
    {
        return $this->status === 'delivery_started';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    
    public function isFarmerCancelled()
    {
        return $this->status === 'farmer_cancelled';
    }

    public function isBuyerCancelled()
    {
        return $this->status === 'buyer_cancelled';
    }
    
    public function markAsDelivered()
    {
        return $this->update(['status' => 'delivered']);
    }

    public function markAsDeliveryStarted()
    {
        return $this->update(['status' => 'delivery_started']);
    }
    
    public function markAsProcessing()
    {
        return $this->update(['status' => 'processing']);
    }

    public function markAsCompleted()
    {
        return $this->update(['status' => 'completed']);
    }

    public function markAsFarmerCancelled()
    {
        return $this->update([
            'status' => 'farmer_cancelled',
            'cancelled_by' => 'farmer',
            'cancelled_at' => now()
        ]);
    }

    public function markAsBuyerCancelled()
    {
        return $this->update([
            'status' => 'buyer_cancelled',
            'cancelled_by' => 'buyer',
            'cancelled_at' => now()
        ]);
    }
}