<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmerSellingPaddyType extends Model
{
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FarmerID',
        'PaddyID', // Changed from PaddyTypeID to PaddyID
        'PriceSelected',
        'Quantity',
    ];

    /**
     * Get the farmer associated with the paddy listing.
     */
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class, 'FarmerID', 'FarmerID');
    }

    /**
     * Get the paddy type associated with the paddy listing.
     */
    public function paddyType(): BelongsTo
    {
        return $this->belongsTo(PaddyType::class, 'PaddyID', 'PaddyID'); // Changed from PaddyTypeID to PaddyID
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'paddy_type_id', 'PaddyID');
    }
}