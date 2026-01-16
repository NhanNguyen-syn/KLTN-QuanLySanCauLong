<?php

use Botble\Widget\Widgets\Text as BaseTextWidget;
use Botble\Theme\Facades\Theme;

class TextWidget extends BaseTextWidget
{
    /**
     * @var string
     */
    protected $template;

    public function __construct()
    {
        parent::__construct();

        $this->template = Theme::getThemeNamespace('widgets.text.templates.frontend');
    }
}

