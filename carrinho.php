<?php
$pageTitle = 'Carrito';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="cart-section" aria-labelledby="cart-title">
        <div class="cart-header">
            <div>
                <span class="section-kicker">Pedido</span>
                <h1 id="cart-title">Carrito de compras</h1>
                <p>Revisa los productos elegidos antes de finalizar el pedido.</p>
            </div>

            <a class="btn btn-outline" href="produtos.php">Volver a productos</a>
        </div>

        <div class="cart-layout">
            <section class="cart-items-panel" aria-label="Productos en el carrito">
                <div id="cart-empty" class="cart-empty">
                    <h2>Tu carrito está vacío</h2>
                    <p>Agrega productos del catálogo para armar tu pedido.</p>
                    <a class="btn btn-primary" href="produtos.php">Ver productos</a>
                </div>

                <div id="cart-items" class="cart-items"></div>
            </section>

            <aside id="cart-summary" class="cart-summary" aria-label="Resumen del carrito">
                <h2>Resumen</h2>
                <div class="summary-row">
                    <span>Total</span>
                    <strong id="cart-total">$U 0,00</strong>
                </div>

                <a id="checkout-button" class="btn btn-primary" href="checkout.php">Finalizar pedido</a>
                <p id="checkout-message" class="checkout-message"></p>
            </aside>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
