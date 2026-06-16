function validateContactForm() {
    const form = document.getElementById('contact-form');
    const messageBox = document.getElementById('contact-message');

    if (!form || !messageBox) {
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const name = document.getElementById('contact-name').value.trim();
        const email = document.getElementById('contact-email').value.trim();
        const text = document.getElementById('contact-text').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (name === '' || email === '' || text === '') {
            messageBox.textContent = 'Completa todos los campos de contacto.';
            messageBox.className = 'alert-error';
            return;
        }

        if (!emailRegex.test(email)) {
            messageBox.textContent = 'Indica un correo electrónico válido.';
            messageBox.className = 'alert-error';
            return;
        }

        messageBox.textContent = 'Mensaje validado con éxito. Este formulario es demostrativo.';
        messageBox.className = 'checkout-success';
        form.reset();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    validateContactForm();
});
