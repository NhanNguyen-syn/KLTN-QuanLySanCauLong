<?php

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email from Resend - ' . now(), function ($m) {
        $m->to('tuan212104@gmail.com')->subject('Test Resend Mail');
    });
    echo "MAIL SENT OK\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
