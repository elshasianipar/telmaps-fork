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
 * @property string|null $story_eyebrow
 * @property string|null $story_title
 * @property string|null $story_body
 * @property string|null $story_image
 * @property string|null $mission
 * @property string|null $vision
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
}
