<?php

use App\Models\About;
use App\Models\FaqItem;
use App\Models\TeamMember;
use App\Models\User;

beforeEach(function () {
    // Bersihkan konten seeded agar tiap test menulis datanya sendiri.
    About::query()->delete();
    TeamMember::query()->delete();
    FaqItem::query()->delete();
});

it('redirects guests away from admin CMS pages', function () {
    $this->get('/admin/about')->assertRedirect('/login');
});

it('forbids non-admin users from CMS pages', function () {
    $viewer = User::factory()->create(['role' => 'viewer']);

    $this->actingAs($viewer)->get('/admin/about')->assertForbidden();
});

it('renders the About manager for admins and shows the current content', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    About::create(['is_active' => true, 'hero_title' => 'Hero unik test']);

    $this->actingAs($admin)
        ->get('/admin/about')
        ->assertOk()
        ->assertSee('Tentang')
        ->assertSee('Hero unik test');
});

it('renders the Team manager and lists members', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    TeamMember::create(['name' => 'Budi Santoso', 'role' => 'Analis', 'sort_order' => 0]);

    $this->actingAs($admin)
        ->get('/admin/teams')
        ->assertOk()
        ->assertSee('Budi Santoso');
});

it('renders the FAQ manager and lists items', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    FaqItem::create(['question' => 'Apa itu TELF test?', 'answer' => 'Jawaban.', 'sort_order' => 0]);

    $this->actingAs($admin)
        ->get('/admin/faq')
        ->assertOk()
        ->assertSee('Apa itu TELF test?');
});

it('shows seeded team members on the public teams page', function () {
    TeamMember::create(['name' => 'Siti Aminah', 'role' => 'Peneliti', 'sort_order' => 0]);

    $this->get('/teams')->assertOk()->assertSee('Siti Aminah');
});

it('shows seeded FAQ items on the public faq page', function () {
    FaqItem::create(['question' => 'Pertanyaan publik?', 'answer' => 'Jawaban publik.', 'sort_order' => 0]);

    $this->get('/faq')->assertOk()->assertSee('Pertanyaan publik?');
});

it('shows about content on the public about page', function () {
    About::create(['is_active' => true, 'hero_title' => 'Judul hero publik']);

    $this->get('/about')->assertOk()->assertSee('Judul hero publik');
});
