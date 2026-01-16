<?php

use Botble\Base\Forms\FieldOptions\InputFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\Fields\ShortcodeColorField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;

Shortcode::register('policy-main-grid', __('Policy - Main Grid'), __('Policy Main Grid Section'), function (ShortcodeCompiler $shortcode) {
    $columns = [];
    
    // Loop through 4 columns
    for ($c = 1; $c <= 4; $c++) {
        $colTitle = $shortcode->{"col{$c}_title"};
        $colItems = [];

        // Loop through 6 fixed rows per column
        for ($r = 1; $r <= 6; $r++) {
            $cond = $shortcode->{"col{$c}_r{$r}_condition"};
            $fee = $shortcode->{"col{$c}_r{$r}_fee"};
            $desc = $shortcode->{"col{$c}_r{$r}_desc"};

            // Only add if at least Condition or Fee is present
            if ($cond || $fee) {
                $colItems[] = [
                    'condition' => $cond,
                    'fee' => $fee,
                    'description' => $desc,
                ];
            }
        }

        // Add column if it has title or items
        if ($colTitle || !empty($colItems)) {
            $columns[] = [
                'title' => $colTitle,
                'items' => $colItems
            ];
        }
    }

    return Theme::partial('shortcodes.policy-main-grid', compact('shortcode', 'columns'));
});

Shortcode::setAdminConfig('policy-main-grid', function (array $attributes) {
    $form = ShortcodeForm::createFromArray($attributes)
        ->withLazyLoading()
        ->add(
            'background_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Section Background Color'))
                ->defaultValue('#f8faf6')
                ->toArray()
        )
        ->add(
            'primary_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Primary Color (Titles & Highlights)'))
                ->defaultValue('#065f46')
                ->toArray()
        )
        ->add(
            'border_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Border Color'))
                ->defaultValue('#d1f2e8')
                ->toArray()
        )
        ->add(
            'text_color',
            ShortcodeColorField::class,
            InputFieldOption::make()
                ->label(__('Description Text Color'))
                ->defaultValue('#6b7280')
                ->toArray()
        );

    // Generate fields for 4 Columns wrapped in <details>
    for ($c = 1; $c <= 4; $c++) {
        
        // Open Details Tag
        $isOpen = ($c == 1) ? 'open' : ''; // Open first column by default
        $form->add("col{$c}_open", HtmlField::class, [
            'html' => "
            <details {$isOpen} style='margin-bottom: 15px; border: 1px solid #e0e0e0; border-radius: 8px; background: #fff; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05);'>
                <summary style='padding: 12px 15px; background: #f8fafc; cursor: pointer; font-weight: 600; color: #334155; border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; justify-content: space-between;'>
                    <span>COLUMN $c SETTINGS</span>
                    <span style='font-size: 10px; color: #94a3b8; font-weight: normal;'>(Click to expand/collapse)</span>
                </summary>
                <div style='padding: 20px;'>
            "
        ]);

        // Column Title
        $defaultTitle = '';
        if ($c == 1) $defaultTitle = 'CHÍNH SÁCH HỦY SÂN';
        elseif ($c == 2) $defaultTitle = 'CHÍNH SÁCH ĐỔI SÂN';
        elseif ($c == 3) $defaultTitle = 'CHÍNH SÁCH HOÀN TIỀN';

        $form->add(
            "col{$c}_title",
            TextField::class,
            TextFieldOption::make()
                ->label(__("Column Title"))
                ->defaultValue($defaultTitle)
                ->placeholder('Enter column title')
                ->attributes(['style' => 'font-weight: bold; color: #0f172a;'])
                ->toArray()
        );

        // Generate 6 Rows for this Column
        for ($r = 1; $r <= 6; $r++) {
            $form->add("sep_c{$c}_r{$r}", HtmlField::class, [
                'html' => "<div style='margin-top: 15px; margin-bottom: 10px; font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 600; border-bottom: 1px dashed #cbd5e1; padding-bottom: 5px;'>Row Item #$r</div>"
            ]);
            
            // Condition & Fee side-by-side
            $form->add(
                "col{$c}_r{$r}_condition",
                TextField::class,
                TextFieldOption::make()
                    ->label(__("Condition"))
                    ->placeholder('e.g. Hủy trước 2h')
                    ->wrapperAttributes(['class' => 'form-group col-md-6', 'style' => 'display:inline-block; width:49%; padding-right:1%; margin-bottom: 10px; vertical-align: top;'])
                    ->toArray()
            );
            $form->add(
                "col{$c}_r{$r}_fee",
                TextField::class,
                TextFieldOption::make()
                    ->label(__("Fee / Action"))
                    ->placeholder('e.g. Miễn phí 100%')
                    ->wrapperAttributes(['class' => 'form-group col-md-6', 'style' => 'display:inline-block; width:49%; margin-bottom: 10px; vertical-align: top;'])
                    ->toArray()
            );
            $form->add(
                "col{$c}_r{$r}_desc",
                TextareaField::class,
                [
                    'label' => __("Description (Optional)"),
                    'attr' => ['rows' => 2, 'style' => 'min-height: 60px; font-size: 13px;'],
                    'wrapper' => ['class' => 'form-group', 'style' => 'margin-bottom: 5px;']
                ]
            );
        }

        // Close Details Tag
        $form->add("col{$c}_close", HtmlField::class, [
            'html' => "</div></details>"
        ]);
    }

    return $form;
});
