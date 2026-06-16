<?php
$pageTitle = 'Sobre';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="about-section" aria-labelledby="about-title">
        <div class="section-intro">
            <span class="section-kicker">Sobre</span>
            <h1 id="about-title">Sobre SupleStore</h1>
            <p>
                SupleStore es un sistema web académico para una tienda de suplementos deportivos,
                creado para demostrar HTML5, CSS3, JavaScript, PHP y MySQL en un MVP funcional.
            </p>
        </div>

        <div class="about-grid">
            <article class="feature-card">
                <h2>Objetivo</h2>
                <p>
                    Presentar productos por categorías, permitir búsquedas en el catálogo y armar pedidos
                    por email de forma simple.
                </p>
            </article>

            <article class="feature-card">
                <h2>Área administrativa</h2>
                <p>
                    El administrador accede al panel con login y gestiona productos con alta,
                    listado, actualización, eliminación y búsqueda.
                </p>
            </article>

            <aside class="side-panel" aria-label="Resumen técnico">
                <h2>Tecnologías</h2>
                <p>
                    Frontend con HTML, CSS y JavaScript. Backend con PHP puro, sesiones y conexión PDO
                    con base de datos MySQL.
                </p>
            </aside>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
