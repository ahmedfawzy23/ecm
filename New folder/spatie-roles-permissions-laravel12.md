# 🔐 دليل Spatie Roles & Permissions في Laravel 12
### الدليل الشامل اللي هيفضل معاك دايمًا

> **ملاحظة للمبرمج:** الملف ده هو مرجعك الكامل لكل حاجة خاصة بـ Spatie Roles & Permissions. هتلاقي فيه التثبيت، الإعداد، الأمثلة العملية، والاختبار — كل حاجة خطوة بخطوة. ارجعله في أي وقت محتاج فيه مراجعة سريعة أو تفصيل أكتر.

---

## 📋 فهرس المحتويات

1. [مقدمة: إيه هو Spatie Permissions؟](#مقدمة)
2. [ليه نستخدم Spatie ومش نعمل الحاجة دي بنفسنا؟](#المزايا)
3. [التثبيت والإعداد الأولي](#التثبيت)
4. [بنية النظام والجداول](#البنية)
5. [العمل مع Permissions](#permissions)
6. [العمل مع Roles](#roles)
7. [ربط الـ Users بالـ Roles والـ Permissions](#ربط-المستخدمين)
8. [الـ Middleware والحماية](#middleware)
9. [الـ Blade Directives](#blade)
10. [الـ Policies وتكاملها مع Spatie](#policies)
11. [سيناريوهات واقعية كاملة](#سيناريوهات)
12. [الـ Caching وتحسين الأداء](#caching)
13. [أفضل الممارسات والنصائح](#best-practices)
14. [دليل الاختبار الكامل](#testing)
15. [مشاكل شائعة وحلولها](#troubleshooting)

---

## 1. مقدمة: إيه هو Spatie Permissions؟ {#مقدمة}

### الفكرة الأساسية

تخيل معايا إنك بتبني نظام إدارة كبير — فيه **Admin**، و**Editor**، و**Viewer**، وكل واحد منهم المفروض يعمل حاجات مختلفة. السؤال بيجي: إزاي تتحكم في "مين يعمل إيه؟"

**Spatie Laravel Permission** هي package جاهزة بتحل المشكلة دي بشكل احترافي وكامل. بتديك نظامين:

- **Permissions (الصلاحيات):** الأفعال اللي ممكن يتعملها حاجة في التطبيق — زي `edit posts`، `delete users`، `view reports`.
- **Roles (الأدوار):** مجموعة من الـ Permissions مجمعة تحت اسم واحد — زي `Admin` اللي عنده كل الـ Permissions، أو `Editor` اللي عنده بس صلاحيات التعديل.

### النموذج الكامل

```
User
 ├── له Roles مباشرة: ["admin", "editor"]
 └── له Permissions مباشرة: ["view reports"]

Role: "editor"
 ├── عنده Permissions: ["edit posts", "create posts", "delete posts"]
 └── User اللي عنده الـ Role ده بيورث كل الـ Permissions دي

```

---

## 2. ليه نستخدم Spatie ومش نعمل الحاجة بنفسنا؟ {#المزايا}

### المزايا الرئيسية

| الميزة | التفاصيل |
|--------|----------|
| **جاهز وموثوق** | Package بتتستخدم في ملايين المشاريع حول العالم، متيستة ومحدثة باستمرار |
| **مرونة كاملة** | تقدر تدي User صلاحية مباشرة من غير Role، أو تديه Role كاملة |
| **Multi-guard Support** | لو عندك أكتر من Authentication Guard (زي `web` و`api`) |
| **Blade Directives** | `@role`، `@permission`، `@can` — تحكم في الـ Views بسهولة |
| **Middleware جاهز** | حماية الـ Routes بسطر واحد |
| **Caching ذكي** | بيعمل Cache للصلاحيات عشان ما يحملش قاعدة البيانات في كل Request |
| **توافق مع Policies** | بيشتغل جنب Laravel Gates and Policies عادي |

### مقارنة: بنيده بنفسنا vs Spatie

| الجانب | Build يدوي | Spatie |
|--------|-----------|--------|
| وقت التطوير | أسابيع | ساعات |
| الـ Testing | محتاج تكتبه من الأول | موجود ومتيست |
| الـ Updates | مسؤوليتك | Package بتتحدث |
| الـ Edge Cases | هتكتشفهم بعدين | متعالجين |
| Multi-guard | معقدة تعمله | out-of-the-box |

---

## 3. التثبيت والإعداد الأولي {#التثبيت}

### الخطوة الأولى: تثبيت الـ Package

```bash
composer require spatie/laravel-permission
```

### الخطوة التانية: نشر الـ Config والـ Migration

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

الأمر ده هيعمل حاجتين:
- ملف `config/permission.php` — إعدادات الـ Package
- Migration لإنشاء الجداول اللازمة

### الخطوة التالتة: تشغيل الـ Migration

```bash
php artisan migrate
```

### الخطوة الرابعة: إضافة الـ Trait للـ User Model

افتح ملف `app/Models/User.php` وعدّله:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles; // ← إضافة مهمة

class User extends Authenticatable
{
    use HasRoles; // ← إضافة مهمة

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // باقي الـ Model زي ما هو
}
```

### الخطوة الخامسة: الـ Middleware (Laravel 12)

في Laravel 12، الـ Middleware بتتسجل بشكل مختلف شوية. افتح ملف `bootstrap/app.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // تسجيل Spatie Middleware
        $middleware->alias([
            'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### ✅ التحقق من نجاح التثبيت

شغّل الأمر ده وشوف لو الجداول اتنشأت:

```bash
php artisan db:show
```

المفروض تلاقي الجداول دي:
- `permissions`
- `roles`
- `model_has_permissions`
- `model_has_roles`
- `role_has_permissions`

---

## 4. بنية النظام والجداول {#البنية}

### الجداول وشرحها

#### جدول `permissions`

```
+----+------------------+------------+-----------+
| id | name             | guard_name | timestamps|
+----+------------------+------------+-----------+
| 1  | edit posts       | web        | ...       |
| 2  | delete posts     | web        | ...       |
| 3  | view reports     | web        | ...       |
+----+------------------+------------+-----------+
```

#### جدول `roles`

```
+----+----------+------------+-----------+
| id | name     | guard_name | timestamps|
+----+----------+------------+-----------+
| 1  | admin    | web        | ...       |
| 2  | editor   | web        | ...       |
| 3  | viewer   | web        | ...       |
+----+----------+------------+-----------+
```

#### جدول `role_has_permissions` (العلاقة بين Role وPermission)

```
+---------------+----------+
| permission_id | role_id  |
+---------------+----------+
| 1             | 2        |  ← editor عنده edit posts
| 2             | 2        |  ← editor عنده delete posts
| 1             | 1        |  ← admin عنده edit posts كمان
+---------------+----------+
```

#### جدول `model_has_roles` (إسناد Role لـ User)

```
+----------+------------+----------+
| role_id  | model_type | model_id |
+----------+------------+----------+
| 1        | App\Models\User | 5   |  ← User رقم 5 عنده role admin
| 2        | App\Models\User | 8   |  ← User رقم 8 عنده role editor
+----------+------------+----------+
```

#### جدول `model_has_permissions` (صلاحية مباشرة للـ User)

```
+---------------+------------------+----------+
| permission_id | model_type       | model_id |
+---------------+------------------+----------+
| 3             | App\Models\User  | 10       |  ← User 10 عنده view reports مباشرة
+---------------+------------------+----------+
```

### رسم العلاقات

```
User ──────── model_has_roles ──────── roles
 │                                       │
 │                                       │
 └─── model_has_permissions ─── permissions
                                         │
                                         │
              roles ─── role_has_permissions ───┘
```

---

## 5. العمل مع Permissions {#permissions}

### إنشاء Permission

```php
use Spatie\Permission\Models\Permission;

// إنشاء permission واحدة
Permission::create(['name' => 'edit posts']);

// إنشاء مجموعة permissions دفعة واحدة
$permissions = [
    'view posts',
    'create posts',
    'edit posts',
    'delete posts',
    'publish posts',
    'view users',
    'create users',
    'edit users',
    'delete users',
    'view reports',
    'export reports',
];

foreach ($permissions as $permission) {
    Permission::firstOrCreate(['name' => $permission]);
}
```

### جلب الـ Permissions

```php
// جلب كل الـ permissions
$allPermissions = Permission::all();

// جلب permission بالاسم
$permission = Permission::findByName('edit posts');

// جلب permission بالـ ID
$permission = Permission::findById(1);
```

### حذف Permission

```php
$permission = Permission::findByName('edit posts');
$permission->delete();
```

---

## 6. العمل مع Roles {#roles}

### إنشاء Role

```php
use Spatie\Permission\Models\Role;

// إنشاء role بدون permissions
$adminRole = Role::create(['name' => 'admin']);
$editorRole = Role::create(['name' => 'editor']);
$viewerRole = Role::create(['name' => 'viewer']);
```

### إسناد Permissions لـ Role

```php
// إسناد permission واحدة
$editorRole->givePermissionTo('edit posts');

// إسناد أكتر من permission
$editorRole->givePermissionTo(['edit posts', 'create posts', 'delete posts']);

// إسناد كل الـ Permissions لـ Admin
$adminRole->givePermissionTo(Permission::all());

// مزامنة (sync) الـ Permissions — بتحذف القديمة وتضيف الجديدة
$editorRole->syncPermissions(['edit posts', 'view posts']);
```

### إلغاء Permission من Role

```php
$editorRole->revokePermissionTo('delete posts');
```

### جلب Permissions الـ Role

```php
$role = Role::findByName('editor');

// جلب كل permissions الـ role
$permissions = $role->permissions;

// التحقق من وجود permission
$role->hasPermissionTo('edit posts'); // true or false
```

---

## 7. ربط الـ Users بالـ Roles والـ Permissions {#ربط-المستخدمين}

### إسناد Roles للـ User

```php
$user = User::find(1);

// إسناد role واحدة
$user->assignRole('admin');

// إسناد أكتر من role
$user->assignRole(['admin', 'editor']);

// إسناد باستخدام Role Object
$role = Role::findByName('admin');
$user->assignRole($role);
```

### إلغاء Role من User

```php
// إلغاء role واحدة
$user->removeRole('editor');

// إلغاء كل الـ roles
$user->syncRoles([]); // بتحط array فاضية

// مزامنة (بتحذف القديمة وتحط الجديدة)
$user->syncRoles(['editor', 'viewer']);
```

### إسناد Permissions مباشرة للـ User

```php
// إسناد permission مباشرة (من غير role)
$user->givePermissionTo('view reports');

// إسناد أكتر من permission
$user->givePermissionTo(['view reports', 'export reports']);

// مزامنة الـ permissions المباشرة
$user->syncPermissions(['view reports']);

// إلغاء permission مباشرة
$user->revokePermissionTo('view reports');
```

### التحقق من Roles وPermissions

```php
$user = User::find(1);

// ───── التحقق من Role ─────

// هل عنده role معينة؟
$user->hasRole('admin');                    // true or false
$user->hasRole(['admin', 'editor']);        // true لو عنده واحدة على الأقل

// هل عنده كل الـ roles دي؟
$user->hasAllRoles(['admin', 'editor']);    // true بس لو عنده الاتنين

// هل عنده أي role من دي؟
$user->hasAnyRole(['admin', 'editor']);     // true لو عنده واحدة على الأقل

// ───── التحقق من Permission ─────

// هل عنده permission (من role أو مباشرة)؟
$user->hasPermissionTo('edit posts');       // true or false

// هل عنده permission مباشرة (مش من role)؟
$user->hasDirectPermission('view reports'); // true or false

// هل عنده permission من role؟
$user->hasPermissionViaRole('edit posts');  // true or false

// ───── جلب الـ Roles والـ Permissions ─────

// جلب كل roles الـ user
$user->roles;                               // Collection of Role models

// جلب كل permissions الـ user (مباشرة + من roles)
$user->getAllPermissions();                 // Collection of Permission models

// جلب الـ permissions المباشرة بس
$user->getDirectPermissions();

// جلب الـ permissions اللي جاية من الـ roles
$user->getPermissionsViaRoles();
```

---

## 8. الـ Middleware والحماية {#middleware}

### حماية الـ Routes

#### التحقق من Role

```php
// routes/web.php

// حماية route واحدة
Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware('role:admin');

// حماية route بأكتر من role
Route::get('/content/manage', [ContentController::class, 'index'])
    ->middleware('role:admin|editor');

// حماية مجموعة routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::put('/admin/users/{user}', [UserController::class, 'update']);
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy']);
});
```

#### التحقق من Permission

```php
// حماية بـ permission
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware('permission:create posts');

// أكتر من permission (OR — يكفي واحدة)
Route::get('/posts', [PostController::class, 'index'])
    ->middleware('permission:view posts|edit posts');

// حماية بأكتر من permission (AND — لازم كلهم)
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->middleware('permission:delete posts,publish posts');
// ملاحظة: الفاصلة (,) معناها AND، والـ pipe (|) معناها OR
```

#### التحقق من Role أو Permission

```php
// يدخل لو عنده الـ role أو الـ permission
Route::get('/reports', [ReportController::class, 'index'])
    ->middleware('role_or_permission:admin|view reports');
```

### التعامل مع الـ Exception

لما user ماعندوش صلاحية والـ middleware يرفضه، هيتعمله Exception من نوع `UnauthorizedException`. عشان تعالجه بشكل كويس، في ملف `bootstrap/app.php`:

```php
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'مش عندك صلاحية تعمل الحاجة دي.',
                'error'   => 'Unauthorized',
            ], 403);
        }

        return redirect()->route('home')->with('error', 'مش عندك صلاحية للوصول لهذه الصفحة.');
    });
})
```

### الحماية في الـ Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // حماية كل الـ methods
        $this->middleware('auth');

        // حماية methods معينة
        $this->middleware('permission:create posts')->only(['create', 'store']);
        $this->middleware('permission:edit posts')->only(['edit', 'update']);
        $this->middleware('permission:delete posts')->only(['destroy']);
    }

    public function index()
    {
        // لو وصل للهنا، معناه اجتاز الـ middleware
        $posts = Post::latest()->paginate(15);
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        // تحقق يدوي داخل الـ method لو محتاج
        if (!auth()->user()->hasPermissionTo('create posts')) {
            abort(403, 'مش مسموحلك تنشئ بوست جديد.');
        }

        // باقي الكود...
    }
}
```

---

## 9. الـ Blade Directives {#blade}

### التحقق من Role في الـ View

```blade
{{-- التحقق من role واحدة --}}
@role('admin')
    <a href="/admin/dashboard">لوحة التحكم</a>
@endrole

{{-- التحقق من أكتر من role --}}
@hasanyrole('admin|editor')
    <a href="/posts/create">إنشاء مقال جديد</a>
@endhasanyrole

{{-- التحقق من كل الـ roles --}}
@hasallroles('admin|editor')
    <span>عندك دور Admin و Editor معًا</span>
@endhasallroles

{{-- عكس الـ role --}}
@unlessrole('admin')
    <p>أنت لست مدير</p>
@endunlessrole
```

### التحقق من Permission في الـ View

```blade
{{-- التحقق من permission --}}
@can('edit posts')
    <button class="btn btn-warning">تعديل</button>
@endcan

{{-- التحقق من permission مع else --}}
@can('delete posts')
    <button class="btn btn-danger">حذف</button>
@else
    <span class="text-muted">غير مسموح بالحذف</span>
@endcan

{{-- عكس التحقق --}}
@cannot('edit posts')
    <p>مش عندك صلاحية التعديل</p>
@endcannot
```

### مثال عملي: Navigation Menu

```blade
{{-- resources/views/layouts/navigation.blade.php --}}
<nav>
    <ul>
        {{-- ظاهر للكل --}}
        <li><a href="/">الرئيسية</a></li>

        {{-- ظاهر بس للي عندهم admin role --}}
        @role('admin')
        <li><a href="/admin/users">إدارة المستخدمين</a></li>
        <li><a href="/admin/settings">الإعدادات</a></li>
        @endrole

        {{-- ظاهر للـ admin و editor --}}
        @hasanyrole('admin|editor')
        <li><a href="/posts">المقالات</a></li>
        @endhasanyrole

        {{-- ظاهر لأي حد عنده permission view reports --}}
        @can('view reports')
        <li><a href="/reports">التقارير</a></li>
        @endcan
    </ul>
</nav>
```

---

## 10. الـ Policies وتكاملها مع Spatie {#policies}

الـ Policies في Laravel هي طريقة تانية للتحكم في الصلاحيات على مستوى الـ Model. ممكن تدمجها مع Spatie بشكل رائع.

### مثال: PostPolicy مع Spatie

```php
<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * قبل أي تحقق تاني، لو Admin يعدي على طول
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true; // Admin بيعدي على كل الـ checks
        }

        return null; // null = كمّل التحقق الطبيعي
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view posts');
    }

    public function view(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('view posts');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posts');
    }

    public function update(User $user, Post $post): bool
    {
        // تقدر تعمل تحقق أذكى: صاحب البوست أو عنده permission
        return $user->id === $post->user_id 
            || $user->hasPermissionTo('edit posts');
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('delete posts');
    }

    public function publish(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('publish posts');
    }
}
```

### تسجيل الـ Policy

في `app/Providers/AppServiceProvider.php`:

```php
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::policy(Post::class, PostPolicy::class);
}
```

### استخدام الـ Policy في الـ Controller

```php
public function update(Request $request, Post $post)
{
    $this->authorize('update', $post); // هيستخدم PostPolicy::update

    // لو وصل هنا = عنده صلاحية
    $post->update($request->validated());
    return redirect()->route('posts.show', $post);
}
```

---

## 11. سيناريوهات واقعية كاملة {#سيناريوهات}

### سيناريو 1: نظام إدارة محتوى (CMS)

#### أولاً: إنشاء الـ Permissions والـ Roles في Seeder

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // مسح الـ Cache الموجود
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ───── إنشاء الـ Permissions ─────

        // Permissions خاصة بالمقالات
        $postPermissions = [
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
        ];

        // Permissions خاصة بالمستخدمين
        $userPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        // Permissions خاصة بالتقارير
        $reportPermissions = [
            'view reports',
            'export reports',
        ];

        // Permissions خاصة بالإعدادات
        $settingPermissions = [
            'view settings',
            'edit settings',
        ];

        $allPermissions = array_merge(
            $postPermissions,
            $userPermissions,
            $reportPermissions,
            $settingPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ───── إنشاء الـ Roles وإسناد الـ Permissions ─────

        // Admin: عنده كل حاجة
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Editor: يعمل حاجات على المحتوى بس
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->syncPermissions([
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
        ]);

        // Author: بس يكتب مقالات، مينقدرش يحذف أو ينشر
        $authorRole = Role::firstOrCreate(['name' => 'author']);
        $authorRole->syncPermissions([
            'view posts',
            'create posts',
            'edit posts',
        ]);

        // Viewer: بس يشوف
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);
        $viewerRole->syncPermissions([
            'view posts',
        ]);

        // ───── إسناد الـ Roles للـ Users ─────

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $adminUser->assignRole('admin');

        $editorUser = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor User', 'password' => bcrypt('password')]
        );
        $editorUser->assignRole('editor');

        $this->command->info('✅ Roles and Permissions seeded successfully!');
    }
}
```

شغّل الـ Seeder:

```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

---

### سيناريو 2: نظام Multi-tenant مع أدوار مختلفة

في بعض الأنظمة، User ممكن يكون عنده دور مختلف في كل "Organization" أو "Tenant". Spatie بيدعم ده باستخدام مفهوم الـ `teams`.

#### تفعيل الـ Teams في `config/permission.php`

```php
// config/permission.php
'teams' => true,
```

ثم تشغيل الـ Migration الجديدة:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="permission-migrations"
php artisan migrate
```

#### استخدام الـ Teams

```php
// تحديد الـ team الحالية
setPermissionsTeamId($organizationId);

// إسناد role في Organization معينة
$user->assignRole('manager'); // هيتأسند للـ team الحالية

// التحقق من role في Organization معينة
setPermissionsTeamId($organizationId);
$user->hasRole('manager'); // بيتحقق في الـ team دي بس
```

---

### سيناريو 3: API Authentication مع Sanctum

لو بتستخدم Laravel Sanctum للـ API:

```php
// config/permission.php
'guards' => ['web', 'sanctum'],

// أو لو بتستخدم api guard
'guards' => ['web', 'api'],
```

في الـ Routes:

```php
// routes/api.php
Route::middleware(['auth:sanctum', 'permission:view reports'])->group(function () {
    Route::get('/reports', [ApiReportController::class, 'index']);
});
```

في الـ Controller:

```php
public function index(Request $request)
{
    $user = $request->user(); // الـ authenticated user

    if (!$user->hasPermissionTo('view reports', 'sanctum')) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // باقي الكود...
}
```

---

### سيناريو 4: إدارة الصلاحيات من الـ Admin Panel

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * عرض صلاحيات مستخدم معين
     */
    public function show(User $user)
    {
        $allRoles        = Role::all();
        $allPermissions  = Permission::all();
        $userRoles       = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->getDirectPermissions()->pluck('id')->toArray();

        return view('admin.users.permissions', compact(
            'user',
            'allRoles',
            'allPermissions',
            'userRoles',
            'userPermissions'
        ));
    }

    /**
     * تحديث صلاحيات مستخدم معين
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles'       => ['nullable', 'array'],
            'roles.*'     => ['exists:roles,id'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        // مزامنة الـ Roles
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);

        // مزامنة الـ Permissions المباشرة
        $permissions = $request->input('permissions', []);
        $user->syncPermissions($permissions);

        return redirect()
            ->back()
            ->with('success', 'تم تحديث صلاحيات المستخدم بنجاح.');
    }
}
```

---

## 12. الـ Caching وتحسين الأداء {#caching}

Spatie بتعمل Cache للـ Roles والـ Permissions عشان ما تعملش Query لقاعدة البيانات في كل Request. ده بيحسن الأداء جدًا.

### كيفية عمل الـ Cache

افتراضيًا، Spatie بتحفظ الـ Permissions في الـ Cache لمدة 24 ساعة. الـ Cache key بيكون `spatie.permission.cache`.

### مسح الـ Cache يدويًا

```bash
# مسح الـ Cache من الـ Terminal
php artisan permission:cache-reset
```

### مسح الـ Cache برمجيًا

```php
use Spatie\Permission\PermissionRegistrar;

// لازم تمسح الـ Cache بعد أي تغيير في الـ Permissions
app(PermissionRegistrar::class)->forgetCachedPermissions();

// مثال في Controller
public function updatePermissions(User $user, Request $request)
{
    $user->syncPermissions($request->permissions);

    // مسح الـ Cache بعد التحديث
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    return response()->json(['message' => 'تم التحديث بنجاح']);
}
```

### تعديل إعدادات الـ Cache

في `config/permission.php`:

```php
'cache' => [
    // مدة الـ Cache (بالثواني) — افتراضي 24 ساعة
    'expiration_time' => \DateInterval::createFromDateString('24 hours'),

    // اسم الـ Cache key
    'key' => 'spatie.permission.cache',

    // اسم الـ Cache store
    'store' => 'default',
],
```

---

## 13. أفضل الممارسات والنصائح {#best-practices}

### ✅ أفضل الممارسات

**1. استخدم دايمًا Seeders لإنشاء الـ Roles والـ Permissions**
```php
// ✅ صح — في Seeder
Permission::firstOrCreate(['name' => 'edit posts']);

// ❌ غلط — في الكود مباشرة أو في Migration
```

**2. امسح الـ Cache بعد أي تعديل على الـ Permissions**
```php
// ✅ دايمًا بعد syncPermissions أو assignRole
$user->syncPermissions($permissions);
app(PermissionRegistrar::class)->forgetCachedPermissions();
```

**3. استخدم `firstOrCreate` عشان تتجنب الـ Duplicates**
```php
// ✅ آمن
Permission::firstOrCreate(['name' => 'edit posts']);

// ⚠️ ممكن يرمي Exception لو موجود
Permission::create(['name' => 'edit posts']);
```

**4. فصل الـ Permissions لمجموعات منطقية**
```php
// ✅ أفضل — ناميNG واضح
'view posts', 'create posts', 'edit posts', 'delete posts'

// ❌ أسوأ — غامض
'posts_read', 'p_create', 'editPost'
```

**5. استخدم `before()` في الـ Policy للـ Super Admin**
```php
public function before(User $user, string $ability): bool|null
{
    if ($user->hasRole('super-admin')) {
        return true; // يعدي على كل الـ checks
    }
    return null;
}
```

**6. تجنب إسناد Permissions كتير مباشرة للـ Users**
```php
// ✅ أفضل — استخدم Roles
$user->assignRole('editor');

// ⚠️ تجنب — بيعقد الإدارة
$user->givePermissionTo(['create posts', 'edit posts', 'delete posts', ...]);
```

### ⚠️ تحذيرات مهمة

- **دايمًا امسح الـ Cache** بعد تعديل الـ Permissions في الـ Production
- **لا تحذف Permissions** موجودة ومستخدمة من غير ما تتأكد إن مفيش كود بيعتمد عليها
- **الـ Guard Name** لازم يطابق الـ Guard المستخدم في الـ Auth — لو بتعمل `Role::create(['name' => 'admin', 'guard_name' => 'api'])` وبتتحقق منه في `web` guard، مش هيشتغل

---

## 14. دليل الاختبار الكامل {#testing}

### إعداد بيئة الاختبار

في `tests/TestCase.php` أو في الـ Test class نفسه، لازم تعمل refresh للـ Roles والـ Permissions:

```php
<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\PermissionRegistrar;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // مسح الـ Cache قبل كل test
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
```

### كتابة الـ Tests

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesAndPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $editorUser;
    protected User $viewerUser;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء Permissions
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'view reports']);

        // إنشاء Roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $viewerRole = Role::create(['name' => 'viewer']);

        $adminRole->givePermissionTo(Permission::all());
        $editorRole->givePermissionTo(['view posts', 'create posts', 'edit posts']);
        $viewerRole->givePermissionTo(['view posts']);

        // إنشاء Users
        $this->adminUser  = User::factory()->create();
        $this->editorUser = User::factory()->create();
        $this->viewerUser = User::factory()->create();

        $this->adminUser->assignRole('admin');
        $this->editorUser->assignRole('editor');
        $this->viewerUser->assignRole('viewer');
    }

    // ───── اختبارات الـ Roles ─────

    /** @test */
    public function admin_has_admin_role(): void
    {
        $this->assertTrue($this->adminUser->hasRole('admin'));
        $this->assertFalse($this->adminUser->hasRole('editor'));
    }

    /** @test */
    public function editor_has_editor_role(): void
    {
        $this->assertTrue($this->editorUser->hasRole('editor'));
        $this->assertFalse($this->editorUser->hasRole('admin'));
    }

    // ───── اختبارات الـ Permissions ─────

    /** @test */
    public function admin_has_all_permissions(): void
    {
        $this->assertTrue($this->adminUser->hasPermissionTo('view posts'));
        $this->assertTrue($this->adminUser->hasPermissionTo('create posts'));
        $this->assertTrue($this->adminUser->hasPermissionTo('delete posts'));
        $this->assertTrue($this->adminUser->hasPermissionTo('view reports'));
    }

    /** @test */
    public function editor_cannot_delete_posts(): void
    {
        $this->assertFalse($this->editorUser->hasPermissionTo('delete posts'));
    }

    /** @test */
    public function viewer_can_only_view_posts(): void
    {
        $this->assertTrue($this->viewerUser->hasPermissionTo('view posts'));
        $this->assertFalse($this->viewerUser->hasPermissionTo('create posts'));
        $this->assertFalse($this->viewerUser->hasPermissionTo('edit posts'));
        $this->assertFalse($this->viewerUser->hasPermissionTo('delete posts'));
    }

    // ───── اختبارات الـ Routes ─────

    /** @test */
    public function admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    public function viewer_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->viewerUser)
            ->get('/admin/dashboard');

        $response->assertStatus(403); // Forbidden
    }

    /** @test */
    public function editor_can_create_posts(): void
    {
        $response = $this->actingAs($this->editorUser)
            ->post('/posts', [
                'title'   => 'مقال تجريبي',
                'content' => 'محتوى المقال',
            ]);

        $response->assertStatus(201); // Created
    }

    /** @test */
    public function viewer_cannot_create_posts(): void
    {
        $response = $this->actingAs($this->viewerUser)
            ->post('/posts', [
                'title'   => 'مقال تجريبي',
                'content' => 'محتوى المقال',
            ]);

        $response->assertStatus(403); // Forbidden
    }

    // ───── اختبارات الـ Direct Permissions ─────

    /** @test */
    public function user_can_have_direct_permission(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view reports');

        $this->assertTrue($user->hasPermissionTo('view reports'));
        $this->assertTrue($user->hasDirectPermission('view reports'));
    }

    /** @test */
    public function user_can_lose_direct_permission(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view reports');
        $user->revokePermissionTo('view reports');

        $this->assertFalse($user->hasPermissionTo('view reports'));
    }

    // ───── اختبارات الـ Role Assignment ─────

    /** @test */
    public function user_role_can_be_changed(): void
    {
        $this->editorUser->syncRoles(['admin']);

        $this->assertTrue($this->editorUser->hasRole('admin'));
        $this->assertFalse($this->editorUser->hasRole('editor'));
    }

    /** @test */
    public function user_can_have_multiple_roles(): void
    {
        $this->editorUser->assignRole('viewer');

        $this->assertTrue($this->editorUser->hasRole('editor'));
        $this->assertTrue($this->editorUser->hasRole('viewer'));
        $this->assertTrue($this->editorUser->hasAnyRole(['admin', 'editor']));
    }
}
```

### تشغيل الـ Tests

```bash
# تشغيل كل الـ Tests
php artisan test

# تشغيل Tests معينة
php artisan test --filter=RolesAndPermissionsTest

# مع تفاصيل أكتر
php artisan test --filter=RolesAndPermissionsTest --verbose

# تشغيل test واحد
php artisan test --filter="admin_has_all_permissions"
```

---

## 15. مشاكل شائعة وحلولها {#troubleshooting}

### المشكلة الأولى: `There is no permission named X`

```
Spatie\Permission\Exceptions\PermissionDoesNotExist:
There is no permission named `edit post` for guard `web`.
```

**السبب:** اسم الـ Permission مش موجود أو فيه typo.

**الحل:**
```php
// تحقق من الأسماء الموجودة
Permission::all()->pluck('name');

// استخدم firstOrCreate بدل findByName
$permission = Permission::firstOrCreate(['name' => 'edit posts']);
```

---

### المشكلة التانية: `Role does not exist`

**الحل:**
```php
// تحقق إن الـ Seeder اتشغل
php artisan db:seed --class=RolesAndPermissionsSeeder

// أو تحقق يدوي
Role::all()->pluck('name');
```

---

### المشكلة التالتة: الـ Middleware مش شغال

**الحل:** تأكد إنك سجلت الـ Middleware صح في `bootstrap/app.php` زي ما اتذكر في الخطوة الخامسة من التثبيت.

---

### المشكلة الرابعة: الـ Cache القديم بيسبب مشاكل

**الحل:**
```bash
php artisan permission:cache-reset
php artisan cache:clear
```

---

### المشكلة الخامسة: `User does not use the HasRoles trait`

**الحل:** تأكد إنك أضفت الـ Trait للـ User Model:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

---

### المشكلة السادسة: Guard Name Mismatch

لو بتستخدم `api` guard وبتعمل check على `web` guard أو العكس.

**الحل:**
```php
// إنشاء Role لـ guard معين
Role::create(['name' => 'admin', 'guard_name' => 'api']);

// التحقق مع تحديد الـ guard
$user->hasRole('admin', 'api');
$user->hasPermissionTo('edit posts', 'api');
```

---

## 🎯 ملخص سريع — Cheat Sheet

```php
// ══════════════════════════════
//  PERMISSIONS
// ══════════════════════════════
Permission::create(['name' => 'edit posts']);
Permission::all();
Permission::findByName('edit posts');

// ══════════════════════════════
//  ROLES
// ══════════════════════════════
Role::create(['name' => 'admin']);
$role->givePermissionTo('edit posts');
$role->syncPermissions(['edit posts', 'view posts']);
$role->revokePermissionTo('edit posts');

// ══════════════════════════════
//  USER ↔ ROLES
// ══════════════════════════════
$user->assignRole('admin');
$user->removeRole('admin');
$user->syncRoles(['admin', 'editor']);
$user->hasRole('admin');
$user->hasAnyRole(['admin', 'editor']);
$user->hasAllRoles(['admin', 'editor']);
$user->roles; // Collection

// ══════════════════════════════
//  USER ↔ PERMISSIONS
// ══════════════════════════════
$user->givePermissionTo('edit posts');
$user->revokePermissionTo('edit posts');
$user->syncPermissions(['edit posts']);
$user->hasPermissionTo('edit posts');
$user->hasDirectPermission('edit posts');
$user->getAllPermissions();

// ══════════════════════════════
//  CACHE
// ══════════════════════════════
app(PermissionRegistrar::class)->forgetCachedPermissions();
// أو
php artisan permission:cache-reset

// ══════════════════════════════
//  MIDDLEWARE (في Routes)
// ══════════════════════════════
->middleware('role:admin')
->middleware('role:admin|editor')
->middleware('permission:edit posts')
->middleware('role_or_permission:admin|edit posts')

// ══════════════════════════════
//  BLADE
// ══════════════════════════════
@role('admin') ... @endrole
@hasanyrole('admin|editor') ... @endhasanyrole
@can('edit posts') ... @endcan
@cannot('edit posts') ... @endcannot
```

---

> **تذكر دايمًا:** Spatie Permissions هي أداة قوية، بس قوتها في إنك تخططها صح من الأول. حدد الـ Roles والـ Permissions بوضوح قبل ما تبدأ تكود، واستخدم Seeders عشان تضمن الـ Consistency في كل بيئة.

---

*آخر تحديث: Laravel 12 — Spatie Laravel Permission v6*
