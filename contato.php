<?php
$pageTitle = 'Contacto';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="contact-section" aria-labelledby="contact-title">
        <div class="section-intro">
            <span class="section-kicker">Contacto</span>
            <h1 id="contact-title">Contacta a SupleStore</h1>
            <p>Envía un mensaje para resolver dudas sobre productos, entregas o pedidos.</p>
        </div>

        <div class="contact-layout">
            <article class="contact-card">
                <h2>Atención</h2>
                <p>Correo electrónico: atendimento@suplestore.com</p>
                <p>WhatsApp: (11) 99999-9999</p>
                <p>Horario: lunes a viernes, de 9 h a 18 h.</p>
            </article>

            <form id="contact-form" class="form-card contact-form" action="#" method="post" novalidate>
                <div id="contact-message" class="checkout-success" aria-live="polite"></div>

                <div class="form-group">
                    <label for="contact-name">Nombre</label>
                    <input type="text" id="contact-name" name="contact_name" required>
                </div>

                <div class="form-group">
                    <label for="contact-email">Correo electrónico</label>
                    <input type="email" id="contact-email" name="contact_email" required>
                </div>

                <div class="form-group">
                    <label for="contact-text">Mensaje</label>
                    <textarea id="contact-text" name="contact_text" rows="5" required></textarea>
                </div>

                <button class="btn btn-primary" type="submit">Enviar mensaje</button>
            </form>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
