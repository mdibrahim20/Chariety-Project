<?php

namespace App\Livewire\Admin\SiteSettings\Navbar;

use App\Models\NavbarItem;
use App\Services\NavbarService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public NavbarItem $item;
    
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

    public function mount(NavbarItem $item)
    {
        $this->item = $item;
        $this->label = $item->label;
        $this->route = $item->route;
        $this->parent_id = $item->parent_id;
        $this->is_active = $item->is_active;
        $this->opens_in_new_tab = $item->opens_in_new_tab;
    }

    protected function rules()
    {
        return [
            'label' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'parent_id' => [
                'nullable',
                'exists:navbar_items,id',
                function ($attribute, $value, $fail) {
                    if ($value == $this->item->id) {
                        $fail('A menu item cannot be its own parent.');
                    }
                    
                    // Check if parent is a descendant
                    if ($value && $this->item->descendants->contains('id', $value)) {
                        $fail('Cannot set a descendant as the parent.');
                    }
                },
            ],
            'is_active' => 'boolean',
            'opens_in_new_tab' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->navbarService->update($this->item, [
            'label' => $this->label,
            'route' => $this->route,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'opens_in_new_tab' => $this->opens_in_new_tab,
        ]);

        session()->flash('success', 'Menu item updated successfully.');

        return redirect()->route('admin.site-settings.navbar.index');
    }

    public function render()
    {
        $parentOptions = $this->navbarService->getParentOptions($this->item->id);

        return view('livewire.admin.site-settings.navbar.edit', [
            'parentOptions' => $parentOptions,
        ]);
    }
}
