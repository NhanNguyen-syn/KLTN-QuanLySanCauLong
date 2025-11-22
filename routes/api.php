<?php

use Illuminate\Support\Facades\Route;

// API routes are provided by the court-booking plugin.
// This file is intentionally minimal to satisfy Laravel's router loader.
Route::get('/_alive', fn () => response()->json(['status' => 'ok']));

