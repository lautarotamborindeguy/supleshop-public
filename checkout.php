<?php
$pageTitle = 'Finalizar pedido';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="checkout-section" aria-labelledby="checkout-title">
        <div class="checkout-header">
            <div>
                <span class="section-kicker">Finalizar pedido</span>
                <h1 id="checkout-title">Finalizar pedido</h1>
                <p>Revisa el resumen y envía el pedido por WhatsApp a la tienda.</p>
            </div>

            <a class="btn btn-outline" href="carrinho.php">Volver al carrito</a>
        </div>

        <div class="checkout-layout">
            <aside class="checkout-summary" aria-label="Resumen del pedido">
                <h2>Resumen del pedido</h2>
                <div id="checkout-empty" class="checkout-empty">
                    <p>Tu carrito está vacío.</p>
                    <a class="btn btn-primary" href="produtos.php">Ver productos</a>
                </div>

                <div id="checkout-items" class="checkout-items"></div>

                <div class="summary-row checkout-total-row">
                    <span>Total general</span>
                    <strong id="checkout-total">$U 0,00</strong>
                </div>
            </aside>

            <article class="checkout-form-panel">
                <h2>Datos del cliente</h2>

                <div id="checkout-errors" class="checkout-errors" aria-live="polite"></div>
                <div id="checkout-success" class="checkout-success" aria-live="polite"></div>

                <form id="checkout-form" class="form-card checkout-form" action="#" method="post" novalidate>
                    <div class="form-group">
                        <label for="customer-name">Nombre completo</label>
                        <input type="text" id="customer-name" name="customer_name" required>
                    </div>

                    <div class="form-group">
                        <label for="customer-phone">Teléfono / WhatsApp</label>
                        <input type="tel" id="customer-phone" name="customer_phone" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="customer-city">Ciudad</label>
                            <input type="text" id="customer-city" name="customer_city" required>
                        </div>

                        <div class="form-group">
                            <label for="customer-address">Dirección o zona de entrega</label>
                            <input type="text" id="customer-address" name="customer_address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-comments">Comentarios adicionales</label>
                        <textarea id="customer-comments" name="customer_comments" rows="4"></textarea>
                    </div>

                    <button class="btn btn-primary" type="submit">Enviar por WhatsApp</button>
                </form>
            </article>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
