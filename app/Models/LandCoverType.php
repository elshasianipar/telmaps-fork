<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandCoverType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'color', 'description', 'is_forest', 'sort_order',
    ];

    protected $casts = [
        'is_forest' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function deforestationRecords(): HasMany
    {
        return $this->hasMany(DeforestationRecord::class);
    }

    public function scopeForest($query)
    {
        return $query->where('is_forest', true);
    }
}

