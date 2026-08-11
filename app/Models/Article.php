<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id', 'title', 'title_en', 'slug', 'excerpt', 'excerpt_en',
        'content', 'content_en', 'featured_image', 'link',
        'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at?->isPast();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Dipublikasikan',
            'archived' => 'Diarsipkan',
            default => $this->status,
        };
    }

    /**
     * Telemetry-style status code shown in the CMS list (mono "readout").
     */
    public function getStatusCodeAttribute(): string
    {
        return match ($this->status) {
            'published' => 'LIVE',
            'draft' => 'DRAFT',
            'archived' => 'ARSIP',
            default => strtoupper($this->status),
        };
    }

    /**
     * LED color for the status indicator. Green = live (canopy), amber = draft,
     * red = archived — mirroring the fire-monitoring palette.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'published' => '#2F7A3C',
            'draft' => '#E8A93A',
            'archived' => '#C84A26',
            default => '#9AA3A0',
        };
    }

    /**
     * Localized title: English when available and requested, else Indonesian.
     */
    public function titleFor(?string $locale): string
    {
        return $this->localized('title', $locale);
    }

    public function excerptFor(?string $locale): ?string
    {
        return $this->localized('excerpt', $locale);
    }

    public function contentFor(?string $locale): ?string
    {
        return $this->localized('content', $locale);
    }

    protected function localized(string $base, ?string $locale): ?string
    {
        if ($locale === 'en') {
            $en = $this->getAttribute($base.'_en');
            if (filled($en)) {
                return $en;
            }
        }

        return $this->getAttribute($base);
    }
}
