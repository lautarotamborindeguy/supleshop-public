<?php
$pageTitle = 'Contato';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="contact-section" aria-labelledby="contact-title">
        <div class="section-intro">
            <span class="section-kicker">Contato</span>
            <h1 id="contact-title">Fale com a SupleStore</h1>
            <p>Envie uma mensagem para tirar duvidas sobre produtos, entregas ou pedidos.</p>
        </div>

        <div class="contact-layout">
            <article class="contact-card">
                <h2>Atendimento</h2>
                <p>Email: atendimento@suplestore.com</p>
                <p>WhatsApp: (11) 99999-9999</p>
                <p>Horario: segunda a sexta, das 9h as 18h.</p>
            </article>

            <form id="contact-form" class="form-card contact-form" action="#" method="post" novalidate>
                <div id="contact-message" class="checkout-success" aria-live="polite"></div>

                <div class="form-group">
                    <label for="contact-name">Nome</label>
                    <input type="text" id="contact-name" name="contact_name" required>
                </div>

                <div class="form-group">
                    <label for="contact-email">Email</label>
                    <input type="email" id="contact-email" name="contact_email" required>
                </div>

                <div class="form-group">
                    <label for="contact-text">Mensagem</label>
                    <textarea id="contact-text" name="contact_text" rows="5" required></textarea>
                </div>

                <button class="btn btn-primary" type="submit">Enviar mensagem</button>
            </form>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
