import './bootstrap';
import './alerts';

// Ensure proper form submission for logout
document.addEventListener('DOMContentLoaded', function() {
    const logoutForms = document.querySelectorAll('.logout-form');
    
    logoutForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const method = this.getAttribute('method');
            if (method.toUpperCase() !== 'POST') {
                e.preventDefault();
                console.error('Form submission blocked: Method must be POST');
                return;
            }
        });
    });
});
