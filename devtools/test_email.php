<?php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Current mail config:\n";
print_r(config('mail.default'));
print_r(config('mail.driver'));
print_r(config('mail.mailers.smtp'));
echo "\nAttempting to send email...\n";

echo "Laravel Version: " . app()->version() . "\n";

try {
    Mail::mailer('smtp')->raw('This is a test email from the debugger.', function ($message) {
        $message->to('tuan212104@gmail.com')
                ->subject('Test Email Debug');
    });
    echo "Email sent command executed (check inbox).\n";
} catch (\Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    Log::error("Test email failed: " . $e->getMessage());
}
