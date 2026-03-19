<?php
require 'core/boot/bootstrap.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$booking = Botble\CourtBooking\Models\BookingList::first();
echo "Class of status: " . get_class($booking->status ?? new stdClass) . "\n";
echo "Value of status: " . (string) $booking->status . "\n";
echo "Type of status: " . gettype($booking->status) . "\n";
