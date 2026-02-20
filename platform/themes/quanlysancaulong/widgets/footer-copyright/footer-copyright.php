<?php

use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;

class FooterCopyrightWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Footer Copyright'),
            'description' => __('Display copyright text and footer links'),
            'copyright_text' => null,
            'links' => '',
        ]);
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'copyright_text',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Copyright Text'))
                    ->placeholder(__('© 2026 . All rights reserved.'))
                    ->helperText(__('Use {year} for current year, {site_title} for site name'))
                    ->toArray()
            )
            ->add(
                'links',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Footer Links'))
                    ->placeholder(__("Privacy policy|/privacy-policy\nTerms of use|/terms-of-use\nCookie|/cookie-policy"))
                    ->helperText(__('Format: Link Text|URL (one per line)'))
                    ->rows(5)
                    ->toArray()
            );
    }

    public function data(): array
    {
        $copyrightText = $this->getConfig('copyright_text');
        
        // Replace placeholders
        $copyrightText = str_replace(
            ['{year}', '{site_title}'],
            [date('Y'), theme_option('site_title', 'Sân cầu lông Niên Thời')],
            $copyrightText
        );

        // Parse links
        $linksText = $this->getConfig('links');
        $links = [];
        
        if ($linksText) {
            $lines = explode("\n", $linksText);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }
                
                $parts = explode('|', $line);
                if (count($parts) === 2) {
                    $links[] = [
                        'text' => trim($parts[0]),
                        'url' => trim($parts[1]),
                    ];
                }
            }
        }

        return compact('copyrightText', 'links');
    }
}
