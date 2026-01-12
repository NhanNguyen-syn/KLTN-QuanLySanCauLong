<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id' => 'bank_transfer_shortcode',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'textarea',
            'label' => __('Bank transfer details shortcode'),
            'attributes' => [
                'name' => 'bank_transfer_shortcode',
                'value' => '',
                'options' => [
                    'class' => 'form-control',
                    'rows' => 4,
                ],
            ],
            'helper' => __('Generate this shortcode from UI Blocks and paste it here to show on the checkout page.'),
        ]);
});
