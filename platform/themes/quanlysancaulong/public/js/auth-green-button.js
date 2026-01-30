// Force solid green button - override Botble core.css
document.addEventListener('DOMContentLoaded', function () {
    const submitBtn = document.querySelector('button[type="submit"]');
    if (submitBtn) {
        // Apply solid green color
        submitBtn.style.cssText = 'background: #059669 !important; color: white !important; border: none !important; border-radius: 12px !important; padding: 14px 20px !important; font-weight: 700 !important; font-size: 16px !important; width: 100%;';

        // Hover effects
        submitBtn.addEventListener('mouseenter', function () {
            this.style.background = '#047857 !important';
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 4px 12px rgba(5, 150, 105, 0.3)';
        });

        submitBtn.addEventListener('mouseleave', function () {
            this.style.background = '#059669 !important';
            this.style.transform = 'translateY(0)';
        });

        submitBtn.addEventListener('mousedown', function () {
            this.style.transform = 'translateY(0)';
        });
    }
});
