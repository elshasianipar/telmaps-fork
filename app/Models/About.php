<?php

namespace App\Models;

use Database\Factories\AboutFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Konten halaman "Tentang" — disimpan sebagai satu baris (singleton).
 *
 * @property int $id
 * @property string|null $hero_eyebrow
 * @property string|null $hero_title
 * @property string|null $hero_subtitle
 * @property string|null $hero_image
 * @property string|null $hero_eyebrow_en
 * @property string|null $hero_title_en
 * @property string|null $hero_subtitle_en
 * @property string|null $story_eyebrow
 * @property string|null $story_title
 * @property string|null $story_body
 * @property string|null $story_image
 * @property string|null $story_eyebrow_en
 * @property string|null $story_title_en
 * @property string|null $story_body_en
 * @property string|null $mission
 * @property string|null $vision
 * @property string|null $mission_en
 * @property string|null $vision_en
 * @property bool $is_active
 */
class About extends Model
{
    /** @use HasFactory<AboutFactory> */
    use HasFactory;

    protected $fillable = [
        'hero_eyebrow', 'hero_title', 'hero_subtitle', 'hero_image',
        'story_eyebrow', 'story_title', 'story_body', 'story_image',
        'mission', 'vision', 'is_active',
        'hero_eyebrow_en', 'hero_title_en', 'hero_subtitle_en',
        'story_eyebrow_en', 'story_title_en', 'story_body_en',
        'mission_en', 'vision_en',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Ambil baris konten aktif (singleton). Buat default bila belum ada.
     */
    public static function current(): self
    {
        return self::where('is_active', true)->latest('id')->first()
            ?? self::create(['is_active' => true]);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function heroEyebrowFor(?string $locale): ?string
    {
        return $this->localized('hero_eyebrow', $locale);
    }

    public function heroTitleFor(?string $locale): ?string
    {
        return $this->localized('hero_title', $locale);
    }

    public function heroSubtitleFor(?string $locale): ?string
    {
        return $this->localized('hero_subtitle', $locale);
    }

    public function storyEyebrowFor(?string $locale): ?string
    {
        return $this->localized('story_eyebrow', $locale);
    }

    public function storyTitleFor(?string $locale): ?string
    {
        return $this->localized('story_title', $locale);
    }

    public function storyBodyFor(?string $locale): ?string
    {
        return $this->localized('story_body', $locale);
    }

    public function missionFor(?string $locale): ?string
    {
        return $this->localized('mission', $locale);
    }

    public function visionFor(?string $locale): ?string
    {
        return $this->localized('vision', $locale);
    }

    /**
     * English when available and requested, else Indonesian — mirrors the
     * articles pattern so the public site falls back gracefully.
     */
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
