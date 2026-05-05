# Laravel Socialite

هذا الملف يشرح كيفية إضافة خاصية التسجيل عبر وسائل التواصل الاجتماعي باستخدام `Laravel Socialite`.

## المتطلبات والمتعلقات

- حزمة `laravel/socialite`.
- حساب مطور في المنصة المراد الربط معها (مثل GitHub, Google, Facebook).

## خطوات التثبيت

1. تثبيت الحزمة:
```bash
composer require laravel/socialite
```

2. إضافة حقول قاعدة البيانات المطلوبة لموديل المستخدم:
قم بإنشاء Migration جديد:
```bash
php artisan make:migration add_socialite_fields_to_users_table --table=users
```

محتوى الـ Migration:
```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('provider_id')->nullable();
        $table->string('provider_name')->nullable();
    });
}
```
ثم شغل `php artisan migrate`.

## شرح التكوين

1. إضافة بيانات الاعتماد في `config/services.php`:

```php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('GITHUB_REDIRECT_URL'),
],
```

2. إضافة القيم في ملف `.env`:
```env
GITHUB_CLIENT_ID=your_client_id
GITHUB_CLIENT_SECRET=your_client_secret
GITHUB_REDIRECT_URL=http://localhost:8000/auth/github/callback
```

## كود التطبيق (Controller)

أنشئ `SocialiteController` لإدارة عملية التحويل والاستجابة:

```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'provider_id' => $socialUser->getId(),
            'provider_name' => $provider,
        ], [
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => bcrypt(str()->random(16)),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
```

## المسارات (Routes)

أضف المسارات التالية في `web.php`:

```php
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback']);
```

## أمثلة استخدام عملية

في صفحة تسجيل الدخول، أضف رابطاً للمنصة:

```html
<a href="/auth/github/redirect" class="btn btn-dark">
    تسجيل الدخول عبر GitHub
</a>
```

## ملاحظات هامة

- تأكد من تفعيل "Callback URL" في إعدادات تطبيق المطور الخاص بالمنصة (مثل GitHub Settings).
- بعض المنصات قد لا ترجع البريد الإلكتروني إذا لم يقم المستخدم بتفعيله أو جعله عاماً، لذا قد تحتاج لمعالجة هذه الحالة.
