<?php
$pageTitle = 'Sobre';
require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="about-section" aria-labelledby="about-title">
        <div class="section-intro">
            <span class="section-kicker">Sobre</span>
            <h1 id="about-title">Sobre a SupleStore</h1>
            <p>
                A SupleStore e um sistema web academico para uma loja de suplementos esportivos,
                criado para demonstrar HTML5, CSS3, JavaScript, PHP e MySQL em um MVP funcional.
            </p>
        </div>

        <div class="about-grid">
            <article class="feature-card">
                <h2>Objetivo</h2>
                <p>
                    Apresentar produtos por categorias, permitir busca no catalogo e montar pedidos
                    por email de forma simples.
                </p>
            </article>

            <article class="feature-card">
                <h2>Area administrativa</h2>
                <p>
                    O administrador acessa o painel por login e gerencia produtos com cadastro,
                    listagem, atualizacao, exclusao e busca.
                </p>
            </article>

            <aside class="side-panel" aria-label="Resumo tecnico">
                <h2>Tecnologias</h2>
                <p>
                    Frontend com HTML, CSS e JavaScript. Backend com PHP puro, sessoes e conexao PDO
                    com banco MySQL.
                </p>
            </aside>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
