<?php
$pageTitle = 'Carrinho';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="cart-section" aria-labelledby="cart-title">
        <div class="cart-header">
            <div>
                <span class="section-kicker">Pedido</span>
                <h1 id="cart-title">Carrinho de compras</h1>
                <p>Revise os produtos escolhidos antes de finalizar o pedido.</p>
            </div>

            <a class="btn btn-outline" href="produtos.php">Voltar aos produtos</a>
        </div>

        <div class="cart-layout">
            <section class="cart-items-panel" aria-label="Produtos no carrinho">
                <div id="cart-empty" class="cart-empty">
                    <h2>Seu carrinho esta vazio</h2>
                    <p>Adicione produtos no catalogo para montar seu pedido.</p>
                    <a class="btn btn-primary" href="produtos.php">Ver produtos</a>
                </div>

                <div id="cart-items" class="cart-items"></div>
            </section>

            <aside id="cart-summary" class="cart-summary" aria-label="Resumo do carrinho">
                <h2>Resumo</h2>
                <div class="summary-row">
                    <span>Total</span>
                    <strong id="cart-total">R$ 0,00</strong>
                </div>

                <a id="checkout-button" class="btn btn-primary" href="checkout.php">Finalizar pedido</a>
                <p id="checkout-message" class="checkout-message"></p>
            </aside>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
