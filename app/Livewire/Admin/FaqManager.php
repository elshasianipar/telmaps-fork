<?php

namespace App\Livewire\Admin;

use App\Models\FaqItem;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('FAQ · Admin TELF')]
class FaqManager extends Component
{
    public ?int $editingId = null;

    public bool $showModal = false;

    public bool $confirmingDelete = false;

    public ?int $deleteId = null;

    public ?string $question = '';

    public ?string $answer = '';

    public ?string $category = '';

    public int $sort_order = 0;

    public bool $is_active = true;

    public ?string $successMessage = null;

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $item = FaqItem::findOrFail($id);
        $this->editingId = $id;
        $this->question = $item->question;
        $this->answer = (string) $item->answer;
        $this->category = (string) $item->category;
        $this->sort_order = (int) $item->sort_order;
        $this->is_active = (bool) $item->is_active;
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'question' => ['required', 'string', 'max:200'],
            'answer' => ['required', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ]);

        if ($this->editingId) {
            FaqItem::find($this->editingId)->update($validated);
            $this->successMessage = 'Item FAQ diperbarui.';
        } else {
            FaqItem::create($validated);
            $this->successMessage = 'Item FAQ ditambahkan.';
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            FaqItem::find($this->deleteId)?->delete();
            $this->successMessage = 'Item FAQ dihapus.';
        }
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function toggleActive(int $id): void
    {
        $item = FaqItem::find($id);
        if ($item) {
            $item->update(['is_active' => ! $item->is_active]);
        }
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->question = '';
        $this->answer = '';
        $this->category = '';
        $this->sort_order = 0;
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        $items = FaqItem::ordered()->get();

        return view('livewire.admin.faq-manager', ['items' => $items])
            ->layout('layouts.admin', ['header' => 'FAQ']);
    }
}
