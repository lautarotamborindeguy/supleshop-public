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
            messageBox.textContent = 'Preencha todos os campos do contato.';
            messageBox.className = 'alert-error';
            return;
        }

        if (!emailRegex.test(email)) {
            messageBox.textContent = 'Informe um email valido.';
            messageBox.className = 'alert-error';
            return;
        }

        messageBox.textContent = 'Mensagem validada com sucesso. Este formulario e demonstrativo.';
        messageBox.className = 'checkout-success';
        form.reset();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    validateContactForm();
});
