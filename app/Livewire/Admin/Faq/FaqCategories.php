<?php

namespace App\Livewire\Admin\Faq;

use App\Models\FaqCategory;
use App\Services\FaqService;
use Livewire\Component;
use Livewire\WithPagination;

class FaqCategories extends Component
{
    use WithPagination;

    public $name;
    public $is_active = true;
    public $display_order = 0;
    public $editingId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'is_active' => 'boolean',
        'display_order' => 'required|integer|min:0',
    ];

    public function save(FaqService $service)
    {
        $this->validate();

        $category = $this->editingId ? FaqCategory::findOrFail($this->editingId) : null;

        $service->upsertCategory([
            'name' => $this->name,
            'is_active' => $this->is_active ?? false,
            'display_order' => $this->display_order,
        ], $category);

        session()->flash('success', $this->editingId ? 'Category updated successfully!' : 'Category created successfully!');
        $this->reset(['name', 'is_active', 'display_order', 'editingId']);
        $this->is_active = true;
    }

    public function edit($id)
    {
        $category = FaqCategory::findOrFail($id);
        $this->editingId = $id;
        $this->name = $category->name;
        $this->is_active = $category->is_active;
        $this->display_order = $category->display_order;
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'is_active', 'display_order', 'editingId']);
        $this->is_active = true;
    }

    public function delete($id, FaqService $service)
    {
        $category = FaqCategory::findOrFail($id);
        $service->deleteCategory($category);
        session()->flash('success', 'Category and all its FAQ items deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.faq.faq-categories', [
            'categories' => FaqCategory::ordered()->paginate(20),
        ])->layout('layouts.app');
    }
}
