# 🔗 دليل Laravel Socialite في Laravel 12
### تسجيل الدخول بحسابات Google, GitHub, Facebook وأكتر

> **ملاحظة للمبرمج:** الملف ده مرجعك الكامل لكل حاجة خاصة بـ Laravel Socialite. هتلاقي فيه التثبيت، الإعداد، التعامل مع كل Provider، الحالات الخاصة، والاختبار — كل حاجة خطوة بخطوة. ارجعله في أي وقت.

---

## 📋 فهرس المحتويات

1. [مقدمة: إيه هو Laravel Socialite؟](#مقدمة)
2. [إزاي بيشتغل النظام؟ (OAuth 2.0 بالبساطة)](#كيفية-العمل)
3. [التثبيت والإعداد الأولي](#التثبيت)
4. [إعداد الـ Providers المختلفة](#providers)
5. [بناء الـ Routes والـ Controller](#routes-controller)
6. [التعامل مع بيانات المستخدم](#user-data)
7. [ربط الـ Social Login بالـ Database](#database)
8. [Stateless Authentication (للـ APIs)](#stateless)
9. [سيناريوهات واقعية كاملة](#سيناريوهات)
10. [معالجة الأخطاء والحالات الخاصة](#error-handling)
11. [أفضل الممارسات والأمان](#best-practices)
12. [دليل الاختبار الكامل](#testing)
13. [مشاكل شائعة وحلولها](#troubleshooting)

---

## 1. مقدمة: إيه هو Laravel Socialite؟ {#مقدمة}

### الفكرة

بدل ما المستخدم يسجّل حساب جديد بـ email وpassword، تديله خيار يدخل بـ:

- حساب **Google** بتاعه
- حساب **GitHub** بتاعه
- حساب **Facebook** بتاعه
- حساب **Twitter/X** بتاعه
- وأكتر من 100 Provider تاني!

**Laravel Socialite** هي الـ Package الرسمية من Laravel اللي بتتعامل مع الـ OAuth 2.0 (وبعض OAuth 1.0) بشكل مبسط وجاهز.

### الفرق بين الـ Providers

| Provider | OAuth Version | ملاحظات |
|----------|--------------|---------|
| Google | OAuth 2.0 | الأكتر استخداماً |
| GitHub | OAuth 2.0 | شائع في التطبيقات التقنية |
| Facebook | OAuth 2.0 | محتاج App Review للـ Production |
| Twitter/X | OAuth 1.0a / 2.0 | فيه نسختين |
| LinkedIn | OAuth 2.0 | مفيد للتطبيقات الـ B2B |
| Apple | OAuth 2.0 | لازم لـ iOS apps |

### المزايا

- **سهولة التطبيق:** بدل ما تتعامل مع OAuth بنفسك، Socialite بتعمل كل حاجة
- **Unified API:** نفس الكود لكل الـ Providers — `Socialite::driver('google')` أو `Socialite::driver('github')`
- **Community Providers:** أكتر من 100 Provider إضافي من مجتمع Laravel
- **Stateless Support:** للـ APIs والـ SPAs

---

## 2. إزاي بيشتغل النظام؟ {#كيفية-العمل}

### رحلة OAuth 2.0 خطوة بخطوة

```
المستخدم                  تطبيقك                   Google (مثلاً)
    │                        │                           │
    │  "ادخل بـ Google"      │                           │
    │ ─────────────────────► │                           │
    │                        │  Redirect لـ Google       │
    │                        │ ─────────────────────────►│
    │                        │                           │
    │  ◄─────────────────────────────────────────────── │
    │  Google: "إيه هو التطبيق؟ تسمح له بإيه؟"         │
    │                        │                           │
    │  المستخدم يوافق ────────────────────────────────► │
    │                        │                           │
    │                        │ ◄──── Authorization Code ─│
    │                        │                           │
    │                        │ ── يطلب Access Token ───► │
    │                        │ ◄────── Access Token ───── │
    │                        │                           │
    │                        │ ── يطلب بيانات اليوزر ──► │
    │                        │ ◄── الاسم، الإيميل، إلخ ─ │
    │                        │                           │
    │  ◄── دخل بنجاح ──────  │                           │
```

### الـ Callback URL

الـ Callback URL هو الـ URL اللي Google (أو أي Provider) هيرجع المستخدم إليه بعد الموافقة. هتحتاج تحطه في إعدادات الـ App على كل Provider.

---

## 3. التثبيت والإعداد الأولي {#التثبيت}

### الخطوة الأولى: تثبيت Socialite

```bash
composer require laravel/socialite
```

### الخطوة التانية: إضافة بيانات الـ Providers في `.env`

```env
# Google
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=https://yourapp.com/auth/google/callback

# GitHub
GITHUB_CLIENT_ID=your-github-client-id
GITHUB_CLIENT_SECRET=your-github-client-secret
GITHUB_REDIRECT_URI=https://yourapp.com/auth/github/callback

# Facebook
FACEBOOK_CLIENT_ID=your-facebook-app-id
FACEBOOK_CLIENT_SECRET=your-facebook-app-secret
FACEBOOK_REDIRECT_URI=https://yourapp.com/auth/facebook/callback

# Twitter
TWITTER_CLIENT_ID=your-twitter-client-id
TWITTER_CLIENT_SECRET=your-twitter-client-secret
TWITTER_REDIRECT_URI=https://yourapp.com/auth/twitter/callback
```

### الخطوة التالتة: إضافة إعدادات الـ Providers في `config/services.php`

```php
<?php

return [
    // ... الإعدادات التانية الموجودة

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],

    'github' => [
        'client_id'     => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect'      => env('GITHUB_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT_URI'),
    ],

    'twitter' => [
        'client_id'     => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect'      => env('TWITTER_REDIRECT_URI'),
    ],

    'linkedin-openid' => [
        'client_id'     => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect'      => env('LINKEDIN_REDIRECT_URI'),
    ],
];
```

> **ملاحظة:** اسم الـ key في `config/services.php` لازم يطابق اسم الـ driver اللي هتستخدمه في `Socialite::driver('...')`.

---

## 4. إعداد الـ Providers المختلفة {#providers}

### Google

1. روح على [Google Cloud Console](https://console.cloud.google.com)
2. إنشئ Project جديد أو استخدم موجود
3. فعّل **Google+ API** أو **Google Identity**
4. روح على **Credentials** → إنشئ **OAuth 2.0 Client ID**
5. اختار **Web Application**
6. في **Authorized redirect URIs** حط الـ Callback URL بتاعك

```
Callback URL للـ Local:   http://localhost:8000/auth/google/callback
Callback URL للـ Production: https://yourapp.com/auth/google/callback
```

### GitHub

1. روح على [GitHub Developer Settings](https://github.com/settings/applications/new)
2. **New OAuth App**
3. **Authorization callback URL:** حط الـ Callback URL بتاعك
4. هتاخد الـ Client ID والـ Client Secret

### Facebook

1. روح على [Facebook for Developers](https://developers.facebook.com)
2. إنشئ App جديد → اختار **Consumer**
3. من الـ Dashboard، اضغط **Add Product** → **Facebook Login**
4. في **Valid OAuth Redirect URIs** حط الـ Callback URL

> **تحذير:** Facebook بتحتاج تعمل App Review عشان تشتغل مع users تانيين غير الـ developers في الـ App. للتجربة، أضف الـ users كـ Testers.

### Apple Sign In

Apple محتاج إعداد أكتر شوية:

```bash
# تثبيت Community Provider لـ Apple
composer require socialiteproviders/apple
```

في `app/Providers/AppServiceProvider.php`:

```php
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Apple\AppleExtendSocialite;

public function boot(): void
{
    Event::listen(SocialiteWasCalled::class, AppleExtendSocialite::class);
}
```

---

## 5. بناء الـ Routes والـ Controller {#routes-controller}

### الـ Routes

```php
// routes/web.php

use App\Http\Controllers\Auth\SocialAuthController;

// Google
Route::get('/auth/google',          [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// GitHub
Route::get('/auth/github',          [SocialAuthController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback'])->name('auth.github.callback');

// Facebook
Route::get('/auth/facebook',          [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
```

### طريقة أنيقة: Route واحدة لكل الـ Providers

```php
// routes/web.php

Route::get('/auth/{provider}',          [SocialAuthController::class, 'redirect'])->name('auth.social');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('auth.social.callback');
```

### الـ Controller الأساسي

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * قائمة الـ Providers المسموح بيها — عشان نمنع أي provider غير مصرّح
     */
    protected array $allowedProviders = ['google', 'github', 'facebook', 'twitter'];

    /**
     * Redirect المستخدم للـ Provider
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * استقبال الـ Callback من الـ Provider
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        // هنكمل الكود ده في الأقسام الجاية
    }

    /**
     * التحقق من إن الـ Provider مسموح بيه
     */
    private function validateProvider(string $provider): void
    {
        if (!in_array($provider, $this->allowedProviders)) {
            abort(404);
        }
    }
}
```

---

## 6. التعامل مع بيانات المستخدم {#user-data}

### إيه البيانات اللي بتيجي من الـ Provider؟

```php
$socialUser = Socialite::driver('google')->user();

// البيانات الأساسية (متوفرة في معظم الـ Providers)
$socialUser->getId();        // ID المستخدم على الـ Provider
$socialUser->getName();      // الاسم الكامل
$socialUser->getEmail();     // الإيميل
$socialUser->getAvatar();    // رابط الصورة الشخصية
$socialUser->getNickname();  // الـ Username أو النكنيم (مش دايماً متاح)

// الـ Token (مهم للـ APIs)
$socialUser->token;           // Access Token
$socialUser->refreshToken;    // Refresh Token (مش كل الـ Providers بتديه)
$socialUser->expiresIn;       // وقت انتهاء الـ Token بالثواني

// البيانات الخام من الـ Provider
$socialUser->getRaw();        // Array بكل البيانات اللي رجعت
```

### مثال: إيه اللي بييجي من Google

```php
$socialUser->getRaw();
// [
//   'sub' => '112233445566778899',
//   'name' => 'Ahmed Mohamed',
//   'given_name' => 'Ahmed',
//   'family_name' => 'Mohamed',
//   'picture' => 'https://lh3.googleusercontent.com/...',
//   'email' => 'ahmed@gmail.com',
//   'email_verified' => true,
//   'locale' => 'ar',
// ]
```

### مثال: إيه اللي بييجي من GitHub

```php
$socialUser->getRaw();
// [
//   'login' => 'ahmed-dev',
//   'id' => 12345678,
//   'avatar_url' => 'https://avatars.githubusercontent.com/...',
//   'name' => 'Ahmed Mohamed',
//   'email' => 'ahmed@example.com',
//   'bio' => 'Backend Developer',
//   'public_repos' => 42,
//   ...
// ]
```

### طلب بيانات إضافية (Scopes)

```php
// طلب بيانات إضافية من Google
return Socialite::driver('google')
    ->scopes(['openid', 'profile', 'email'])
    ->redirect();

// طلب الوصول لـ Repos الـ Private من GitHub
return Socialite::driver('github')
    ->scopes(['user', 'repo'])
    ->redirect();

// طلب البيانات المالية من Facebook (مثال)
return Socialite::driver('facebook')
    ->scopes(['email', 'public_profile'])
    ->fields(['name', 'email', 'picture'])
    ->redirect();
```

---

## 7. ربط الـ Social Login بالـ Database {#database}

### Migration لحفظ بيانات الـ Social Accounts

محتاج جدول جديد يربط الـ Users بالـ Social Accounts بتوعهم:

```bash
php artisan make:migration create_social_accounts_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider');          // 'google', 'github', etc.
            $table->string('provider_id');       // ID المستخدم على الـ Provider
            $table->string('provider_token')->nullable();      // Access Token
            $table->string('provider_refresh_token')->nullable(); // Refresh Token
            $table->timestamp('token_expires_at')->nullable(); // وقت انتهاء الـ Token
            $table->string('avatar')->nullable();              // رابط الصورة
            $table->timestamps();

            // منع التكرار: نفس الـ Provider ونفس الـ ID مرة واحدة بس
            $table->unique(['provider', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
```

```bash
php artisan migrate
```

### إنشاء الـ Models

#### SocialAccount Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'provider_token',
        'provider_refresh_token',
        'token_expires_at',
        'avatar',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

#### تعديل User Model

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }
}
```

### إنشاء SocialAuthService

عشان نفصل الـ Logic ونخليه نظيف، هنعمل Service:

```php
<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialAuthService
{
    /**
     * جلب أو إنشاء User بناءً على بيانات الـ Social Provider
     */
    public function findOrCreateUser(SocialiteUser $socialUser, string $provider): User
    {
        return DB::transaction(function () use ($socialUser, $provider) {

            // هل الـ Social Account موجود أصلاً؟
            $socialAccount = SocialAccount::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($socialAccount) {
                // موجود — بس حدّث الـ Token
                $socialAccount->update([
                    'provider_token'         => $socialUser->token,
                    'provider_refresh_token' => $socialUser->refreshToken,
                    'token_expires_at'       => $socialUser->expiresIn
                        ? now()->addSeconds($socialUser->expiresIn)
                        : null,
                    'avatar' => $socialUser->getAvatar(),
                ]);

                return $socialAccount->user;
            }

            // Social Account جديد — هل الإيميل موجود عند user تاني؟
            $user = null;

            if ($socialUser->getEmail()) {
                $user = User::where('email', $socialUser->getEmail())->first();
            }

            // لو مفيش user بالإيميل ده، إنشئ واحد جديد
            if (!$user) {
                $user = User::create([
                    'name'     => $socialUser->getName(),
                    'email'    => $socialUser->getEmail(),
                    'password' => null, // مفيش password لأنه بيدخل بـ Social
                    'avatar'   => $socialUser->getAvatar(),
                ]);
            }

            // إنشئ الـ Social Account وربطه بالـ User
            $user->socialAccounts()->create([
                'provider'               => $provider,
                'provider_id'            => $socialUser->getId(),
                'provider_token'         => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken,
                'token_expires_at'       => $socialUser->expiresIn
                    ? now()->addSeconds($socialUser->expiresIn)
                    : null,
                'avatar' => $socialUser->getAvatar(),
            ]);

            return $user;
        });
    }
}
```

### الـ Controller الكامل

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    protected array $allowedProviders = ['google', 'github', 'facebook', 'twitter'];

    public function __construct(
        private SocialAuthService $socialAuthService
    ) {}

    /**
     * Redirect المستخدم للـ Provider
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * استقبال الـ Callback
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            // المستخدم رفض أو في خطأ من الـ Provider
            return redirect()->route('login')
                ->with('error', 'فشل تسجيل الدخول. حاول تاني.');
        }

        // لو الـ Provider مش بيرجع إيميل
        if (!$socialUser->getEmail()) {
            return redirect()->route('login')
                ->with('error', 'مش قادرين نجيب الإيميل بتاعك. جرب طريقة تانية.');
        }

        try {
            $user = $this->socialAuthService->findOrCreateUser($socialUser, $provider);
        } catch (Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'حصل مشكلة. حاول تاني.');
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }

    private function validateProvider(string $provider): void
    {
        if (!in_array($provider, $this->allowedProviders)) {
            abort(404);
        }
    }
}
```

---

## 8. Stateless Authentication للـ APIs {#stateless}

لو تطبيقك API أو SPA (React, Vue, etc.)، هتستخدم `stateless()`:

```php
// الـ Redirect
public function redirect(string $provider): RedirectResponse
{
    return Socialite::driver($provider)->stateless()->redirect();
}

// الـ Callback
public function callback(string $provider)
{
    try {
        $socialUser = Socialite::driver($provider)->stateless()->user();
    } catch (Throwable $e) {
        return response()->json(['message' => 'فشل التحقق من الـ Provider'], 422);
    }

    $user = $this->socialAuthService->findOrCreateUser($socialUser, $provider);

    // إنشاء Sanctum Token
    $token = $user->createToken('social-auth-token')->plainTextToken;

    return response()->json([
        'user'  => $user,
        'token' => $token,
    ]);
}
```

### الـ Flow مع SPA (مثلاً React)

```
1. Frontend يفتح:  GET /auth/google  ← في نافذة جديدة أو redirect
2. المستخدم يوافق على Google
3. Google بترجع لـ:  GET /auth/google/callback
4. Backend يعمل stateless()->user()
5. Backend بيرجع JSON فيه الـ token
6. Frontend يحفظ الـ token ويستخدمه في كل Request
```

---

## 9. سيناريوهات واقعية كاملة {#سيناريوهات}

### سيناريو 1: ربط Social Account بـ Account موجود

المستخدم عنده حساب بـ email/password وعايز يضيف Google عليه:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LinkedAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // لازم يكون logged in
    }

    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)
            ->with(['state' => 'link_account']) // نبعت state عشان نعرف إنه linking
            ->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable $e) {
            return redirect()->route('profile')
                ->with('error', 'فشل الربط. حاول تاني.');
        }

        $currentUser = Auth::user();

        // تحقق إن الـ Social Account مش مربوط بـ user تاني
        $existingAccount = \App\Models\SocialAccount::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($existingAccount && $existingAccount->user_id !== $currentUser->id) {
            return redirect()->route('profile')
                ->with('error', 'الحساب ده مربوط بـ user تاني بالفعل.');
        }

        // ربط الحساب
        $currentUser->socialAccounts()->updateOrCreate(
            ['provider' => $provider, 'provider_id' => $socialUser->getId()],
            [
                'provider_token'         => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken,
                'avatar'                 => $socialUser->getAvatar(),
            ]
        );

        return redirect()->route('profile')
            ->with('success', "تم ربط حساب {$provider} بنجاح!");
    }
}
```

---

### سيناريو 2: GitHub Login مع جلب الـ Repos

```php
public function redirect(): RedirectResponse
{
    return Socialite::driver('github')
        ->scopes(['user', 'public_repo'])
        ->redirect();
}

public function callback(): RedirectResponse
{
    $githubUser = Socialite::driver('github')->user();

    $user = $this->socialAuthService->findOrCreateUser($githubUser, 'github');

    // جلب الـ Repos باستخدام الـ Access Token
    $repos = $this->fetchGithubRepos($githubUser->token);

    // حفظ الـ Repos في الـ Cache
    cache()->put("user_{$user->id}_github_repos", $repos, now()->addHour());

    Auth::login($user, true);

    return redirect()->route('dashboard');
}

private function fetchGithubRepos(string $token): array
{
    $response = \Illuminate\Support\Facades\Http::withToken($token)
        ->get('https://api.github.com/user/repos', [
            'sort' => 'updated',
            'per_page' => 10,
        ]);

    return $response->json() ?? [];
}
```

---

### سيناريو 3: Google One Tap Sign In

```php
// في الـ Controller
public function handleOneTap(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
{
    $request->validate([
        'credential' => ['required', 'string'],
    ]);

    // التحقق من الـ Google ID Token
    $client = new \Google\Client(['client_id' => config('services.google.client_id')]);

    try {
        $payload = $client->verifyIdToken($request->credential);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Invalid token'], 401);
    }

    if (!$payload) {
        return response()->json(['message' => 'Verification failed'], 401);
    }

    // استخدم الـ payload لإنشاء أو جلب الـ User
    $user = User::firstOrCreate(
        ['email' => $payload['email']],
        [
            'name'   => $payload['name'],
            'avatar' => $payload['picture'],
        ]
    );

    Auth::login($user, true);

    return response()->json([
        'message'  => 'تم تسجيل الدخول بنجاح',
        'redirect' => route('dashboard'),
    ]);
}
```

---

### سيناريو 4: الـ View مع أزرار Social Login

```blade
{{-- resources/views/auth/login.blade.php --}}

<div class="login-container">
    <h1>تسجيل الدخول</h1>

    {{-- عرض الأخطاء --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- تسجيل دخول عادي --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="الإيميل" required>
        <input type="password" name="password" placeholder="كلمة السر" required>
        <button type="submit">دخول</button>
    </form>

    <div class="divider">أو</div>

    {{-- أزرار Social Login --}}
    <div class="social-buttons">

        {{-- Google --}}
        <a href="{{ route('auth.social', 'google') }}" class="btn-social btn-google">
            <img src="/icons/google.svg" alt="Google" width="20">
            دخول بـ Google
        </a>

        {{-- GitHub --}}
        <a href="{{ route('auth.social', 'github') }}" class="btn-social btn-github">
            <img src="/icons/github.svg" alt="GitHub" width="20">
            دخول بـ GitHub
        </a>

        {{-- Facebook --}}
        <a href="{{ route('auth.social', 'facebook') }}" class="btn-social btn-facebook">
            <img src="/icons/facebook.svg" alt="Facebook" width="20">
            دخول بـ Facebook
        </a>

    </div>
</div>
```

---

## 10. معالجة الأخطاء والحالات الخاصة {#error-handling}

### الحالات الخاصة اللي لازم تتعاملها

#### 1. المستخدم يلغي الـ Request

```php
public function callback(string $provider): RedirectResponse
{
    // لو المستخدم ضغط "Cancel" في Google
    if (request()->has('error')) {
        return redirect()->route('login')
            ->with('info', 'تم إلغاء تسجيل الدخول.');
    }

    try {
        $socialUser = Socialite::driver($provider)->user();
    } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
        // لو الـ State مش متطابق (CSRF protection)
        return redirect()->route('login')
            ->with('error', 'انتهت صلاحية الطلب. حاول تاني.');
    } catch (Throwable $e) {
        return redirect()->route('login')
            ->with('error', 'حصل خطأ. حاول تاني.');
    }

    // باقي الكود...
}
```

#### 2. Provider مش بيرجع إيميل

```php
// Twitter مثلاً بيرجع إيميل بس لو المستخدم أضافه على حسابه
if (!$socialUser->getEmail()) {

    // خيار 1: اطلب من المستخدم يدخل إيميله
    session(['pending_social_user' => [
        'provider'    => $provider,
        'provider_id' => $socialUser->getId(),
        'name'        => $socialUser->getName(),
        'avatar'      => $socialUser->getAvatar(),
        'token'       => $socialUser->token,
    ]]);

    return redirect()->route('social.complete-profile')
        ->with('info', 'محتاج تضيف إيميلك عشان نكمل التسجيل.');
}
```

#### 3. Controller لطلب الإيميل

```php
public function completeProfile(Request $request)
{
    if (!session('pending_social_user')) {
        return redirect()->route('login');
    }

    if ($request->isMethod('POST')) {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        $pending = session('pending_social_user');

        $user = User::create([
            'name'   => $pending['name'],
            'email'  => $request->email,
            'avatar' => $pending['avatar'],
        ]);

        $user->socialAccounts()->create([
            'provider'       => $pending['provider'],
            'provider_id'    => $pending['provider_id'],
            'provider_token' => $pending['token'],
        ]);

        session()->forget('pending_social_user');
        Auth::login($user, true);

        return redirect()->route('dashboard');
    }

    return view('auth.complete-profile');
}
```

---

## 11. أفضل الممارسات والأمان {#best-practices}

### ✅ أفضل الممارسات

**1. دايمًا Validate الـ Provider**

```php
// ✅ صح — عندنا allowedProviders
private array $allowedProviders = ['google', 'github'];

private function validateProvider(string $provider): void
{
    abort_unless(in_array($provider, $this->allowedProviders), 404);
}

// ❌ غلط — بيقبل أي provider
Socialite::driver($request->provider)->redirect(); // خطر!
```

**2. استخدم HTTPS دايمًا في الـ Production**

```php
// في AppServiceProvider::boot()
if (app()->isProduction()) {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}
```

**3. تعامل مع نقص البيانات**

```php
// بعض الـ Providers مش بيبعتوا كل حاجة
$name   = $socialUser->getName() ?? $socialUser->getNickname() ?? 'مستخدم جديد';
$email  = $socialUser->getEmail();
$avatar = $socialUser->getAvatar();
```

**4. حفظ الـ Tokens بأمان**

```php
// لو بتحفظ الـ Tokens في DB، استخدم Encryption
// في SocialAccount Model:
protected $casts = [
    'provider_token'         => 'encrypted',
    'provider_refresh_token' => 'encrypted',
];
```

**5. Rate Limiting لمنع الـ Abuse**

```php
// routes/web.php
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])
    ->middleware('throttle:10,1'); // 10 requests كل دقيقة
```

**6. لا تثق في البيانات الجاية من الـ Provider بدون Validation**

```php
// ✅ دايمًا validate قبل ما تحفظ
$name = substr(strip_tags($socialUser->getName()), 0, 255);
```

### ⚠️ تحذيرات مهمة

- **لا تحفظ الـ Access Token في plain text** في الـ Production — استخدم الـ Encryption
- **Callback URLs** لازم تتطابق تماماً مع اللي محطوط في إعدادات الـ Provider
- **الـ State Parameter** في OAuth مهم لمنع CSRF attacks — متعطلوش
- **لو عملت Stateless** فمعناه إنك أنت بتتحمل مسؤولية الـ Security

---

## 12. دليل الاختبار الكامل {#testing}

### إعداد بيئة الاختبار

```php
// في الـ Test، بنعمل Mock لـ Socialite عشان مانحتاجش نتكلم مع Google فعلاً
```

### كتابة الـ Tests

```php
<?php

namespace Tests\Feature\Auth;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class SocialAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper: نعمل Mock لـ Socialite User
     */
    private function mockSocialiteUser(array $overrides = []): object
    {
        $defaults = [
            'id'     => '12345',
            'name'   => 'Ahmed Mohamed',
            'email'  => 'ahmed@example.com',
            'avatar' => 'https://example.com/avatar.jpg',
            'token'  => 'fake-access-token',
            'refreshToken' => 'fake-refresh-token',
            'expiresIn' => 3600,
        ];

        $data = array_merge($defaults, $overrides);

        $socialiteUser = Mockery::mock(\Laravel\Socialite\Two\User::class);
        $socialiteUser->shouldReceive('getId')->andReturn($data['id']);
        $socialiteUser->shouldReceive('getName')->andReturn($data['name']);
        $socialiteUser->shouldReceive('getEmail')->andReturn($data['email']);
        $socialiteUser->shouldReceive('getAvatar')->andReturn($data['avatar']);
        $socialiteUser->token        = $data['token'];
        $socialiteUser->refreshToken = $data['refreshToken'];
        $socialiteUser->expiresIn    = $data['expiresIn'];

        return $socialiteUser;
    }

    /**
     * Helper: نعمل Mock لـ Socialite Provider
     */
    private function mockSocialiteProvider(string $provider, object $socialiteUser): void
    {
        $providerMock = Mockery::mock(Provider::class);
        $providerMock->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')
            ->with($provider)
            ->andReturn($providerMock);
    }

    // ───── اختبار الـ Redirect ─────

    /** @test */
    public function redirect_redirects_to_google(): void
    {
        Socialite::shouldReceive('driver->redirect')
            ->once()
            ->andReturn(redirect('https://accounts.google.com/oauth'));

        $response = $this->get('/auth/google');

        $response->assertRedirect();
    }

    /** @test */
    public function invalid_provider_returns_404(): void
    {
        $response = $this->get('/auth/invalid-provider');

        $response->assertNotFound();
    }

    // ───── اختبار إنشاء User جديد ─────

    /** @test */
    public function new_user_is_created_on_first_social_login(): void
    {
        $socialiteUser = $this->mockSocialiteUser();
        $this->mockSocialiteProvider('google', $socialiteUser);

        $response = $this->get('/auth/google/callback');

        // تأكد إن user اتنشأ
        $this->assertDatabaseHas('users', [
            'email' => 'ahmed@example.com',
            'name'  => 'Ahmed Mohamed',
        ]);

        // تأكد إن social account اتنشأ
        $this->assertDatabaseHas('social_accounts', [
            'provider'    => 'google',
            'provider_id' => '12345',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    // ───── اختبار تسجيل دخول User موجود ─────

    /** @test */
    public function existing_user_can_login_with_social_account(): void
    {
        // إنشاء user وsocial account موجودين
        $user = User::factory()->create(['email' => 'ahmed@example.com']);
        $user->socialAccounts()->create([
            'provider'    => 'google',
            'provider_id' => '12345',
        ]);

        $socialiteUser = $this->mockSocialiteUser();
        $this->mockSocialiteProvider('google', $socialiteUser);

        $response = $this->get('/auth/google/callback');

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    // ───── اختبار ربط Social Account بـ Email موجود ─────

    /** @test */
    public function social_login_links_to_existing_user_with_same_email(): void
    {
        // user موجود بـ email
        $existingUser = User::factory()->create(['email' => 'ahmed@example.com']);

        $socialiteUser = $this->mockSocialiteUser(['email' => 'ahmed@example.com']);
        $this->mockSocialiteProvider('google', $socialiteUser);

        $this->get('/auth/google/callback');

        // تأكد إن social account اتضاف للـ user الموجود
        $this->assertDatabaseHas('social_accounts', [
            'user_id'     => $existingUser->id,
            'provider'    => 'google',
            'provider_id' => '12345',
        ]);

        // تأكد إنه منشأش user جديد
        $this->assertDatabaseCount('users', 1);
    }

    // ───── اختبار فشل الـ Callback ─────

    /** @test */
    public function failed_callback_redirects_with_error(): void
    {
        $providerMock = Mockery::mock(Provider::class);
        $providerMock->shouldReceive('user')
            ->andThrow(new \Exception('Provider error'));

        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($providerMock);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    // ───── اختبار الحالة لما الإيميل مش موجود ─────

    /** @test */
    public function user_without_email_is_redirected_to_complete_profile(): void
    {
        $socialiteUser = $this->mockSocialiteUser(['email' => null]);
        $this->mockSocialiteProvider('twitter', $socialiteUser);

        $response = $this->get('/auth/twitter/callback');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function token_is_updated_on_subsequent_logins(): void
    {
        $user = User::factory()->create(['email' => 'ahmed@example.com']);
        $user->socialAccounts()->create([
            'provider'       => 'google',
            'provider_id'    => '12345',
            'provider_token' => 'old-token',
        ]);

        $socialiteUser = $this->mockSocialiteUser(['token' => 'new-token']);
        $this->mockSocialiteProvider('google', $socialiteUser);

        $this->get('/auth/google/callback');

        $this->assertDatabaseHas('social_accounts', [
            'provider'       => 'google',
            'provider_id'    => '12345',
            'provider_token' => 'new-token',
        ]);
    }
}
```

### تشغيل الـ Tests

```bash
# تشغيل كل الـ Tests
php artisan test

# تشغيل Tests الـ Social Auth بس
php artisan test --filter=SocialAuthTest

# مع تفاصيل
php artisan test --filter=SocialAuthTest --verbose
```

---

## 13. مشاكل شائعة وحلولها {#troubleshooting}

### المشكلة الأولى: `Invalid state`

```
Laravel\Socialite\Two\InvalidStateException
```

**السبب:** الـ Session انتهت، أو الـ Cookies مش شغالة، أو الـ Redirect URI مش متطابق.

**الحل:**

```php
// تأكد إن الـ SESSION_DRIVER شغال
// في .env
SESSION_DRIVER=file  // أو database أو redis

// لو بتستخدم Stateless فعّلها
Socialite::driver($provider)->stateless()->user();
```

---

### المشكلة التانية: `redirect_uri_mismatch`

**السبب:** الـ Callback URL في `.env` مختلف عن اللي محطوط في Google/GitHub Console.

**الحل:**

```env
# تأكد إن الـ URL متطابق تماماً — حتى الـ trailing slash مهم
GOOGLE_REDIRECT_URI=https://yourapp.com/auth/google/callback
# مش
GOOGLE_REDIRECT_URI=https://yourapp.com/auth/google/callback/
```

---

### المشكلة التالتة: مفيش إيميل بييجي من Twitter

**السبب:** Twitter بيطلب تفعيل خاص لجلب الإيميل.

**الحل:**

في Twitter Developer Portal، تأكد إنك فعّلت **Request email address from users** في إعدادات الـ App.

---

### المشكلة الرابعة: الـ Avatar مش بيتحفظ

```php
// بعض الـ Providers بيبعتوا size صغير في الـ Avatar
// تقدر تعمله أكبر زي كده لـ Google:
$avatar = $socialUser->getAvatar();
// Google بتبعت ?sz=50 — حوّلها لـ sz=200
$avatar = str_replace('=s96-c', '=s400-c', $avatar);
```

---

### المشكلة الخامسة: مشكلة في الـ Local بالـ HTTPS

```php
// في AppServiceProvider::boot()
// فقط في الـ Local — متعملهاش في Production
if (app()->isLocal()) {
    \Illuminate\Support\Facades\URL::forceScheme('http');
}
```

---

## 🎯 ملخص سريع — Cheat Sheet

```php
// ══════════════════════════════
//  REDIRECT للـ Provider
// ══════════════════════════════
return Socialite::driver('google')->redirect();

// مع Scopes إضافية
return Socialite::driver('google')
    ->scopes(['profile', 'email'])
    ->redirect();

// Stateless (للـ API)
return Socialite::driver('google')->stateless()->redirect();

// ══════════════════════════════
//  جلب بيانات الـ User
// ══════════════════════════════
$user = Socialite::driver('google')->user();
$user = Socialite::driver('google')->stateless()->user(); // للـ API

$user->getId();        // ID على الـ Provider
$user->getName();      // الاسم الكامل
$user->getEmail();     // الإيميل
$user->getAvatar();    // رابط الصورة
$user->getNickname();  // الـ Username
$user->token;          // Access Token
$user->refreshToken;   // Refresh Token
$user->expiresIn;      // الوقت بالثواني
$user->getRaw();       // كل البيانات الخام

// ══════════════════════════════
//  الـ Providers الشائعة
// ══════════════════════════════
Socialite::driver('google')
Socialite::driver('github')
Socialite::driver('facebook')
Socialite::driver('twitter')
Socialite::driver('linkedin-openid')
Socialite::driver('apple')    // Community Provider

// ══════════════════════════════
//  الـ Services Config Keys
// ══════════════════════════════
// config/services.php
'google'           => [...],
'github'           => [...],
'facebook'         => [...],
'twitter'          => [...],
'linkedin-openid'  => [...],

// ══════════════════════════════
//  Community Providers
// ══════════════════════════════
// composer require socialiteproviders/apple
// composer require socialiteproviders/microsoft
// composer require socialiteproviders/discord
// كل الـ Providers: https://socialiteproviders.com
```

---

## 🌐 Community Providers (أكتر من 100 Provider!)

لو محتاج Provider مش موجود في Socialite الأساسية:

```bash
# تثبيت الـ Manager أولاً
composer require socialiteproviders/manager

# ثم تثبيت الـ Provider اللي عايزه
composer require socialiteproviders/discord
composer require socialiteproviders/microsoft
composer require socialiteproviders/tiktok
composer require socialiteproviders/instagram
```

في `app/Providers/AppServiceProvider.php`:

```php
use SocialiteProviders\Manager\SocialiteWasCalled;

public function boot(): void
{
    \Event::listen(SocialiteWasCalled::class, \SocialiteProviders\Discord\DiscordExtendSocialite::class);
}
```

بعد كده، استخدمه عادي:

```php
Socialite::driver('discord')->redirect();
```

كل الـ Providers الإضافية موجودة على: [https://socialiteproviders.com](https://socialiteproviders.com)

---

> **تذكر دايمًا:** الـ Social Login هو تجربة المستخدم أولاً — خليها سريعة، واضحة، وبدون خطوات زيادة. معالجة الأخطاء بشكل كويس هي اللي بتفرق بين تطبيق محترف وتطبيق هواة.

---

*آخر تحديث: Laravel 12 — Laravel Socialite v5*
