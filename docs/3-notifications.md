# Laravel Notifications

هذا الملف يشرح كيفية استخدام نظام الإخطارات (Notifications) في Laravel لإرسال تنبيهات عبر قنوات متعددة مثل البريد الإلكتروني وقاعدة البيانات.

## المتطلبات والمتعلقات

- Laravel 8.x أو أحدث.
- إعداد قاعدة البيانات (لإخطارات الـ Database).
- إعداد خدمة البريد (لإخطارات الـ Mail).

## خطوات التثبيت

1. لإنشاء جدول الإخطارات في قاعدة البيانات، قم بتشغيل الأمر:
```bash
php artisan notifications:table
php artisan migrate
```

2. إنشاء كلاس إخطار جديد:
```bash
php artisan make:notification GeneralNotification
```

## شرح التكوين

في كلاس الإخطار (`app/Notifications/GeneralNotification.php`)، نحدد القنوات والبيانات:

```php
public function via($notifiable)
{
    // نحدد هنا القنوات المستخدمة
    return ['mail', 'database'];
}

public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject('تنبيه جديد')
                ->line('هذا نص الرسالة البريدية.')
                ->action('زيارة الموقع', url('/'))
                ->line('شكراً لك!');
}

public function toArray($notifiable)
{
    // هذه البيانات ستخزن في قاعدة البيانات بتنسيق JSON
    return [
        'title' => 'مرحباً بك!',
        'message' => 'لديك إشعار جديد في لوحة التحكم.',
    ];
}
```

## أمثلة استخدام عملية

### 1. إرسال إشعار لمستخدم معين

```php
use App\Models\User;
use App\Notifications\GeneralNotification;

$user = User::find(1);
$user->notify(new GeneralNotification());
```

### 2. إرسال إشعار لمجموعة من المستخدمين

```php
use Illuminate\Support\Facades\Notification;

$users = User::all();
Notification::send($users, new GeneralNotification());
```

### 3. عرض الإخطارات من قاعدة البيانات في Blade

```blade
@foreach($user->notifications as $notification)
    <div>
        <h4>{{ $notification->data['title'] }}</h4>
        <p>{{ $notification->data['message'] }}</p>
        <small>{{ $notification->created_at->diffForHumans() }}</small>
    </div>
@endforeach
```

## ملاحظات هامة

- الإخطارات تدعم قنوات أخرى مثل SMS (عبر Vonage أو Twilio) و Slack.
- يمكنك استخدام الـ Queues لإرسال الإخطارات في الخلفية لتحسين تجربة المستخدم من خلال جعل كلاس الإخطار ينفذ `ShouldQueue`.
