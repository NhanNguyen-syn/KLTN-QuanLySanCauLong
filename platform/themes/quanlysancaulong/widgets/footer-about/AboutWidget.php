<?php

use Botble\Widget\AbstractWidget;

class AboutWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Company info'),
            'description' => __('Widget for footer about section with logo, text, and social links.'),
            'logo' => null,
            'headline' => null,
            'description_text' => null,
            'phone' => null,
            'phone_icon' => null,
            'email' => null,
            'email_icon' => null,
        ]);

    }
}
