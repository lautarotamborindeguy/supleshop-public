<?php
$baseUrl = '../';
$pageTitle = 'Panel';
require_once '../includes/auth.php';

requireLogin('../login.php');

require_once '../includes/header.php';
?>

<main class="main-content page-shell">
    <section class="dashboard-section" aria-labelledby="dashboard-title">
        <div class="dashboard-header">
            <span class="section-kicker">Área administrativa</span>
            <h1 id="dashboard-title">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Usa los accesos directos para entrar a las funciones principales del panel.</p>
        </div>

        <nav class="dashboard-actions" aria-label="Navegación administrativa">
            <a class="admin-card" href="produtos/index.php">
                <strong>Listado de productos</strong>
                <span>Ver productos cargados.</span>
            </a>

            <a class="admin-card" href="produtos/create.php">
                <strong>Crear producto</strong>
                <span>Agregar un nuevo producto al catálogo.</span>
            </a>

            <a class="admin-card" href="../index.php">
                <strong>Volver al sitio</strong>
                <span>Acceder al área pública de SupleStore.</span>
            </a>

            <a class="admin-card admin-card-danger" href="../logout.php">
                <strong>Cerrar sesión</strong>
                <span>Finalizar el acceso administrativo.</span>
            </a>
        </nav>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>
