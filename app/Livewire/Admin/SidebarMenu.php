<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SidebarMenu extends Component
{
    public array $menu = [];
    public ?string $activeMenu = null;

    public function mount()
    {
        $this->buildMenu();
        $this->setActiveMenu();
    }

    protected function buildMenu()
    {
        $user = auth()->user();

        $this->menu = [
            [
                'name' => 'Dashboard',
                'route' => 'admin.dashboard',
                'icon' => 'dashboard',
                'permission' => null,
            ],
            [
                'name' => 'Users',
                'icon' => 'users',
                'permission' => 'manage-users',
                'children' => [
                    [
                        'name' => 'All Users',
                        'route' => 'admin.users.index',
                        'permission' => 'view-users',
                    ],
                    [
                        'name' => 'Create User',
                        'route' => 'admin.users.create',
                        'permission' => 'create-users',
                    ],
                    [
                        'name' => 'Roles & Permissions',
                        'route' => 'admin.roles.index',
                        'permission' => 'manage-roles',
                    ],
                ],
            ],
            [
                'name' => 'Settings',
                'icon' => 'settings',
                'permission' => null,
                'children' => [
                    [
                        'name' => 'General Settings',
                        'route' => 'admin.settings.general',
                        'permission' => null,
                    ],
                    [
                        'name' => 'Email Settings',
                        'route' => 'admin.settings.email',
                        'permission' => null,
                    ],
                    [
                        'name' => 'Security Settings',
                        'route' => 'admin.settings.security',
                        'permission' => null,
                    ],
                    [
                        'name' => 'Appearance',
                        'route' => 'admin.settings.appearance',
                        'permission' => null,
                    ],
                ],
            ],
            [
                'name' => 'Homepage',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Hero Section',
                        'route' => 'admin.homepage.hero-section',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'About Us Section',
                        'route' => 'admin.homepage.about-us',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Testimonials',
                        'route' => 'admin.homepage.testimonials',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Newsletter Section',
                        'route' => 'admin.homepage.newsletter-section',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'Subscribers',
                'route' => 'admin.subscribers',
                'icon' => 'users',
                'permission' => 'manage-settings',
            ],
            [
                'name' => 'Events',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Events Hero',
                        'route' => 'admin.events.hero',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Manage Events',
                        'route' => 'admin.events.index',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Donations',
                        'route' => 'admin.donations',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'Blog',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Blog Hero',
                        'route' => 'admin.blog.hero',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Blog Contents',
                        'route' => 'admin.blog.index',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'Our Services',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Services Hero',
                        'route' => 'admin.services.hero',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Services Box',
                        'route' => 'admin.services.index',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'Volunteers',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Volunteers Hero',
                        'route' => 'admin.volunteers.hero',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Volunteers List',
                        'route' => 'admin.volunteers.index',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'FAQ',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'FAQ Hero',
                        'route' => 'admin.faq.hero',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'FAQ Settings',
                        'route' => 'admin.faq.settings',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'FAQ Categories',
                        'route' => 'admin.faq.categories',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'FAQ Items',
                        'route' => 'admin.faq.items',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'Contact',
                'icon' => 'dashboard',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Contact Hero',
                        'route' => 'admin.contact.hero',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Contact Page Settings',
                        'route' => 'admin.contact.settings',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Contact Messages',
                        'route' => 'admin.contact.messages',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
            [
                'name' => 'Site Settings',
                'icon' => 'settings',
                'permission' => 'manage-settings',
                'children' => [
                    [
                        'name' => 'Topbar',
                        'route' => 'admin.site-settings.topbar',
                        'permission' => 'manage-settings',
                    ],
                    [
                        'name' => 'Navbar Menu',
                        'route' => 'admin.site-settings.navbar.index',
                        'permission' => 'manage-settings',
                    ],
                ],
            ],
        ];

        // Filter menu items based on permissions
        $this->menu = $this->filterMenuByPermissions($this->menu, $user);
    }

    protected function filterMenuByPermissions(array $menu, $user): array
    {
        return collect($menu)->filter(function ($item) use ($user) {
            // If item requires permission and user doesn't have it, exclude it
            if (isset($item['permission']) && $item['permission'] && !$user->hasPermission($item['permission'])) {
                return false;
            }

            // Filter children if they exist
            if (isset($item['children'])) {
                $item['children'] = $this->filterMenuByPermissions($item['children'], $user);
                
                // If no children remain after filtering, exclude parent
                if (empty($item['children'])) {
                    return false;
                }
            }

            return true;
        })->values()->toArray();
    }

    protected function setActiveMenu()
    {
        $currentRoute = request()->route()->getName();
        $this->activeMenu = $currentRoute;
    }

    public function isActive(string $route): bool
    {
        return str_starts_with($this->activeMenu, $route);
    }

    public function isParentActive(array $children): bool
    {
        foreach ($children as $child) {
            if (isset($child['route']) && $this->isActive($child['route'])) {
                return true;
            }
        }
        return false;
    }

    public function render()
    {
        return view('livewire.admin.sidebar-menu');
    }
}
