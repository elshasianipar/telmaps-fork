<?php

namespace App\Models;

use Database\Factories\FaqItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Item FAQ — ditampilkan sebagai akordion di halaman /faq.
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property string|null $category
 * @property string|null $question_en
 * @property string|null $answer_en
 * @property int $sort_order
 * @property bool $is_active
 */
class FaqItem extends Model
{
    /** @use HasFactory<FaqItemFactory> */
    use HasFactory;

    protected $fillable = [
        'question', 'answer', 'category', 'sort_order', 'is_active',
        'question_en', 'answer_en',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function questionFor(?string $locale): string
    {
        return $this->localized('question', $locale);
    }

    public function answerFor(?string $locale): string
    {
        return $this->localized('answer', $locale);
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
