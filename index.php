<?php
$pageTitle = 'Inicio';
require_once 'includes/header.php';
?>

<main class="main-content">
    <section class="hero-section">
        <div class="hero-content">
            <span class="hero-label">Rendimiento y salud</span>
            <h1>SupleStore</h1>
            <p>
                Suplementos deportivos para quienes buscan energía, enfoque y mejores resultados en sus entrenamientos.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="produtos.php">Ver productos</a>
                <a class="btn btn-outline" href="sobre.php">Conocer la tienda</a>
            </div>
        </div>
    </section>

    <section class="content-grid" aria-labelledby="destaques-title">
        <div class="section-intro">
            <span class="section-kicker">Destacados</span>
            <h2 id="destaques-title">Todo para tu rutina fitness</h2>
            <p>Una base simple para presentar productos, categorías e información de la tienda.</p>
        </div>

        <article class="feature-card">
            <h3>Productos seleccionados</h3>
            <p>
                Whey protein, creatina, preentrenos y vitaminas organizados por categorías para facilitar la búsqueda.
            </p>
        </article>

        <article class="feature-card">
            <h3>Compra práctica</h3>
            <p>
                Carrito con JavaScript y localStorage para armar pedidos sin registro de cliente.
            </p>
        </article>

        <aside class="side-panel" aria-label="Información del proyecto">
            <h3>Proyecto Web I</h3>
            <p>
                Este MVP usa HTML5, CSS3, JavaScript, PHP y MySQL con una estructura clara para presentación académica.
            </p>
        </aside>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
