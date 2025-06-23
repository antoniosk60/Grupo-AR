// Validación básica para formularios
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validar campos requeridos
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.border = '1px solid red';
                    isValid = false;
                } else {
                    field.style.border = '';
                }
            });

            // Validar email
            const email = form.querySelector('input[type="email"]');
            if (email && !email.value.includes('@')) {
                email.style.border = '1px solid red';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos correctamente.');
            }
        });
    });
});