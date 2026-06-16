<?php
$pageTitle = 'Home';
require_once 'includes/header.php';
?>

<main class="main-content">
    <section class="hero-section">
        <div class="hero-content">
            <span class="hero-label">Performance e saude</span>
            <h1>SupleStore</h1>
            <p>
                Suplementos esportivos para quem busca energia, foco e melhores resultados nos treinos.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="produtos.php">Ver produtos</a>
                <a class="btn btn-outline" href="sobre.php">Conhecer a loja</a>
            </div>
        </div>
    </section>

    <section class="content-grid" aria-labelledby="destaques-title">
        <div class="section-intro">
            <span class="section-kicker">Destaques</span>
            <h2 id="destaques-title">Tudo para sua rotina fitness</h2>
            <p>Uma base simples para apresentar produtos, categorias e informacoes da loja.</p>
        </div>

        <article class="feature-card">
            <h3>Produtos selecionados</h3>
            <p>
                Whey protein, creatina, pre-treinos e vitaminas organizados por categorias para facilitar a busca.
            </p>
        </article>

        <article class="feature-card">
            <h3>Compra pratica</h3>
            <p>
                Carrinho com JavaScript e localStorage para montar pedidos sem cadastro de cliente.
            </p>
        </article>

        <aside class="side-panel" aria-label="Informacoes do projeto">
            <h3>Projeto Web I</h3>
            <p>
                Este MVP usa HTML5, CSS3, JavaScript, PHP e MySQL com uma estrutura clara para apresentacao academica.
            </p>
        </aside>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
