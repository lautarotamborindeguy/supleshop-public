<?php
$pageTitle = $pageTitle ?? 'SupleStore';
$baseUrl = $baseUrl ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | SupleStore</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/styles.css">
</head>
<body>
    <header class="site-header">
        <nav class="navbar container" aria-label="Navegación principal">
            <a class="brand" href="<?php echo $baseUrl; ?>index.php">SupleStore</a>

            <ul class="nav-menu">
                <li><a href="<?php echo $baseUrl; ?>index.php">Inicio</a></li>
                <li><a href="<?php echo $baseUrl; ?>produtos.php">Productos</a></li>
                <li>
                    <a class="cart-link" href="<?php echo $baseUrl; ?>carrinho.php">
                        Carrito
                        <span class="cart-count" id="cart-count">0</span>
                    </a>
                </li>
                <li><a href="<?php echo $baseUrl; ?>sobre.php">Sobre</a></li>
                <li><a href="<?php echo $baseUrl; ?>contato.php">Contacto</a></li>
                <li><a class="nav-login" href="<?php echo $baseUrl; ?>login.php">Acceso</a></li>
            </ul>
        </nav>
    </header>
