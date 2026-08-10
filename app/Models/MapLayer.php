<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapLayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'config', 'style', 'is_active', 'is_default',
        'min_year', 'max_year',
    ];

    protected $casts = [
        'config' => 'array',
        'style' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'min_year' => 'integer',
        'max_year' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true)->first() ?? $query->active()->first();
    }
}

