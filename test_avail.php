<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

use Botble\CourtBooking\Http\Controllers\API\AvailabilityController;
use Illuminate\Http\Request;

$controller = new AvailabilityController();
$request = new Request(['date' => '2025-12-22']);
$response = $controller->index($request);
$data = $response->getData()->data;
$stats = [];
foreach ($data as $slot) {
    if (!isset($stats[$slot->status])) {
        $stats[$slot->status] = 0;
    }
    $stats[$slot->status]++;
}
print_r($stats);
?>
