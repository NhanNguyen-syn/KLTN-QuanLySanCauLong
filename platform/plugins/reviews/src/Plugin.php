<?php

namespace Botble\Reviews;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        // Don't drop table as it might be shared or important
    }
}
