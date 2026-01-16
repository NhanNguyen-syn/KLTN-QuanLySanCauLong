<?php

use Botble\Widget\AbstractWidget;

class IconsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Icons'),
            'description' => __('Widget for social icons with a title.'),
            'title' => null,
            'icons' => [],
        ]);
    }
}

