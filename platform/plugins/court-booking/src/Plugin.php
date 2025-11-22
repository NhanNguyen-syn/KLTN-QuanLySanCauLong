<?php

namespace Botble\CourtBooking;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Court Bookings');
        Schema::dropIfExists('Court Bookings_translations');
    }
}
