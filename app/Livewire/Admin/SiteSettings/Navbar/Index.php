<?php

namespace App\Livewire\Admin\SiteSettings\Navbar;

use App\Models\NavbarItem;
use App\Services\NavbarService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showInactive = false;
    
    // Modal states
    public $showModal = false;
    public $editMode = false;
    public $itemId = null;
    
    // Form fields
    public $label = '';
    public $route = '';
    public $parent_id = null;
    public $is_active = true;
    public $opens_in_new_tab = false;

    protected $navbarService;

    public function boot(NavbarService $navbarService)
    {
        $this->navbarService = $navbarService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $item = NavbarItem::findOrFail($id);
        
        $this->itemId = $item->id;
        $this->label = $item->label;
        $this->route = $item->route;
        $this->parent_id = $item->parent_id;
        $this->is_active = $item->is_active;
        $this->opens_in_new_tab = $item->opens_in_new_tab;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    protected function resetForm()
    {
        $this->itemId = null;
        $this->label = '';
        $this->route = '';
        $this->parent_id = null;
        $this->is_active = true;
        $this->opens_in_new_tab = false;
    }

    protected function rules()
    {
        $rules = [
            'label' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:navbar_items,id',
            'is_active' => 'boolean',
            'opens_in_new_tab' => 'boolean',
        ];

        if ($this->editMode && $this->itemId) {
            $rules['parent_id'] = [
                'nullable',
                'exists:navbar_items,id',
                function ($attribute, $value, $fail) {
                    if ($value == $this->itemId) {
                        $fail('A menu item cannot be its own parent.');
                    }
                    
                    $item = NavbarItem::find($this->itemId);
                    if ($value && $item && $item->descendants->contains('id', $value)) {
                        $fail('Cannot set a descendant as the parent.');
                    }
                },
            ];
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $item = NavbarItem::findOrFail($this->itemId);
                $this->navbarService->update($item, [
                    'label' => $this->label,
                    'route' => $this->route,
                    'parent_id' => $this->parent_id,
                    'is_active' => $this->is_active,
                    'opens_in_new_tab' => $this->opens_in_new_tab,
                ]);
                session()->flash('success', 'Menu item updated successfully.');
            } else {
                $this->navbarService->create([
                    'label' => $this->label,
                    'route' => $this->route,
                    'parent_id' => $this->parent_id,
                    'is_active' => $this->is_active,
                    'opens_in_new_tab' => $this->opens_in_new_tab,
                ]);
                session()->flash('success', 'Menu item created successfully.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $item = NavbarItem::findOrFail($id);
        
        if ($item->hasChildren()) {
            session()->flash('error', 'Cannot delete menu item with children. Delete child items first.');
            return;
        }

        $this->navbarService->delete($item);
        
        session()->flash('success', 'Menu item deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $item = NavbarItem::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
        
        session()->flash('success', 'Menu item status updated.');
    }

    public function render()
    {
        $query = NavbarItem::with(['parent', 'children'])
            ->when($this->search, function ($q) {
                $q->where('label', 'like', '%' . $this->search . '%')
                  ->orWhere('route', 'like', '%' . $this->search . '%');
            })
            ->when(!$this->showInactive, function ($q) {
                $q->where('is_active', true);
            })
            ->orderBy('order');

        $items = $query->paginate(20);
        $parentOptions = $this->navbarService->getParentOptions($this->itemId);

        return view('livewire.admin.site-settings.navbar.index', [
            'items' => $items,
            'parentOptions' => $parentOptions,
        ]);
    }
}
