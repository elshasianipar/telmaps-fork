<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeforestationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id', 'land_cover_type_id', 'year', 'change_type',
        'area_km2', 'cause', 'source', 'geometry', 'notes',
    ];

    protected $casts = [
        'year' => 'integer',
        'area_km2' => 'decimal:2',
        'geometry' => 'array',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function landCoverType(): BelongsTo
    {
        return $this->belongsTo(LandCoverType::class);
    }

    public function scopeLoss($query)
    {
        return $query->where('change_type', 'loss');
    }

    public function scopeByYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByRegion($query, int $regionId)
    {
        return $query->where('region_id', $regionId);
    }

    public function scopeByChangeType($query, string $type)
    {
        return $query->where('change_type', $type);
    }
}

