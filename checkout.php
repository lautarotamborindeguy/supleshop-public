<?php
$pageTitle = 'Checkout';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="checkout-section" aria-labelledby="checkout-title">
        <div class="checkout-header">
            <div>
                <span class="section-kicker">Finalizar pedido</span>
                <h1 id="checkout-title">Checkout</h1>
                <p>Confira o resumo e envie seu pedido por email para a loja.</p>
            </div>

            <a class="btn btn-outline" href="carrinho.php">Voltar ao carrinho</a>
        </div>

        <div class="checkout-layout">
            <aside class="checkout-summary" aria-label="Resumo do pedido">
                <h2>Resumo do pedido</h2>
                <div id="checkout-empty" class="checkout-empty">
                    <p>Seu carrinho esta vazio.</p>
                    <a class="btn btn-primary" href="produtos.php">Ver produtos</a>
                </div>

                <div id="checkout-items" class="checkout-items"></div>

                <div class="summary-row checkout-total-row">
                    <span>Total geral</span>
                    <strong id="checkout-total">R$ 0,00</strong>
                </div>
            </aside>

            <article class="checkout-form-panel">
                <h2>Dados do cliente</h2>

                <div id="checkout-errors" class="checkout-errors" aria-live="polite"></div>
                <div id="checkout-success" class="checkout-success" aria-live="polite"></div>

                <form id="checkout-form" class="form-card checkout-form" action="#" method="post" novalidate>
                    <div class="form-group">
                        <label for="customer-name">Nome completo</label>
                        <input type="text" id="customer-name" name="customer_name" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="customer-email">Email</label>
                            <input type="email" id="customer-email" name="customer_email" required>
                        </div>

                        <div class="form-group">
                            <label for="customer-phone">Telefone / WhatsApp</label>
                            <input type="tel" id="customer-phone" name="customer_phone" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="customer-city">Cidade</label>
                            <input type="text" id="customer-city" name="customer_city" required>
                        </div>

                        <div class="form-group">
                            <label for="customer-address">Endereco ou zona de entrega</label>
                            <input type="text" id="customer-address" name="customer_address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-comments">Comentarios adicionais</label>
                        <textarea id="customer-comments" name="customer_comments" rows="4"></textarea>
                    </div>

                    <button class="btn btn-primary" type="submit">Enviar pedido</button>
                </form>
            </article>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
