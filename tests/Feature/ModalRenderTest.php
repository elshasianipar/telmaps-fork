<?php

use App\Livewire\Admin\TeamManager;
use App\Models\TeamMember;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    TeamMember::query()->delete();
});

it('renders the team modal always in the DOM with wire:show + wire:cloak (no @if, so buttons stay hydrated)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    TeamMember::create(['name' => 'Budi', 'role' => 'Analis', 'sort_order' => 0]);

    $html = $this->actingAs($admin)->get('/admin/teams')->assertOk()->content();

    // Modal is always present (wire:show, not @if) and cloaked against flash.
    expect($html)->toContain('wire:show="showModal"', 'wire:cloak');
    expect($html)->not->toContain('@if ($showModal)');

    // Close buttons use the documented $set action (not raw property assignment).
    expect($html)->toContain("\$set('showModal', false)");
    expect($html)->not->toContain('wire:click="showModal = false"');

    // Delete confirm is also always-present + cloaked.
    expect($html)->toContain('wire:show="confirmingDelete"');
});

it('opens and closes the team modal via Livewire round-trip', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Livewire::actingAs($admin)
        ->test(TeamManager::class)
        ->assertSet('showModal', false)
        ->call('create')
        ->assertSet('showModal', true)
        ->set('showModal', false)
        ->assertSet('showModal', false);
});
