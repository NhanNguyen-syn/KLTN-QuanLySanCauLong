<?php

/**
 * Admin Form Enhancements
 * Thêm color picker và toggle cho admin form
 */

add_action('admin_enqueue_scripts', function () {
    // Enqueue color picker library (Spectrum)
    wp_enqueue_style('spectrum-css', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css');
    wp_enqueue_script('spectrum-js', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js', ['jquery']);
    
    // Enqueue Bootstrap Toggle (cho toggle buttons)
    wp_enqueue_style('bootstrap-toggle-css', 'https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css');
    wp_enqueue_script('bootstrap-toggle-js', 'https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js', ['jquery']);
    
    // Enqueue custom admin enhancements
    wp_enqueue_script('admin-form-enhancements', get_theme_file_uri('js/admin-form-enhancements.js'), ['jquery']);
    
    // Inline styles for admin form
    wp_add_inline_style('spectrum-css', '
        .color-picker-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 8px;
        }
        
        .color-picker-wrapper input[type="color"] {
            width: 50px;
            height: 40px;
            cursor: pointer;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .color-picker-wrapper input[type="text"] {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: monospace;
        }
        
        .toggle-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 8px;
        }
        
        .toggle-btn {
            padding: 6px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            background-color: #f5f5f5;
            color: #666;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .toggle-btn:hover {
            border-color: #999;
        }
        
        .toggle-btn.active {
            background-color: #4CAF50;
            color: #fff;
            border-color: #4CAF50;
        }
        
        .num-fields-info {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 12px;
            margin: 12px 0;
            border-radius: 4px;
            font-size: 13px;
            color: #1565c0;
        }
    ');
});

/**
 * Add color palette suggestions
 */
add_action('admin_footer', function () {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize color pickers with palette
            const colorInputs = document.querySelectorAll('[data-color-picker="true"]');
            colorInputs.forEach(input => {
                const colorInput = input.nextElementSibling?.querySelector('input[type="color"]');
                if (colorInput) {
                    // Add color palette
                    const palette = [
                        '#ffffff', '#f5f5f5', '#e8f5e9', '#e3f2fd', '#f0f4ff',
                        '#fff3e0', '#fce4ec', '#f3e5f5', '#ede7f6', '#e0f2f1',
                        '#0E6B5C', '#FF6B00', '#2196F3', '#4CAF50', '#FF9800'
                    ];
                    
                    // Store palette in data attribute for reference
                    colorInput.dataset.palette = JSON.stringify(palette);
                }
            });
        });
    </script>
    <?php
});

