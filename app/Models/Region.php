<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'code', 'name', 'type', 'capital',
        'area_km2', 'population', 'latitude', 'longitude', 'boundary',
    ];

    protected $casts = [
        'area_km2' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'boundary' => 'array',
    ];

    public function parent(): ?\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Region::class, 'parent_id');
    }

    public function deforestationRecords(): HasMany
    {
        return $this->hasMany(DeforestationRecord::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return "[{$this->code}] {$this->name}";
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'province' => 'Provinsi',
            'regency' => 'Kabupaten',
            'district' => 'Kecamatan',
            default => $this->type,
        };
    }
}

