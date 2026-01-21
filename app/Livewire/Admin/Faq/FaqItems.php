<?php

namespace App\Livewire\Admin\Faq;

use App\Models\FaqCategory;
use App\Models\FaqItem;
use App\Services\FaqService;
use Livewire\Component;
use Livewire\WithPagination;

class FaqItems extends Component
{
    use WithPagination;

    public $faq_category_id;
    public $question;
    public $answer;
    public $is_active = true;
    public $display_order = 0;
    public $editingId = null;
    public $filterCategoryId = '';

    protected $rules = [
        'faq_category_id' => 'required|exists:faq_categories,id',
        'question' => 'required|string|max:500',
        'answer' => 'required|string',
        'is_active' => 'boolean',
        'display_order' => 'required|integer|min:0',
    ];

    public function save(FaqService $service)
    {
        $this->validate();

        $item = $this->editingId ? FaqItem::findOrFail($this->editingId) : null;

        $service->upsertFaqItem([
            'faq_category_id' => $this->faq_category_id,
            'question' => $this->question,
            'answer' => $this->answer,
            'is_active' => $this->is_active ?? false,
            'display_order' => $this->display_order,
        ], $item);

        session()->flash('success', $this->editingId ? 'FAQ item updated successfully!' : 'FAQ item created successfully!');
        $this->reset(['faq_category_id', 'question', 'answer', 'is_active', 'display_order', 'editingId']);
        $this->is_active = true;
    }

    public function edit($id)
    {
        $item = FaqItem::findOrFail($id);
        $this->editingId = $id;
        $this->faq_category_id = $item->faq_category_id;
        $this->question = $item->question;
        $this->answer = $item->answer;
        $this->is_active = $item->is_active;
        $this->display_order = $item->display_order;
    }

    public function cancelEdit()
    {
        $this->reset(['faq_category_id', 'question', 'answer', 'is_active', 'display_order', 'editingId']);
        $this->is_active = true;
    }

    public function delete($id, FaqService $service)
    {
        $item = FaqItem::findOrFail($id);
        $service->deleteFaqItem($item);
        session()->flash('success', 'FAQ item deleted successfully!');
    }

    public function render()
    {
        $query = FaqItem::with('category')->ordered();
        
        if ($this->filterCategoryId) {
            $query->where('faq_category_id', $this->filterCategoryId);
        }

        return view('livewire.admin.faq.faq-items', [
            'items' => $query->paginate(20),
            'categories' => FaqCategory::active()->ordered()->get(),
        ])->layout('layouts.app');
    }
}
