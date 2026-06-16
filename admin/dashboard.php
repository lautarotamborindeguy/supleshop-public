<?php
$baseUrl = '../';
$pageTitle = 'Dashboard';
require_once '../includes/auth.php';

requireLogin('../login.php');

require_once '../includes/header.php';
?>

<main class="main-content page-shell">
    <section class="dashboard-section" aria-labelledby="dashboard-title">
        <div class="dashboard-header">
            <span class="section-kicker">Area administrativa</span>
            <h1 id="dashboard-title">Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Use os atalhos abaixo para acessar as funcoes principais do painel.</p>
        </div>

        <nav class="dashboard-actions" aria-label="Navegacao administrativa">
            <a class="admin-card" href="produtos/index.php">
                <strong>Listagem de produtos</strong>
                <span>Visualizar produtos cadastrados.</span>
            </a>

            <a class="admin-card" href="produtos/create.php">
                <strong>Cadastro de produto</strong>
                <span>Adicionar um novo produto ao catalogo.</span>
            </a>

            <a class="admin-card" href="../index.php">
                <strong>Voltar ao site</strong>
                <span>Acessar a area publica da SupleStore.</span>
            </a>

            <a class="admin-card admin-card-danger" href="../logout.php">
                <strong>Cerrar sesion</strong>
                <span>Finalizar o acesso administrativo.</span>
            </a>
        </nav>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>
