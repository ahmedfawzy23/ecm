# Email Integration

هذا الملف يشرح كيفية إعداد وإرسال رسائل البريد الإلكتروني في Laravel باستخدام Mailables.

## المتطلبات والمتعلقات

- Laravel 8.x أو أحدث.
- خادم SMTP أو خدمة بريد (مثل Mailtrap، SendGrid، أو AWS SES).

## خطوات التثبيت

1. إنشاء كلاس Mailable جديد:
```bash
php artisan make:mail WelcomeMail
```

2. إنشاء قالب Blade للبريد (اختياري، أو يتم تحديده داخل الكلاس):
قم بإنشاء الملف `resources/views/emails/welcome.blade.php`.

## شرح التكوين

1. في ملف `.env` قم بتحديد بيانات خادم البريد:
```env
MAIL_MAILER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

2. في كلاس `app/Mail/WelcomeMail.php`:

```php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'مرحباً بك في منصتنا',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.welcome', // مسار ملف Blade
        );
    }
}
```

## أمثلة استخدام عملية

### 1. إرسال بريد بسيط

```php
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

Mail::to('user@example.com')->send(new WelcomeMail('أحمد'));
```

### 2. الإرسال في الخلفية (Queue)

لتحسين الأداء، يمكنك جعل الـ Mailable ينفذ الواجهة `ShouldQueue`:

```php
class WelcomeMail extends Mailable implements ShouldQueue
{
    // ...
}
```

### 3. معاينة البريد في المتصفح (Testing)

يمكنك إرجاع الـ Mailable مباشرة من الـ Route لمعاينته:

```php
Route::get('/mail-preview', function () {
    return new App\Mail\WelcomeMail('أحمد');
});
```

## ملاحظات هامة

- أثناء التطوير، يفضل استخدام `MAIL_MAILER=log` لمشاهدة محتوى الرسائل في `storage/logs/laravel.log` بدلاً من إرسالها فعلياً.
- استخدم خدمات مثل **Mailtrap** لاختبار شكل الرسائل البريدية دون إزعاج المستخدمين الحقيقيين.
- تأكد من أن الصور المستخدمة في القوالب تستخدم روابط مطلقة (`https://...`).
