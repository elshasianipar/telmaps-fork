<?php

use App\Models\About;
use App\Models\FaqItem;
use App\Models\TeamMember;

beforeEach(function () {
    // Bersihkan konten publik agar tiap test menulis datanya sendiri.
    About::query()->delete();
    FaqItem::query()->delete();
    TeamMember::query()->delete();
});

it('renders english about content when requested and available', function () {
    About::create([
        'is_active' => true,
        'hero_title' => 'Memantau hutan Sumatera',
        'hero_title_en' => 'Monitoring Sumatra forests',
        'mission' => 'Memberdayakan keputusan berbasis data.',
        'mission_en' => 'Empowering data-driven decisions.',
    ]);

    $this->get('/about?lang=en')
        ->assertOk()
        ->assertSee('Monitoring Sumatra forests')
        ->assertSee('Empowering data-driven decisions.')
        ->assertDontSee('Memantau hutan Sumatera');
});

it('falls back to indonesian about content when english is empty', function () {
    About::create([
        'is_active' => true,
        'hero_title' => 'Memantau hutan Sumatera',
        'mission' => 'Memberdayakan keputusan berbasis data.',
    ]);

    $this->get('/about?lang=en')
        ->assertOk()
        ->assertSee('Memantau hutan Sumatera')
        ->assertSee('Memberdayakan keputusan berbasis data.');
});

it('keeps showing indonesian about content on the default locale', function () {
    About::create([
        'is_active' => true,
        'hero_title' => 'Memantau hutan Sumatera',
        'mission' => 'Memberdayakan keputusan berbasis data.',
        'mission_en' => 'Empowering data-driven decisions.',
    ]);

    $this->get('/about')
        ->assertOk()
        ->assertSee('Memantau hutan Sumatera')
        ->assertDontSee('Empowering data-driven decisions.');
});

it('renders english faq items when requested and available', function () {
    FaqItem::create([
        'question' => 'Apa itu TELF?',
        'question_en' => 'What is TELF?',
        'answer' => 'Platform pemantauan hutan.',
        'answer_en' => 'A forest monitoring platform.',
        'sort_order' => 0,
    ]);

    $this->get('/faq?lang=en')
        ->assertOk()
        ->assertSee('What is TELF?')
        ->assertSee('A forest monitoring platform.');
});

it('falls back to indonesian faq items when english is empty', function () {
    FaqItem::create([
        'question' => 'Apa itu TELF?',
        'answer' => 'Platform pemantauan hutan.',
        'sort_order' => 0,
    ]);

    $this->get('/faq?lang=en')
        ->assertOk()
        ->assertSee('Apa itu TELF?')
        ->assertSee('Platform pemantauan hutan.');
});

it('renders english team member role and bio when requested and available', function () {
    TeamMember::create([
        'name' => 'Rina Kartika',
        'role' => 'Analis Geospasial',
        'role_en' => 'Geospatial Analyst',
        'bio' => 'Memetakan titik panas deforestasi.',
        'bio_en' => 'Maps deforestation hotspots.',
        'sort_order' => 0,
    ]);

    $this->get('/teams?lang=en')
        ->assertOk()
        ->assertSee('Rina Kartika')
        ->assertSee('Geospatial Analyst')
        ->assertSee('Maps deforestation hotspots.');
});

it('falls back to indonesian team content when english is empty', function () {
    TeamMember::create([
        'name' => 'Rina Kartika',
        'role' => 'Analis Geospasial',
        'bio' => 'Memetakan titik panas deforestasi.',
        'sort_order' => 0,
    ]);

    $this->get('/teams?lang=en')
        ->assertOk()
        ->assertSee('Analis Geospasial')
        ->assertSee('Memetakan titik panas deforestasi.');
});

it('renders the landing page in english when requested', function () {
    $this->get('/?lang=en')
        ->assertOk()
        ->assertSee('Forest-loss monitoring')
        ->assertSee('Provinces monitored')
        ->assertDontSee('Pemantauan kehilangan hutan');
});

it('renders the landing page in indonesian by default', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Pemantauan kehilangan hutan')
        ->assertSee('Provinsi dipantau')
        ->assertDontSee('Forest-loss monitoring');
});

it('renders the platform map page in english when requested', function () {
    $this->get('/map?lang=en')
        ->assertOk()
        ->assertSee('TELF · Fire Monitoring')
        ->assertSee('Forest Fire · Sumatra');
});

it('renders the platform map page in indonesian by default', function () {
    $this->get('/map')
        ->assertOk()
        ->assertSee('TELF · Pemantauan Kebakaran')
        ->assertSee('Kebakaran Hutan · Sumatera');
});
