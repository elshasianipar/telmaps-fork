<?php

use App\Livewire\Admin\TeamManager;
use App\Models\TeamMember;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    TeamMember::query()->delete();
});

it('opens the create modal when create is called', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Livewire::actingAs($admin)
        ->test(TeamManager::class)
        ->call('create')
        ->assertSet('showModal', true)
        ->assertSeeHtml('Tambah anggota');
});

it('opens edit modal for an existing member', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $m = TeamMember::create(['name' => 'Budi', 'role' => 'Analis', 'sort_order' => 0]);

    Livewire::actingAs($admin)
        ->test(TeamManager::class)
        ->call('edit', $m->id)
        ->assertSet('showModal', true)
        ->assertSet('editingId', $m->id)
        ->assertSet('name', 'Budi');
});

it('opens and completes delete confirmation', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $m = TeamMember::create(['name' => 'Budi', 'role' => 'Analis', 'sort_order' => 0]);

    Livewire::actingAs($admin)
        ->test(TeamManager::class)
        ->call('confirmDelete', $m->id)
        ->assertSet('confirmingDelete', true)
        ->call('delete')
        ->assertSet('confirmingDelete', false);

    expect(TeamMember::find($m->id))->toBeNull();
});
