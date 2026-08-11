<?php

use App\Models\Article;
use App\Models\User;

beforeEach(function () {
    Article::query()->delete();
});

it('shows the latest-articles section on the landing page with the empty state when no articles are published', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Kabar dari lapangan')
        ->assertSee('Belum ada data.')
        ->assertDontSee('View all services')
        ->assertDontSee('Gardening Consultation');
});

it('shows up to three published articles in the landing latest-articles section', function () {
    $author = User::factory()->create();

    foreach (range(1, 4) as $i) {
        Article::factory()->create([
            'author_id' => $author->id,
            'title' => "Laporan lapangan #{$i}",
            'status' => 'published',
            'published_at' => now()->subDays($i),
        ]);
    }

    $html = $this->get('/')->assertOk()->content();

    // 3 terbaru tampil (yang paling lama, #4, tidak ikut).
    expect($html)->toContain('Laporan lapangan #1', 'Laporan lapangan #2', 'Laporan lapangan #3');
    expect($html)->not->toContain('Laporan lapangan #4');
});

it('links the section CTA to the public articles index', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee(route('articles.index'));
});

it('does not show draft articles in the landing latest-articles section', function () {
    $author = User::factory()->create();

    Article::factory()->create([
        'author_id' => $author->id,
        'title' => 'Draf yang belum tayang',
        'status' => 'draft',
        'published_at' => now()->subDay(),
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Belum ada data.')
        ->assertDontSee('Draf yang belum tayang');
});
