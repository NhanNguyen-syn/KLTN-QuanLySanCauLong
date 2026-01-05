/**
 * Personal Info Form Handler
 * Xử lý form submission và validation
 */

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.personal-info-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            
            // Collect form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = form.querySelector('.btn-submit');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang xử lý...';
            
            // Send data to server
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Success
                showMessage(form, 'success', data.message || 'Thông tin đã được lưu thành công!');
                form.reset();
                
                // Redirect if needed
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                }
            })
            .catch(error => {
                // Error
                console.error('Error:', error);
                showMessage(form, 'error', 'Có lỗi xảy ra. Vui lòng thử lại.');
            })
            .finally(() => {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    });
    
    /**
     * Show success/error message
     */
    function showMessage(form, type, message) {
        const messageEl = form.querySelector(`.form-${type}`);
        if (messageEl) {
            messageEl.textContent = message;
            messageEl.style.display = 'block';
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                messageEl.style.display = 'none';
            }, 5000);
        }
    }
});

