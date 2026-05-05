# SMS Integration

هذا الملف يشرح كيفية تكامل خدمة الرسائل القصيرة (SMS) في Laravel باستخدام قناة **Vonage** (Nexmo سابقاً).

## المتطلبات والمتعلقات

- حساب في [Vonage (Nexmo)](https://www.vonage.com/communications-apis/verify/).
- مفتاح API وسر API (API Key & Secret).
- حزمة `laravel/vonage-notification-channel`.

## خطوات التثبيت

1. تثبيت الحزمة عبر Composer:
```bash
composer require laravel/vonage-notification-channel
```

2. إنشاء كلاس إخطار للرسائل القصيرة:
```bash
php artisan make:notification SmsNotification
```

## شرح التكوين

1. إضافة بيانات Vonage في ملف `.env`:
```env
VONAGE_KEY=your_api_key
VONAGE_SECRET=your_api_secret
VONAGE_SMS_FROM=123456789
```

2. تحديث موديل المستخدم (`User.php`) لتحديد رقم الهاتف المستهدف:
تأكد أولاً من إضافة حقل الهاتف لقاعدة البيانات عبر Migration:
```bash
php artisan make:migration add_phone_to_users_table --table=users
```
ثم في الـ migration: `$table->string('phone')->nullable();`.

ثم في الموديل:
```php
public function routeNotificationForVonage($notification)
{
    return $this->phone;
}
```

3. تكوين كلاس الإخطار `app/Notifications/SmsNotification.php`:

```php
use Illuminate\Notifications\Messages\VonageMessage;

public function via($notifiable)
{
    return ['vonage'];
}

public function toVonage($notifiable)
{
    return (new VonageMessage)
                ->content('مرحباً بك! كود التفعيل الخاص بك هو: 1234');
}
```

## أمثلة استخدام عملية

### 1. إرسال رسالة لمستخدم

```php
use App\Notifications\SmsNotification;

$user = User::find(1);
$user->notify(new SmsNotification());
```

### 2. إرسال رسالة فورية (On-Demand)

إذا أردت إرسال رسالة لرقم غير مسجل في قاعدة البيانات:

```php
use Illuminate\Support\Facades\Notification;

Notification::route('vonage', '201234567890')
            ->notify(new SmsNotification());
```

## ملاحظات هامة

- تأكد من كتابة رقم الهاتف بالصيغة الدولية (مثال: `201234567890`).
- توفر Vonage رصيداً تجريبياً مجانياً عند التسجيل لأول مرة.
- في حالة الفشل، تأكد من مراجعة سجلات الخطأ (Logs) للتأكد من صحة مفاتيح الـ API.
