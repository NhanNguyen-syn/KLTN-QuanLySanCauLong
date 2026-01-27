<?php

namespace Botble\ProductsServices;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
    }
}
