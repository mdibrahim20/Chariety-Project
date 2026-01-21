<?php

namespace App\Livewire\Admin\SiteSettings\Navbar;

use App\Models\NavbarItem;
use App\Services\NavbarService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Create extends Component
{
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

    protected function rules()
    {
        return [
            'label' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:navbar_items,id',
            'is_active' => 'boolean',
            'opens_in_new_tab' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->navbarService->create([
            'label' => $this->label,
            'route' => $this->route,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'opens_in_new_tab' => $this->opens_in_new_tab,
        ]);

        session()->flash('success', 'Menu item created successfully.');

        return redirect()->route('admin.site-settings.navbar.index');
    }

    public function render()
    {
        $parentOptions = $this->navbarService->getParentOptions();

        return view('livewire.admin.site-settings.navbar.create', [
            'parentOptions' => $parentOptions,
        ]);
    }
}
