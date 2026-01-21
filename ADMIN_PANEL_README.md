# Admin Panel - Setup & Installation Guide

## Overview

A production-ready, fully responsive Laravel Admin Panel built with:
- **Laravel** (latest stable)
- **Livewire 4** (no Vue, React, or Inertia)
- **Tailwind CSS** for styling
- **Alpine.js** for minimal interactivity
- **Two-Factor Authentication** (TOTP)
- **Role-Based Access Control**
- **Comprehensive Settings Management**

---

## Features

### ✅ Authentication & Security
- Admin login with rate limiting
- Forgot password & password reset
- Email verification
- **Two-Factor Authentication (2FA/TOTP)**
  - QR code setup
  - Recovery codes
  - Authenticator app support (Google Authenticator, Authy)
- Role-based access control
- Permission management
- Login activity tracking
- Security middleware enforcement

### ✅ Admin Panel Layout
- Responsive sidebar navigation (collapsible on mobile)
- Top navbar with user profile dropdown
- 2FA status badge
- Breadcrumbs support
- Flash message system
- Loading states

### ✅ Dashboard
- User statistics cards
- Failed login monitoring
- 2FA compliance tracking
- Recent login activity
- Security alerts

### ✅ User Management
- List all users with search & filters
- Create/Edit/Delete users
- Assign roles & permissions
- Toggle admin status
- Enable/disable 2FA per user
- View last login activity

### ✅ Roles & Permissions
- Create/Edit/Delete roles
- Assign permissions to roles
- Protected admin role
- User count per role

### ✅ Settings Module
#### General Settings
- App name configuration
- Timezone selection
- Locale/Language

#### Email Settings
- SMTP configuration UI
- Test email functionality
- Database-driven mail config
- Runtime config synchronization

#### Security Settings
- Password complexity rules
- Force 2FA for admins
- Session timeout configuration
- Login activity logs

#### Appearance Settings
- Primary color customization
- Sidebar collapse preference
- Live preview

---

## Installation

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install

# Install Livewire (already added via composer.json)
# Install Google2FA for TOTP
composer require pragmarx/google2fa-qrcode
```

### 2. Environment Configuration

Update your `.env` file:

```env
APP_NAME="Your App Name"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail Configuration (can be set via admin panel later)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed the database (creates roles, permissions, settings, and default admin)
php artisan db:seed
```

**Default Admin Credentials:**
- Email: `admin@example.com`
- Password: `password`
- ⚠️ **Change immediately after first login!**

### 4. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 5. Configure Alpine.js

Add Alpine.js to your `resources/js/app.js`:

```javascript
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();
```

Install Alpine collapse plugin:
```bash
npm install @alpinejs/collapse
```

### 6. Start the Application

```bash
# Start Laravel development server
php artisan serve

# In another terminal, run Vite
npm run dev
```

Visit: `http://localhost:8000/admin/login`

---

## File Structure

```
app/
├── Http/
│   └── Middleware/
│       ├── IsAdmin.php           # Admin access middleware
│       ├── RequireTwoFactor.php  # 2FA enforcement
│       ├── RoleMiddleware.php    # Role verification
│       └── PermissionMiddleware.php
├── Livewire/
│   └── Admin/
│       ├── Auth/
│       │   ├── Login.php
│       │   ├── ForgotPassword.php
│       │   ├── ResetPassword.php
│       │   ├── TwoFactorSetup.php
│       │   └── TwoFactorVerify.php
│       ├── Dashboard.php
│       ├── SidebarMenu.php
│       ├── Users/
│       │   ├── Index.php
│       │   ├── Create.php
│       │   └── Edit.php
│       ├── Roles/
│       │   ├── Index.php
│       │   ├── Create.php
│       │   └── Edit.php
│       └── Settings/
│           ├── General.php
│           ├── Email.php
│           ├── Security.php
│           └── Appearance.php
├── Models/
│   ├── User.php
│   ├── Role.php
│   ├── Permission.php
│   ├── Setting.php
│   ├── TwoFactorAuthentication.php
│   └── LoginActivity.php
├── Services/
│   ├── SettingsService.php
│   ├── TwoFactorService.php
│   ├── MailConfigService.php
│   ├── RoleService.php
│   └── UserService.php
└── Traits/
    ├── HasRoles.php
    └── HasTwoFactorAuth.php

database/
├── migrations/
│   ├── 2026_01_20_000001_create_roles_table.php
│   ├── 2026_01_20_000002_create_permissions_table.php
│   ├── 2026_01_20_000003_create_role_user_table.php
│   ├── 2026_01_20_000004_create_permission_role_table.php
│   ├── 2026_01_20_000005_create_settings_table.php
│   ├── 2026_01_20_000006_create_two_factor_authentications_table.php
│   ├── 2026_01_20_000007_create_login_activities_table.php
│   └── 2026_01_20_000008_add_admin_fields_to_users_table.php
└── seeders/
    ├── RolesAndPermissionsSeeder.php
    ├── AdminUserSeeder.php
    └── SettingsSeeder.php

resources/
└── views/
    ├── components/
    │   ├── admin-button.blade.php
    │   ├── admin-card.blade.php
    │   ├── admin-icon.blade.php
    │   └── admin-input.blade.php
    ├── layouts/
    │   ├── admin.blade.php
    │   ├── admin-guest.blade.php
    │   └── partials/
    │       ├── admin-navbar.blade.php
    │       ├── admin-sidebar.blade.php
    │       └── flash-messages.blade.php
    └── livewire/
        └── admin/
            ├── auth/
            ├── dashboard.blade.php
            ├── sidebar-menu.blade.php
            ├── users/
            ├── roles/
            └── settings/
```

---

## Usage Guide

### Accessing the Admin Panel

Navigate to: `http://yourapp.com/admin/login`

### Setting Up Two-Factor Authentication

1. Login to admin panel
2. Go to **Security Settings** or click **Enable 2FA** in navbar dropdown
3. Scan QR code with authenticator app (Google Authenticator, Authy, etc.)
4. Enter verification code
5. Save recovery codes in a secure location

### Managing Users

1. Navigate to **Users → All Users**
2. Click **Add New User**
3. Fill in user details
4. Assign roles
5. Toggle admin status and 2FA requirement
6. Click **Create User**

### Managing Roles & Permissions

1. Navigate to **Users → Roles & Permissions**
2. Click **Add New Role**
3. Define role name and description
4. Select permissions
5. Click **Create Role**

### Configuring Email Settings

1. Navigate to **Settings → Email Settings**
2. Enter SMTP credentials
3. Click **Save Settings**
4. Test configuration by sending a test email

### Viewing Login Activity

1. Navigate to **Settings → Security Settings**
2. Scroll to **Recent Login Activity**
3. View all login attempts with IP addresses and timestamps

---

## Security Best Practices

### Recommended Settings

1. **Force 2FA for Admins**: Enable in Security Settings
2. **Password Requirements**:
   - Minimum 8 characters
   - Require uppercase
   - Require numbers
   - Optional: Special characters
3. **Session Timeout**: Set to 120 minutes or less

### Post-Installation Checklist

- [ ] Change default admin password
- [ ] Enable 2FA for admin account
- [ ] Configure SMTP settings
- [ ] Test email functionality
- [ ] Review and adjust password requirements
- [ ] Set up proper database backups
- [ ] Enable SSL/HTTPS in production
- [ ] Review login activity regularly

---

## Middleware Usage

### Protecting Routes

```php
// Require admin access
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});

// Require specific role
Route::middleware(['auth', 'role:moderator'])->group(function () {
    // Moderator routes
});

// Require specific permission
Route::middleware(['auth', 'permission:manage-users'])->group(function () {
    // Routes for users with manage-users permission
});

// Require 2FA verification
Route::middleware(['auth', 'two-factor'])->group(function () {
    // Routes requiring 2FA
});
```

---

## Customization

### Adding New Menu Items

Edit `app/Livewire/Admin/SidebarMenu.php`:

```php
protected function buildMenu()
{
    $this->menu = [
        // ... existing items
        [
            'name' => 'New Section',
            'icon' => 'custom-icon',
            'permission' => 'view-section',
            'children' => [
                [
                    'name' => 'Sub Item',
                    'route' => 'admin.section.index',
                    'permission' => 'view-section',
                ],
            ],
        ],
    ];
}
```

### Adding New Settings

```php
use App\Services\SettingsService;

$settings = app(SettingsService::class);
$settings->set('custom_setting', 'value', 'string', 'custom_group');
```

### Creating Custom Permissions

```php
use App\Models\Permission;

Permission::create([
    'name' => 'Custom Permission',
    'slug' => 'custom-permission',
    'description' => 'Description here',
]);
```

---

## Troubleshooting

### Issue: 2FA QR Code Not Showing

**Solution**: Install required packages:
```bash
composer require pragmarx/google2fa-qrcode
```

### Issue: Mail Settings Not Loading

**Solution**: Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
```

### Issue: Permissions Not Working

**Solution**: Check that user has assigned role:
```php
$user->assignRole('admin');
```

### Issue: Sidebar Not Collapsing on Mobile

**Solution**: Ensure Alpine.js is installed and loaded:
```bash
npm install alpinejs @alpinejs/collapse
```

---

## Production Deployment

### Pre-Deployment Checklist

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Run `npm run build`
7. Set up proper database backups
8. Configure SSL certificate
9. Set up queue workers for emails
10. Configure proper logging

### Queue Configuration (Optional but Recommended)

For better performance with emails:

```bash
# .env
QUEUE_CONNECTION=database

# Run migration
php artisan queue:table
php artisan migrate

# Start queue worker
php artisan queue:work
```

---

## Support & Documentation

### Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Google2FA Documentation](https://github.com/antonioribeiro/google2fa)

---

## License

This admin panel is built on Laravel, which is open-sourced software licensed under the MIT license.

---

**Built with ❤️ using Laravel, Livewire, and Tailwind CSS**
