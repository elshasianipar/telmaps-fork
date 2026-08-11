<?php

use App\Models\About;
use App\Models\Article;
use App\Models\FaqItem;
use App\Models\TeamMember;
use App\Models\User;

beforeEach(function () {
    // Bersihkan konten publik agar tiap test menulis datanya sendiri.
    About::query()->delete();
    TeamMember::query()->delete();
    FaqItem::query()->delete();
    Article::query()->delete();
});

it('shows the empty state on the public about page when no content is published', function () {
    $this->get('/about')->assertOk()->assertSee('Belum ada data.');
});

it('shows real about content instead of the empty state when a record exists', function () {
    About::create([
        'is_active' => true,
        'hero_title' => 'Memantau hutan Sumatera',
        'mission' => 'Memberdayakan keputusan berbasis data.',
    ]);

    $this->get('/about')
        ->assertOk()
        ->assertSee('Memantau hutan Sumatera')
        ->assertDontSee('Belum ada data.');
});

it('shows the empty state on the public faq page when no items exist', function () {
    $this->get('/faq')->assertOk()->assertSee('Belum ada data.');
});

it('shows faq items instead of the empty state when seeded', function () {
    FaqItem::create(['question' => 'Apa itu TELF?', 'answer' => 'Platform pemantauan.', 'sort_order' => 0]);

    $this->get('/faq')
        ->assertOk()
        ->assertSee('Apa itu TELF?')
        ->assertDontSee('Belum ada data.');
});

it('shows the empty state on the public teams page when no members exist', function () {
    $this->get('/teams')->assertOk()->assertSee('Belum ada data.');
});

it('shows team members instead of the empty state when seeded', function () {
    TeamMember::create(['name' => 'Rina Kartika', 'role' => 'Analis Geospasial', 'sort_order' => 0]);

    $this->get('/teams')
        ->assertOk()
        ->assertSee('Rina Kartika')
        ->assertDontSee('Belum ada data.');
});

it('shows the empty state on the public articles page when none are published', function () {
    $this->get('/articles')->assertOk()->assertSee('Belum ada data.');
});

it('shows the english empty state on the articles page when lang=en', function () {
    $this->get('/articles?lang=en')->assertOk()->assertSee('No data yet.');
});

it('shows published articles instead of the empty state when seeded', function () {
    $author = User::factory()->create();

    Article::factory()->create([
        'author_id' => $author->id,
        'title' => 'Laporan kebakaran Agustus',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);

    $this->get('/articles')
        ->assertOk()
        ->assertSee('Laporan kebakaran Agustus')
        ->assertDontSee('Belum ada data.');
});

it('does not list draft articles on the public articles page', function () {
    $author = User::factory()->create();

    Article::factory()->create([
        'author_id' => $author->id,
        'title' => 'Draf rahasia',
        'status' => 'draft',
        'published_at' => now()->subDay(),
    ]);

    $this->get('/articles')
        ->assertOk()
        ->assertSee('Belum ada data.')
        ->assertDontSee('Draf rahasia');
});
