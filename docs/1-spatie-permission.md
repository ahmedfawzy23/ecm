# Spatie Laravel Permission

هذا الملف يشرح كيفية تثبيت وتكوين واستخدام حزمة `spatie/laravel-permission` في مشروع Laravel لإدارة الأدوار والصلاحيات.

## المتطلبات والمتعلقات

- Laravel 8.x أو أحدث.
- PHP 8.0 أو أحدث.

## خطوات التثبيت

1. تثبيت الحزمة عبر Composer:
```bash
composer require spatie/laravel-permission
```

2. نشر ملف التكوين والمهاجر (Migrations):
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

3. تشغيل المهاجر لإنشاء الجداول المطلوبة في قاعدة البيانات:
```bash
php artisan migrate
```

## شرح التكوين

يجب إضافة Trait المسمى `HasRoles` إلى موديل المستخدم (`User.php`):

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // ... باقي الكود
}
```

## أمثلة استخدام عملية

### 1. إنشاء الصلاحيات والأدوار (عبر Seeder)

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// إنشاء صلاحية
Permission::create(['name' => 'edit articles']);

// إنشاء دور وإسناد صلاحية له
$role = Role::create(['name' => 'writer']);
$role->givePermissionTo('edit articles');
```

### 2. إسناد الأدوار للمستخدمين

```php
$user = User::find(1);

// إضافة دور للمستخدم
$user->assignRole('writer');

// التحقق مما إذا كان المستخدم يمتلك دوراً معيناً
if ($user->hasRole('writer')) {
    // كود خاص بالكاتب
}
```

### 3. التحقق من الصلاحيات

```php
if ($user->can('edit articles')) {
    // يمكن للمستخدم التعديل
}
```

### 4. استخدامها في الـ Blade Templates

```blade
@can('edit articles')
    <button>تعديل المقال</button>
@endcan

@role('super-admin')
    <p>مرحباً بك أيها المدير!</p>
@endrole
```

## ملاحظات هامة

- تقوم الحزمة بعمل Cache للصلاحيات والأدوار لتحسين الأداء. إذا قمت بتغييرها يدوياً في قاعدة البيانات، قد تحتاج لمسح الذاكرة المؤقتة:
```bash
php artisan permission:cache-reset
```
