/**
 * Admin Form Enhancements
 * Thêm color picker và toggle cho admin form
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialize color pickers
    initColorPickers();

    // Initialize toggles
    initToggles();
});

/**
 * Initialize color pickers
 */
function initColorPickers() {
    const colorInputs = document.querySelectorAll('[data-color-picker="true"]');

    colorInputs.forEach(input => {
        // Create color picker wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'color-picker-wrapper';
        wrapper.style.display = 'flex';
        wrapper.style.gap = '10px';
        wrapper.style.alignItems = 'center';

        // Create native color input
        const colorInput = document.createElement('input');
        colorInput.type = 'color';
        colorInput.value = input.value || '#f5f5f5';
        colorInput.style.width = '50px';
        colorInput.style.height = '40px';
        colorInput.style.cursor = 'pointer';
        colorInput.style.border = '1px solid #ddd';
        colorInput.style.borderRadius = '4px';

        // Create hex text input
        const hexInput = document.createElement('input');
        hexInput.type = 'text';
        hexInput.value = input.value || '#f5f5f5';
        hexInput.placeholder = '#f5f5f5';
        hexInput.style.flex = '1';
        hexInput.style.padding = '8px 12px';
        hexInput.style.border = '1px solid #ddd';
        hexInput.style.borderRadius = '4px';
        hexInput.style.fontFamily = 'monospace';

        // Sync color input and hex input
        colorInput.addEventListener('input', function () {
            hexInput.value = this.value;
            input.value = this.value;
        });

        hexInput.addEventListener('input', function () {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                colorInput.value = this.value;
                input.value = this.value;
            }
        });

        // Insert after original input
        input.style.display = 'none';
        input.parentNode.insertBefore(wrapper, input.nextSibling);
        wrapper.appendChild(colorInput);
        wrapper.appendChild(hexInput);
    });
}

/**
 * Initialize toggles
 */
function initToggles() {
    const toggleInputs = document.querySelectorAll('[data-toggle="true"]');

    toggleInputs.forEach(input => {
        const onText = input.dataset.on || 'Có';
        const offText = input.dataset.off || 'Không';

        // Create toggle wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'toggle-wrapper';
        wrapper.style.display = 'flex';
        wrapper.style.gap = '10px';
        wrapper.style.alignItems = 'center';

        // Create toggle button
        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'toggle-btn';
        toggle.style.padding = '6px 16px';
        toggle.style.border = '1px solid #ddd';
        toggle.style.borderRadius = '4px';
        toggle.style.cursor = 'pointer';
        toggle.style.backgroundColor = input.value === '1' ? '#4CAF50' : '#f5f5f5';
        toggle.style.color = input.value === '1' ? '#fff' : '#666';
        toggle.style.fontWeight = '600';
        toggle.style.transition = 'all 0.3s';
        toggle.textContent = input.value === '1' ? onText : offText;

        // Toggle click handler
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isOn = input.value === '1';
            input.value = isOn ? '0' : '1';

            // Update button style
            if (input.value === '1') {
                toggle.style.backgroundColor = '#4CAF50';
                toggle.style.color = '#fff';
                toggle.textContent = onText;
            } else {
                toggle.style.backgroundColor = '#f5f5f5';
                toggle.style.color = '#666';
                toggle.textContent = offText;
            }
        });

        // Insert after original input
        input.style.display = 'none';
        input.parentNode.insertBefore(wrapper, input.nextSibling);
        wrapper.appendChild(toggle);
    });
}
