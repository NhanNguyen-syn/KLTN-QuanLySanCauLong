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
            'id' => 'logo_max_height',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'number',
            'label' => __('Logo max height (px)'),
            'attributes' => [
                'name' => 'logo_max_height',
                'value' => 50,
                'options' => [
                    'class' => 'form-control',
                    'min' => 24,
                    'max' => 200,
                ],
            ],
            'helper' => __('Chiều cao tối đa cho logo trên header (đơn vị px).'),
        ])
        ->setField([
            'id' => 'register_background',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'mediaImage',
            'label' => __('Register page banner (optional)'),
            'attributes' => [
                'name' => 'register_background',
                'value' => null,
            ],
            'helper' => __('Ảnh hiển thị ở cột trái trang Đăng ký/Đăng nhập.'),
        ]);
});
